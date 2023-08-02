<?php
// Add or edit hotel logic here

// Retrieve the hotel ID from the URL parameter
$hotelID = $_GET['hotelID'];

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

// Retrieve hotel details from the database based on the hotel ID
$query = "SELECT * FROM Hotels WHERE HotelID = :hotelID";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':hotelID', $hotelID);
$stmt->execute();
$hotel = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission for adding or editing hotel
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if it's a delete request
    // Check if it's a delete request
    // Handle hotel deletion
    if (isset($_POST['deleteHotel'])) {
        // Delete associated bookings first
        $deleteBookingsQuery = "DELETE FROM bookings WHERE RoomID IN (SELECT RoomID FROM rooms WHERE HotelID = :hotelID)";
        $deleteBookingsStmt = $pdo->prepare($deleteBookingsQuery);
        $deleteBookingsStmt->bindParam(':hotelID', $hotelID);
        $deleteBookingsStmt->execute();

        // Delete associated rooms
        $deleteRoomsQuery = "DELETE FROM rooms WHERE HotelID = :hotelID";
        $deleteRoomsStmt = $pdo->prepare($deleteRoomsQuery);
        $deleteRoomsStmt->bindParam(':hotelID', $hotelID);
        $deleteRoomsStmt->execute();

        // Delete the hotel from the database
        $deleteQuery = "DELETE FROM Hotels WHERE HotelID = :hotelID";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->bindParam(':hotelID', $hotelID);
        $deleteStmt->execute();

        // Redirect or display success message
        header("Location: admin_dashboard.php"); // Redirect to the admin dashboard or appropriate page
        exit;
    }

    // Retrieve form data
    $hotelName = $_POST['hotelName'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    // Add or update the hotel in the database
    if ($hotelID) {
        // Perform update
        $updateQuery = "UPDATE Hotels SET Name = :hotelName, Address = :address, City = :city, Country = :country WHERE HotelID = :hotelID";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':hotelID', $hotelID);
        $updateStmt->bindParam(':hotelName', $hotelName);
        $updateStmt->bindParam(':address', $address);
        $updateStmt->bindParam(':city', $city);
        $updateStmt->bindParam(':country', $country);
        $updateStmt->execute();

        // Redirect or display success message
        header("Location: admin_dashboard.php"); // Redirect to the admin dashboard or appropriate page
        exit;
    } else {
        // Perform insertion
        $insertQuery = "INSERT INTO Hotels (Name, Address, City, Country) VALUES (:hotelName, :address, :city, :country)";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(':hotelName', $hotelName);
        $insertStmt->bindParam(':address', $address);
        $insertStmt->bindParam(':city', $city);
        $insertStmt->bindParam(':country', $country);
        $insertStmt->execute();

        // Redirect or display success message
        header("Location: admin_dashboard.php"); // Redirect to the admin dashboard or appropriate page
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Hotel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
            text-align: center;
        }

        input[type="text"] {
            width: 100%;
            height: 40px;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
            color: #555;
            box-sizing: border-box;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
        form {
            width: 40%;
            margin: 0 auto;
        }

        .delete-button {
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #FF0000!important;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .delete-button:hover {

            background-color: #D50000!important;
        }
    </style>
</head>
<body>
<h2>Edit Hotel</h2>
<div class="container">
    <form id="edit-hotel-form" action="edit_hotel.php?hotelID=<?php echo $hotelID; ?>" method="POST">
        <input type="text" name="hotelName" placeholder="Hotel Name" value="<?php echo $hotel['Name']; ?>" required>
        <input type="text" name="address" placeholder="Address" value="<?php echo $hotel['Address']; ?>" required>
        <input type="text" name="city" placeholder="City" value="<?php echo $hotel['City']; ?>" required>
        <input type="text" name="country" placeholder="Country" value="<?php echo $hotel['Country']; ?>" required>
        <button type="submit">Save Changes</button>
    </form>
    <form id="delete-hotel-form" action="edit_hotel.php?hotelID=<?php echo $hotelID; ?>" method="POST">
        <button class="delete-button" type="submit" name="deleteHotel">Delete Hotel</button>
    </form>
</div>
</body>
</html>