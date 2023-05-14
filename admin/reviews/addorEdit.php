<?php
//Start the session
session_start();
// Include the database connection
$connection = include '../../config/database.php';
// Get all auctions from the database
$auctions = $connection->query("SELECT * FROM auctions");
$auctions = $auctions->fetchAll(PDO::FETCH_ASSOC);
// Get the username from the session and retrieve the user from the database
$username = $_SESSION['name'];
$user = $connection->query("SELECT * FROM users WHERE name='$username';");
$user = $user->fetchAll(PDO::FETCH_ASSOC);
//If the 'id' parameter is set in the URL, retrieve the review with the corresponding ID from the database
if (isset($_GET['id'])) {
    $id = trim($_GET['id']);
    $review = $connection->query("SELECT * FROM reviews WHERE id='$id';");
    $review = $review->fetchAll(PDO::FETCH_ASSOC);
}
// If the review form is submitted, insert or update the review in the database and redirect to the reviews page
if (isset($_POST['review'])) {
    $auction_id = trim($_POST['auction_id']);
    $user_id = trim($_POST['user_id']);
    $review = trim($_POST['review']);
    if (isset($_POST['id'])) {
        $id = trim($_POST['id']);
        $connection->exec("UPDATE reviews set 
        auction_id='$auction_id',
        user_id='$user_id',
        review='$review' 
        where id='$id';");
    } else {
        $connection->exec("INSERT INTO reviews(auction_id, user_id, review)
        VALUES( '$auction_id', '$user_id', '$review');");
    }
    header('location: ../reviews.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Add auction</title>
</head>

<body>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="../categories.php">Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="../auctions.php">Auctions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../reviews.php">Reviews</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-sm btn-primary" href="logout.php">Logout</a>
            </li>
        </ul>

        <div>
            <div class="card">
                <form action="addorEdit.php" method="post">
                    <h2>Add Review</h2>
                    <?php if (isset($_GET['id'])) { ?>
                        <input class="form-control" type="hidden" name="id" value="<?php echo isset($review) ? $review[0]['id'] : '' ?>">
                    <?php } ?>
                    <div class="form-group">
                        <label for="name">Auction</label>
                        <select name="auction_id" id="" class="form-control">
                            <?php
                            foreach ($auctions as $key => $auc) {
                            ?>
                                <option value="<?php echo $auc['id'] ?>" <?php isset($review) ? ($review[0]['auction_id'] == $auc['id'] ? "selected" : '') : '' ?>><?php echo $auc['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input class="form-control" type="hidden" name="user_id" required value="<?php echo $user[0]['id'] ?>"> <br>
                    <div class="form-group">
                        <label for="name">review</label>
                        <textarea name="review" class="form-control" id="" cols="30" rows="10">
                            <?php echo isset($review) ? $review[0]['review'] : '' ?>
                        </textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>