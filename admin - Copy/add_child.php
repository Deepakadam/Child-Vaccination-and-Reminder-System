<?php 
include('../includes/db_connect.php');

// Ensure the admin is logged in (assuming the admin role is checked)
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');  // Redirect to login if not logged in as admin
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $parent_id = $_POST['parent_id'];  // Get the parent ID from the form

    // Insert new child data into the Children table
    $sql = "INSERT INTO Children (name, dob, gender, parent_id) 
            VALUES ('$name', '$dob', '$gender', '$parent_id')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to manage_children.php after successful insert
        header("Location: manage_children.php"); // Redirect to the page that shows the list of children
        exit();  // Make sure no further code is executed
    } else {
        // If there’s an error, display the error and stop further execution
        die("Error: " . $conn->error);
    }
}

include 'navbar.php';
?>

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
            min-height: 600px;  /* Ensures the container has enough space */
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
            width: 100%;  /* Ensure the submit button is visible and takes full width */
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
        .navbar-nav .nav-link {
            color: black !important;
            font-weight: 500;
            padding: 10px 15px;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: white !important;
            background-color: #28a745 !important;
            border-radius: 5px;
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

            <!-- Submit Button -->
            <input type="submit" value="Add Child">
        </form>

        <div class="form-footer">
            <a href="manage_children.php" class="back-link">Back to Manage Children</a>
        </div>
    </div>

</body>
</html>
