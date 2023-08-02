<?php
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

// If a city has been specified, add a WHERE clause to the query
if (isset($_GET['city'])) {
    $city = $_GET['city'];
    $query = "SELECT * FROM Hotels WHERE City = :city";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':city', $city);
} else {
    // If no city was specified, fetch all hotels
    $query = "SELECT * FROM Hotels";
    $stmt = $pdo->prepare($query);
}

$stmt->execute();
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return hotels as JSON response
header('Content-Type: application/json');
echo json_encode($hotels);
?>