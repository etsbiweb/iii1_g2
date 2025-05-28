<?php
session_start();
include '../dbh.php';

// Provjera je li korisnik admin
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@gmail.com') {
    header("Location: postavke.php");
    exit();
}

// Brisanje korisnika
if (isset($_GET['delete_user'])) {
    $userId = intval($_GET['delete_user']);

    $stmt = $conn->prepare("DELETE FROM korisnici WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();

    header("Location: postavke.php");
    exit();
}

// Brisanje recepta
if (isset($_GET['delete_recept'])) {
    $receptId = intval($_GET['delete_recept']);

    $stmt = $conn->prepare("DELETE FROM recepti WHERE ID = ?");
    $stmt->bind_param("i", $receptId);
    $stmt->execute();
    $stmt->close();

    header("Location: postavke.php");
    exit();
}

// Dohvat korisnika
$sql_korisnici = "SELECT id, username, email FROM korisnici";
$result_korisnici = $conn->query($sql_korisnici);

// Dohvat recepata
$sql_recepti = "SELECT ID, ime_umjetnika, ime_recepta FROM recepti";
$result_recepti = $conn->query($sql_recepti);
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Postavke - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10 px-6">

    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-bold text-center text-purple-700 mb-10">Postavke</h1>

        <!-- KORISNICI -->
        <h2 class="text-2xl font-semibold text-purple-700 mb-6">Registrirani korisnici</h2>

        <table class="w-full table-auto border border-gray-300 rounded-md overflow-hidden mb-12">
            <thead>
                <tr class="bg-purple-200 text-purple-900">
                    <th class="py-3 px-4 text-left">Korisničko ime</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-center">Akcija</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_korisnici && $result_korisnici->num_rows > 0): ?>
                    <?php while ($user = $result_korisnici->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50 border-b border-gray-200">
                            <td class="py-3 px-4"><?php echo htmlspecialchars($user["username"]); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($user["email"]); ?></td>
                            <td class="py-3 px-4 text-center">
                                <a href="postavke.php?delete_user=<?php echo $user['id']; ?>" 
                                   class="inline-block bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-1 px-3 rounded"
                                   onclick="return confirm('Jeste li sigurni da želite obrisati ovog korisnika?');">
                                    Obriši
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="py-4 text-center text-gray-500">Nema registriranih korisnika.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- RECEPTI -->
        <h2 class="text-2xl font-semibold text-purple-700 mb-6">Recepti</h2>

        <table class="w-full table-auto border border-gray-300 rounded-md overflow-hidden">
            <thead>
                <tr class="bg-green-200 text-green-900">
                    <th class="py-3 px-4 text-left">Ime umjetnika</th>
                    <th class="py-3 px-4 text-left">Naziv recepta</th>
                    <th class="py-3 px-4 text-center">Akcija</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_recepti && $result_recepti->num_rows > 0): ?>
                    <?php while ($recept = $result_recepti->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50 border-b border-gray-200">
                            <td class="py-3 px-4"><?php echo htmlspecialchars($recept["ime_umjetnika"]); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($recept["ime_recepta"]); ?></td>
                            <td class="py-3 px-4 text-center">
                                <a href="postavke.php?delete_recept=<?php echo $recept['ID']; ?>" 
                                   class="inline-block bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-1 px-3 rounded"
                                   onclick="return confirm('Jeste li sigurni da želite obrisati ovaj recept?');">
                                    Obriši
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="py-4 text-center text-gray-500">Nema unesenih recepata.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Gumb za povratak -->
        <div class="mt-12 text-center">
            <a href="admin.php" 
               class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-200">
                ⬅ Povratak na Admin Panel
            </a>
        </div>
    </div>
</body>
</html>
