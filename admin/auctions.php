<!--NAME: SANJIV TAMANNG, UON: 21422144, LEVEL:06-->

<?php
//starts the php session and checks whether the 'name' session variablei set or not. if not then user is redirected to login page ..
session_start();
if (!isset($_SESSION['name'])) {
    header('location: login.php');
}
//includes the database configuration file
$connections = include '../config/database.php';

//if the logged-in user is an admin, fetch all auctions from the database, otherwise fetch only the auctions of the logged-in user
if ($_SESSION['name'] == 'admin')
    $auctions = $connections->query('SELECT * FROM auctions');
else {
    $name = $_SESSION['name'];
    $userid = $connections->query("SELECT * FROM users where name='$name'");
    $userid = $userid->fetchAll(PDO::FETCH_ASSOC);
    $uid = $userid[0]['id'];
    $auctions = $connections->query("SELECT * FROM auctions where user_id='$uid'");
}
//fetch all auctions from the database and store them in the $auctions variable
$auctions = $auctions->fetchAll(PDO::FETCH_ASSOC);
//fetch all categories from the database and store them in the $categories variable
$categories = $connections->query("SELECT * FROM categories");
$categories = $categories->fetchAll(PDO::FETCH_ASSOC);
//fetch all users from the database and store them in the $users variable
$users = $connections->query("SELECT * FROM users");
$users = $users->fetchAll(PDO::FETCH_ASSOC);
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
                    <a class="nav-link " href="categories.php">Categories</a>
                <?php } ?>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="auctions.php">Auctions</a>
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
                <h2>auctions </h2>
                <a href="./auctions/addorEdit.php" class="btn btn-primary btn-sm">Add Auction</a>
                <table>
                    <thead>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Cat ID</th>
                        <th>User ID</th>
                        <th>Description</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                        if (count($auctions) > 0) {
                            foreach ($auctions as $key => $auc) { ?>
                                <tr>
                                    <!--display serial number of the auction-->
                                    <td><?php echo $key + 1 ?></td>
                                    <!-- display the name of the auction-->
                                    <td><?php echo $auc['name'] ?></td>
                                    <td><?php
                                    // loop through each category
                                        foreach ($categories as $cat) {
                                            // check if the category id matches the category id of the current auction
                                            if ($cat['id'] == $auc['cat_id']) {
                                                // display the name of the category
                                                echo $cat['name'];
                                            }
                                        }
                                        ?></td>
                                    <td><?php
                                    // loop through each user
                                        foreach ($users as $user) {
                                            if ($user['id'] == $auc['user_id']) {
                                                echo $user['name'];
                                            }
                                        }
                                        ?></td>
                                        <!-- display the description of the auction-->
                                    <td><?php echo $auc['description'] ?></td>
                                    <td><?php echo $auc['end_date'] ?></td>
                                    <td>
                                        <a href="./auctions/addorEdit.php?id=<?php echo $auc['id'] ?>">Edit</a>
                                        <a href="delete.php?type=auc&id=<?php echo $auc['id'] ?>">Delete</a>
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