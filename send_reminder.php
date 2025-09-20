<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Include Database Connection
include 'includes/db_connect.php';  

// ✅ Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ✅ Check if `schedule_id` is passed
if (!isset($_GET['schedule_id']) || empty($_GET['schedule_id'])) {
    die("Error: Schedule ID is missing!");
}

$schedule_id = intval($_GET['schedule_id']); // Ensure it's an integer

// ✅ Fetch Parent Email and Vaccine Details
$query = "
    SELECT 
        p.email, 
        c.name AS child_name, 
        v.vaccine_name, 
        vs.scheduled_date
    FROM vaccinationschedules vs
    JOIN children c ON vs.child_id = c.id
    JOIN users p ON c.parent_id = p.id
    JOIN vaccines v ON vs.vaccine_id = v.id
    WHERE vs.id = ?";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}

$stmt->bind_param("i", $schedule_id);
$stmt->execute();
$result = $stmt->get_result();

// ✅ Check if a parent email exists
if ($row = $result->fetch_assoc()) {
    $parent_email = $row['email'];
    $child_name = $row['child_name'];
    $vaccine_name = $row['vaccine_name'];
    $scheduled_date = date('d M Y', strtotime($row['scheduled_date']));

    // ✅ Validate Parent Email
    if (empty($parent_email)) {
        die("Error: Parent email is missing!");
    }

    // ✅ Send Email Reminder using PHPMailer
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'deepajkadam1234@gmail.com'; // Your Gmail
        $mail->Password = 'ojzv tvqe zams njte';       // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('deepajkadam1234@gmail.com', 'Vaccination Reminder');
        $mail->addAddress($parent_email);
        $mail->Subject = 'Vaccination Reminder';

        // ✅ Updated message with the required format
        $mail->Body = "
        Your child, <strong>$child_name</strong>, is scheduled for the upcoming vaccine<strong>$vaccine_name</strong> on 
        <strong>$scheduled_date</strong>.
        ";

        $mail->isHTML(true);  // Ensure HTML formatting

        if ($mail->send()) {
            // ✅ Update reminder_sent to 1
            $updateSql = "UPDATE vaccinationschedules SET reminder_sent = 1 WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("i", $schedule_id);
            $updateStmt->execute();

            // ✅ Success Message
            echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Reminder Sent</title>
                <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
                <style>
                    body {
                        font-family: "Poppins", sans-serif;
                        background: #f5f7fa;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                    }
                    .container {
                        background: #fff;
                        padding: 30px;
                        border-radius: 10px;
                        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                        text-align: center;
                        max-width: 400px;
                    }
                    .success-icon {
                        font-size: 50px;
                        color: #28a745;
                        margin-bottom: 15px;
                    }
                    h2 {
                        font-size: 22px;
                        color: #333;
                        margin-bottom: 10px;
                    }
                    p {
                        font-size: 16px;
                        color: #555;
                        margin-bottom: 20px;
                    }
                    .btn {
                        display: inline-block;
                        padding: 10px 20px;
                        background: #007bff;
                        color: #fff;
                        text-decoration: none;
                        border-radius: 5px;
                        transition: 0.3s;
                    }
                    .btn:hover {
                        background: #0056b3;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="success-icon">✅</div>
                    <h2>Reminder Sent Successfully!</h2>
                    <p>An email reminder has been sent to <strong>'.$parent_email.'</strong>.</p>
                    <a href="admin/manage_vaccination_schedules.php" class="btn">Go Back</a>
                </div>
            </body>
            </html>';
        } else {
            echo "Failed to send reminder: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Mail Error: " . $e->getMessage();
    }
} else {
    echo "No parent found for this schedule ID.";
}

// ✅ Close resources
$stmt->close();
$conn->close();
?>
