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

// Retrieve all hotels from the database
$query = "SELECT * FROM Hotels";
$stmt = $pdo->prepare($query);
$stmt->execute();
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table td, table th {
            padding: 10px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f9f9f9;
            text-align: left;
        }

        .button-container {
            text-align: right;
            margin-bottom: 10px;
        }

        .button-container button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .button-container button:hover {
            background-color: #45a049;
        }

        .edit-button {
            background-color: #2196F3;
            transition: background-color 0.3s ease;
        }

        .edit-button:hover {
            background-color: #0D47A1;
        }
    </style>
</head>
<body>
<h1>Admin Dashboard</h1>
<div class="button-container">
    <button onclick="location.href='add_hotel.php'">Add New Hotel</button>
</div>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>City</th>
        <th>Country</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($hotels as $hotel): ?>
        <tr>
            <td><?php echo $hotel['HotelID']; ?></td>
            <td><?php echo $hotel['Name']; ?></td>
            <td><?php echo $hotel['Address']; ?></td>
            <td><?php echo $hotel['City']; ?></td>
            <td><?php echo $hotel['Country']; ?></td>
            <td>
                <a href="edit_hotel.php?hotelID=<?php echo $hotel['HotelID']; ?>" class="edit-button">Edit</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>