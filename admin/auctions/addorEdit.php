<?php
session_start();
$connection = include '../../config/database.php';
$categories = $connection->query("SELECT * FROM categories");
$categories = $categories->fetchAll(PDO::FETCH_ASSOC);
$username = $_SESSION['name'];
$user = $connection->query("SELECT * FROM users WHERE name='$username';");
$user = $user->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $id = trim($_GET['id']);
    $auction = $connection->query("SELECT * FROM auctions WHERE id='$id';");
    $auction = $auction->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['name'])) {
    $name = trim($_POST['name']);
    $cat_id = trim($_POST['cat_id']);
    $user_id = trim($_POST['user_id']);
    $description = trim($_POST['description']);
    $end_date = trim($_POST['end_date']);
    if (isset($_POST['id'])) {
        $id = trim($_POST['id']);
        $connection->exec("UPDATE auctions set 
        name='$name',
        cat_id='$cat_id',
        user_id='$user_id',
        description='$description',
        end_date='$end_date' 
        where id='$id';");
    } else {
        $connection->exec("INSERT INTO auctions(name, cat_id, user_id, description, end_date)
        VALUES('$name', '$cat_id', '$user_id', '$description', '$end_date');");
    }
    header('location: ../auctions.php');
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
                <a class="nav-link active" href="../auctions.php">Auctions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Reviews</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-sm btn-primary" href="logout.php">Logout</a>
            </li>
        </ul>

        <div>
            <div class="card">
                <form action="addorEdit.php" method="post">
                    <h2>Add auction</h2>
                    <div class="form-group">
                        <?php if (isset($_GET['id'])) { ?>
                            <input class="form-control" type="hidden" name="id" value="<?php echo isset($auction) ? $auction[0]['id'] : '' ?>">
                        <?php } ?>
                        <label for="name">Name</label>
                        <input class="form-control" type="text" name="name" placeholder="auction Title" required value="<?php echo isset($auction) ? $auction[0]['name'] : '' ?>"> <br>
                    </div>
                    <div class="form-group">
                        <label for="name">Category</label>
                        <select name="cat_id" id="" class="form-control">
                            <?php
                            foreach ($categories as $key => $cat) {
                            ?>
                                <option value="<?php echo $cat['id'] ?>" <?php isset($auction) ? ($auction[0]['cat_id'] == $cat['id'] ? "selected" : '') : '' ?>><?php echo $cat['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input class="form-control" type="hidden" name="user_id" required value="<?php echo $user[0]['id'] ?>"> <br>
                    <div class="form-group">
                        <label for="name">Description</label>
                        <textarea name="description" class="form-control" id="" cols="30" rows="10">
                            <?php echo isset($auction) ? $auction[0]['description'] : '' ?>
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="name">End Date</label>
                        <input class="form-control" type="date" name="end_date" placeholder="End Date" required value="<?php echo isset($auction) ? $auction[0]['end_date'] : '' ?>"> <br>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>