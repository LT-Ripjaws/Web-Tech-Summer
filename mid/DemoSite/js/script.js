function validateForm(e) {
    e.preventDefault();
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


     /*let isValid = true;
            function validateForm(e) {

                let name = e.target.name + 'Error';
                document.querySelector(#${name}).textContent = "";
                isValid = true;
                
                if(e.target.value.trim() === ""){
                    isValid = false;
                    document.querySelector(`#${name}`).textContent = "Please fill the field";
                }
            }

            function a(){
                // e.preventDefault();
                document.querySelectorAll(".required").forEach(input => {
                    input.addEventListener("blur", validateForm);
                });
            }

            a();

            document.getElementById("regForm").addEventListener("submit", function a(e){
                if (!isValid) e.preventDefault();
            });






            //chat's
            document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("regForm");
            const nameInput = document.getElementById("patientName");
            const nameError = document.getElementById("nameError");

            form.addEventListener("submit", function (e) {
                // Clear previous error
                nameError.textContent = "";

                if (nameInput.value.trim() === "") {
                    e.preventDefault(); // stop form submission
                    nameError.textContent = "Full name is required.";
                }
            });
        });
    */
}

document.getElementById("regForm").addEventListener("submit", validateForm);