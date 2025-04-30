<?php
include "../db.php";

<<<<<<< HEAD
// Fetch alerts from database
$query = "SELECT * FROM alert";
=======
// Fetch data for the table
$query = "SELECT * FROM alerts;";
>>>>>>> a0d30bea43bb7373cd9c0d65c646c2aed675edc5
$result = mysqli_query($conn, $query);

// Handle Update Action
if (isset($_POST['update'])) {
    $alertId = $_POST['alertId'];
    $alertType = $_POST['alertType'];
    $description = $_POST['description'];
    $severity = $_POST['severity'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE alerts SET alertType = '$alertType', description = '$description', severity = '$severity', status = '$status' WHERE alertId = '$alertId';";
    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(["status" => "success", "message" => "Alert updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Update failed"]);
    }
    exit;
}

// Handle Delete Action
if (isset($_POST['delete'])) {
    $alertId = $_POST['alertId'];
    $deleteQuery = "DELETE FROM alerts WHERE alertId = '$alertId';";
    if (mysqli_query($conn, $deleteQuery)) {
        echo json_encode(["status" => "success", "message" => "Alert deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Delete failed"]);
    }
    exit;
}

// Handle Add New Data
if (isset($_POST['add'])) {
    $newType = $_POST['newAlertType'];
    $newDescription = $_POST['newDescription'];
    $newSeverity = $_POST['newSeverity'];
    $newStatus = $_POST['newStatus'];

    $addQuery = "INSERT INTO alerts (alertType, description, severity, status) VALUES ('$newType', '$newDescription', '$newSeverity', '$newStatus');";
    mysqli_query($conn, $addQuery);
}
?>

<!-- Below this: HTML part -->
<div class="bg-white p-6 rounded-lg shadow-md mt-6">
    <h3 class="text-xl font-semibold text-green-700 mb-4">📢 Alert Center</h3>
    <form method="POST">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <input type="text" name="newAlertType" placeholder="Alert Type" class="border border-gray-300 p-2 rounded" required>
            <input type="text" name="newDescription" placeholder="Description" class="border border-gray-300 p-2 rounded" required>
            <input type="text" name="newSeverity" placeholder="Severity" class="border border-gray-300 p-2 rounded" required>
            <input type="text" name="newStatus" placeholder="Status" class="border border-gray-300 p-2 rounded" required>
        </div>
        <button type="submit" name="add" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Add Alert</button>
    </form>

    <table class="min-w-full mt-6">
        <thead class="bg-green-100">
            <tr>
                <th>Alert ID</th>
                <th>Alert Type</th>
                <th>Description</th>
                <th>Severity</th>
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
                        <td><?= $row['alertId'] ?>
                            <input type="hidden" name="alertId" value="<?= $row['alertId'] ?>">
                        </td>
                        <td><input type="text" name="alertType" value="<?= $row['alertType'] ?>"></td>
                        <td><input type="text" name="description" value="<?= $row['description'] ?>"></td>
                        <td><input type="text" name="severity" value="<?= $row['severity'] ?>"></td>
                        <td><input type="text" name="status" value="<?= $row['status'] ?>"></td>
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

<script>
    $(".update-btn-action").on("click", function () {
        var form = $(this).closest('form');
        $.ajax({
            url: '', // same page
            method: 'POST',
            data: form.serialize() + '&update=true',
            success: function (response) {
                var data = JSON.parse(response);
                alert(data.message);
                if (data.status === 'success') {
                    location.reload();
                }
            }
        });
    });

    $(".delete-btn-action").on("click", function () {
        var form = $(this).closest('form');
        $.ajax({
            url: '',
            method: 'POST',
            data: form.serialize() + '&delete=true',
            success: function (response) {
                var data = JSON.parse(response);
                alert(data.message);
                if (data.status === 'success') {
                    location.reload();
                }
            }
        });
    });
</script>
