<?php include("../includes/header.php"); ?>
<link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/register.css">

<main>
    <section class="register-card">
        <div class="headings">
            <h1>Create Account</h1>
            <p>Join the ride today</p>
        </div>
        <form method="post" action="">
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
                <input type="password" name="password" placeholder="Confirm Password">
            </div>

            <button type="submit" class="btn-main" name="register">Register?</button>
        </form>
        <p class="signup-link">Already have an account? <a href="login.php"> Login </a></p>
    </section>

</main>
<?php include("../includes/footer.php"); ?>