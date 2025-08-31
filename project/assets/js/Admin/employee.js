const modal = document.getElementById("addEmployeefunc");
  const openBtn = document.getElementById("addEmployeeBtn");
  const cancelBtn = modal.querySelector("button[type='button']");

 
  openBtn.addEventListener("click", () => {
    modal.classList.add("show");
  });

  
  cancelBtn.addEventListener("click", () => {
    modal.classList.remove("show");
  });


  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.classList.remove("show");
    }
  });