<?php
include_once 'dbh.php';

$required = ['ime_umjetnika', 'ime_recepta', 'sastojci', 'piprema'];

foreach ($required as $field) {
    if (empty($_POST[$field])) {
        die("Polje '$field' nije popunjeno.");
    }
}

if (!isset($_FILES['slika'])) {
    die("Slika nije poslana.");
}

$ime_umjetnika = $_POST['ime_umjetnika'];
$ime_recepta = $_POST['ime_recepta'];
$sastojci = $_POST['sastojci'];
$piprema = $_POST['piprema'];

// (Ostatak tvog koda za upload i unos u bazu...)

if (isset($_POST['ime_umjetnika'], $_POST['ime_recepta'], $_POST['sastojci'], $_POST['piprema']) && isset($_FILES['slika'])) {
    $ime_umjetnika = $_POST['ime_umjetnika'];
    $ime_recepta = $_POST['ime_recepta'];
    $sastojci = $_POST['sastojci'];
    $piprema = $_POST['piprema'];

    // Validacija slike
    $slika = $_FILES['slika'];
    $fileName = $slika['name'];
    $fileTmpName = $slika['tmp_name'];
    $fileSize = $slika['size'];
    $fileError = $slika['error'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileType, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 5 * 1024 * 1024) { // 5MB limit
                $newFileName = uniqid('', true) . '.' . $fileType;
                $fileDestination = 'uploads/' . $newFileName;

                if (!is_dir('uploads')) {
                    mkdir('uploads', 0755, true);
                }

                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $sql = "INSERT INTO recepti (ime_umjetnika, ime_recepta, sastojci, piprema, slika) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $sql);
                    if (!$stmt) {
                        die("Prepare failed: " . mysqli_error($conn));
                    }

                    mysqli_stmt_bind_param($stmt, "sssss", $ime_umjetnika, $ime_recepta, $sastojci, $piprema, $newFileName);

                    if (mysqli_stmt_execute($stmt)) {
                        // Uspješan unos
                        header("Location: index.html?success=1");
                        exit();
                    } else {
                        echo "Greška u bazi: " . mysqli_error($conn);
                    }
                } else {
                    echo "Greška prilikom premještanja slike.";
                }
            } else {
                echo "Slika je prevelika.";
            }
        } else {
            echo "Greška pri uploadu slike.";
        }
    } else {
        echo "Nepodržan format slike.";
    }
} else {
    echo "Sva polja su obavezna.";
}
?>
