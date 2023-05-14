<?php
session_start();

$connection = include '../../config/database.php';
if (isset($_GET['id'])) {
    $id = trim($_GET['id']);
    $category = $connection->query("SELECT * FROM categories WHERE id='$id';");
    $category = $category->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['name'])) {
    $cat = trim($_POST['name']);
    if (isset($_POST['id'])) {
        $id = trim($_POST['id']);
        $connection->exec("UPDATE categories set name='$cat' where id='$id';");
    } else {
        $connection->exec("INSERT INTO categories(name) VALUES('$cat');");
    }
    header('location: ../categories.php');
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
    <title>Add Category</title>
</head>

<body>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../categories.php">Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Auctions</a>
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
                    <h2>Add Category</h2>
                    <div class="form-group">
                        <?php if (isset($_GET['id'])) { ?>
                            <input class="form-control" type="hidden" name="id" value="<?php echo isset($category) ? $category[0]['id'] : '' ?>">
                        <?php } ?>

                        <label for="name">Name</label>
                        <input class="form-control" type="text" name="name" placeholder="Category Title" required value="<?php echo isset($category) ? $category[0]['name'] : '' ?>"> <br>
                    </div>
                    <button type="submit" class="btn btn-prumary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>