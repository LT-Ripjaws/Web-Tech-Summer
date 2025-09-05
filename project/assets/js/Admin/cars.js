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



  const searchBar = document.getElementById("searchBar");
  const brandFilter = document.getElementById("brandFilter");
  const statusFilter = document.getElementById("statusFilter");
  const searchBtn = document.getElementById("searchBtn");
  const rows = document.querySelectorAll(".employee-table tbody tr");

  function filterCars() {
    const searchText = searchBar.value.toLowerCase().trim();
    const brandValue = brandFilter.value.toLowerCase();
    const statusValue = statusFilter.value.toLowerCase();

    rows.forEach(row => {
      const vin = row.querySelector(".vin").textContent.toLowerCase();
      const brand = row.querySelector(".brand").textContent.toLowerCase();
      const model = row.querySelector(".model").textContent.toLowerCase();
      const status = row.querySelector(".status").textContent.toLowerCase();

      const matchesSearch =
        !searchText ||
        vin.includes(searchText) ||
        brand.includes(searchText) ||
        model.includes(searchText);

      const matchesBrand = !brandValue || brand === brandValue;
      const matchesStatus = !statusValue || status === statusValue;

      if (matchesSearch && matchesBrand && matchesStatus) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  }

  searchBtn.addEventListener("click", (e) => {
    e.preventDefault();
    filterCars();
  });