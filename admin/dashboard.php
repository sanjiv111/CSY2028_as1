<?php
//This function starts a new or resumes an existing PHP session.
session_start();
//This line checks whether a session variable named "name" is set. If the variable is not set, the user is redirected to the login page.
if (!isset($_SESSION['name'])) {
//This line sends an HTTP header to redirect the user to the login page.
    header('location: login.php');
}
//This line includes the database configuration file and assigns the returned value to a variable named $connections.
$connections = include '../config/database.php';
//This line executes a SQL query to select all columns and rows from the "reviews" table using the database connection.
$reviews = $connections->query('SELECT * FROM reviews');
//This line fetches all the rows returned by the query as an associative array and assigns it to the $reviews variable.
$reviews = $reviews->fetchAll(PDO::FETCH_ASSOC);
//This line executes a SQL query to select all columns and rows from the "auctions" table using the database connection.
$auctions = $connections->query("SELECT * FROM auctions");
//This line fetches all the rows returned by the query as an associative array and assigns it to the $auctions variable.
$auctions = $auctions->fetchAll(PDO::FETCH_ASSOC);
//This line executes a SQL query to select all columns and rows from the "categories" table using the database connection.
$categories = $connections->query('SELECT * FROM categories');
//This line fetches all the rows returned by the query as an associative array and assigns it to the $categories variable.
$categories = $categories->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="container">
         <!-- Navigation tabs for the dashboard -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">Dashboard</a>
            </li>
            <li class="nav-item">
                <!-- If the user is an admin, show a link to the categories page -->
                <?php if ($_SESSION['name'] == 'admin') { ?>
                    <a class="nav-link" href="categories.php">Categories</a>
                <?php } ?>
            </li>
            <li class="nav-item">
                <!-- Link to the auctions page -->
                <a class="nav-link" href="auctions.php">Auctions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reviews.php">Reviews</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-sm btn-primary" href="../index.php">Homepage</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-sm btn-primary" href="logout.php">Logout</a>
            </li>
        </ul>

        <div>
            <!-- Display a card with a welcome message and some statistics -->
            <div class="card">
                <h2>Hello, <strong><?php echo $_SESSION['name'] ?></strong> !!! </h2>
                <h3>Welcome to the Dashboard</h3>
                <div class="row ">
                    <div class="col-sm-4">
                        <div class="card p-4">
                            <h1><?php echo isset($categories) ? count($categories) : 0 ?></h1>
                            <small>Categories</small>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card p-4">
                            <h1><?php echo isset($auctions) ? count($auctions) : 0 ?></h1>
                            <small>Auctions</small>
                        </div>
                    </div>
                    <!-- Display the number of reviews on the site -->
                    <div class="col-sm-4">
                        <div class="card p-4">
                            <h1><?php echo isset($reviews) ? count($reviews) : 0 ?></h1>
                            <small>Reviews</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>