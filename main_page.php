<!DOCTYPE html>
<html>
<head>
    <title>Hotel Booking</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<h1>Hotel Booking</h1>

<select id="citySelect">
    <option value="">--Select City--</option>
    <!-- This will be populated by JavaScript -->
</select>

<button id="filterButton">Filter</button>

<div id="hotels"></div>

<script>
    $(document).ready(function() {
        // Fetch all hotels when the page loads
        fetchHotels();

        // Fetch all cities and populate the select element
        fetchCities();

        // Add an event listener to the filter button
        $("#filterButton").click(function() {
            var selectedCity = $("#citySelect").val();
            fetchHotels(selectedCity);
        });
    });

    function fetchHotels(city) {
        var url = "get_hotels.php";

        // If a city is specified, add it as a parameter to the URL
        if (city) {
            url += "?city=" + city;
        }

        $.getJSON(url, function(data) {
            var html = "";

            $.each(data, function(key, value) {
                html += "<div>";
                html += "<h2>" + value.Name + "</h2>";
                html += "<p>" + value.Address + "</p>";
                html += "<p>" + value.City + ", " + value.Country + "</p>";
                html += "<a href='hotel.php?hotelID=" + value.HotelID + "' class='book-button'>Book</a>";
                html += "</div>";
            });

            $("#hotels").html(html);
        });
    }

    function fetchCities() {
        $.getJSON("get_cities.php", function(data) {
            var html = "";

            $.each(data, function(key, value) {
                html += "<option value='" + value + "'>" + value + "</option>";
            });

            $("#citySelect").html(html);
        });
    }
</script>
</body>
</html>