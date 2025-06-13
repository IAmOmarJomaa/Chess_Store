<?php
session_start();
include '../guest/f1/database.php';
$query_products = "SELECT * FROM products ORDER BY created_at DESC LIMIT 10";
$result_products = mysqli_query($conn, $query_products);

$query_articles = "SELECT * FROM articles ORDER BY created_at DESC LIMIT 10";
$result_articles = mysqli_query($conn, $query_articles);
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="../guest/general.css">
 <link rel="stylesheet" href="../guest/css/index.css">

 <title>Chess Store</title>
</head>

<body>
 <header>
  <h1>Chess Store</h1>
  <nav>
   <ul>
    <li><a id="home" href="admin.php" class="active">Home</a></li>
    <li><a id="manage users" href="manageusers.php">manage users</a></li>
    <li><a id="manage Products" href="manageproducts.php">manage Products</a></li>
    <li><a id="manage users" href="manageArticles.php">manage Articles</a></li>
    <li><a id="products" href="../guest/products/products.php">Products</a></li>
    <li><a id="profile" href="profile.php">Profile</a></li>
    <li><a id="cart" href="cart.php">Cart</a></li>
   </ul>
  </nav>
 </header>
 <main class="main-content">

  <section class="featured-products">
   <h2>Featured Products</h2>
   <div class="product-container">
    <?php
    while ($row_products = mysqli_fetch_assoc($result_products)) {
     echo '<div class="product">';
     $product_id = $row_products['product_id'];
     $img_sql = "SELECT image_path FROM prod_images WHERE product_id='$product_id' ORDER BY image_id DESC LIMIT 1";
     $result = mysqli_query($conn, $img_sql);
     $row = mysqli_fetch_assoc($result);
     $img_path = $row['image_path'];
     $img_path = substr($img_path, 3);
     echo '<img src="' . $img_path . '" alt=" ' . $row_products['name'] . '">';
     echo '<h3>' . $row_products['name'] . '</h3>';
     echo '<p>' . $row_products['description'] . '</p>';
     echo '<p>Price: $' . $row_products['price'] . '</p>';
     echo '</div>';
    }
    ?>
   </div>
  </section>
  <section class="articles">
   <h2>Chess Articles</h2>
   <div class="article-container">
    <?php
    while ($row_articles = mysqli_fetch_assoc($result_articles)) {
     echo '<div class="article">';
     $article_id = $row_articles['article_id'];
     $img_sql2 = "SELECT image_path FROM art_images WHERE article_id='$article_id' ORDER BY image_id DESC LIMIT 1";
     $result2 = mysqli_query($conn, $img_sql2);
     $row2 = mysqli_fetch_assoc($result2);
     $img_path2 = $row2['image_path'];
     echo '<img src="' . $img_path2 . '" alt="fammach">';
     echo '<h3>' . $row_articles['title'] . '</h3>';
     echo '<p>' . $row_articles['content'] . '</p>';
     echo '</div>';
    }
    ?>
   </div>
  </section>
 </main>
 <footer>
  <p>&copy; 2024 Chess Store</p>
 </footer>
</body>

</html>