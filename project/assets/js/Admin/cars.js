  const addCarBtn = document.querySelector(".topbar .btn-main"); 
  const modal = document.getElementById("addCarfunc");
  const cancelBtn = modal.querySelector(".form-actions button[type='button']");

 
  addCarBtn.addEventListener("click", () => {
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