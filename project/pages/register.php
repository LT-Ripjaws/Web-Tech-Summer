<?php include("../includes/header.php"); 
include("../includes/db/config.php"); 

if (isset($_POST['register'])) {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $error="";
    $success="";
    $valid = true;

 
    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $error = "All fields are required.";
        $valid = false;
    }

 
    if ($valid) {
        $email = $conn->real_escape_string($email);
        $check = $conn->query("SELECT id FROM users WHERE email = '$email' LIMIT 1");
        if ($check && $check->num_rows > 0) {
            $error = "This email is already registered. Try logging in.";
            $valid = false;
        }
    }

   
    if ($valid && strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
        $valid = false;
    }

    
    if ($valid && $password !== $confirm) {
        $error = "Passwords do not match!";
        $valid = false;
    }

    
    if ($valid) {
        $username = $conn->real_escape_string($username);
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) 
                VALUES ('$username', '$email', '$hashed')";
        if ($conn->query($sql)) {
            $success= "Registration successful! Login from login page";
        } else {
            echo "<p style='color:red'>Database error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red'>$error</p>";
    }
}

?>
<link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/register.css">

<main>
    <section class="register-card">
        <div class="headings">
            <h1>Create Account</h1>
            <p>Join the ride today</p>
        </div>
         <?php if (!empty($error)): ?>
                <div class="error-box">
                        <p><?php echo $error; ?></p>
                </div>
                 <?php elseif (!empty($success)): ?>
                <div class="success-box">
                        <p><?php echo $success; ?></p>
                </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="input-field">
                <input type="text" name="username" placeholder="Username">
            </div>
            <div class="input-field">
                <input type="email" name="email" placeholder="Email">
            </div>
            <div class="input-field">
                <input type="password" name="password" placeholder="Password">
            </div>
            <div class="input-field">
                <input type="password" name="confirm_password" placeholder="Confirm Password">
            </div>

            <button type="submit" class="btn-main" name="register">Register?</button>
        </form>
        <p class="signup-link">Already have an account? <a href="login.php"> Login </a></p>
    </section>

</main>
<?php include("../includes/footer.php"); ?>