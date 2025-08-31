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
            <?php include("../../includes/sidebar.php"); ?>
             <main>
                <header class="topbar">
                    <h1>Team Management</h1>
                    <button class="btn-main" id="addEmployeeBtn">+ Add Employee</button>
                </header>


                <!-- Search & Filters -->
                <section class="search">
                    <input type="text" placeholder="Search employees..." class="search-bar">
                    <select class="search">
                        <option value="">All Departments</option>
                        <option value="sales">Sales</option>
                        <option value="service">Service</option>
                        <option value="finance">Finance</option>
                        <option value="admin">Administration</option>
                    </select>
                    <select class="search">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="leave">On Leave</option>
                    </select>
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
                    <tr>
                        <td>
                            <div class="employee-info">
                                <img src="employee1.jpg" alt="employee" class="avatar">
                                <div>
                                <span class="name">a name</span>
                                <span class="email">email@retrorides.com</span>
                                <span class="phone">+0182-xxxxx</span>
                                </div>
                            </div>
                        </td>
                        <td>Sales Executive</td>
                        <td>Sales</td>
                        <td>Jan 12, 2021</td>
                        <td><span class="status active">Active</span></td>
                        <td class="actions">
                        <button class="btn-main small">Edit</button>
                        <button class="btn-main small">Promote</button>
                        <button class="btn-main small warning">Deactivate</button>
                        <button class="btn-main small danger">Delete</button>
                        </td>
                    </tr>
                    
                    </tbody>
                </table>
                </section>
             </main>

        </div>

        <!-- Add Employee function-->
<div class="modal" id="addEmployeefunc">
  <div class="form-content">
    <h2>Add New Employee</h2>
    <form>
      <label>Name</label>
      <input type="text" required>
      
      <label>Email</label>
      <input type="email" required>
      
      <label>Phone</label>
      <input type="text">
      
      <label>Role</label>
      <input type="text" required>
      
      <label>Department</label>
      <select required>
        <option value="sales">Sales</option>
        <option value="service">Service</option>
        <option value="finance">Finance</option>
        <option value="admin">Administration</option>
      </select>
      
      <label>Status</label>
      <select>
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