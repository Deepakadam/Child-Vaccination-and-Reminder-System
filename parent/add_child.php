<?php 
include('../includes/db_connect.php');


// Ensure the parent is logged in
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
    header('Location: login.php');  // Redirect to login if not logged in as parent
    exit();
}

// Get the logged-in parent's ID
$parent_id = $_SESSION['user_id'];

// Fetch parent details from the database
$sql_parent = "SELECT name FROM Users WHERE id = ?";
$stmt = $conn->prepare($sql_parent);
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$result = $stmt->get_result();
$parent = $result->fetch_assoc();
$parent_name = $parent['name'] ?? 'Unknown'; // If no name is found, default to 'Unknown'

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    // Insert new child data into the Children table
    $sql = "INSERT INTO Children (name, dob, gender, parent_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $dob, $gender, $parent_id);

    if ($stmt->execute()) {
        header("Location: manage_children.php");
        exit();
    } else {
        die("Error: " . $conn->error);
    }
}
?>
<?php include('navbar.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Child</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            font-size: 26px;
            color: #333;
        }
        label {
            font-size: 16px;
            margin: 10px 0 5px;
            color: #333;
        }
        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            background-color: #fafafa;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .form-footer {
            text-align: center;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Add New Child</h2>

        <form method="POST" action="add_child.php">
            <label for="name">Child's Name:</label>
            <input type="text" name="name" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" required>

            <label for="gender">Gender:</label>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <!-- Parent Name (Readonly) -->
            <label for="parent_name">Parent Name:</label>
            <input type="text" name="parent_name" value="<?= htmlspecialchars($parent_name) ?>" readonly>

            <!-- Hidden Parent ID -->
            <input type="hidden" name="parent_id" value="<?= $parent_id ?>">

            <input type="submit" value="Add Child">
        </form>

        <div class="form-footer">
            <a href="manage_children.php" class="back-link">Back to Manage Children</a>
        </div>
    </div>

</body>
</html>
