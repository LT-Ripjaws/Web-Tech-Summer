  const modal = document.getElementById("addEmployeefunc");
  const openBtn = document.getElementById("addEmployeeBtn");
  const cancelBtn = modal.querySelector("button[type='button']");
  const form = document.getElementById("employeeForm");
  const title = document.getElementById("modalTitle");
  const id = document.getElementById("employee_id");

 
  openBtn.addEventListener("click", () => {
    form.action = "actions/add_employee.php";
    title.textContent = "Add New Employee";
    form.reset();
    id.value="";
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

  document.querySelectorAll(".editBtn").forEach(btn => {
    btn.addEventListener("click", () => {
      form.action="actions/edit_employee.php";
      title.textContent = "Edit Employee";

      document.getElementById("employee_id").value = btn.getAttribute("emp-id"); //i might have to use HTML dataset attribute here later
      document.getElementById("name").value = btn.getAttribute("emp-name");
      document.getElementById("email").value = btn.getAttribute("emp-email");
      document.getElementById("phone").value = btn.getAttribute("emp-phone");
      document.getElementById("role").value = btn.getAttribute("emp-role");
      document.getElementById("department").value = btn.getAttribute("emp-department");
      document.getElementById("status").value =  btn.getAttribute("emp-status");

      modal.classList.add("show");
    })
  })



const searchBar = document.getElementById("searchBar");
const departmentFilter = document.getElementById("departmentFilter");
const statusFilter = document.getElementById("statusFilter");
const searchBtn = document.getElementById("searchBtn");
const rows = document.querySelectorAll(".employee-table tbody tr");

function filterTable() {
  const searchText = searchBar.value.toLowerCase().trim();
  const departmentValue = departmentFilter.value.toLowerCase();
  const statusValue = statusFilter.value.toLowerCase();

  rows.forEach(row => {
    const name = row.querySelector(".name").textContent.toLowerCase();
    const email = row.querySelector(".email").textContent.toLowerCase();
    const phone = row.querySelector(".phone").textContent.toLowerCase();
    const department = row.children[2].textContent.toLowerCase(); 
    const status = row.querySelector(".status").textContent.toLowerCase();

    const matchesSearch =
      !searchText || 
      name.includes(searchText) ||
      email.includes(searchText) ||
      phone.includes(searchText);

    const matchesDepartment = !departmentValue || department === departmentValue;
    const matchesStatus = !statusValue || status === statusValue;

    if (matchesSearch && matchesDepartment && matchesStatus) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
}


searchBtn.addEventListener("click", (e) => {
  e.preventDefault(); 
  filterTable();
});