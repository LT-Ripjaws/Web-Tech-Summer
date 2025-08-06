function validateForm() {
    let isValid = true;

   var patientname = document.getElementById("patientName").value.trim();
    var nameError = document.getElementById("nameError");

    if (patientname === "") {
        nameError.textContent = "Please enter the name field.";
        isValid = false;
    } else {
        nameError.textContent = "";
        isvalid = true;
    
    }

    var age = document.getElementById("age").value.trim();
    var ageError = document.getElementById("ageError");
    if (age === "") {
        ageError.textContent = "Please enter the age field.";
        isValid = false;
    } else if (isNaN(age) || age < 0 || age > 120) {
        ageError.textContent = "Please enter a valid age between 0 and 120.";
        isValid = false;
    } else {
        ageError.textContent = "";
    }

    var username = document.getElementById("username").value.trim();
    var usernameError = document.getElementById("usernameError");
    if (username === "") {
        usernameError.textContent = "Please enter the username field.";
        isValid = false;
    } else {
        usernameError.textContent = "";
        isValid = true;
}
}