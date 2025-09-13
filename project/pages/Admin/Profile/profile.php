<?php 
session_start();
include("../../../includes/db/config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM employees WHERE employee_id = $admin_id");
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>

    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/Admin/profile.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" />
</head>
<body>
<div class="full-container">
    <?php include("../../../includes/sidebar.php"); ?>

    <main>
        <header class="topbar">
            <h1>Profile</h1>
        </header>

        <!-- Profile Overview -->
        <section class="profile-grid">
            <div class="profile-overview">
                <img src="/Web-Tech-Summer/project/assets/images/Admin/profile/default-avatar.png" alt="Profile Picture" class="profile-pic">
                <h2><?php echo htmlspecialchars($admin['name']); ?></h2>
                <p><?php echo htmlspecialchars($admin['role']); ?> - <?php echo htmlspecialchars($admin['department']); ?></p>
                <p>Joined: <?php echo date("F j, Y", strtotime($admin['joined'])); ?></p>
                <p>Status: <strong><?php echo htmlspecialchars($admin['status']); ?></strong></p>
            </div>

            <!-- Editable Info -->
            <div class="panel">
                <h3>Edit Personal Info</h3>
                <form action="update_profile.php" method="POST">
                    <input type="hidden" name="employee_id" value="<?php echo $admin['employee_id']; ?>">

                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>">

                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>">

                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($admin['phone']); ?>">

                    <button class="btn-main" type="submit">Save Changes</button>
                </form>
            </div>
        </section>

        <!-- Password Change -->
        <section class="profile-grid">
            <div class="panel">
                <h3>Change Password</h3>
                <form action="change_password.php" method="POST">
                    <label>Old Password</label>
                    <input type="password" name="old_password">

                    <label>New Password</label>
                    <input type="password" name="new_password">

                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password">

                    <button class="btn-main" type="submit">Update Password</button>
                </form>
            </div>

            <!-- Account Info -->
            <div class="panel">
                <h3>Account Info</h3>
                <p><strong>Employee ID:</strong> <?php echo $admin['employee_id']; ?></p>
                <p><strong>Created At:</strong> <?php echo $admin['created_at']; ?></p>
                <p><strong>Last Updated:</strong> <?php echo $admin['updated_at']; ?></p>
            </div>
        </section>
    </main>
</div>

<script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</body>
</html>