<?php include("../includes/header.php"); 
session_start();
require_once __DIR__ . "/../includes/db/config.php";
?>
<link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/login.css">


<?php 
   

    $error = "";
    
    function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
    if (isset($_SESSION['admin_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: Admin/admin-dash.php");
    } else {
        header("Location: Employee/employee-dash.php");
    }
    exit();
    }

    if (!isset($_SESSION['admin_id']) && isset($_COOKIE['user_email'])) {
        $email = $conn->real_escape_string($_COOKIE['user_email']);
        $sql = "SELECT employee_id, name, role, status FROM employees WHERE email = '$email' LIMIT 1";
        $result = $conn->query($sql);

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if ($row['status'] === "active") {
                
                session_regenerate_id(true);
                $_SESSION['admin_id']   = $row['employee_id'];
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['role']       = $row['role'];

                
                if ($row['role'] === 'admin') {
                    header("Location: Admin/admin-dash.php");
                } else {
                    header("Location: Employee/employee-dash.php");
                }
                exit();
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {   

        $user = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);
        $valid = true;

        
        if (empty($user) || empty($password)) {
            $error = "All fields are required";
            $valid = false;
        }

        
        if ($valid) {
            $sql = "SELECT employee_id, name, email, password, role, status 
                    FROM employees WHERE email = '$user' LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

           
            if (password_verify($password, $row['password'])) {
                if ($row['status'] !== "active") {
                    $passErr = "Account is not active.";
                } else {
                    session_regenerate_id(true); 
                    $_SESSION['admin_id'] = $row['employee_id'];
                    $_SESSION['admin_name'] = $row['name'];
                    $_SESSION['role'] = $row['role'];

                    if (isset($_POST['remember-me'])) {
                    setcookie("user_email", $row['email'], time() + (86400 * 30), "/"); 
                    }

                    if ($row['role'] === 'admin') {
                        header("Location: Admin/admin-dash.php");
                    } else {
                        header("Location: Employee/employee-dash.php");
                    }
                    exit();
                }
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
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
            <?php if (!empty($error)): ?>
                <div class="error-box">
                        <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="input-field">
                     <input type="text" name="username" placeholder="Enter your username/email">
                     <div style="color:red">*</div>
                </div>
                <div class="input-field">
                    <input type="password" name="password" placeholder="Enter your password">
                    <div style="color:red">*</div>
                </div>
                <div class="remember">
                    <input type="checkbox" class="remember-me" name="remember-me"> Remember Me?
                </div><br>
                <button type="submit" class="btn-main" name="login">Login</button>
            </form>

            <p class="signup-link">Don't have an account? <a href="register.php">Sign Up</a></p> 
        </div>


    
    </div>
</main>






<?php include ('../includes/footer.php'); ?>