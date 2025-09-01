<?php include("../includes/header.php"); 
session_start();
require_once __DIR__ . "/../includes/db/config.php";
?>
<link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/login.css">


<?php 
    session_start();

    $nameErr = $passErr = $success = "";
    
    function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {   

        $user = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);
        $valid = true;

        
        if (empty($user)) {
            $nameErr = "Username or Email is required";
            $valid = false;
        }

       
        if (empty($password)) {
            $passErr = "You did not provide a password";
            $valid = false;
        }

        if ($valid) {
            $stmt = $conn->prepare("SELECT employee_id, name, email, password, role, status 
                                FROM employees 
                                WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $row['password'])) {
                if ($row['status'] !== "active") {
                    $passErr = "Account is not active.";
                } else {
                    // ✅ Login successful
                    session_regenerate_id(true); // prevent session fixation
                    $_SESSION['admin_id'] = $row['employee_id'];
                    $_SESSION['admin_name'] = $row['name'];
                    $_SESSION['role'] = $row['role'];

                    if ($row['role'] === 'admin') {
                        header("Location: Admin/admin-dash.php");
                    } else {
                        header("Location: Employee/employee-dash.php");
                    }
                    exit();
                }
            } else {
                $passErr = "Invalid username or password";
            }
        } else {
            $passErr = "Invalid username or password";
        }
        
    }
}

?>


<main>
    <div class="login-block">
        <div class="left-part">

            <div class="login-slides">
                <img src="../assets/images/login/car1.jpg" alt="login image1">
                <img src="../assets/images/login/car2.jpg" alt="login image2">
                <img src="../assets/images/login/car3.jpg" alt="login image3">
                <img src="../assets/images/login/car4.jpg" alt="login image4">
            </div>
            
        </div>

        <div class="right-part">
            <h1>Welcome back Rider!</h1>
            <p> Sign in your account </p>
            <form action="login.php" method="post">
                <div class="input-field">
                     <input type="text" name="username" placeholder="Enter your username/email">
                     <div style="color:red">* <?php echo $nameErr; ?></div>
                </div>
                <div class="input-field">
                    <input type="password" name="password" placeholder="Enter your password">
                    <div style="color:red">* <?php echo $passErr; ?></div>
                </div>
                <button type="submit" class="btn-main" name="login">Login</button>
            </form>

            <p class="signup-link">Don't have an account? <a href="register.php">Sign Up</a></p> 
        </div>


    
    </div>
</main>






<?php include ('../includes/footer.php'); ?>