<?php
include('../includes/db_connect.php');

// Fetch all children for the admin
$sql = "SELECT * FROM Children";
$result = $conn->query($sql);

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Children</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }
        /* .container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        } */
        .container {
        width: 80%;
        max-width: 800px; /* Prevents it from getting too wide */
        margin: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); /* Centers it perfectly */
        /* background-color: rgba(255, 255, 255, 0.8);  */
        /* background-color: rgba(255, 255, 255, 0.5); Light white with 50% transparency */
    
        padding: 20px;
        border-radius: 10px;
        box-shadow: none;
        }
        h2 {
            text-align: center;
            /* font-size: 26px; */
            color: #333;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        /* tr:nth-child(even) {
            background-color: #f9f9f9;
        } */
        a {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #218838;
        }
        .form-footer {
            margin-top: 20px;
            text-align: center;
        }
        .add-child-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .add-child-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Manage Children</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['dob']; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td>
                            <a href="edit_child.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="delete_child.php?id=<?php echo $row['id']; ?>">Delete</a>
                            <a href="view_chart.php?child_id=<?php echo $row['id']; ?>" class="action-btn" style="background-color: #28a745;">View Chart</a>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="form-footer">
            <a href="add_child.php" class="add-child-btn">Add New Child</a>
        </div>
    </div>

</body>
</html>
