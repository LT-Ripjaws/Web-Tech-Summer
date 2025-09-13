<?php
session_start();

if(!isset($_SESSION['user_id']) && isset($_COOKIE['user-email']))
{
    $email = $conn->real_escape_string($_COOKIE['user-email']);
    $sql = "SELECT employee_id, name, role FROM employees WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1)
    {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['employee_id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['role'] = $row['role'];
    }
}


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include("../../includes/db/config.php");

$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'] ?? 0;


$employees = $conn->query("SELECT COUNT(*) as total FROM employees")->fetch_assoc()['total'] ?? 0;


$cars = $conn->query("SELECT COUNT(*) as total FROM cars")->fetch_assoc()['total'] ?? 0;


$bookings = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'] ?? 0;


$revenue = $conn->query("SELECT SUM(c.price) as total 
                        FROM bookings b 
                        JOIN cars c ON b.car_id=c.car_id 
                        WHERE b.status='sold'")->fetch_assoc()['total'] ?? 0;



?>

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
        <div class="full-container">
       
        <?php include("../../includes/sidebar.php"); ?>
        <!-- admin dashboard section -->
        <main>
            <header class="topbar">
                <div>
                    <h1>Dashboard</h1>
                    <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                </div>
            </header>

            <!-- summarisation cards -->
            <section class="summarisation-cards">
            <div class="card">
                <h3>TOTAL USERS</h3>
                <p id="users"><?php echo $users ?></p>
            </div>
            <div class="card">
                <h3>TOTAL EMPLOYEES</h3>
                <p id="employees"><?php echo $employees; ?></p>
            </div>
            <div class="card">
                <h3>CARS ADDED</h3>
                <p id="cars"><?php echo $cars; ?></p>
            </div>
            <div class="card">
                <h3>BOOKINGS</h3>
                <p id="bookings"><?php echo $bookings; ?></p>
            </div>
            <div class="card">
                <h3>TOTAL REVENUE</h3>
                <p id="revenue">$<?php echo number_format($revenue, 2); ?></p>
            </div>
            </section>


            <!-- Charts  -->
            <section class="chart-grid">
            <div class="panel">
                <h4>Sales (Last 30 days)</h4>
                <div id="sales" class="chart-holder">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            <div class="panel">
                <h4>Sales by Car Brand</h4>
                <div id="sales-brand" class="chart-holder">
                    <canvas id="BrandChart"></canvas>
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
                     <?php
                        $sql = "SELECT id, username, email, role FROM users ORDER BY created_at DESC LIMIT 5";
                        $resultUsers = $conn->query($sql);

                        if ($resultUsers && $resultUsers->num_rows > 0) {
                            while ($u = $resultUsers->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($u['id']) . "</td>
                                        <td>" . htmlspecialchars($u['username']) . "</td>
                                        <td>" . htmlspecialchars($u['email']) . "</td>
                                        <td>" . htmlspecialchars($u['role']) . "</td>
                                    </tr>";
                            }
                        } elseif ($resultUsers) {
                            echo "<tr><td colspan='4'>No recent users found</td></tr>";
                        } else {
                            echo "<tr><td colspan='4'>Query error: " . htmlspecialchars($conn->error) . "</td></tr>";
                        }
                        ?>
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
                     <?php
                        $sqlCars = "SELECT car_id, brand, model, year FROM cars ORDER BY created_at DESC LIMIT 5";
                        $resultCars = $conn->query($sqlCars);

                        if ($resultCars && $resultCars->num_rows > 0) {
                            while ($c = $resultCars->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($c['car_id']) . "</td>
                                        <td>" . htmlspecialchars($c['brand']) . "</td>
                                        <td>" . htmlspecialchars($c['model']) . "</td>
                                        <td>" . htmlspecialchars($c['year']) . "</td>
                                    </tr>";
                            }
                        } elseif ($resultCars) {
                            echo "<tr><td colspan='4'>No recent cars found</td></tr>";
                        } else {
                            echo "<tr><td colspan='4'>Query error: " . htmlspecialchars($conn->error) . "</td></tr>";
                        }
                     ?>
                </tbody>
                </table>
            </div>
            </section>
        </main>
        </div>
    <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>




    <?php
        
        $salesData = [];
        $dateLabels = [];
        $result = $conn->query("
            SELECT DATE(booking_date) as day, COUNT(*) as total 
            FROM bookings 
            WHERE booking_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
            GROUP BY day
            ORDER BY day ASC
        ");
        while ($row = $result->fetch_assoc()) {
            $dateLabels[] = $row['day'];
            $salesData[] = $row['total'];
        }

        
        $brandLabels = [];
        $brandData = [];
        $resultBrand = $conn->query("
            SELECT c.brand, COUNT(b.booking_id) as total
            FROM bookings b
            JOIN cars c ON b.car_id = c.car_id
            GROUP BY c.brand
            ORDER BY total DESC
            LIMIT 5
        ");
        while ($row = $resultBrand->fetch_assoc()) {
            $brandLabels[] = $row['brand'];
            $brandData[] = $row['total'];
        }
        ?>


        <script>
            
            const salesLabels = <?php echo json_encode($dateLabels); ?>;
            const salesData = <?php echo json_encode($salesData); ?>;

            new Chart(document.getElementById('salesChart'), {
                type: 'line',
                data: {
                    labels: salesLabels,
                    datasets: [{
                        label: 'Bookings',
                        data: salesData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true },
                    },
                    scales: {
                        x: { title: { display: true, text: 'Date' } },
                        y: { title: { display: true, text: 'Bookings' }, beginAtZero: true }
                    }
                }
            });

            
            const brandLabels = <?php echo json_encode($brandLabels); ?>;
            const brandData = <?php echo json_encode($brandData); ?>;

            new Chart(document.getElementById('BrandChart'), {
                type: 'pie',
                data: {
                    labels: brandLabels,
                    datasets: [{
                        label: 'Bookings by Brand',
                        data: brandData,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
            </script>
    </body>
</html>