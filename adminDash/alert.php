<?php
include "../db.php";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $type = mysqli_real_escape_string($conn, $_POST['alertType']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $severity = mysqli_real_escape_string($conn, $_POST['severity']);

        mysqli_query($conn, "INSERT INTO alert (alert_type, description, severity, status) 
                             VALUES ('$type', '$description', '$severity', 'Active')");
    }

    if (isset($_POST['update'])) {
        $id = mysqli_real_escape_string($conn, $_POST['alertId']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        mysqli_query($conn, "UPDATE alert SET status = '$status' WHERE id = '$id'");
    }

    if (isset($_POST['delete'])) {
        $id = mysqli_real_escape_string($conn, $_POST['alertId']);
        mysqli_query($conn, "DELETE FROM alert WHERE id = '$id'");
    }

    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Fetch alerts with optional filtering
$filterType = isset($_GET['filterType']) ? mysqli_real_escape_string($conn, $_GET['filterType']) : '';
$query = "SELECT * FROM alert";
if (!empty($filterType)) {
    $query .= " WHERE alert_type = '$filterType'";
}
$result = mysqli_query($conn, $query);

// Fetch counts
$countQuery = mysqli_query($conn, "SELECT status, COUNT(*) as count FROM alert GROUP BY status");
$counts = ['Active' => 0, 'Resolved' => 0, 'Pending' => 0];
while ($row = mysqli_fetch_assoc($countQuery)) {
    $counts[$row['status']] = $row['count'];
}

// Alert types for dropdown
$alertTypes = ['Spoilage Risk', 'Low Stock', 'Pest Alert', 'Harvest Ready', 'Water Shortage'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Alerts</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e8f5e9] font-sans text-gray-800">

  <!-- Navbar -->
  <div class="bg-green-900 text-white py-4 shadow-md">
    <div class="flex justify-center items-center space-x-3">
      <img src="./logo.svg" alt="Logo" class="w-14 h-14">
      <span class="text-2xl font-bold">শস্য শ্যামলা</span>
    </div>
  </div>

  <!-- Container -->
  <div class="max-w-6xl mx-auto mt-8 p-6 bg-white rounded-2xl shadow-lg">
    <h1 class="text-3xl font-bold text-center text-green-800 mb-8">📢 Alert Center</h1>

    <!-- Summary Cards -->
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

    <!-- Filters -->
    <div class="flex flex-col md:flex-row justify-end gap-4 mb-6">
      <form method="GET" class="flex gap-4">
        <select name="filterType" class="px-4 py-2 border rounded-xl shadow-sm">
          <option value="">All Types</option>
          <?php foreach ($alertTypes as $type): ?>
            <option value="<?= $type ?>" <?= $filterType === $type ? 'selected' : '' ?>><?= $type ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="bg-green-700 hover:bg-green-600 text-white px-5 py-2 rounded-xl shadow">Apply</button>
      </form>
    </div>

    <!-- Alerts Table -->
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
          <?php while ($alert = mysqli_fetch_assoc($result)): ?>
          <form method="POST">
            <input type="hidden" name="alertId" value="<?= $alert['id'] ?>">
            <tr>
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
            </tr>
          </form>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- Alert Form -->
    <div class="mt-10 bg-green-50 p-6 rounded-2xl shadow">
      <h3 class="text-xl font-semibold mb-4 text-green-800">📝 Create New Alert</h3>
      <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="alertType" class="block text-sm font-medium text-gray-700">Alert Type</label>
          <select name="alertType" id="alertType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <?php foreach ($alertTypes as $type): ?>
              <option value="<?= $type ?>"><?= $type ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
          <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
        </div>
        <div>
          <label for="severity" class="block text-sm font-medium text-gray-700">Severity</label>
          <select name="severity" id="severity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
          </select>
        </div>
        <div class="md:col-span-2 text-right">
          <button type="submit" name="add" class="bg-green-700 hover:bg-green-600 text-white px-6 py-2 rounded-xl shadow">Create Alert</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
