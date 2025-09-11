<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Management</title>

    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/Admin/cars.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
</head>
<body>
<div class="full-container">
    <?php include("../../../includes/sidebar.php"); ?>
    <main>
        <header class="topbar">
            <h1>Bookings Management</h1>
        </header>

        <!-- Bookings Table -->
        <section class="car-table">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Car</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        include("../../../includes/db/config.php");
                        $sql = "SELECT b.booking_id, b.customer_name, b.customer_email, b.booking_date, b.status, 
                                       c.brand, c.model, c.year
                                FROM bookings b
                                JOIN cars c ON b.car_id = c.car_id
                                ORDER BY b.booking_date DESC";
                        $result = $conn->query($sql);
                        ?>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['booking_id']; ?></td>
                                    <td><?php echo $row['brand'] . " " . $row['model'] . " (" . $row['year'] . ")"; ?></td>
                                    <td><?php echo $row['customer_name']; ?></td>
                                    <td><?php echo $row['customer_email']; ?></td>
                                    <td><?php echo $row['booking_date']; ?></td>
                                    <td><span class="status <?php echo strtolower($row['status']); ?>"><?php echo ucfirst($row['status']); ?></span></td>
                                    <td>
                                    
                                        <a href="actions/cancel_booking.php?booking_id=<?php echo $row['booking_id']; ?>">
                                            <button class="btn-main danger small" onclick="return confirm('Cancel this booking?');">Cancel</button>
                                        </a>
                                      
                                        <a href="actions/mark_sold.php?booking_id=<?php echo $row['booking_id']; ?>">
                                            <button class="btn-main small">Mark as Sold</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="7">No bookings yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
<script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</body>
</html>