<?php
//Start the session
session_start();
// Establishing database connection
$connections = include './config/database.php';

// Check if an auction ID is present in the GET request
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Fetch reviews for the auction with the specified ID
    $reviews = $connections->query("SELECT * FROM reviews WHERE auction_id='$id'");
    $reviews = $reviews->fetchAll(PDO::FETCH_ASSOC);
    // Fetch details for the auction with the specified ID
    $auc = $connections->query("SELECT * FROM auctions WHERE id='$id'; order by id desc limit 10");
    $auc = $auc->fetchAll(PDO::FETCH_ASSOC);
     // Fetch all categories
    $categories = $connections->query('SELECT * FROM categories  order by id desc');
    $categories = $categories->fetchAll(PDO::FETCH_ASSOC);
     // Fetch all users
    $users = $connections->query('SELECT * FROM users  order by id desc');
    $users = $users->fetchAll(PDO::FETCH_ASSOC);
     // Fetch details for the currently logged in user, if there is one
    if (isset($_SESSION['name'])) {
        $username = $_SESSION['name'];
        $current = $connections->query("SELECT * FROM users  where name='$username'");
        $current = $current->fetchAll(PDO::FETCH_ASSOC);
    }
}
// If a review was submitted through POST
if (isset($_POST['review'])) {
    $auction_id = trim($_POST['auction_id']);
    $user_id = trim($_POST['user_id']);
    $review = trim($_POST['review']);
 // Insert the review into the database
    $connections->exec("INSERT INTO reviews(auction_id, user_id, review)
        VALUES( '$auction_id', '$user_id', '$review');");
    header('location: product.php?id=' . $id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Product Page</title>
</head>

<body>
    <div class="container">
        <a href="index.php">Back</a>
        <h1>Product Page</h1>
        <article class="product">

            <img src="product.png" alt="product name">
            <section class="details">
                <h2><?php echo $auc[0]['name'] ?></h2>
                <h3><?php
                    foreach ($categories as $cat) {
                        if ($cat['id'] == $auc[0]['cat_id']) {
                            echo $cat['name'];
                        }
                    }
                    ?></h3>

                <p>Auction created by <a href="#">
                        <?php
                        foreach ($users as $user) {
                            if ($user['id'] == $auc[0]['user_id']) {
                                echo $user['name'];
                            }
                        }
                        ?>
                    </a></p>
                <p class="price">Current bid: £123.45</p>
                <time>Time left:
                    <?php


                    $date1 = strtotime(date('Y-m-d'));
                    $date2 = strtotime($auc[0]['end_date']);

                    $diff = abs($date2 - $date1);

                    $years = floor($diff / (365 * 60 * 60 * 24));

                    $months = floor(($diff - $years * 365 * 60 * 60 * 24)
                        / (30 * 60 * 60 * 24));

                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
                        $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

                    $hours = floor(($diff - $years * 365 * 60 * 60 * 24
                        - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
                        / (60 * 60));

                    $minutes = floor(($diff - $years * 365 * 60 * 60 * 24
                        - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
                        - $hours * 60 * 60) / 60);

                    $seconds = floor(($diff - $years * 365 * 60 * 60 * 24
                        - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
                        - $hours * 60 * 60 - $minutes * 60));

                    printf(
                        "%d years, %d months, %d days, %d hours, "
                            . "%d minutes, %d seconds",
                        $years,
                        $months,
                        $days,
                        $hours,
                        $minutes,
                        $seconds
                    );
                    ?>

                </time>
                <form action="#" class="bid">
                    <input type="text" name="bid" placeholder="Enter bid amount" />
                    <input type="submit" value="Place bid" />
                </form>
            </section>
            <section class="description">
                <p>
                    <?php echo $auc[0]['description'] ?>
                </p>

            </section>

            <section class="reviews container">
                <?php
                if (isset($reviews))
                    foreach ($reviews as $review) { ?>
                    <h2>Reviews of
                        <?php
                        foreach ($users as $user) {
                            if ($user['id'] == $review['user_id']) {
                                echo $user['name'];
                            }
                        }
                        ?>
                    </h2>
                    <ul>
                        <?php echo $review['review'] ?>
                    </ul>
                    <br>
                <?php } ?>
            </section>
            <?php if (isset($_SESSION['name'])) { ?>
                <form action="product.php?id=<?php echo $auc[0]['id'] ?>" method="POST">
                    <h2>Add Review</h2>
                    <div class="form-group">
                        <input class="form-control" type="hidden" name="user_id" required value="<?php echo $current[0]['id'] ?>"> <br>
                        <input class="form-control" type="hidden" name="auction_id" required value="<?php echo $auc[0]['id'] ?>"> <br>
                        <div class="form-group">
                            <label for="name">review</label>
                            <textarea name="review" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Review</button>
                </form>
            <?php } ?>
        </article>
    </div>
</body>

</html>