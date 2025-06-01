<?php
include_once '../dbh.php';

// Broj korisnika
$brojKorisnika = 0;
$sql = "SELECT COUNT(*) AS ukupno FROM korisnici";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $brojKorisnika = $row['ukupno'];
}

// Broj recepata
$brojRecepata = 0;
$sql = "SELECT COUNT(*) AS ukupno FROM recepti";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $brojRecepata = $row['ukupno'];
}

// Broj posjeta (koristit ćemo kao broj korisnika u Pie Chartu)
$brojPosjeta = 0;
$sql = "SELECT COUNT(*) AS ukupno FROM posjete";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $brojPosjeta = $row['ukupno'];
}

$brojAdmina = 1; // Fiksno

// Top 3 pretrage
$topPretrage = [];
$sql = "SELECT pojam, COUNT(*) AS broj FROM pretrage GROUP BY pojam ORDER BY broj DESC LIMIT 3";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $topPretrage[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

  <!-- Sidebar -->
  <div class="flex">
    <aside class="w-64 bg-white shadow-md h-screen p-5">
      <h2 class="text-2xl font-bold text-purple-700 mb-10">Admin Panel</h2>
      <nav>
        <ul class="space-y-4">
          <li><a href="../index2.php" class="text-gray-700 hover:text-purple-700">Nazad na prijavu/registraciju</a></li>
          <li><a href="postavke.php" class="text-gray-700 hover:text-purple-700">Postavke</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
      <h1 class="text-3xl font-semibold mb-6">Pregled statistika</h1>

      <!-- Stats Cards -->
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
  <div class="bg-white p-6 rounded-xl shadow text-center">
    <p class="text-gray-500">Ukupni korisnici</p>
    <h2 class="text-3xl font-bold text-purple-700"><?php echo $brojKorisnika; ?></h2>
  </div>
  <div class="bg-white p-6 rounded-xl shadow text-center">
    <p class="text-gray-500">Ukupni recepti</p>
    <h2 class="text-3xl font-bold text-purple-700"><?php echo $brojRecepata; ?></h2>
  </div>
  <div class="bg-white p-6 rounded-xl shadow text-center">
    <p class="text-gray-500">Broj posjeta stranice</p>
    <h2 class="text-3xl font-bold text-purple-700"><?php echo $brojPosjeta; ?></h2>
  </div>
</div>



      <!-- Charts -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Bar Chart -->
        <div class="bg-white p-6 rounded-xl shadow">
          <h3 class="text-xl font-semibold mb-4">Pregledi po mjesecima</h3>
          <canvas id="barChart"></canvas>
        </div>

        <!-- Pie Chart -->
        <div class="bg-white p-6 rounded-xl shadow">
          <h3 class="text-xl font-semibold mb-4">Otvaranje stranice</h3>
          <canvas id="pieChart"></canvas>
        </div>
      </div>
    </main>
  </div>

  <script>
    // Bar Chart
    const brojPosjeta = <?php echo $brojPosjeta; ?>;

  // Bar Chart
  const barCtx = document.getElementById('barChart').getContext('2d');
  new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: ['April', 'Maj', 'Juni', 'Juli', 'August'],
      datasets: [{
        label: 'Pregledi',
        data: [0, brojPosjeta, 0, 0, 0], // koristi broj posjeta iz PHP-a za Maj
        backgroundColor: '#7d2ae8'
      }]
    }
  });
   const brojAdmina = <?php echo $brojAdmina; ?>;
  const brojKorisnika = <?php echo $brojPosjeta; ?>;

  const pieCtx = document.getElementById('pieChart').getContext('2d');
  new Chart(pieCtx, {
    type: 'pie',
    data: {
      labels: ['Administrator', 'Korisnici (pregledi stranice)'],
      datasets: [{
        label: 'Raspodjela korisnika',
        data: [brojAdmina, brojKorisnika],
        backgroundColor: ['#7d2ae8', '#5b13b9']
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        },
        tooltip: {
          enabled: true
        }
      }
    }
  });
  
  </script>

</body>
</html>
