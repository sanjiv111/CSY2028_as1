<?php
    $connection = include '../../config/database.php';

    $error = [];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password']));

    $alreadyExists = $connection->query("SELECT * FROM users WHERE email='$email';");
    $alreadyExists = $alreadyExists->fetchAll(PDO::FETCH_ASSOC);
    if (empty($alreadyExists)) {
        $data = $connection->exec("INSERT INTO users(name, email, password) VALUES('$name', '$email','$password');");
        $_SESSION['error'] = [];
        $_SESSION['name'] = $name;
        header('location: ../dashboard.php');
    } else {
        array_push($error, 'User already exists!!!');
        $_SESSION['error'] = $error;
        header("location: ../register.php");
    }
    ?>