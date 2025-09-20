<?php
session_start();
include('includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password == $row['password']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['name'] = $row['name'];

            // Redirect based on role
            if ($row['role'] == 'admin') {
                header("Location: admin/admin_dashboard.php");
            } else {
                header("Location: parent/parent_dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid Password!";
        }
    } else {
        $error = "No account found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .message {
            color: #ff4d4d;
            text-align: center;
            font-weight: bold;
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Login</h2>

    <?php if (isset($error)) echo "<p class='message'>$error</p>"; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn">Login</button>
    </form>

    <a href="register.php" class="register-link">Don't have an account? Register here</a>
</div>

</body>
</html>
