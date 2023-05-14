<?php
session_start();
//Establish the connection
$connections = include './config/database.php';
// Retrieve all reviews from database
$reviews = $connections->query('SELECT * FROM reviews');
$reviews = $reviews->fetchAll(PDO::FETCH_ASSOC);
// Retrieve auctions based on selected category, or retrieve all auctions if no category is selected
if (isset($_GET['cat'])) {
	$cat = $_GET['cat'];
	$auctions = $connections->query("SELECT * FROM auctions WHERE cat_id='$cat'; order by id desc limit 10");
} else {
	$auctions = $connections->query("SELECT * FROM auctions order by id desc limit 10");
}
$auctions = $auctions->fetchAll(PDO::FETCH_ASSOC);
// Retrieve all categories from database
$categories = $connections->query('SELECT * FROM categories  order by id desc');
$categories = $categories->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>


<head>
	<title>ibuy Auctions</title>
	<link rel="stylesheet" href="ibuy.css" />
</head>

<body>
	<header>
		<a href="index.php">
			<h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>

		</a>

		<form action="#">
			<input type="text" name="search" placeholder="Search for anything" />
			<input type="submit" name="submit" value="Search" />
		</form>

		<?php
		if (isset($_SESSION['name'])) { ?>
			<a href="./admin/dashboard.php">Dashboard</a>

		<?php
		} else { ?>
			<a href="./admin/login.php">Login</a>

		<?php } ?>
	</header>

	<nav>
		<ul>
			<?php foreach ($categories as $cat) { ?>
				<li><a class="categoryLink" href="index.php?cat=<?php echo $cat['id'] ?>"><?php echo $cat['name'] ?></a></li>

			<?php } ?>

		</ul>
	</nav>
	<img src="banners/1.jpg" alt="Banner" />

	<main>

		<h1>Latest Listings / Search Results / Category listing</h1>

		<ul class="productList">
			<?php foreach ($auctions as $auc) { ?>

				<li>
					<img src="product.png" alt="product name">
					<article>
						<h2><?php echo $auc['name'] ?></h2>
						<h3><?php
							foreach ($categories as $cat) {
								if ($cat['id'] == $auc['cat_id']) {
									echo $cat['name'];
								}
							}
							?></h3>
						<p>
							<?php echo $auc['description'] ?>
						</p>

						<p class="price">Current bid: £123.45</p>
						<a href="product.php?id=<?php echo $auc['id'] ?>" class="more auctionLink">More &gt;&gt;</a>
					</article>
				</li>
			<?php } ?>

		</ul>

		<hr />

		

		<hr />
		<!-- <h1>Sample Form</h1>

		<form action="#">
			<label>Text box</label> <input type="text" />
			<label>Another Text box</label> <input type="text" />
			<input type="checkbox" /> <label>Checkbox</label>
			<input type="radio" /> <label>Radio</label>
			<input type="submit" value="Submit" />

		</form> -->



		<footer>
			&copy; ibuy 2019
		</footer>
	</main>
</body>

</html>