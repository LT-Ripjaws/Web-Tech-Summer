<?php include("../includes/header.php"); ?>
<link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/login.css">
<link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">


<?php 
    $nameErr = "";
    $passErr = "";
    $success = "";

    function test_input($data) {
        $data = trim($data);            
        $data = stripslashes($data);     
        return $data;   
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
             if($user == "admin" && $password == "1234")
              {
                   $success = "Welcome back, " .$user. "!";
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
            <h1>Welcome back fellow rider!</h1>
            <p> Sign in your account </p>
            <p style="color:green; font-weight:bold;">
                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($nameErr) && empty($passErr) && isset($_POST["login"])) {
                        echo $success;} ?> 
            </p>

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