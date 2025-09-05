<?php
require_once("../../../includes/db/config.php");

$result = $conn->query("SELECT * FROM employees ORDER BY joined DESC");

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Team Management</title>

        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/Admin/team.css">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    </head>
    <body>
        <div class="full-container">
            <?php include("../../../includes/sidebar.php"); ?>
             <main>
                <header class="topbar">
                    <h1>Team Management</h1>
                    <button class="btn-main" id="addEmployeeBtn">+ Add Employee</button>
                </header>


                <!-- Search & Filters -->
                <section class="search">
                    <input type="text" id="searchBar" placeholder="Search employees by name, email or phone" class="search-bar">
                    <select id="departmentFilter" class="search">
                        <option value="">All Departments</option>
                        <option value="sales">Sales</option>
                        <option value="service">Service</option>
                        <option value="finance">Finance</option>
                        <option value="admin">Administration</option>
                    </select>
                    <select id="statusFilter" class="search">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="leave">On Leave</option>
                    </select>
                    <button class="btn-main" id="searchBtn">Search</button>
                </section>


                 <!-- Employee Table -->
                <section class="employee-table">
                <table>
                    <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div>
                                        <span class="name"><?php echo $row['name']; ?></span>
                                        <span class="email"><?php echo $row['email']; ?></span>
                                        <span class="phone"><?php echo $row['phone']; ?></span>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $row['role']; ?></td>
                            <td><?php echo $row['department']; ?></td>
                            <td><?php echo date("M d, Y", strtotime($row['joined'])); ?></td>
                            <td><span class="status <?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span></td>
                        <td class="actions">
                        <button 
                            class="btn-main small editBtn"
                            emp-id="<?php echo $row['employee_id']; ?>"
                            emp-name="<?php echo $row['name']; ?>"
                            emp-email="<?php echo $row['email']; ?>"
                            emp-phone="<?php echo $row['phone']; ?>"
                            emp-role="<?php echo $row['role']; ?>"
                            emp-department="<?php echo $row['department']; ?>"
                            emp-status="<?php echo $row['status']; ?>"
                            >Edit</button>
                        <form action="actions/delete_employee.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['employee_id']; ?>">
                            <button type="submit" class="btn-main small danger" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</button>
                        </form>
                        </td>
                    </tr>
                     <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6">No employees yet.</td></tr>
                <?php endif; ?>
                    </tbody>
                </table>
                </section>
             </main>

        </div>

        <!-- Add Employee function-->
<div class="modal" id="addEmployeefunc">
  <div class="form-content">
    <h2 id="modalTitle">Add New Employee</h2>
    <form id="employeeForm" action="actions/add_employee.php" method="POST">
      <input type="hidden" name="employee_id" id="employee_id">
      <label>Name</label>
      <input type="text" name="name" id="name" required>
      
      <label>Email</label>
      <input type="email" name="email" id="email" required>
      
      <label>Phone</label>
      <input type="number" name="phone" id="phone">
      
      <label>Role</label>
      <select name="role" id="role" required>
        <option value="sales">Sales</option>
        <option value="mechanic">Mechanic</option>
        <option value="support">Support</option>
        <option value="other">Other</option>
        <option value="admin">Administration</option>
      </select>
      
      <label>Department</label>
      <select name="department" id="department" required>
        <option value="sales">Sales</option>
        <option value="mechanic">Mechanic</option>
        <option value="finance">Finance</option>
        <option value="admin">Administration</option>
      </select>
      
      <label>Status</label>
      <select name="status" id="status">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
        <option value="leave">On Leave</option>
      </select>
      
      <div class="form-actions">
        <button type="submit" class="btn-main">Save</button>
        <button type="button" class="btn-main">Cancel</button>
      </div>
    </form>
  </div>
</div>
        <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
        <script src="/Web-Tech-Summer/project/assets/js/Admin/employee.js"></script>
    </body>
</html>