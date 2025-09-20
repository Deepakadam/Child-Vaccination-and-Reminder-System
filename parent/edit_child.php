<?php
session_start();
include('../includes/db_connect.php');

// Ensure the parent is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
    header('Location: login.php');
    exit();
}

// Get the logged-in parent's details from session
$parent_id = $_SESSION['user_id'];
$parent_name = $_SESSION['name']; // Fetching parent name from session

// Check if child ID is provided
if (!isset($_GET['id'])) {
    die("❌ Error: No child ID provided.");
}

$child_id = $_GET['id'];

// Fetch child details but only if the child belongs to the logged-in parent
$sql = "SELECT * FROM Children WHERE id = ? AND parent_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $child_id, $parent_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if child exists
if ($result->num_rows == 0) {
    die("❌ Error: Child not found or you don't have access.");
}
$child = $result->fetch_assoc();

$stmt->close();
?>
<?php include('navbar.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Child</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }
        .container {
            width: 40%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.25);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Child Details</h2>

        <form method="POST" action="update_child.php">
            <input type="hidden" name="child_id" value="<?= $child['id']; ?>">

            <label for="name">Child's Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($child['name']); ?>" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" value="<?= htmlspecialchars($child['dob']); ?>" required>

            <label for="gender">Gender:</label>
            <select name="gender" required>
                <option value="Male" <?= ($child['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?= ($child['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?= ($child['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>

            <!-- Parent Name (Readonly) -->
            <label for="parent_name">Parent Name:</label>
            <input type="text" name="parent_name" value="<?= htmlspecialchars($parent_name) ?>" readonly>

            <!-- Hidden Parent ID -->
            <input type="hidden" name="parent_id" value="<?= $parent_id ?>">

            <input type="submit" value="Update Child">
        </form>

        <a href="manage_children.php" class="back-link">Back to Children List</a>
    </div>

</body>
</html>
