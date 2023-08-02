document.getElementById('login-form').addEventListener('submit', function(event) {
    var email = document.querySelector('input[name="email"]').value;
    var password = document.querySelector('input[name="password"]').value;

    if (!validateEmail(email)) {
        alert("Invalid email format");
        event.preventDefault();
    } else if (password.length < 6) {
        alert("Password must be at least 6 characters long");
        event.preventDefault();
    }
});

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}