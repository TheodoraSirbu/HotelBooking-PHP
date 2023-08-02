<?php
session_start();

// Retrieve form data
$hotelID = $_POST['hotelID'];
$roomType = $_POST['roomType'];
$checkInDate = $_POST['checkInDate'];
$checkOutDate = $_POST['checkOutDate'];

// You can perform validation, error handling, etc. here

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

// Placeholder for the user ID - replace it with the actual user ID
if (isset($_SESSION['user']['userID'])) {
    $userID = $_SESSION['user']['userID'];
} else {
    // Redirect or display an error message if the user is not logged in
    header("Location: login.php");
    exit;
}

// Retrieve the RoomID based on the hotel ID and room type
$query = "SELECT RoomID FROM Rooms WHERE HotelID = :hotelID AND Type = :roomType";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':hotelID', $hotelID);
$stmt->bindParam(':roomType', $roomType);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$roomID = $row['RoomID'];

// Insert the booking into the database
$query = "INSERT INTO Bookings (UserID, RoomID, CheckInDate, CheckOutDate)
          VALUES (:userID, :roomID, :checkInDate, :checkOutDate)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':userID', $userID);
$stmt->bindParam(':roomID', $roomID);
$stmt->bindParam(':checkInDate', $checkInDate);
$stmt->bindParam(':checkOutDate', $checkOutDate);
$stmt->execute();

// You can perform additional error handling or redirect upon successful booking

// Display a success message
echo "Booking successful! Thank you for your reservation.";
?>