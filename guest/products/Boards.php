<?php
include '../f1/database.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chess Store</title>
  <link rel="stylesheet" href="../general.css">
  <link rel="stylesheet" href="../css/products.css">

</head>

<body>
  <header>
    <h1>Chess Store</h1>
    <nav>
      <?php
      if (isset($_SESSION["loggedin"])) {
        if (isset($_SESSION["user_type"]) && ($_SESSION["user_type"] == "admin")) {
          echo
          '
    <ul>
   <li><a id="home" href="../../admin/admin.php">Home</a></li>
   <li><a id="manage users" href="../../admin/manageusers.php">manage users</a></li>
   <li><a id="manage Products" href="../../admin/manageproducts.php" >manage Products</a></li>
   <li><a id="manage users" href="../../admin/manageArticles.php">manage Articles</a></li>
   <li><a id="products" href="products.php" class="active" >Products</a></li>
   <li><a id="profile" href="../../admin/profile.php">Profile</a></li>
   <li><a id="cart" href="../../admin/cart.php">Cart</a></li>
  </ul> ';
        } else {
          echo
          '
  <ul>
   <li><a id="home" href="../../user/user.php">Home</a></li>
   <li><a id="products" href="products.php" class="active">Products</a></li>
   <li><a id="About" href="../../user/about.php">About</a></li>
   <li><a id="contact" href="../../user/contact.php">Contact</a></li>
   <li><a id="profile" href="../../user/profile.php">Profile</a></li>
   <li><a id="cart" href="../../user/cart.php">Cart</a></li>
  </ul> ';
        }
      } else {
        echo '
   <ul>
   <li><a id="home" href="../index.php">Home</a></li>
   <li><a id="products" href="products.php" class="active" >Products</a></li>
   <li><a id="About" href="../about.php">About</a></li>
   <li><a id="contact" href="../contact.php">Contact</a></li>
   <li><a id="signin" href="../signin.php">Sign In</a></li>
  </ul> ';
      } ?>
    </nav>
  </header>
  <div class="pagination">
    <li>
      <a href="products.php">Accessories</a>
      <a href="Apparel.php">Apparel</a>
      <a href="Boards.php" class="active">Boards</a>
      <a href="Books.php">Books and courses</a>
      <a href="Sets.php">Chess Sets</a>
      <a href="Software.php">Software and Apps</a>
    </li>
  </div>
  <?php
  $sql = "SELECT * FROM products WHERE category='Boards';";
  $result = mysqli_query($conn, $sql);
  while ($product = mysqli_fetch_assoc($result)) {
    $product_id = $product['product_id'];
    $img_sql = "SELECT * FROM prod_images WHERE product_id='$product_id'";
    $img_result = mysqli_query($conn, $img_sql);
    $images = [];
    while ($img_row = mysqli_fetch_assoc($img_result)) {
      $images[] = $img_row['image_path'];
    }
  ?>
    <div class="product-container">
      <div class="product">
        <h2><?php echo $product['name']; ?></h2>
        <p><?php echo $product['description']; ?></p>
        <p>Price: $<?php echo $product['price']; ?></p>
      </div>
      <div class="button">
        <?php if (isset($_SESSION["loggedin"])) { ?>
          <form action="f1/add_to_cart.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <input type="hidden" name="redirect" value="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button type="submit">Add to Cart</button>
          </form>
          <!-- kanek guest -->
        <?php } else { ?>
          <form action="f1/set_redirect.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <input type="hidden" name="redirect" value="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button type="submit">Add to Cart</button>
          </form>

        <?php } ?>
      </div>
      <div class="product-images">
        <?php foreach ($images as $index => $image) : ?>
          <img src="<?php echo $image; ?>" class="product-image <?php echo $index === 0 ? 'active' : ''; ?>" alt="Product Image">
        <?php endforeach; ?>
      </div>
    </div>
  <?php } ?>
  <footer>
    <p>&copy; 2024 Chess Store</p>
  </footer>
</body>

</html>
<script>
  document.addEventListener("DOMContentLoaded", function() {

    // Save scroll position and current PHP file path on button click
    document.querySelectorAll('form[action="f1/add_to_cart.php"]').forEach(form => {
      form.addEventListener('submit', function() {
        localStorage.setItem('scrollPosition', window.scrollY);
      });
    });
    document.querySelectorAll('form[action="f1/set_redirect.php"]').forEach(form => {
      form.addEventListener('submit', function() {
        localStorage.setItem('scrollPosition', window.scrollY);
      });
    });

    // Restore scroll position
    const scrollPosition = localStorage.getItem('scrollPosition');
    if (scrollPosition) {
      window.scrollTo(0, parseInt(scrollPosition));
      localStorage.removeItem('scrollPosition'); // Clear it after using
    }
    const imageContainers = document.querySelectorAll('.product-images');
    imageContainers.forEach(container => {
      const images = container.querySelectorAll('.product-image');
      let currentImageIndex = 0;

      setInterval(() => {
        images[currentImageIndex].classList.remove('active');
        currentImageIndex = (currentImageIndex + 1) % images.length;
        images[currentImageIndex].classList.add('active');
      }, 3000); // Change image every 3 seconds
    });
  });
</script>