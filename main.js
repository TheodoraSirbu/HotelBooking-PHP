// Fetch hotels from the server
fetch('get_hotels.php')
    .then(response => response.json())
    .then(data => {
        const hotelsContainer = document.getElementById('hotels');

        // Loop through the hotels data and create hotel cards
        data.forEach(hotel => {
            const hotelCard = document.createElement('div');
            hotelCard.classList.add('hotel-card');

            const hotelName = document.createElement('h2');
            hotelName.textContent = hotel.Name;

            const hotelAddress = document.createElement('p');
            hotelAddress.textContent = `${hotel.Address}, ${hotel.City}, ${hotel.Country}`;

            const bookButton = document.createElement('a');
            bookButton.href = `hotel.php?hotelID=${hotel.HotelID}`;
            bookButton.textContent = 'Book Now';

            hotelCard.appendChild(hotelName);
            hotelCard.appendChild(hotelAddress);
            hotelCard.appendChild(bookButton);

            hotelsContainer.appendChild(hotelCard);
        });
    });