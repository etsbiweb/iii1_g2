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
          <li><a href="#" class="text-gray-700 hover:text-purple-700">Dashboard</a></li>
          <li><a href="#" class="text-gray-700 hover:text-purple-700">Korisnici</a></li>
          <li><a href="#" class="text-gray-700 hover:text-purple-700">Narudžbe</a></li>
          <li><a href="#" class="text-gray-700 hover:text-purple-700">Postavke</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
      <h1 class="text-3xl font-semibold mb-6">Pregled</h1>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow text-center">
          <p class="text-gray-500">Ukupni korisnici</p>
          <h2 class="text-3xl font-bold text-purple-700">1,245</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
          <p class="text-gray-500">Ukupni recepti</p>
          <h2 class="text-3xl font-bold text-purple-700">580</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
          <p class="text-gray-500">Broj posjeta stranice</p>
          <h2 class="text-3xl font-bold text-purple-700">€12,340</h2>
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
          <h3 class="text-xl font-semibold mb-4">Raspodjela korisnika</h3>
          <canvas id="pieChart"></canvas>
        </div>
      </div>
    </main>
  </div>

  <script>
    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['Januar', 'Februar', 'Mart', 'April', 'Maj'],
        datasets: [{
          label: 'Pregledi',
          data: [65, 59, 80, 81, 56],
          backgroundColor: '#7d2ae8'
        }]
      }
    });

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: ['Administratori', 'Kupci', 'Gosti'],
        datasets: [{
          label: 'Korisnici',
          data: [10, 70, 20],
          backgroundColor: ['#7d2ae8', '#5b13b9', '#a78bfa']
        }]
      }
    });
  </script>

</body>
</html>
