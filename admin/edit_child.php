<?php
session_start();
include('../includes/db_connect.php');

// Ensure the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Check if child ID is provided
if (!isset($_GET['id'])) {
    die("❌ Error: No child ID provided.");
}

$child_id = $_GET['id'];  // Get child ID from URL

// Fetch child details
$sql = "SELECT * FROM Children WHERE id = $child_id";
$result = $conn->query($sql);

// Check if child exists
if ($result->num_rows == 0) {
    die("❌ Error: Child not found.");
}
$child = $result->fetch_assoc();

// Fetch parents list
$sql_parents = "SELECT id, username FROM Users WHERE role = 'parent'";
$result_parents = $conn->query($sql_parents);

include 'navbar.php';
?>

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
        /* .container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        } */
        .container {
    width: 40%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(255, 255, 255, 0.25); /* Slight transparency */
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
        .navbar-nav .nav-link {
    color: black !important; /* Ensure text is visible */
    font-weight: 500;
    padding: 10px 15px;
}

.navbar-nav .nav-link:hover,
.navbar-nav .nav-link.active {
    color: white !important; /* White text for active/hovered links */
    background-color: #28a745 !important; /* Green background */
    border-radius: 5px;
}

    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Child Details</h2>

        <form method="POST" action="update_child.php">
            <input type="hidden" name="child_id" value="<?php echo $child['id']; ?>">

            <label for="name">Child's Name:</label>
            <input type="text" name="name" value="<?php echo $child['name']; ?>" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" value="<?php echo $child['dob']; ?>" required>

            <label for="gender">Gender:</label>
            <select name="gender" required>
                <option value="Male" <?php if ($child['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($child['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if ($child['gender'] == 'Other') echo 'selected'; ?>>Other</option>
            </select>

         <label for="parent_id">Select Parent:</label>
            <select name="parent_id" required>
                <?php
                // Fetch all parents (users with the role 'parent')
                $sql_parents = "SELECT id,name FROM Users WHERE role = 'parent'";
                $result_parents = $conn->query($sql_parents);

                // Check if parents are fetched
                if ($result_parents->num_rows > 0) {
                    // Loop through all parents and display them in the dropdown
                    while ($row = $result_parents->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                } //else {
                //     echo "<option value=''>No parents found</option>";  // Display this if no parents found
                // }
                ?>
            </select> 


            <input type="submit" value="Update Child">
        </form>

        <a href="manage_children.php" class="back-link">Back to Children List</a>
    </div>

</body>
</html>
