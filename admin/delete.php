<?php
// Check if id and type are set in the GET request
if (isset($_GET['id']) && isset($_GET['type'])) {
    // Establish database connection
    $connections = include '../config/database.php';
    $id = $_GET['id'];
// Perform a switch statement based on the type of data to be deleted
    switch ($_GET['type']) {
        case 'cat':
            $connections->exec("DELETE from categories where id='$id'");
            header('location: categories.php');
            break;
        case 'auc':
        // If type is auc, delete auction data with matching id
            $connections->exec("DELETE from auctions where id='$id'");
            header('location: auctions.php');
            break;
        case 'rev':
             // If type is rev, delete review data with matching id
            $connections->exec("DELETE from reviews where id='$id'");
            header('location: reviews.php');
            break;
    }
}
