<?php include("../includes/header.php"); 
session_start();
include("../includes/db/config.php");
?>
<link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/login.css">


<?php 
   

    $error = "";
    
    function test_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }
        if (isset($_SESSION['user_id'])) {
        roleRedirection($_SESSION['role']);
        exit();
    }   

    if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_email'])) {
    $email = $conn->real_escape_string($_COOKIE['user_email']);

    
    $sql = "SELECT employee_id AS id, name, email, role, status 
            FROM employees WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($row['status'] === "active") {
            setUserSession($row['id'], $row['name'], $row['role']);
            roleRedirection($row['role']);
            exit();
        }
    }

    
    $sql2 = "SELECT id, username AS name, email 
            FROM users WHERE email = '$email' LIMIT 1";
    $result2 = $conn->query($sql2);

    if ($result2 && $result2->num_rows === 1) {
        $row2 = $result2->fetch_assoc();
        setUserSession($row2['id'], $row2['name'], "customer");
        roleRedirection("customer");
        exit();
    }
}

   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $user = $conn->real_escape_string(test_input($_POST["username"]));
    $password = test_input($_POST["password"]);

    if (empty($user) || empty($password)) {
        $error = "All fields are required";
    } else {
      
        $sql = "SELECT employee_id AS id, name, email, password, role, status 
                FROM employees WHERE email = '$user' LIMIT 1";
        $result = $conn->query($sql);

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                if ($row['status'] !== "active") {
                    $error = "Account is not active.";
                } else {
                    setUserSession($row['id'], $row['name'], $row['role']);
                    if (isset($_POST['remember-me'])) {
                        setcookie("user_email", $row['email'], time() + (86400 * 30), "/");
                    }
                    roleRedirection($row['role']);
                    exit();
                }
            } else {
                $error = "Invalid username or password";
            }
        } else {
           
            $sql2 = "SELECT id, username AS name, email, password 
                     FROM users WHERE email = '$user' LIMIT 1";
            $result2 = $conn->query($sql2);

            if ($result2 && $result2->num_rows === 1) {
                $row2 = $result2->fetch_assoc();
                if (password_verify($password, $row2['password'])) {
                    setUserSession($row2['id'], $row2['name'], "customer");
                    if (isset($_POST['remember-me'])) {
                        setcookie("user_email", $row2['email'], time() + (86400 * 30), "/");
                    }
                    roleRedirection("customer");
                    exit();
                } else {
                    $error = "Invalid username or password";
                }
            } else {
                $error = "Invalid username or password";
            }
        }
    }
}


function setUserSession($id, $name, $role) {
    session_regenerate_id(true);
    $_SESSION['user_id']   = $id;
    $_SESSION['user_name'] = $name;
    $_SESSION['role']      = $role;
}

function roleRedirection($role) {
    switch ($role) {
        case 'admin':
            header("Location: Admin/admin-dash.php");
            break;
        case 'sales':
            header("Location: Dealer/dealer-dashboard.php");
            break;
        case 'customer':
            header("Location: Customer/dashboard.php");
            break;
        case 'mechanic':
            header("Location: Mechanic/dashboard.php");
            break;
        default:
            header("Location: login.php?error=invalid_role");
            break;
    }
    exit();
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