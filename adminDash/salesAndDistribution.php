
<?php
include "../db.php";

$method = $_SERVER['REQUEST_METHOD']; 

if ($method == 'POST') {
 $input = file_get_contents("php://input");
 $data = json_decode($input, true);

 if (isset($data['add'])) {
 $newProduct = $data['newProduct'];
 $newQuantity = $data['newQuantity'];
 $newAmount = $data['newAmount'];
 $newSoldTo = $data['newSoldTo'];
 $newDate = $data['newDate'];

 $addQuery = "INSERT INTO recent_sales (product, quantity, amount, soldTo, date) VALUES ('$newProduct', '$newQuantity', '$newAmount', '$newSoldTo', '$newDate');";
 mysqli_query($conn, $addQuery);
 echo json_encode(["message" => "Data added successfully", "status" => true]);
 }

 exit;
}

if ($method == 'PATCH') {
 $input = file_get_contents("php://input");
 $data = json_decode($input, true);

 $product = $data['product'];
 $newQuantity = $data['newQuantity'];
 $newAmount = $data['newAmount'];
 $newSoldTo = $data['newSoldTo'];
 $newDate = $data['newDate'];

 $updateQuery = "UPDATE recent_sales SET quantity='$newQuantity', amount='$newAmount', soldTo='$newSoldTo', date='$newDate' WHERE product='$product';";

 if (mysqli_query($conn, $updateQuery)) {
 echo json_encode(["message" => "Data updated successfully", "status" => true]);
 } else {
 echo json_encode(["message" => "Error updating data", "status" => false]);
 }

 exit;
}


if ($method == 'DELETE') {
 $input = file_get_contents("php://input");
 $data = json_decode($input, true);

 $product = $data['product'];

 $deleteQuery = "DELETE FROM recent_sales WHERE product='$product';";

 if (mysqli_query($conn, $deleteQuery)) {
 echo json_encode(["message" => "Data deleted successfully", "status" => true]);
 } else {
 echo json_encode(["message" => "Error deleting data", "status" => false]);
 }

 exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <title>Sales & Distribution</title>
 <script src="https://cdn.tailwindcss.com"></script>
 <style>
 /* Move the header content slightly lower */
 nav {
 padding: 15px 20px;
 height: auto;
 }

 .navbar {
 background-color: #2F6A37;
 color: white;
 }

 /* Reduce the gap between the header and the "Sales & Distribution" section */
 .page-title {
 margin-top: 5px;
 margin-bottom: 5px;
 padding-bottom: 0px;
 }

 /* Reduce the gap between "Sales & Distribution" and other elements */
 .hero-image {
 margin-top: 5px;
 }

 /* Move the main content up */
 .content-gap {
 margin-top: 5px;
 }
 </style>
</head>

<body class="bg-green-50">
 <div class="navbar bg-base-100 shadow-sm justify-center">
 <div class="navbar-center">
 <div class="flex items-center justify-center space-x-2">
 <img src="./logo.svg" alt="Logo" class="w-14 h-14" />
 <span class="text-xl font-bold logo">শস্য শ্যামলা</span>
 </div>
 </div>
 </div>
 </nav>
 <!-- Hero Image -->

 <div class="p-6 max-w-7xl mx-auto content-gap">
  
 <!-- Page Title -->
 <div class="text-center page-title">
 <h1 class="text-4xl font-bold text-gray-800">Sales & Distribution</h1>
 <p class="text-gray-600 mt-1">Overview of your agricultural sales and product delivery</p>
 </div>
 </div>
 

 <!-- Search Bar -->
 <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:space-x-4">
 <input id="searchInput" type="text" placeholder="Search sales..."
 class="w-full sm:w-1/3 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
 <button onclick="searchTable()"
 class="mt-2 sm:mt-0 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">🔍 Search</button>
 
 <button onclick="openAddModal()" class="mt-4 sm:mt-0 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">Add New Sale</button>
 </div>


 <!-- Sales Table -->
 
 <section class="bg-white p-6 rounded-xl shadow">
 <h2 class="text-xl font-semibold text-gray-700 mb-4">Recent Sales</h2>
 <div class="overflow-x-auto">
 <table id="salesTable" class="min-w-full table-auto text-sm text-left">
 <thead class="bg-gray-100 text-gray-600">
 <tr>
 <th class="px-4 py-2">Product</th>
 <th class="px-4 py-2">Quantity</th>
 <th class="px-4 py-2">Amount</th>
 <th class="px-4 py-2">Sold To</th>
 <th class="px-4 py-2">Date</th>
 <th class="px-4 py-2">Actions</th>
 </tr>
 </thead>
 <tbody class="text-gray-700">
 <?php 
 $query = "SELECT * FROM recent_sales;";
 $result = mysqli_query($conn, $query);

 while ($row = mysqli_fetch_assoc($result)) { 
 ?>
 <tr class='border-t'>
 <td class='px-4 py-2'><?= $row['product'] ?></td>
 <td class='px-4 py-2'><?= $row['quantity'] ?></td>
 <td class='px-4 py-2'><?= $row['amount'] ?></td>
 <td class='px-4 py-2'><?= $row['soldTo'] ?></td>
 <td class='px-4 py-2'><?= $row['date'] ?></td>
 <td class="px-4 py-2 space-x-2">

 <button onclick="openModal('edit', this)"
 class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">Edit</button>
 </td>
 </tr>

 <?php
 }
 ?>
 
 </tbody>

 
 </table>
 </div>
 </section>

 <!-- Distribution Summary -->
 <section class="mt-6 bg-white p-6 rounded-xl shadow">
 <h2 class="text-xl font-semibold text-gray-700 mb-4">Distribution Overview</h2>
 <ul class="list-disc pl-6 text-gray-700 space-y-2">
 <li>300 kg of Onions delivered to Local Grocers</li>
 <li>Pending: 150 kg of Carrots to School Program</li>
 <li>Distributed: 1,200 kg of Produce this week</li>
 </ul>
 </section>
 </div>

 <!-- Modal (View / Edit / Add) -->
 <div id="modal" class="fixed inset-0 bg-black bg-opacity-40 hidden justify-center items-center z-50">
 <div class="bg-white rounded-xl p-6 max-w-md w-full shadow-xl">
 <div class="flex justify-between items-center mb-4">
 <h3 class="text-xl font-semibold" id="modalTitle">Title</h3>
 <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
 </div>
 <div id="modalContent"></div>
 </div>
 </div>

 <!-- JavaScript -->
 <script>
 let currentRow = null;

 function searchTable() {
 const input = document.getElementById("searchInput").value.toLowerCase();
 const rows = document.querySelectorAll("#salesTable tbody tr");
 rows.forEach(row => {
 const rowText = row.innerText.toLowerCase();
 row.style.display = rowText.includes(input) ? "" : "none";
 });
 }

 function openModal(type, btn) {
 const row = btn.closest("tr");
 const cells = row.getElementsByTagName("td");
 const product = cells[0].innerText;
 const quantity = cells[1].innerText;
 const amount = cells[2].innerText;
 const soldTo = cells[3].innerText;
 const date = cells[4].innerText;

 const modal = document.getElementById("modal");
 const modalTitle = document.getElementById("modalTitle");
 const modalContent = document.getElementById("modalContent");

 if (type === "view") {
 modalTitle.innerText = "Sale Details";
 modalContent.innerHTML = `
 <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg">
 <tbody class="text-gray-700">
 <tr class="border-b"><th class="px-4 py-2 bg-gray-100 text-gray-600">Product</th><td class="px-4 py-2">${product}</td></tr>
 <tr class="border-b"><th class="px-4 py-2 bg-gray-100 text-gray-600">Quantity</th><td class="px-4 py-2">${quantity}</td></tr>
 <tr class="border-b"><th class="px-4 py-2 bg-gray-100 text-gray-600">Amount</th><td class="px-4 py-2">${amount}</td></tr>
 <tr class="border-b"><th class="px-4 py-2 bg-gray-100 text-gray-600">Sold To</th><td class="px-4 py-2">${buyer}</td></tr>
 <tr><th class="px-4 py-2 bg-gray-100 text-gray-600">Date</th><td class="px-4 py-2">${date}</td></tr>
 </tbody>
 </table>
 `;
 } else if (type === "edit") {
 modalTitle.innerText = "Edit Sale";
 modalContent.innerHTML = `
 <form onsubmit="updateRow(event)">
 <div class="space-y-4">
 <input disabled type="text" id="editProduct" value="${product}" class="w-full px-4 py-2 border rounded-lg" placeholder="Product"/>
 <input type="text" id="editQuantity" value="${quantity}" class="w-full px-4 py-2 border rounded-lg" placeholder="Quantity"/>
 <input type="text" id="editAmount" value="${amount}" class="w-full px-4 py-2 border rounded-lg" placeholder="Amount"/>
 <input type="text" id="editSoldTo" value="${soldTo}" class="w-full px-4 py-2 border rounded-lg" placeholder="Sold To"/>
 <input type="date" id="editDate" value="${date}" class="w-full px-4 py-2 border rounded-lg"/>
 <div class="flex justify-between gap-4">
 <button type="submit" class="w-1/2 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Update</button>
 <button type="button" onclick="deleteRow()" class="w-1/2 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700">Delete</button>
 </div>
 </div>
 </form>
 `;
 currentRow = row;
 }

 modal.classList.remove("hidden");
 modal.classList.add("flex");
 }

 function openAddModal() {
 const modal = document.getElementById("modal");
 document.getElementById("modalTitle").innerText = "Add New Sale";
 document.getElementById("modalContent").innerHTML = `
 <form onsubmit="addRow(event)">
 <div class="space-y-4">
 <input type="text" name="newProduct" class="w-full px-4 py-2 border rounded-lg" placeholder="Product" required />
 <input type="text" name="newQuantity" class="w-full px-4 py-2 border rounded-lg" placeholder="Quantity" required />
 <input type="text" name="newAmount" class="w-full px-4 py-2 border rounded-lg" placeholder="Amount" required />
 <input type="text" name="newSoldTo" class="w-full px-4 py-2 border rounded-lg" placeholder="Sold To" required />
 <input type="date" name="newDate" class="w-full px-4 py-2 border rounded-lg" required />
 <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Add Sale</button>
 </div>
 </form>
 `;
 modal.classList.remove("hidden");
 modal.classList.add("flex");
 }

 function closeModal() {
 const modal = document.getElementById("modal");
 modal.classList.add("hidden");
 modal.classList.remove("flex");
 }

 function updateRow(event) {
 event.preventDefault();
 if (!currentRow) return;

 const product = document.getElementById("editProduct").value;
 const newQuantity = document.getElementById("editQuantity").value;
 const newAmount = document.getElementById("editAmount").value;
 const newSoldTo = document.getElementById("editSoldTo").value;
 const newDate = document.getElementById("editDate").value;

 fetch("", {
 method: "PATCH",
 headers: {
 "Content-Type": "application/json"
 },
 body: JSON.stringify({ product, newQuantity, newAmount, newSoldTo, newDate })
 })
 .then(res => res.json())
 .then(data => {
 if (data?.status) {
 currentRow.cells[1].innerText = newQuantity;
 currentRow.cells[2].innerText = newAmount;
 currentRow.cells[3].innerText = newSoldTo;
 currentRow.cells[4].innerText = newDate;
 }
 })
 .catch((error) => {
 console.error("Error:", error);
 });

 closeModal();
 }

 function deleteRow() {
 if (currentRow && confirm("Are you sure you want to delete this entry?")) {
 const product = document.getElementById("editProduct").value;
 fetch("", {
 method: "DELETE",
 headers: {
 "Content-Type": "application/json"
 },
 body: JSON.stringify({ product })
 })
 .then(res => res.json())
 .then(data => {
 if (data?.status) {
 currentRow.remove();
 }
 })
 .catch((error) => {
 console.error("Error:", error);
 });

 closeModal();
 }
 }

 function addRow(event) {
 event.preventDefault();
 const formData = Object.fromEntries(new FormData(event.target));

 fetch("", {
 method: "POST",
 headers: {
 "Content-Type": "application/json"
 },
 body: JSON.stringify({ ...formData, add: true})
 })
 .then(res => res.json())
 .then(data => {
 if (data?.status) {
 const table = document.querySelector("#salesTable tbody");
 const newRow = document.createElement("tr");
 newRow.classList.add("border-t");
 newRow.innerHTML = `
 <td class="px-4 py-2">${formData.newProduct}</td>
 <td class="px-4 py-2">${formData.newQuantity}</td>
 <td class="px-4 py-2">${formData.newAmount}</td>
 <td class="px-4 py-2">${formData.newSoldTo}</td>
 <td class="px-4 py-2">${formData.newDate}</td>
 <td class="px-4 py-2 space-x-2">
 <button onclick="openModal('view', this)" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">View</button>
 <button onclick="openModal('edit', this)" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">Edit</button>
 </td>
 `;
 table.appendChild(newRow);
 closeModal();
 }
 }).catch((error) => {
 console.error("Error:", error);
 });
 }

 </script>
 

</body>
</html>