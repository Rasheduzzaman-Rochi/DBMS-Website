<?php
// Include your database connection
include "../db.php";

// Fetch data for the table
$query = "SELECT * FROM warehouse;";
$result = mysqli_query($conn, $query);

// Handle Update Action
if (isset($_POST['update'])) {
    $warehouseId = $_POST['warehouseId'];

    // Check if each field is provided and set it; otherwise, don't change it
    $temperature = isset($_POST['temperature']) ? $_POST['temperature'] : null;
    $humidity = isset($_POST['humidity']) ? $_POST['humidity'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    // Build the update query dynamically, only including non-null values
    $updateFields = [];

    if ($temperature !== null) {
        $updateFields[] = "temperature = '$temperature'";
    }

    if ($humidity !== null) {
        $updateFields[] = "humidity = '$humidity'";
    }

    if ($status !== null) {
        $updateFields[] = "status = '$status'";
    }

    // If no fields are provided, don't execute the query
    if (count($updateFields) > 0) {
        $updateQuery = "UPDATE warehouse SET " . implode(', ', $updateFields) . " WHERE warehouseId = '$warehouseId';";

        mysqli_query($conn, $updateQuery);
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        echo json_encode(["status" => "error", "message" => "No data to update"]);
    }

    exit;
}

/// Handle Delete Action
if (isset($_POST['delete']) && isset($_POST['warehouseId'])) {
    $warehouseId = $_POST['warehouseId']; // Get the warehouseId from the POST data

    // Debugging: Check if warehouseId is received properly
    error_log("Received warehouseId: " . $warehouseId);  // Log warehouseId

    // SQL query to delete record
    $deleteQuery = "DELETE FROM warehouse WHERE warehouseId = '$warehouseId';";

    // Execute the delete query
    if (mysqli_query($conn, $deleteQuery)) {
        echo json_encode(["status" => "success", "message" => "Data deleted successfully"]);
    } else {
        // Debugging: Log error if delete fails
        error_log("Error deleting record: " . mysqli_error($conn));
        echo json_encode(["status" => "error", "message" => "Delete failed"]);
    }
    exit;
} else {
    error_log("Delete or warehouseId is missing in the request.");
}



// Handle Add New Data
if (isset($_POST['add'])) {
    $newWarehouseId = $_POST['newWarehouseId'];
    $newLocation = $_POST['newLocation'];
    $newTemperature = $_POST['newTemperature'];
    $newHumidity = $_POST['newHumidity'];
    $newStatus = $_POST['newStatus'];

    $addQuery = "INSERT INTO warehouse (warehouseId, warehouseLocation, temperature, humidity, status) VALUES ('$newWarehouseId', '$newLocation', '$newTemperature', '$newHumidity', '$newStatus');";
    mysqli_query($conn, $addQuery);
    header("Location: " . $_SERVER['PHP_SELF']);
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

        th,
        td {
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
    <!-- Navbar -->
    <div class="navbar bg-base-100 shadow-sm justify-center">
        <div class="navbar-center">
            <div class="flex items-center justify-center space-x-2">
                <img src="./logo.svg" alt="Logo" class="w-14 h-14" />
                <span class="text-xl font-bold logo">শস্য শ্যামলা</span>
            </div>
        </div>
    </div>

    <div class="p-6">
        <!-- Add New Data Form -->
        <form method="POST">
            <div class="bg-white p-6 rounded-lg shadow-md mt-6">
                <h3 class="text-xl font-semibold text-green-700 mb-4">Add New Storage Data</h3>
                <label for="newWarehouseId" class="block">Warehouse ID:</label>
                <input type="text" name="newWarehouseId" class="border border-gray-300 p-2 rounded w-full mb-4"
                    required>

                <label for="newLocation" class="block">Warehouse Location:</label>
                <input type="text" name="newLocation" class="border border-gray-300 p-2 rounded w-full mb-4" required>

                <label for="newTemperature" class="block">Storage Temperature:</label>
                <input type="text" name="newTemperature" class="border border-gray-300 p-2 rounded w-full mb-4"
                    required>

                <label for="newHumidity" class="block">Humidity:</label>
                <input type="text" name="newHumidity" class="border border-gray-300 p-2 rounded w-full mb-4" required>

                <label for="newStatus" class="block">Status:</label>
                <input type="text" name="newStatus" class="border border-gray-300 p-2 rounded w-full mb-4" required>

                <button type="submit" name="add"
                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 mt-4">Add Data</button>
            </div>
        </form>

        <!-- Search Bar -->
        <div class="search-bar mt-6">
            <input type="text" id="searchInput" class="px-4 py-2 border border-gray-300 rounded-lg"
                placeholder="Enter Warehouse ID to search" oninput="searchByID()">
        </div>

        <!-- Data Table -->
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
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <form method="POST">
                                <td><?= $row['wareHouseId'] ?>
                                    <input type="hidden" name="warehouseId" value="<?= $row['wareHouseId'] ?>">
                                </td>
                                <td><?= $row['wareHouseLocation'] ?></td>
                                <td class="storage-columns">
                                    <input type="text" name="temperature" value="<?= $row['temperature'] ?>">
                                </td>
                                <td class="storage-columns">
                                    <input type="text" name="humidity" value="<?= $row['humidity'] ?>">
                                </td>
                                <td class="storage-columns">
                                    <input type="text" name="status" value="<?= $row['status'] ?>">
                                </td>
                                <td class="action-buttons">
                                    <button type="submit" name="update">Update</button>
                                    <button data-id="<?= $row['wareHouseId'] ?>" type="button"
                                        class="delete-btn delete-btn-action">🗑️ Delete</button>
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
        $(".update-btn-action").on("click", function (e) {
            e.preventDefault(); // Prevent the default form submission

            var form = $(this).closest("form"); // Get the closest form

            var formData = new FormData(form[0]);

            // Add the 'update' flag to FormData to indicate this is an update request
            formData.append("update", true);

            $.ajax({
                url: "", // Same page for handling
                method: "POST",
                data: formData,
                processData: false, // Important: Do not process the data with jQuery
                contentType: false, // Important: Do not set the contentType for FormData
                success: function (response) {
                    try {
                        var data = JSON.parse(response); // Parse the JSON response
                        alert(data.message); // Show success or error message

                        if (data.status === "success") {
                            // Fetch the updated data and update the table
                            fetchUpdatedData(); // Call function to fetch updated data and update the UI
                        }
                    } catch (e) {
                        alert("An error occurred while processing the update.");
                    }
                },
                error: function (xhr, status, error) {
                    alert("AJAX error: " + status + " " + error); // Optional: Handle AJAX errors
                }
            });
        });

        // Delete the data using fetch API
        $(".delete-btn-action").on("click", function (e) {
            e.preventDefault();  // Prevent default form submission

            var warehouseId = e.target.getAttribute("data-id");  // Get the warehouseId from the form

            console.log("Sending delete request for warehouseId: " + warehouseId); // Debugging: Check if warehouseId is being sent

            // Send fetch request to delete the data from the database
            fetch("", {
                method: "POST",
                body: new URLSearchParams({
                    delete: true,  // Flag to indicate that it's a delete action
                    warehouseId: warehouseId // Send the warehouseId to delete the record
                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Debugging: Check the response data
                    alert(data.message); // Show success or error message
                    if (data.status === "success") {
                        $(this).closest("tr").remove(); // Remove the row from the UI
                    }
                })
                .catch(error => {
                    alert("An error occurred while processing the delete.");
                    console.error("Error during delete: ", error);
                });
        });



        // Function to fetch the updated data and update the table
        function fetchUpdatedData() {
            $.ajax({
                url: "", // Same page for handling
                method: "POST",
                data: { fetchUpdatedData: true }, // A flag to fetch updated data
                success: function (response) {
                    try {
                        var data = JSON.parse(response); // Parse the JSON response
                        if (data.status === "success") {
                            // Update the table with the new data
                            updateTable(data.updatedData); // Pass the updated data to the function
                        } else {
                            alert("Failed to fetch updated data.");
                        }
                    } catch (e) {
                        alert("An error occurred while fetching the updated data.");
                    }
                },
                error: function (xhr, status, error) {
                    alert("AJAX error: " + status + " " + error); // Optional: Handle AJAX errors
                }
            });
        }

        // Function to update the table with the updated data
        function updateTable(updatedData) {
            var tableBody = $("table tbody"); // Get the table body

            // Clear the current table body
            tableBody.empty();

            // Loop through the updated data and add it to the table
            updatedData.forEach(function (row) {
                var tableRow = "<tr>" +
                    "<td>" + row.warehouseId + "</td>" +
                    "<td>" + row.warehouseLocation + "</td>" +
                    "<td>" + row.temperature + "</td>" +
                    "<td>" + row.humidity + "</td>" +
                    "<td>" + row.status + "</td>" +
                    "<td class='action-buttons'>" +
                    "<button type='button' class='update-btn update-btn-action'>Update</button>" +
                    "<button type='button' class='delete-btn delete-btn-action'>🗑️ Delete</button>" +
                    "</td>" +
                    "</tr>";

                // Append the new row to the table
                tableBody.append(tableRow);
            });
        }

    </script>
</body>

</html>