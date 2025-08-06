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
}