<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Farmer Dashboard - AgriTrack</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .navbar {
      background-color: #2F6A37; /* Same green used for "Farmer Dashboard" */
      color: white; /* White text */
    }

    .navbar .logo {
      font-size: 24px;
      font-weight: bold;
      color: white; /* Highlight the logo with white color */
    }

    .navbar .navbar-center {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .navbar .navbar-center .text-xl {
      color: white; /* Ensure the text inside the navbar is white */
    }

    /* Top bar styles for messages and notifications */
    .navbar .navbar-center button {
      color: white;
    }

    .navbar .navbar-center button:hover {
      color: #e0e0e0; /* Light gray when hovering */
    }

  </style>
</head>
<body class="bg-green-50">
    <div class="navbar bg-base-100 shadow-sm justify-center">
        <div class="navbar-center">
          <div class="flex items-center justify-center space-x-2">
            <img src="assets/logo.svg" alt="Logo" class="w-14 h-14" />
            <span class="text-xl font-bold logo">শস্য শ্যামলা</span>
          </div>
        </div>
    </div>

  <div class="p-6">
    <!-- Navbar -->
    <nav class="bg-[#2F6A37] text-white px-6 py-4 rounded-lg shadow mb-6 flex justify-between items-center">
      <h1 class="text-2xl font-bold">🌾 Farmer Dashboard</h1>
      <div class="flex items-center space-x-6">
        <div class="relative">
          <button class="hover:text-gray-200">💬 Messages</button>
          <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">3</span>
        </div>
        <div class="relative">
          <button class="hover:text-gray-200">🔔 Notifications</button>
          <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">5</span>
        </div>
      </div>
    </nav>

    <!-- Add Transporter and Offer Price Section -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
      <h3 class="text-xl font-semibold mb-4 text-green-700">Add Transporter & Offer Price</h3>
      <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" placeholder="Transporter Name" class="border border-gray-300 px-4 py-2 rounded">
        <input type="text" placeholder="Offer Price (BDT)" class="border border-gray-300 px-4 py-2 rounded">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add</button>
      </form>
    </div>

    <!-- Products for Delivery -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
      <h3 class="text-xl font-semibold mb-4 text-green-700">Products for Delivery</h3>
      <table class="min-w-full bg-white border border-gray-200 rounded shadow">
        <thead class="bg-green-100">
          <tr>
            <th class="py-2 px-4 border-b text-left">Product Name</th>
            <th class="py-2 px-4 border-b text-left">Quantity</th>
            <th class="py-2 px-4 border-b text-left">Delivery Date</th>
            <th class="py-2 px-4 border-b text-left">Transporter</th>
            <th class="py-2 px-4 border-b text-left">Offer Price</th>
            <th class="py-2 px-4 border-b text-left">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="py-2 px-4 border-b">Tomato</td>
            <td class="py-2 px-4 border-b">200 kg</td>
            <td class="py-2 px-4 border-b">2025-04-15</td>
            <td class="py-2 px-4 border-b">Rahim Transport</td>
            <td class="py-2 px-4 border-b">4500</td>
            <td class="py-2 px-4 border-b text-green-600">Scheduled</td>
          </tr>
          <tr>
            <td class="py-2 px-4 border-b">Onion</td>
            <td class="py-2 px-4 border-b">150 kg</td>
            <td class="py-2 px-4 border-b">2025-04-18</td>
            <td class="py-2 px-4 border-b">Fahim Logistics</td>
            <td class="py-2 px-4 border-b">3200</td>
            <td class="py-2 px-4 border-b text-yellow-600">Pending</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Bar Chart Placeholder -->
      <div class="bg-white p-6 rounded-lg shadow">
        <h4 class="text-lg font-semibold text-green-700 mb-4">Delivery Statistics</h4>
        <div class="h-48 bg-green-100 flex items-center justify-center rounded">📊 Bar Chart Placeholder</div>
      </div>

      <!-- Pie Chart Placeholder -->
      <div class="bg-white p-6 rounded-lg shadow">
        <h4 class="text-lg font-semibold text-green-700 mb-4">Product Distribution</h4>
        <div class="h-48 bg-green-100 flex items-center justify-center rounded">🥧 Pie Chart Placeholder</div>
      </div>
    </div>
  </div>
 <script src="dashboard.js"></script>
</body>
</html>
