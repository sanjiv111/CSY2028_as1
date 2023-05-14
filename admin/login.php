<?php
// Start the PHP session
session_start();
// Check if the 'name' session variable is set. If yes, redirect to dashboard.php
if (isset($_SESSION['name'])) {
    header('location: dashboard.php');
}
//Check if the email and password are set in the POST request
if (isset($_POST['email']) && isset($_POST['password'])) {
    $connection = include '../config/database.php';
    // Sanitize and fetch the email and password
    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password']));
    // Query the user with the given email
    $user = $connection->query("SELECT * FROM users WHERE email='$email';");
    $user = $user->fetchAll(PDO::FETCH_ASSOC);
    // Check if user exists and the password matches
    if (isset($user) && count($user)) {
        if ($password === $user[0]['password']) {
             // Set the session variables and redirect to the dashboard or index page depending on the user role
            $_SESSION['error'] = '';
            $_SESSION['name'] = $user[0]['name'];
            if ($user[0]['name'] === 'admin') {
                header('location: dashboard.php');
                exit();
            } else {
                header('location: ../index.php');
                exit();
            }
        } else {
            // Set error message for incorrect password
            $_SESSION['error'] = 'Incorrect  password';
        }
    } else {
        $_SESSION['error'] = 'Incorrect Email';
    }
    // Redirect back to the login page
    header('location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- include bootstrap css from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Login Page</title>
</head>

<body>
    <!-- container to hold the login form -->
    <div class="container d-flex justify-content-center align-items-center" style="
    height: 100vh;
    width: 100vw;">
        <div class="card center" style="width: 350px">
            <?php
            // show any error message in session if exists
            echo isset($_SESSION['error']) ?   $_SESSION['error'] : ''
            ?>
             <!-- form to submit login credentials -->
            <form action="login.php" method="POST">
                <div class="card-header">
                    Login Form
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="text" name="email" placeholder="Email Address" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Login</button><br>
                    <small>Don't have account? <a href="register.php"> Register</a></small>
                </div>
            </form>
        </div>
    </div>
</body>

</html>