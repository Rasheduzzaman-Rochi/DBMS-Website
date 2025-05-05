<?php
// Include your database connection
include "../db.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
 $harvest_batch = $_POST['harvest_batch,'];
 $problem = $_POST['problem'];
 $solve = $_POST['solve'];


 $query = "INSERT INTO report_and_improvement (harvest_batch,problem,solve)
 VALUES ('$harvest_batch', '$problem', '$solve',);";
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
  <title>Reports & Improvements</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 p-6">

  <!-- Header -->
  <div class="bg-green-900 text-white py-4 shadow-md ">
    <div class="flex justify-center items-center space-x-3 ">
      <img src="./logo.svg" alt="Logo" class="w-14 h-14">
      <span class="text-2xl font-bold">শস্য শ্যামলা</span>

  

    </div>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 m-6">
    <div class="bg-green-100 p-4 shadow rounded-lg">
      <h2 class="text-lg font-semibold">Total Reports</h2>
      <p class="text-3xl text-blue-600 font-bold">128</p>
    </div>
    <div class="bg-green-100 p-4 shadow rounded-lg">
      <h2 class="text-lg font-semibold">Issues Resolved</h2>
      <p class="text-3xl text-green-600 font-bold">98</p>
    </div>
    <div class="bg-green-100 p-4 shadow rounded-lg">
      <h2 class="text-lg font-semibold">Suggestions</h2>
      <p class="text-3xl text-yellow-600 font-bold">42</p>
    </div>
  </div>

  <div class="mb-6">
    <h1 class="text-3xl font-bold text-green-700">Reports & Improvement Panel</h1>
    <p class="text-sm text-gray-600">Review reports, feedback, and propose enhancements</p>
  </div>
<!--table-->


 </div><div class="bg-white p-6 rounded shadow">
 <table class="w-full text-sm table-auto">
 <thead>
 <tr class="bg-green-800 text-white">
 <th class="p-2 text-left">Harvest Batch </th>
 <th class="p-2 text-left">Problem</th>
 <th class="p-2 text-left">Solve</th>
 
 </tr>
 </thead>
 <tbody id="inventoryTable" class="divide-y divide-gray-200">
 <?php 
 $query = "SELECT * FROM report_and_improvement;";
 $result = mysqli_query($conn, $query);

 while ($row = mysqli_fetch_assoc($result)) {
 ?>
 <tr>
 <td class="p-2"><?= $row['harvest_batch']?></td>
 <td class="p-2"><?= $row['problem']?></td>
 <td class="p-2"><?= $row['solve']?></td>

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
  <!-- Summary Cards -->
  

  <!-- Feedback Form
  <div class="bg-green-100 p-6 rounded-lg shadow mb-6">
    <h2 class="text-2xl font-bold mb-4">Submit Feedback</h2>
    <form class="space-y-4">
      <div>
        <label class="block text-sm font-medium">Your Name</label>
        <input type="text" class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <div>
        <label class="block text-sm font-medium">Feedback / Issue</label>
        <textarea rows="4" class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
      </div>
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit</button>
    </form>
  </div> -->

  <!-- Recent Reports 
  <div class="bg-green-100 p-6 rounded-lg shadow mb-6">
    <h2 class="text-2xl font-bold mb-4">Recent Reports</h2>
    <ul class="divide-y divide-gray-200">
      <li class="py-2">🔧 Login issue reported on April 5th</li>
      <li class="py-2">📈 Dashboard loading slowly – April 4th</li>
      <li class="py-2">✏️ Typo in help guide corrected – April 3rd</li>
    </ul>
  </div> -->

  <!-- Suggested Improvements 
  <div class="bg-green-100 p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Suggested Improvements</h2>
    <ul class="list-disc pl-5 space-y-2">
      <li>Introduce dark mode for better accessibility</li>
      <li>Allow export of reports as PDF</li>
      <li>Enhance mobile responsiveness of the admin panel</li>
    </ul>
  </div> -->

      <form method="POST" class="mt-6 bg-white p-6 rounded shadow space-y-2">
      <input type="text" name="Harvest Batch " placeholder="harvest_batch " class="p-1 w-full border-2 rounded">
      <input type="text" name="problem" placeholder="problem" class="p-1 w-full border-2 rounded">
      <input type="text" name="solve" placeholder="solve" class="p-1 w-full border-2 rounded">
 

      <button type="submit" name="add" class="bg-blue-500 text-white py-1 px-3 rounded">Add New Entry</button>
      
      </form>

 <script src="dashboard.js"></script>
</body>
</html>

