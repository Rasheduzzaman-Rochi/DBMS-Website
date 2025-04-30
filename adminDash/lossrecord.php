<?php
include "../db.php";

// Fetch data for the table
$query = "SELECT * FROM lossrecord;";
$result = mysqli_query($conn, $query);

// Handle Update Action
if (isset($_POST['update'])) {
    $recordId = $_POST['recordId'];
    $date = $_POST['date'];
    $quantityOfLoss = $_POST['quantityOfLoss'];
    $stageOfLoss = $_POST['stageOfLoss'];
    $causeOfLoss = $_POST['causeOfLoss'];

    $updateQuery = "UPDATE lossrecord SET date = '$date', quantityOfLoss = '$quantityOfLoss', stageOfLoss = '$stageOfLoss', causeOfLoss = '$causeOfLoss' WHERE recordId = '$recordId';";
    mysqli_query($conn, $updateQuery);
}

// Handle Delete Action
if (isset($_POST['delete'])) {
    $recordId = $_POST['recordId'];
    $deleteQuery = "DELETE FROM lossrecord WHERE recordId = '$recordId';";
    mysqli_query($conn, $deleteQuery);
}

// Handle Add New Record
if (isset($_POST['add'])) {
    $newRecordId = $_POST['newRecordId'];
    $newDate = $_POST['newDate'];
    $newQuantityOfLoss = $_POST['newQuantityOfLoss'];
    $newStageOfLoss = $_POST['newStageOfLoss'];
    $newCauseOfLoss = $_POST['newCauseOfLoss'];

    $addQuery = "INSERT INTO lossrecord (recordId, date, quantityOfLoss, stageOfLoss, causeOfLoss) VALUES ('$newRecordId', '$newDate', '$newQuantityOfLoss', '$newStageOfLoss', '$newCauseOfLoss');";
    mysqli_query($conn, $addQuery);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loss Record Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-50">
    <div class="navbar bg-[#2F6A37] justify-center py-4 shadow">
        <div class="flex items-center space-x-2">
            <img src="./logo.svg" alt="Logo" class="w-14 h-14" />
            <span class="text-xl font-bold text-white">শস্য শ্যামলা</span>
        </div>
    </div>

    <div class="p-6">
        <!-- Header -->
        <header class="bg-green-700 text-white px-6 py-4 rounded-lg mb-6 shadow">
            <h1 class="text-2xl font-bold">🌾 Loss Record Management</h1>
        </header>

        <!-- Form to Add New Record -->
        <form method="POST">
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-xl font-semibold text-green-700 mb-4">Add New Loss Record</h3>
                <label for="newRecordId" class="block">Record ID:</label>
                <input type="text" name="newRecordId" class="border border-gray-300 p-2 rounded w-full mb-4" required>

                <label for="newDate" class="block">Date:</label>
                <input type="date" name="newDate" class="border border-gray-300 p-2 rounded w-full mb-4" required>

                <label for="newQuantityOfLoss" class="block">Quantity of Loss (kg):</label>
                <input type="number" name="newQuantityOfLoss" class="border border-gray-300 p-2 rounded w-full mb-4" required>

                <label for="newStageOfLoss" class="block">Stage of Loss:</label>
                <select name="newStageOfLoss" class="border border-gray-300 p-2 rounded w-full mb-4" required>
                    <option value="">Select Stage</option>
                    <option value="Harvesting">Harvesting</option>
                    <option value="Storage">Storage</option>
                    <option value="Handling">Handling</option>
                    <option value="Transportation">Transportation</option>
                </select>

                <label for="newCauseOfLoss" class="block">Cause of Loss:</label>
                <input type="text" name="newCauseOfLoss" class="border border-gray-300 p-2 rounded w-full mb-4" required>

                <button type="submit" name="add" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 mt-4">Add Record</button>
            </div>
        </form>

        <!-- Search Bar -->
        <div class="text-right mb-4">
            <input type="text" id="searchInput" placeholder="Search by Cause of Loss..." class="border p-2 rounded w-64" oninput="searchByCause()">
        </div>

        <!-- Loss Record Table -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-green-700 mb-4">Loss Records</h3>
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-green-100">
                    <tr>
                        <th class="py-2 px-4 border-b text-center">Record ID</th>
                        <th class="py-2 px-4 border-b text-center">Date</th>
                        <th class="py-2 px-4 border-b text-center">Quantity (kg)</th>
                        <th class="py-2 px-4 border-b text-center">Stage</th>
                        <th class="py-2 px-4 border-b text-center">Cause</th>
                        <th class="py-2 px-4 border-b text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <form method="POST">
                                <td class="py-2 px-4 border-b text-center"><?= $row['recordId'] ?>
                                    <input type="hidden" name="recordId" value="<?= $row['recordId'] ?>">
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    <input type="date" name="date" value="<?= $row['date'] ?>" class="w-full p-1 border rounded">
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    <input type="number" name="quantityOfLoss" value="<?= $row['quantityOfLoss'] ?>" class="w-full p-1 border rounded">
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    <select name="stageOfLoss" class="w-full p-1 border rounded">
                                        <option <?= $row['stageOfLoss'] == 'Harvesting' ? 'selected' : '' ?>>Harvesting</option>
                                        <option <?= $row['stageOfLoss'] == 'Storage' ? 'selected' : '' ?>>Storage</option>
                                        <option <?= $row['stageOfLoss'] == 'Handling' ? 'selected' : '' ?>>Handling</option>
                                        <option <?= $row['stageOfLoss'] == 'Transportation' ? 'selected' : '' ?>>Transportation</option>
                                    </select>
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    <input type="text" name="causeOfLoss" value="<?= $row['causeOfLoss'] ?>" class="w-full p-1 border rounded">
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    <button type="submit" name="update" class="text-blue-600 hover:underline">Update</button>
                                    <button type="submit" name="delete" class="text-red-600 hover:underline ml-2">Delete</button>
                                </td>
                            </form>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function searchByCause() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const causeCell = row.children[4].querySelector('input').value.toLowerCase();
                if (causeCell.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>