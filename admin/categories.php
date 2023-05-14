<?php
// Starting a session to persist user's login status
session_start();
// Checking if user is not logged in, redirect to login page
if (!isset($_SESSION['name'])) {
    header('location: login.php');
}
// Including database configuration file
$connections = include '../config/database.php';
// Querying all categories from the database, sorting them in descending order by id
$categories = $connections->query('SELECT * FROM categories order by id desc');
// Fetching all queried categories as an associative array
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
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <?php if ($_SESSION['name'] == 'admin') { ?>
                    <a class="nav-link active" href="categories.php">Categories</a>
                <?php } ?>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="auctions.php">Auctions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reviews.php">Reviews</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-sm btn-primary" href="logout.php">Logout</a>
            </li>
        </ul>

        <div>
            <div class="card">
                <h2>Categories </h2>
                <a href="./categories/addorEdit.php" class="btn btn-primary btn-sm">Add Category</a>
                <table>
                    <thead>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                        if (count($categories) > 0) {
                            foreach ($categories as $key => $cat) { ?>
                                <tr>
                                    <td><?php echo $key + 1 ?></td>
                                    <td><?php echo $cat['name'] ?></td>
                                    <td>
                                        <a href="./categories/addorEdit.php?id=<?php echo $cat['id'] ?>">Edit</a>
                                        <a href="delete.php?type=cat&id=<?php echo $cat['id'] ?>">Delete</a>
                                    </td>
                                </tr>
                        <?php }
                        } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>