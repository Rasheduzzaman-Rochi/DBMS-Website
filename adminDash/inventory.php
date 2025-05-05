<?php
include "../db.php";

// Fetch data for the table
$query = "SELECT * FROM warehouse;";
$result = mysqli_query($conn, $query);

// Handle Update Action
if (isset($_POST['update'])) {
    $warehouseId = $_POST['warehouseId'];
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE warehouse SET temperature = '$temperature', humidity = '$humidity', status = '$status' WHERE wareHouseId = '$warehouseId';";
    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(["status" => "success", "message" => "Data updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Update failed"]);
    }
    exit;
}

// Handle Delete Action
if (isset($_POST['delete'])) {
    $warehouseId = $_POST['warehouseId'];
    $deleteQuery = "DELETE FROM warehouse WHERE wareHouseId = '$warehouseId';";
    if (mysqli_query($conn, $deleteQuery)) {
        echo json_encode(["status" => "success", "message" => "Data deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Delete failed"]);
    }
    exit;
}

// Handle Add New Data
if (isset($_POST['add'])) {
    $newWarehouseId = $_POST['newWarehouseId'];
    $newLocation = $_POST['newLocation'];
    $newTemperature = $_POST['newTemperature'];
    $newHumidity = $_POST['newHumidity'];
    $newStatus = $_POST['newStatus'];

    $addQuery = "INSERT INTO warehouse (wareHouseId, wareHouseLocation, temperature, humidity, status) VALUES ('$newWarehouseId', '$newLocation', '$newTemperature', '$newHumidity', '$newStatus');";
    mysqli_query($conn, $addQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inventory Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen bg-gray-100">

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
      <div id="home"
       class="hover:bg-green-800 rounded px-3 py-2 cursor-pointer">Home</div>
    
      <div id="logout"
       class="mt-10 hover:bg-red-800 rounded px-3 py-2 cursor-pointer">Logout</div>
    </nav>
  </aside>

  <!-- Main Content -->
 <!-- Main Content -->
<main class="flex-1 p-8 overflow-y-auto">
  <h1 class="text-3xl font-bold mb-6">Perishable Goods Inventory</h1>

  <!-- Table -->
  <div class="bg-white p-6 rounded shadow">
    <table class="w-full text-sm table-auto">
      <thead>
        <tr class="bg-green-800 text-white">
          <th class="p-2 text-left">Harvest Batch ID</th>
          <th class="p-2 text-left">Product</th>
          <th class="p-2 text-left">Farmer ID</th>
          <th class="p-2 text-left">Production Date</th>
          <th class="p-2 text-left">Expiry Date</th>
          <th class="p-2 text-left">Damage Reason</th>
          <th class="p-2 text-left">Quantity</th>
          <th class="p-2 text-left">Unit Price</th>
          <th class="p-2 text-left">Actions</th>
        </tr>
      </thead>
      <tbody id="inventoryTable" class="divide-y divide-gray-200">
        <tr>
          <td class="p-2">01</td>
          <td class="p-2">tomato</td>
          <td class="p-2">2111649</td>
          <td class="p-2">2025-04-02</td>
          <td class="p-2">2026-04-15</td>
          <td class="p-2">transport</td>
          <td class="p-2">20</td>
          <td class="p-2">12</td>
          <td class="p-2 space-x-2">
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Add</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Edit</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Update</button>
            <button class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded">Delete</button>
         
           
          </td>
        </tr>
        <tr>
          <td class="p-2">02</td>
          <td class="p-2">potato</td>
          <td class="p-2">211564</td>
          <td class="p-2">2025-04-01</td>
          <td class="p-2">2027-04-21</td>
          <td class="p-2">-</td>
          <td class="p-2">20</td>
          <td class="p-2">15</td>
          <td class="p-2 space-x-2">
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Add</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Edit</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Update</button>
            <button class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded">Delete</button>
            
          </td>
        </tr>
        <tr>
          <td class="p-2">03</td>
          <td class="p-2">potato</td>
          <td class="p-2">211564</td>
          <td class="p-2">2025-04-01</td>
          <td class="p-2">2027-04-21</td>
          <td class="p-2">-</td>
          <td class="p-2">20</td>
          <td class="p-2">15</td>
          <td class="p-2 space-x-2">
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Add</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Edit</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Update</button>
            <button class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded">Delete</button>
            
          </td>
        </tr>
        <tr>
          <td class="p-2">04</td>
          <td class="p-2">potato</td>
          <td class="p-2">211564</td>
          <td class="p-2">2025-04-01</td>
          <td class="p-2">2027-04-21</td>
          <td class="p-2">-</td>
          <td class="p-2">20</td>
          <td class="p-2">15</td>
          <td class="p-2 space-x-2">
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Add</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Edit</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Update</button>
            <button class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded">Delete</button>
            
          </td>
        </tr>
      </tbody>

      
    </table>
  </div>
  
</main>


    

    <!-- Table -->
    <?php 
                    while($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <form method="POST" class="ajax-form">
                                <td><?=  $row['wareHouseId'] ?>
                                    <input type="hidden" name="warehouseId" value="<?= $row['wareHouseId'] ?>">
                                </td>
                                <td><?=  $row['wareHouseLocation'] ?></td>
                                <td class="storage-columns">
                                    <input type="text" name="temperature" value="<?=  $row['temperature'] ?>">
                                </td>
                                <td class="storage-columns">
                                    <input type="text" name="humidity" value="<?=  $row['humidity'] ?>">
                                </td>
                                <td class="storage-columns">
                                    <input type="text" name="status" value="<?=  $row['status'] ?>">
                                </td>
                                <td class="action-buttons">
                                    <button type="button" class="update-btn update-btn-action">Update</button>
                                    <button type="button" class="delete-btn delete-btn-action">🗑️ Delete</button>
                                </td>
                            </form>
                        </tr>
                    <?php 
                    }
                    ?>
               
 

  <script src="./dashboard.js"></script>
</body>
</html>
