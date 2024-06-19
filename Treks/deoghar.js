document.addEventListener("DOMContentLoaded", function () {
    const hotelBookingForm = document.getElementById('hotel-booking-form');
    const hotelResults = document.getElementById('hotel-results');
    const commentForm = document.getElementById('comment-form');
    const commentsSection = document.getElementById('comments-section');

    hotelBookingForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const location = document.getElementById('location').value;
        const checkin = document.getElementById('checkin').value;
        const checkout = document.getElementById('checkout').value;

        // Make an API request to get hotels
        fetch(`https://booking-com.p.rapidapi.com/v1/hotels/search?location=${location}&checkin=${checkin}&checkout=${checkout}`, {
            method: 'GET',
            headers: {
                'x-rapidapi-key': 'ae5116775bmshc503f2a3d81db43p14c805jsn60e01932727e',
                'x-rapidapi-host': 'booking-com.p.rapidapi.com'
            }
        })
        .then(response => response.json())
        .then(data => {
            hotelResults.innerHTML = '';
            data.hotels.forEach(hotel => {
                const hotelElement = document.createElement('div');
                hotelElement.innerHTML = `<h3>${hotel.name}</h3><p>${hotel.address}</p>`;
                hotelResults.appendChild(hotelElement);
            });
        })
        .catch(error => console.error('Error:', error));
    });

    commentForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const comment = document.getElementById('comment').value;
        const commentElement = document.createElement('div');
        commentElement.innerHTML = `<p>${comment}</p>`;
        commentsSection.appendChild(commentElement);
        commentForm.reset();
    });
});

// Light/Dark toggle
const checkbox = document.getElementById("checkbox");

function introAboutLogoTransition() {
    $("#about-quad").css("top", "70%");
    $("#about-quad").css("opacity", "1");
}

function checkDarkMode() {
    if (
        localStorage.getItem("tourism_website_darkmode") !== null &&
        localStorage.getItem("tourism_website_darkmode") === "true"
    ) {
        document.body.classList.add("dark");
        checkbox.checked = true;
    }
}
checkDarkMode();

checkbox.addEventListener("change", () => {
    document.body.classList.toggle("dark");
    document.body.classList.contains("dark")
        ? localStorage.setItem("tourism_website_darkmode", true)
        : localStorage.setItem("tourism_website_darkmode", false);
});
