<?php
session_start();
include('includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"]; // No hashing
    
    // Basic validation
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $error = "Phone number must be 10 digits!";
    } else {
        // Insert into DB without hashing
        $stmt = $conn->prepare("INSERT INTO Users (name, email, phone, password, role) VALUES (?, ?, ?, ?, 'parent')");
        $stmt->bind_param("ssss", $name, $email, $phone, $password);
        
        if ($stmt->execute()) {
            header("Location: login.php?success=registered"); // Redirect to login page
            exit();
        } else {
            $error = "❌ Registration failed! Email or phone might be already used.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('ch.webp'); /* Background Image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
                
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.1); /* Glass Effect */
            padding: 25px;
            width: 350px;
            border-radius: 15px;
            backdrop-filter: blur(8px);
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            color: white;
            font-size: 24px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.7);
            outline: none;
            font-size: 16px;
        }

        .btn {
            width: 100%;
            background: #6C63FF; /* Matching Button */
            color: white;
            border: none;
            padding: 12px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
        }

        .btn:hover {
            background: #5a54e3;
        }

        .error {
            color: #ff4d4d;
            text-align: center;
            font-weight: bold;
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Parent Registration</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" action="">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone (10 digits)" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn">Register</button>
    </form>

    <a href="login.php" class="login-link">Already have an account? Login</a>
</div>

</body>
</html>
