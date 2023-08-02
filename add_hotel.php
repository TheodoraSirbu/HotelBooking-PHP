<?php
// Start the session
session_start();

// Check if the user is an admin
// if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] != 1) {
//     // Redirect to the login page or display an error message
//     header("Location: login.php");
//     exit;
// }

// Database connection setup
$host = 'localhost';
$db = 'hotelbooking';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Handle the form submission for adding a new hotel
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    // Insert the new hotel into the database
    $query = "INSERT INTO Hotels (Name, Address, City, Country) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name, $address, $city, $country]);

    // Redirect back to the admin dashboard after adding the hotel
    header("Location: admin_dashboard.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Hotel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            height: 30px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
            color: #555;
        }

        button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }
        form input {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<h1>Add New Hotel</h1>
<div class="container">
    <form method="POST" action="add_hotel.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" required>
        <button type="submit">Add Hotel</button>
    </form>
</div>
</body>
</html>