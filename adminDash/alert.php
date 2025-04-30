<?php

// Database connection ONLY for alerts table
$alert_conn = mysqli_connect("localhost", "username", "password", "database_name");
if (!$alert_conn) {
    die("Alert database connection failed: " . mysqli_connect_error());
}

// Handle ONLY alert-related database operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add new alert
    if (isset($_POST['alertType'])) {
        $type = mysqli_real_escape_string($alert_conn, $_POST['alertType']);
        $desc = mysqli_real_escape_string($alert_conn, $_POST['description']);
        $severity = mysqli_real_escape_string($alert_conn, $_POST['severity']);
        
        mysqli_query($alert_conn, "INSERT INTO alerts (alert_type, description, severity, status) 
                                 VALUES ('$type', '$desc', '$severity', 'Active')");
        header("Location: ".$_SERVER['PHP_SELF']); // Refresh
        exit();
    }
    
    // Update/Delete alerts
    if (isset($_POST['alertId'])) {
        $id = mysqli_real_escape_string($alert_conn, $_POST['alertId']);
        
        if (isset($_POST['update'])) {
            $status = mysqli_real_escape_string($alert_conn, $_POST['status']);
            mysqli_query($alert_conn, "UPDATE alerts SET status = '$status' WHERE id = '$id'");
        } 
        elseif (isset($_POST['delete'])) {
            mysqli_query($alert_conn, "DELETE FROM alerts WHERE id = '$id'");
        }
        
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}

// Fetch ONLY alerts data
$alerts_result = mysqli_query($alert_conn, "SELECT * FROM alerts");
$alerts = mysqli_fetch_all($alerts_result, MYSQLI_ASSOC);

// Calculate counts for the summary cards
$counts = [
    'Active' => 0,
    'Resolved' => 0,
    'Pending' => 0
];
foreach ($alerts as $alert) {
    $counts[$alert['status']]++;
}
?>

<!-- YOUR EXISTING HTML (NO CHANGES TO STRUCTURE/STYLING) -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Alerts</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e8f5e9] font-sans text-gray-800">
  <!-- Your original navbar -->
  <div class="bg-green-900 text-white py-4 shadow-md">
    <div class="flex justify-center items-center space-x-3">
      <img src="./logo.svg" alt="Logo" class="w-14 h-14">
      <span class="text-2xl font-bold">শস্য শ্যামলা</span>
    </div>
  </div>

  <div class="max-w-6xl mx-auto mt-8 p-6 bg-white rounded-2xl shadow-lg">
    <h1 class="text-3xl font-bold text-center text-green-800 mb-8">📢 Alert Center</h1>

    <!-- Summary Cards (now using database counts) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
      <div class="bg-green-100 p-4 rounded-2xl shadow-sm text-center">
        <p class="text-sm text-gray-600">Active Alerts</p>
        <p class="text-xl font-bold text-green-700"><?= $counts['Active'] ?></p>
      </div>
      <div class="bg-green-100 p-4 rounded-2xl shadow-sm text-center">
        <p class="text-sm text-gray-600">Resolved Alerts</p>
        <p class="text-xl font-bold text-green-700"><?= $counts['Resolved'] ?></p>
      </div>
      <div class="bg-green-100 p-4 rounded-2xl shadow-sm text-center">
        <p class="text-sm text-gray-600">Pending Alerts</p>
        <p class="text-xl font-bold text-green-700"><?= $counts['Pending'] ?></p>
      </div>
    </div>

    <!-- Your original filters (unchanged) -->
    <div class="flex flex-col md:flex-row justify-end gap-4 mb-6">
      <select id="filterType" class="px-4 py-2 border rounded-xl shadow-sm">
        <option>All Alerts</option>
        <option>Expiry Alert</option>
        <option>Temperature Alert</option>
        <!-- Other options... -->
      </select>
      <button onclick="applyFilters()" class="bg-green-700 hover:bg-green-600 text-white px-5 py-2 rounded-xl shadow">Apply</button>
    </div>

    <!-- Alerts Table (now populated from database) -->
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border border-gray-200 rounded-xl overflow-hidden">
        <thead class="bg-green-100">
          <tr class="text-left">
            <th class="px-4 py-3">Alert Type</th>
            <th class="px-4 py-3">Description</th>
            <th class="px-4 py-3">Severity</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Action</th>
          </tr>
        </thead>
        <tbody id="alertsBody" class="text-sm">
          <?php foreach ($alerts as $alert): ?>
          <tr>
            <form method="POST">
              <input type="hidden" name="alertId" value="<?= $alert['id'] ?>">
              <td class="px-4 py-3"><?= htmlspecialchars($alert['alert_type']) ?></td>
              <td class="px-4 py-3"><?= htmlspecialchars($alert['description']) ?></td>
              <td class="px-4 py-3"><?= htmlspecialchars($alert['severity']) ?></td>
              <td class="px-4 py-3">
                <select name="status" class="border rounded px-2 py-1">
                  <option value="Active" <?= $alert['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                  <option value="Resolved" <?= $alert['status'] === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                  <option value="Pending" <?= $alert['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                </select>
              </td>
              <td class="px-4 py-3 space-x-2">
                <button type="submit" name="update" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-lg">Resolve</button>
                <button type="submit" name="delete" class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded-lg">Delete</button>
              </td>
            </form>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Your original alert form (now submits to database) -->
    <div class="mt-10 bg-green-50 p-6 rounded-2xl shadow">
      <h3 class="text-xl font-semibold mb-4 text-green-800">📝 Create New Alert</h3>
      <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="alertType" class="block mb-1 text-sm font-medium">Alert Type</label>
          <select id="alertType" name="alertType" class="w-full px-3 py-2 border rounded-xl" required>
            <option>Expiry Alert</option>
            <option>Temperature Alert</option>
            <!-- Other options... -->
          </select>
        </div>
        <div>
          <label for="severity" class="block mb-1 text-sm font-medium">Severity</label>
          <select id="severity" name="severity" class="w-full px-3 py-2 border rounded-xl" required>
            <option>High</option>
            <option>Medium</option>
            <option>Low</option>
          </select>
        </div>
        <div class="md:col-span-2">
          <label for="description" class="block mb-1 text-sm font-medium">Description</label>
          <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border rounded-xl" required></textarea>
        </div>
        <div class="md:col-span-2 text-right">
          <button type="submit" class="bg-green-700 hover:bg-green-600 text-white px-6 py-2 rounded-xl shadow">Create Alert</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Your original JavaScript (unchanged) -->
  <script>
    function applyFilters() {
      const filterType = document.getElementById("filterType").value;
      const rows = document.querySelectorAll("#alertsBody tr");
      
      rows.forEach(row => {
        const type = row.querySelector("td:first-child").textContent.trim();
        row.style.display = (filterType === "All Alerts" || type === filterType) ? "" : "none";
      });
    }
  </script>
</body>
</html>