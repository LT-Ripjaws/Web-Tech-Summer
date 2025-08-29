<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>

        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">

        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/Admin/dashboard.css">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    </head>
    <body>
        <?php include("../../includes/sidebar.php"); ?>

        <!-- admin dashboard section -->
        <main>
            <header class="topbar">
                <div>
                    <h1>Dashboard</h1>
                </div>
            </header>

            <!-- summarisation cards -->
            <section class="summarisation-cards">
            <div class="card">
                <h3>TOTAL USERS</h3>
                <p id="users">1,247</p>
            </div>
            <div class="card">
                <h3>TOTAL EMPLOYEES</h3>
                <p id="employees">42</p>
            </div>
            <div class="card">
                <h3>CARS ADDED</h3>
                <p id="cars">186</p>
            </div>
            <div class="card">
                <h3>BOOKINGS</h3>
                <p id="bookings">73</p>
            </div>
            <div class="card">
                <h3>TOTAL REVENUE</h3>
                <p id="revenue">$847,320</p>
            </div>
            </section>


            <!-- Charts  -->
            <section class="chart-grid">
            <div class="panel">
                <h4>Sales (Last 30 days)</h4>
                <div id="sales" class="chart-holder">

                </div>
            </div>
            <div class="panel">
                <h4>Sales by Car Brand</h4>
                <div id="sales-brand" class="chart-holder">
                    
                </div>
            </div>
            </section>

            <!-- Tables -->
            <section class="table-grid">
            <div class="panel">
                <h4>Recent Users</h4>
                <table>
                <thead>
                    <tr>
                        <th>ID</th><th>Name</th><th>Email</th><th>Role</th>
                    </tr>
                </thead>
                <tbody id="table-users">
                    <!-- JS  -->
                </tbody>
                </table>
            </div>
            <div class="panel">
                <h4>Recent Cars Added</h4>
                <table>
                <thead>
                    <tr><th>ID</th><th>Brand</th><th>Model</th><th>Year</th></tr>
                </thead>
                <tbody id="table-cars">
                    <!-- JS  -->
                </tbody>
                </table>
            </div>
            </section>
        </main>
    <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
    </body>
</html>