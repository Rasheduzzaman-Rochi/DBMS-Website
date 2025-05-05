<?php
// Include your database connection
include "../db.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
 $harvestBatchId = $_POST['harvestBatchId'];
 $productId = $_POST['productId'];
 $farmerId = $_POST['farmerId'];
 $productionDate = $_POST['productionDate'];
 $expiryDate = $_POST['expiryDate'];
 $ReasonsForDamageDetails = $_POST['ReasonsForDamageDetails'];
 $quantity = $_POST['quantity'];
 $unitPrice = $_POST['unitPrice'];

 $query = "INSERT INTO harvest_batch (harvestBatchId, productID, farmerID, productionDate, expiryDate, ReasonsForDamageDetails, quantity, unitPrice)
 VALUES ('$harvestBatchId', '$productId', '$farmerId', '$productionDate', '$expiryDate', '$ReasonsForDamageDetails', '$quantity', '$unitPrice');";
 mysqli_query($conn, $query);
 header("Location: " . $_SERVER['PHP_SELF']);
}

// Handle Update Action
if (isset($_POST['update'])) {
 $harvestBatchId = $_POST['harvestBatchId'];
 $productId = $_POST['productId'];
 $farmerId = $_POST['farmerId'];
 $productionDate = $_POST['productionDate'];
 $expiryDate = $_POST['expiryDate'];
 $ReasonsForDamageDetails = $_POST['ReasonsForDamageDetails'];
 $quantity = $_POST['quantity'];
 $unitPrice = $_POST['unitPrice'];

 $updateQuery = "UPDATE harvest_batch SET 
 productId = '$productId',
 farmerId = '$farmerId',
 productionDate = '$productionDate',
 expiryDate = '$expiryDate',
 ReasonsForDamageDetails = '$ReasonsForDamageDetails',
 quantity = '$quantity',
 unitPrice = '$unitPrice'
 WHERE harvestBatchId = '$harvestBatchId';";
 
 mysqli_query($conn, $updateQuery);
 header("Location: " . $_SERVER['PHP_SELF']);
 exit;
}

// Handle Delete Action
if (isset($_POST['delete']) && isset($_POST['harvestBatchId'])) {
 $harvestBatchId = $_POST['harvestBatchId'];

 $deleteQuery = "DELETE FROM harvest_batch WHERE harvestBatchId = '$harvestBatchId';";
 mysqli_query($conn, $deleteQuery);
 header("Location: " . $_SERVER['PHP_SELF']);
 exit;
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
 <th class="p-2 text-left">Product ID</th>
 <th class="p-2 text-left">Farmer ID</th>
 <th class="p-2 text-left">Production Date</th>
 <th class="p-2 text-left">Expiry Date</th>
 <th class="p-2 text-left">ReasonsForDamageDetails</th>
 <th class="p-2 text-left">Quantity</th>
 <th class="p-2 text-left">Unit Price</th>
 <th class="p-2 text-left">Actions</th>
 </tr>
 </thead>
 <tbody id="inventoryTable" class="divide-y divide-gray-200">
 <?php 
 $query = "SELECT * FROM harvest_batch;";
 $result = mysqli_query($conn, $query);

 while ($row = mysqli_fetch_assoc($result)) {
 ?>
 <tr>
 <td class="p-2"><?= $row['HarvestBatchId']?></td>
 <td class="p-2"><?= $row['ProductID']?></td>
 <td class="p-2"><?= $row['FarmerID']?></td>
 <td class="p-2"><?= $row['ProductionDate'] ?></td>
 <td class="p-2"><?= $row['ExpiryDate'] ?></td>
 <td class="p-2"><?= $row['ReasonsForDamageDetails'] ?></td>
 <td class="p-2"><?= $row['Quantity'] ?></td>
 <td class="p-2"><?= $row['UnitPrice'] ?></td>
 <td class="p-2 space-x-2">
 <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Add</button>
 <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Edit</button>
 <button class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Update</button>
 <button class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded">Delete</button> 
 </td>
 </tr>

 <?php
 }
 ?>

 </tbody>

 
 </table>
 </div>
 
 <form method="POST" class="mt-6 bg-white p-6 rounded shadow space-y-2">
 <input type="text" name="harvestBatchId" placeholder="Harvest Batch ID" class="p-1 w-full border-2 rounded">
 <input type="text" name="productId" placeholder="Product ID" class="p-1 w-full border-2 rounded">
 <input type="text" name="farmerId" placeholder="Farmer ID" class="p-1 w-full border-2 rounded">
 <input type="date" name="productionDate" placeholder="Production Date" class="p-1 w-full border-2 rounded">
 <input type="date" name="expiryDate" placeholder="Expiry Date" class="p-1 w-full border-2 rounded">
 <input type="text" name="ReasonsForDamageDetails" placeholder="ReasonsForDamageDetails" class="p-1 w-full border-2 rounded">
 <input type="text" name="quantity" placeholder="Quantity" class="p-1 w-full border-2 rounded">
 <input type="number" name="unitPrice" placeholder="Unit Price" class="p-1 w-full border-2 rounded">

 <button type="submit" name="add" class="bg-blue-500 text-white py-1 px-3 rounded">Add New Entry</button>
 
 </form>

</main>

 <script src="./dashboard.js"></script>
</body>
</html>