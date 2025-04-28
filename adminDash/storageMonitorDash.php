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
    mysqli_query($conn, $updateQuery);
}

// Handle Delete Action
if (isset($_POST['delete'])) {
    $warehouseId = $_POST['warehouseId'];
    $deleteQuery = "DELETE FROM warehouse WHERE wareHouseId = '$warehouseId';";
    mysqli_query($conn, $deleteQuery);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storage Monitor - Greenhouse Theme</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .navbar {
            background-color: #2F6A37;
            color: white;
        }

        .navbar .logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .navbar .navbar-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .navbar .navbar-center .text-xl {
            color: white;
        }

        .search-bar {
            margin-bottom: 20px;
            text-align: right;
        }

        #searchInput {
            max-width: 30ch;
            width: 100%;
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

    <div class="p-6">
        <!-- Navbar -->
        <nav class="bg-[#2F6A37] text-white px-6 py-4 rounded-lg shadow mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold">👨‍🌾 Storage Monitor</h1>
        </nav>

        <!-- Storage Condition UI -->
        <div class="bg-green-100 p-4 rounded-lg shadow-md">
            <p class="text-lg">Storage Temperature: <span id="temperature" class="font-bold">22°C</span></p>
            <p class="text-lg text-red-600" id="temperature-alert">Safe</p>
        </div>

        <div class="bg-green-100 p-4 rounded-lg shadow-md">
            <p class="text-lg">Humidity: <span id="humidity" class="font-bold">65%</span></p>
            <p class="text-lg text-red-600" id="humidity-alert">Safe</p>
        </div>

        <div class="bg-green-100 p-4 rounded-lg shadow-md">
            <p class="text-lg">Last Checked: <span id="last-checked" class="font-bold">2024-04-15 10:00 AM</span></p>
        </div>

        <!-- Button to Add New Data (Simulating the "Update Storage Status") -->
        <form method="POST">
            <div class="bg-white p-6 rounded-lg shadow-md mt-6">
                <h3 class="text-xl font-semibold text-green-700 mb-4">Add New Storage Data</h3>
                <label for="newWarehouseId" class="block">Warehouse ID:</label>
                <input type="text" name="newWarehouseId" class="border border-gray-300 p-2 rounded w-full mb-4" required>

                <label for="newLocation" class="block">Warehouse Location:</label>
                <input type="text" name="newLocation" class="border border-gray-300 p-2 rounded w-full mb-4" required>

                <label for="newTemperature" class="block">Storage Temperature:</label>
                <input type="text" name="newTemperature" class="border border-gray-300 p-2 rounded w-full mb-4" required>

                <label for="newHumidity" class="block">Humidity:</label>
                <input type="text" name="newHumidity" class="border border-gray-300 p-2 rounded w-full mb-4" required>

                <label for="newStatus" class="block">Status:</label>
                <input type="text" name="newStatus" class="border border-gray-300 p-2 rounded w-full mb-4" required>

                <button type="submit" name="add" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 mt-4">Add Data</button>
            </div>
        </form>

        <!-- Search Bar Below Update Button -->
        <div class="search-bar mt-6">
            <input type="text" id="searchInput" class="px-4 py-2 border border-gray-300 rounded-lg" placeholder="Enter Warehouse ID to search" oninput="searchByID()">
        </div>

        <!-- Storage Condition Table -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-semibold text-green-700 mb-4">Storage Condition</h3>
            <table class="min-w-full table-auto border-collapse bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-green-100">
                    <tr>
                        <th class="py-2 px-4 border-b text-center">WarehouseID</th>
                        <th class="py-2 px-4 border-b text-center">WarehouseLocation</th>
                        <th class="py-2 px-4 border-b text-center">Storage Temperature</th>
                        <th class="py-2 px-4 border-b text-center">Humidity</th>
                        <th class="py-2 px-4 border-b text-center">Status</th>
                        <th class="py-2 px-4 border-b text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <form method="POST">
                                <td class="py-2 px-4 border-b text-center"><?=  $row['wareHouseId'] ?>
                                    <input type="hidden" name="warehouseId" value="<?= $row['wareHouseId'] ?>">
                                </td>
                                <td class="py-2 px-4 border-b text-center"><?=  $row['wareHouseLocation'] ?></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <input type="text" name="temperature" value="<?=  $row['temperature'] ?>" class="w-full">
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    <input type="text" name="humidity" value="<?=  $row['humidity'] ?>" class="w-full">
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    <input type="text" name="status" value="<?=  $row['status'] ?>" class="w-full">
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    <button type="submit" name="update" class="text-blue-500 hover:text-blue-700">Update</button>
                                    <button type="submit" name="delete" class="text-red-500 hover:text-red-700 ml-2">🗑️ Delete</button>
                                </td>
                            </form>
                        </tr>
                    <?php 
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Function to search by WarehouseID
        function searchByID() {
            const searchInput = document.getElementById('searchInput').value.toUpperCase();
            const rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                const warehouseID = row.querySelector('td').innerText.toUpperCase();
                if (warehouseID.includes(searchInput)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>
