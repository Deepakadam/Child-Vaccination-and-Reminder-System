<?php
session_start();
include('../includes/db_connect.php');

// Fetch children and their parents' names
$sql_children = "SELECT Children.id, Children.name AS child_name, Children.dob, 
                        Users.name AS parent_name 
                 FROM Children 
                 JOIN Users ON Children.parent_id = Users.id";
$result_children = $conn->query($sql_children);

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vaccination Schedule</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            width: 40%;
            margin: 100px auto 20px;
            background-color: rgba(255, 255, 255, 0.9);
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
            margin: 10px 0 5px;
        }
        select, input[type="text"], input[type="date"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
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
    <h2>Add Vaccination Schedule</h2>

    <form method="POST" action="add_vaccination_process.php" id="vaccinationForm">
        <label for="child_id">Select Child:</label>
        <select name="child_id" id="child_id" required onchange="fetchDetails()">
            <option value="">Select Child</option>
            <?php while ($row = $result_children->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>" 
                        data-dob="<?php echo $row['dob']; ?>" 
                        data-parent="<?php echo $row['parent_name']; ?>">
                    <?php echo $row['child_name']; ?>
                </option>
            <?php } ?>
        </select>

        <label for="parent_name">Parent's Name:</label>
        <input type="text" id="parent_name" readonly>

        <label for="age">Age:</label>
        <input type="text" id="age" readonly>

        <label for="vaccine_name">Select Vaccine:</label>
        <select name="vaccine_id" id="vaccine_name" required>
            <option value="">Select a Vaccine</option>
        </select>

        <label for="scheduled_date">Scheduled Date:</label>
        <input type="date" id="scheduled_date" name="scheduled_date" required>

        <input type="submit" value="Add Schedule">
    </form>

    <div class="form-footer">
        <a href="manage_vaccination_schedules.php" class="back-link">Back to Vaccination Schedules</a>
    </div>
</div>

<script>
function fetchDetails() {
    var childSelect = document.getElementById("child_id");
    var dob = childSelect.options[childSelect.selectedIndex].getAttribute("data-dob");
    var parentName = childSelect.options[childSelect.selectedIndex].getAttribute("data-parent");

    document.getElementById("parent_name").value = parentName;

    if (dob) {
        var dobDate = new Date(dob);
        var today = new Date();
        var ageInMonths = (today.getFullYear() - dobDate.getFullYear()) * 12 + (today.getMonth() - dobDate.getMonth());

        var ageText = ageInMonths < 12 ? `${ageInMonths} months` : `${Math.floor(ageInMonths / 12)} years`;
        document.getElementById("age").value = ageText;

        fetchVaccines(ageInMonths, childSelect.value);
    }
}

function fetchVaccines(age, childId) {
    var vaccineSelect = document.getElementById("vaccine_name");
    vaccineSelect.innerHTML = "<option>Loading...</option>";

    fetch(`fetch_vaccines.php?age=${age}&child_id=${childId}`)
        .then(response => response.text())
        .then(data => {
            vaccineSelect.innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
            vaccineSelect.innerHTML = "<option>Error loading vaccines</option>";
        });
}
</script>

</body>
</html>
