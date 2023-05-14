<?php
// Start a new or resume an existing session
session_start();
// If the user is already logged in, redirect to the dashboard page
if (isset($_SESSION['name'])) {
    header('location: dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Register Page</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="
    height: 100vh;
    width: 100vw;">
        <div class="card center" style="width: 350px">
            <form action="./logic/register.php" method="post">
                <div class="card-header">
                     <!-- Header of the Register form -->
                    Register Form
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" name="name" required placeholder="Name">
                         <!-- Input field to enter the name of the user -->
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="text" name="email" required placeholder="Email Address">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="password" required placeholder="Password">
                         <!-- Input field to enter the password of the user -->
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Register</button><br>
                    <!-- Button to submit the form to register the user -->
                    <small>Already have account? <a href="login.php"> Login</a></small>
                </div>
            </form>
        </div>
    </div>
</body>

</html>