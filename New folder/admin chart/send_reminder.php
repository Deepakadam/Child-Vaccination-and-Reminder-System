<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Load PHPMailer from the vendor folder

function sendEmailReminder($toEmail, $childName, $vaccineName, $dueDate) {
    $mail = new PHPMailer(true);
    
    try {
        // SMTP Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Change if using a different email provider
        $mail->SMTPAuth = true;
        $mail->Username = 'deepajkadam1234@gmail.com'; // Your email
        $mail->Password = 'kimteahyung'; // Use an App Password if using Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email details
        $mail->setFrom('deepajkadam1234@gmail.com', 'Vaccination Reminder');
        $mail->addAddress($toEmail); // Parent's email
        $mail->Subject = 'Vaccination Reminder for ' . $childName;
        $mail->Body = "Hello,\n\nThis is a reminder that your child $childName is due for the $vaccineName vaccine on $dueDate.\n\nPlease ensure timely vaccination.";

        // Send Email
        $mail->send();
        echo "Reminder email sent successfully!";
    } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    }
}

// Example Usage (Replace with actual data)
sendEmailReminder('rekhagk2002@gmail.com', 'John Doe', 'Polio Vaccine', '2025-02-28');
?>
