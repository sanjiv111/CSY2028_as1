<?php
// Start the session
session_start();
// Redirect to login page if the user is not logged in
if (!isset($_SESSION['name'])) {
    header('location: login.php');
}
// Get the database connection
$connections = include '../config/database.php';
// Fetch the reviews based on user role
if ($_SESSION['name'] == 'admin')
    $reviews = $connections->query('SELECT * FROM reviews');
else {
    // Get the user ID of the logged in user
    $name = $_SESSION['name'];
    $userid = $connections->query("SELECT * FROM users where name='$name'");
    $userid = $userid->fetchAll(PDO::FETCH_ASSOC);
    $uid = $userid[0]['id'];
    // Fetch reviews for the logged in user
    $reviews = $connections->query("SELECT * FROM reviews where user_id='$uid'");
}

$reviews = $reviews->fetchAll(PDO::FETCH_ASSOC);
// Fetch all auctions
$auctions = $connections->query("SELECT * FROM auctions");
$auctions = $auctions->fetchAll(PDO::FETCH_ASSOC);
// Fetch all users
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
                <a class="nav-link " href="auctions.php">Auctions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="reviews.php">Reviews</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-sm btn-primary" href="logout.php">Logout</a>
            </li>
        </ul>

        <div>
            <div class="card">
                <h2>reviews </h2>
                <a href="./reviews/addorEdit.php" class="btn btn-primary btn-sm">Add Review</a>
                <table>
                    <thead>
                        <th>SN</th>
                        <th>Auction ID</th>
                        <th>User ID</th>
                        <th>Review</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                        if (count($reviews) > 0) {
                            foreach ($reviews as $key => $rev) { ?>
                                <tr>
                                    <td><?php echo $key + 1 ?></td>
                                    <td><?php
                                        foreach ($auctions as $auc) {
                                            if ($auc['id'] == $rev['auction_id']) {
                                                echo $auc['name'];
                                            }
                                        }
                                        ?></td>
                                    <td><?php
                                        foreach ($users as $user) {
                                            if ($user['id'] == $rev['user_id']) {
                                                echo $user['name'];
                                            }
                                        }
                                        ?></td>
                                    <td><?php echo $rev['review'] ?></td>
                                    <td>
                                        <a href="./reviews/addorEdit.php?id=<?php echo $rev['id'] ?>">Edit</a>
                                        <a href="delete.php?type=rev&id=<?php echo $rev['id'] ?>">Delete</a>
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