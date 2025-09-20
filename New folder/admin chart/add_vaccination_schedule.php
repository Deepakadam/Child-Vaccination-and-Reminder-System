<?php
include('../includes/db_connect.php');

// Fetch all children along with their parents' names and DOB
$sql_children = "SELECT Children.id, Children.name AS child_name, Children.dob, 
                        Users.name AS parent_name 
                 FROM Children 
                 JOIN Users ON Children.parent_id = Users.id";
$result_children = $conn->query($sql_children);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $child_id = $_POST['child_id'];
    $vaccine_name = $_POST['vaccine_name'];
    $scheduled_date = $_POST['scheduled_date'];

    // Get parent's email
    $sql_parent = "SELECT Users.email, Users.name AS parent_name 
                   FROM Users 
                   JOIN Children ON Users.id = Children.parent_id 
                   WHERE Children.id = '$child_id'";
    $result_parent = $conn->query($sql_parent);
    $parent = $result_parent->fetch_assoc();
    $parent_email = $parent['email'];
    $parent_name = $parent['parent_name'];

    // Insert into database
    $sql = "INSERT INTO VaccinationSchedules (child_id, vaccine_name, scheduled_date) 
            VALUES ('$child_id', '$vaccine_name', '$scheduled_date')";

    if ($conn->query($sql) === TRUE) {
        // Send email notification
        $subject = "Vaccination Scheduled for Your Child";
        $message = "Dear $parent_name,\n\nYour child has a scheduled vaccination:\n\n"
                  . "Vaccine: $vaccine_name\n"
                  . "Date: $scheduled_date\n\n"
                  . "Please ensure your child is vaccinated on time.\n\nBest Regards,\nVaccination System";
        $headers = "From: admin@vaccination.com";

        if (mail($parent_email, $subject, $message, $headers)) {
            echo "✅ Email sent successfully!";
        } else {
            echo "❌ Failed to send email.";
        }

        header("Location: manage_vaccination_schedules.php");
        exit();
    } else {
        echo "❌ Error: " . $conn->error;
    }
}

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
    background-color: #f8f9fa; /* Light gray background */
}

/* Centering the form properly */
.container {
    width: 40%;
    margin: 100px auto 20px; /* Moves form down from navbar */
    background-color: rgba(255, 255, 255, 0.9);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}
/* Fix Navbar at the Top */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: white; /* Adjust if needed */
    z-index: 1000; /* Ensures navbar stays above content */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional shadow */
}

/* Push the form below the fixed navbar */
.container {
    width: 40%;
    margin: 120px auto 20px; /* Adjust top margin to avoid overlap */
    background-color: rgba(255, 255, 255, 0.9);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}
/* Form Heading */
h2 {
    text-align: center;
    color: #333;
}

/* Labels */
label {
    display: block;
    margin: 10px 0 5px;
}

/* Input fields */
select, input[type="date"], input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

/* Submit Button */
input[type="submit"] {
    background-color: #28a745;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #218838;
}

/* Back Button */
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

/* Navbar Styles */
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

.navbar-nav .nav-item .nav-link.text-danger:hover {
    background-color: #dc3545 !important;
}

    </style>
</head>
<body>

    <div class="container">
        <h2>Add Vaccination Schedule</h2>

        <form method="POST" action="add_vaccination_schedule.php">
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
            <select name="vaccine_name" id="vaccine_name" required>
                <option value="">Select a Child First</option>
            </select>

            <label for="scheduled_date">Scheduled Date:</label>
            <input type="date" name="scheduled_date" required>

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

        // Determine age format
        var ageText = ageInMonths < 12 ? `${ageInMonths} months` : `${Math.floor(ageInMonths / 12)} years`;
        document.getElementById("age").value = ageText;

        var vaccineDropdown = document.getElementById("vaccine_name");
        vaccineDropdown.innerHTML = ""; // Clear previous options

        if (ageInMonths < 1) {
            vaccineDropdown.innerHTML = `<option value="BCG">BCG (Tuberculosis)</option>
                                         <option value="Hepatitis B">Hepatitis B</option>`;
        } else if (ageInMonths >= 1 && ageInMonths <= 2) {
            vaccineDropdown.innerHTML = `<option value="Polio">Polio</option>
                                         <option value="DTP">DTP (Diphtheria, Tetanus, Pertussis)</option>`;
        } else if (ageInMonths >= 6 && ageInMonths <= 12) {
            vaccineDropdown.innerHTML = `<option value="MMR">MMR (Measles, Mumps, Rubella)</option>
                                         <option value="Hepatitis A">Hepatitis A</option>`;
        } else if (ageInMonths >= 12) {
            vaccineDropdown.innerHTML = `<option value="Varicella">Varicella (Chickenpox)</option>
                                         <option value="Typhoid">Typhoid</option>`;
        }
    }
}
</script>

</body>
</html>
