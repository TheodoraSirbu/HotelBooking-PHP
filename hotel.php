<?php
// Retrieve hotel ID from the URL parameter
$hotelID = $_GET['hotelID'];

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

// Fetch hotel details from the database based on the hotel ID
$query = "SELECT * FROM Hotels WHERE HotelID = :hotelID";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':hotelID', $hotelID);
$stmt->execute();
$hotel = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch room types for the specific hotel
$query = "SELECT DISTINCT Type FROM Rooms WHERE HotelID = :hotelID";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':hotelID', $hotelID);
$stmt->execute();
$roomTypes = $stmt->fetchAll(PDO::FETCH_COLUMN);

// You can perform additional error handling or redirect if the hotel doesn't exist

// HTML - hotel page
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $hotel['Name']; ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
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

        p {
            margin: 0;
            color: #777;
            text-align: center;
        }

        form {
            margin-top: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        select,
        input[type="date"],
        button {
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

        input[type="date"]::-webkit-inner-spin-button,
        input[type="date"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="date"] {
            -webkit-appearance: none;
            appearance: none;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }
        #price {
            font-size: 18px;
            font-weight: bold;
            color: #4CAF50;
            margin-top: 10px;
        }
        .goback-button {
            display: block;
            margin-top: 20px;
            text-align: center;
        }

        .goback-button a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .goback-button a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><?php echo $hotel['Name']; ?></h1>
    <p><?php echo $hotel['Address']; ?></p>
    <p><?php echo $hotel['City']; ?></p>
    <p><?php echo $hotel['Country']; ?></p>

    <form action="book.php" method="post">
        <input type="hidden" name="hotelID" value="<?php echo $hotel['HotelID']; ?>">

        <label for="roomType">Room Type:</label>
        <select id="roomType" name="roomType">
            <?php foreach ($roomTypes as $roomType): ?>
                <option value="<?php echo $roomType; ?>"><?php echo $roomType; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="checkInDate">Check-in Date:</label>
        <input type="date" id="checkInDate" name="checkInDate" required>

        <label for="checkOutDate">Check-out Date:</label>
        <input type="date" id="checkOutDate" name="checkOutDate" required>

        <p id="price"></p>
        <button type="submit">Book Now</button>

    </form>
    <div class="goback-button">
        <a href="main_page.php">Go Back</a>
    </div>

    <script>
        // Calculate and display the price based on the selected dates
        const checkInDateInput = document.getElementById('checkInDate');
        const checkOutDateInput = document.getElementById('checkOutDate');
        const priceDisplay = document.getElementById('price');

        checkInDateInput.addEventListener('change', updatePrice);
        checkOutDateInput.addEventListener('change', updatePrice);

        function updatePrice() {
            const checkInDate = new Date(checkInDateInput.value);
            const checkOutDate = new Date(checkOutDateInput.value);

            if (checkInDate < checkOutDate) {
                const nights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24)); // Calculate number of nights
                const roomType = document.getElementById('roomType').value;
                // Get the room type and perform calculations based on the selected room
                let pricePerNight;
                if (roomType === 'Standard') {
                    pricePerNight = 100; // Set the price per night for the Standard room
                } else if (roomType === 'Deluxe') {
                    pricePerNight = 150; // Set the price per night for the Deluxe room
                }
                // Add more room types and their respective prices if needed

                // Calculate the total price based on the number of nights and price per night
                const totalPrice = nights * pricePerNight;

                // Display the calculated price
                priceDisplay.textContent = `Total Price: $${totalPrice.toFixed(2)}`;
            } else {
                // Clear the price display if the selected dates are invalid
                priceDisplay.textContent = '';
            }
        }
    </script>
</div>
</body>
</html>