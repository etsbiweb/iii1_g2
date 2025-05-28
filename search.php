<?php
// Povezivanje na bazu
require_once 'dbh.php';

if (isset($_GET['search'])) {
    $searchTerm = trim($_GET['search']);
    
    // Priprema i izvršenje upita
    $stmt = $conn->prepare("SELECT * FROM recepti WHERE naziv LIKE ?");
    $likeSearch = "%" . $searchTerm . "%";
    $stmt->bind_param("s", $likeSearch);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Provjera rezultata
    if ($result->num_rows > 0) {
        echo "<h2>Rezultati pretrage za: <em>" . htmlspecialchars($searchTerm) . "</em></h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<h3>" . htmlspecialchars($row['naziv']) . "</h3>";
            echo "<p>" . nl2br(htmlspecialchars($row['opis'])) . "</p>"; // opis ako postoji
            echo "</div><hr>";
        }
    } else {
        echo "<p>Recept nije pronađen.</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Niste unijeli termin za pretragu.</p>";
}
?>
