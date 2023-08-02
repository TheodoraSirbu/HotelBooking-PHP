<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password_db = ""; // Provide the actual database password
    $dbname = "hotelbooking";

    $conn = new mysqli($servername, $username, $password_db, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the query to verify user credentials
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, check if admin
        $row = $result->fetch_assoc();
        $userID = $row['UserID'];

        if ($row['isAdmin'] == 1) {
            $_SESSION['user'] = [
                'email' => $email,
                'userID' => $userID
            ];
            header("Location: admin_dashboard.php"); // Redirect to the admin dashboard
            exit(); // Add this line to prevent further code execution
        } else {
            $_SESSION['user'] = [
                'email' => $email,
                'userID' => $userID
            ];
            header("Location: main_page.php"); // Redirect to the main page for normal users
            exit(); // Add this line to prevent further code execution
        }
    } else {
        $error = "Invalid email or password";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form id="login-form" action="login.php" method="POST">
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>
<script src="script.js"></script>
</body>
</html>