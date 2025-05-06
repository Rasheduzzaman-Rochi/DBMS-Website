<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inventory Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Include Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-green-50 font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-green-900 text-white p-5">
      <div class="mb-10 flex items-center gap-4">
        <!-- Updated logo path and size -->
        <img src="./logo.svg" alt="Logo" class="w-14 h-14" />
        <!-- Shifted text slightly right -->
        <h1 class="text-lg font-bold ml-2">শস্য শ্যামলা</h1>
      </div>
      <nav class="space-y-4">
        <div class="bg-green-700 rounded px-3 py-2">Dashboard</div>
        <div id="inventory" class="hover:bg-green-800 rounded px-3 py-2 cursor-pointer">Inventory</div>
        <div id="storageMonitor" class="hover:bg-green-800 rounded px-3 py-2 cursor-pointer">Storage Monitor</div>
        <div id="salesDistribution" class="hover:bg-green-800 rounded px-3 py-2 cursor-pointer">Sales & Distribution</div>
        <div id="lossRecords" class="hover:bg-green-800 rounded px-3 py-2 cursor-pointer">Loss Records</div>
        <div id="Alerts" class="hover:bg-green-800 rounded px-3 py-2 cursor-pointer">Alerts</div>
        <div id="Reports" class="hover:bg-green-800 rounded px-3 py-2 cursor-pointer">Reports & Improvement</div>
        <div id="farmer" class="mt-10 hover:bg-green-800 rounded px-3 py-2 cursor-pointer">Farmer</div>
        <div id="transport" class="mt-10 hover:bg-green-800 rounded px-3 py-2 cursor-pointer">Transporter</div>
        <div id="logout" onclick="window.location.href='login.php'" class="mt-10 hover:bg-red-800 rounded px-3 py-2 cursor-pointer">Logout</div>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-8">
      <h2 class="text-2xl font-semibold mb-6">Inventory Management and Post-Harvest Loss Management System</h2>

      <!-- Stat cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white shadow rounded p-5">
          <p class="text-gray-600">Total Inventory</p>
          <p class="text-3xl font-bold">450</p>
        </div>
        <div class="bg-white shadow rounded p-5">
          <p class="text-gray-600">Spoilage Alerts</p>
          <p class="text-3xl font-bold">3</p>
        </div>
        <div class="bg-white shadow rounded p-5">
          <p class="text-gray-600">Real-Time Data</p>
          <p class="text-sm text-green-600">View storage conditions</p>
        </div>
        <div class="bg-white shadow rounded p-5">
          <p class="text-gray-600">Loss Summary</p>
          <p class="text-sm text-green-600">See trends analysis</p>
        </div>
      </div>

      <!-- Recent Activity Table -->
      <h3 class="text-xl font-semibold mb-3">Recent Activity</h3>
      <div class="overflow-auto">
        <table class="min-w-full bg-white shadow rounded">
          <thead>
            <tr class="bg-green-100 text-left text-gray-700">
              <th class="py-3 px-4">Type</th>
              <th class="py-3 px-4">Quantity</th>
              <th class="py-3 px-4">Harvest Date</th>
              <th class="py-3 px-4">Stage</th>
              <th class="py-3 px-4">Details</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-t">
              <td class="py-3 px-4">Carrots</td>
              <td class="py-3 px-4">100</td>
              <td class="py-3 px-4">2024-04-20</td>
              <td class="py-3 px-4">Distributed</td>
              <td class="py-3 px-4">Sold to Fresh Mart</td>
            </tr>
            <tr class="border-t">
              <td class="py-3 px-4">Tomatoes</td>
              <td class="py-3 px-4">50</td>
              <td class="py-3 px-4">2024-04-18</td>
              <td class="py-3 px-4">Handled</td>
              <td class="py-3 px-4">Damaged during transport</td>
            </tr>
            <tr class="border-t">
              <td class="py-3 px-4">Lettuce</td>
              <td class="py-3 px-4">75</td>
              <td class="py-3 px-4">2024-04-15</td>
              <td class="py-3 px-4">Stored</td>
              <td class="py-3 px-4">Placed in cool storage</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Graphs Section -->
      <h3 class="text-xl font-semibold mt-8 mb-3">Graphs</h3>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Inventory Chart -->
        <div class="bg-white p-6 rounded shadow">
          <h4 class="text-lg font-semibold mb-4">Inventory Overview</h4>
          <canvas id="inventoryChart"></canvas>
        </div>

        <!-- Loss Record Chart -->
        <div class="bg-white p-6 rounded shadow">
          <h4 class="text-lg font-semibold mb-4">Loss Record Overview</h4>
          <canvas id="lossRecordChart"></canvas>
        </div>

        <!-- Sales and Distribution Chart -->
        <div class="bg-white p-6 rounded shadow">
          <h4 class="text-lg font-semibold mb-4">Sales & Distribution Overview</h4>
          <canvas id="salesDistributionChart"></canvas>
        </div>
      </div>
    </main>
  </div>

  <script src="./dashboard.js"></script>
  <script>
    // Sample data for Inventory Chart
    const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
    new Chart(inventoryCtx, {
      type: 'bar',
      data: {
        labels: ['Carrots', 'Tomatoes', 'Lettuce', 'Onions', 'Cabbage'],
        datasets: [{
          label: 'Inventory (Quantity)',
          data: [100, 50, 75, 60, 80],
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    // Sample data for Loss Record Chart
    const lossRecordCtx = document.getElementById('lossRecordChart').getContext('2d');
    new Chart(lossRecordCtx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        datasets: [{
          label: 'Loss Percentage',
          data: [10, 15, 12, 20, 18],
          fill: false,
          borderColor: 'rgba(255, 99, 132, 1)',
          tension: 0.1
        }]
      }
    });

    // Sample data for Sales and Distribution Chart
    const salesDistributionCtx = document.getElementById('salesDistributionChart').getContext('2d');
    new Chart(salesDistributionCtx, {
      type: 'pie',
      data: {
        labels: ['Sold', 'Damaged', 'Stored'],
        datasets: [{
          label: 'Sales & Distribution',
          data: [80, 15, 5],
          backgroundColor: ['#36A2EB', '#FF6384', '#FFCD56'],
          borderColor: '#fff',
          borderWidth: 1
        }]
      }
    });
  </script>
</body>
</html>
