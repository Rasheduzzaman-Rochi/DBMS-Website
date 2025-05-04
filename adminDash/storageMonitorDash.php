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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storage Monitor - Greenhouse Theme</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .action-buttons button {
            margin: 0 5px;
            padding: 6px 10px;
            font-size: 14px;
            cursor: pointer;
        }

        .action-buttons .update-btn {
            background-color: #4CAF50;
            color: white;
        }

        .action-buttons .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .storage-columns input {
            text-align: center;
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
        <nav class="bg-[#2F6A37] text-white px-6 py-4 rounded-lg shadow mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold">👨‍🌾 Storage Monitor</h1>
        </nav>

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

        <div class="search-bar mt-6">
            <input type="text" id="searchInput" class="px-4 py-2 border border-gray-300 rounded-lg" placeholder="Enter Warehouse ID to search" oninput="searchByID()">
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-semibold text-green-700 mb-4">Storage Condition</h3>
            <table class="min-w-full">
                <thead class="bg-green-100">
                    <tr>
                        <th>WarehouseID</th>
                        <th>WarehouseLocation</th>
                        <th>Storage Temperature</th>
                        <th>Humidity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
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
                row.style.display = warehouseID.includes(searchInput) ? '' : 'none';
            });
        }

        // Update the data using AJAX
        $(".update-btn-action").on("click", function() {
            var form = $(this).closest('form'); // Get the closest form
            $.ajax({
                url: '', // Same page for handling
                method: 'POST',
                data: form.serialize() + '&update=true',
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert(data.message); // Show success message
                        location.reload(); // Reload the page to show updated data
                    } else {
                        alert(data.message); // Show error message
                    }
                }
            });
        });

        // Delete the data using AJAX
        $(".delete-btn-action").on("click", function() {
            var form = $(this).closest('form');
            $.ajax({
                url: '', 
                method: 'POST',
                data: form.serialize() + '&delete=true',
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert(data.message); // Show success message
                        location.reload(); // Reload the page to show updated data
                    } else {
                        alert(data.message); // Show error message
                    }
                }
            });
        });
    </script>
</body>

</html>
