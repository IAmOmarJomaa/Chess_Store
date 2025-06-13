<?php
session_start();
include '../guest/f1/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_all'])) {
 $_SESSION['cart'] = [];
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_product_id'])) {
 $remove_product_id = intval($_POST['remove_product_id']);
 foreach ($_SESSION['cart'] as $key => $product_id) {
  if ($product_id == $remove_product_id) {
   unset($_SESSION['cart'][$key]);
   break;
  }
 }
}

$products = [];
$total_price = 0;

foreach ($_SESSION['cart'] as $product_id) {
 $product_id = intval($product_id);
 if ($product_id > 0) {
  $sql = "SELECT * FROM products WHERE product_id=$product_id;";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
   $product = mysqli_fetch_assoc($result);
   $products[] = $product;
   $total_price += $product['price'];
  }
 }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="../guest/general.css">
 <link rel="stylesheet" href="../guest/css/cart.css">
 <title>Cart</title>
</head>

<body>
 <header>
  <h1>Chess Store</h1>
  <nav>
   <ul>
    <li><a id="home" href="user.php">Home</a></li>
    <li><a id="products" href="../guest/products/products.php">Products</a></li>
    <li><a id="about" href="about.php">About</a></li>
    <li><a id="contact" href="contact.php">Contact</a></li>
    <li><a id="profile" href="profile.php">Profile</a></li>
    <li><a id="cart" href="cart.php" class="active">Cart</a></li>
   </ul>
  </nav>
 </header>
 <div class="cart-container">
  <h1>Your Cart</h1>
  <div>
   <?php if (empty($_SESSION['cart'])) : ?>
    <p>Your cart is empty.</p>
   <?php else : ?>
    <ul>
     <?php
     foreach ($products as $product) : ?>
      <li>
       <h2><?php echo $product['category']; ?></h2>
       <p><?php echo $product['name']; ?></p>
       <p>Price: $<?php echo $product['price']; ?></p>
       <form action="cart.php" method="post">
        <input type="hidden" name="remove_product_id" value="<?php echo $product['product_id']; ?>">
        <button type="submit">Remove</button>
       </form>
      </li>
     <?php endforeach; ?>
    </ul>
    <p class="total-price">Total Price: $<?php echo $total_price; ?></p>
    <div class="actions">
     <form action="cart.php" method="post">
      <input type="hidden" name="remove_all" value="1">
      <button type="submit" class="remove-all-button">Remove All</button>
     </form>
     <form action="checkout.php" method="post">
      <input type="hidden" name="total" value="<?php echo $total_price; ?>">
      <button type="submit" class="checkout-button">Proceed to Checkout</button>
     </form>
    </div>
   <?php endif; ?>
  </div>
 </div>
</body>

</html>
<script>
 document.addEventListener("DOMContentLoaded", function() {
  document.querySelectorAll('form[action="cart.php"]').forEach(form => {
   form.addEventListener('submit', function() {
    localStorage.setItem('scrollPosition', window.scrollY);
   });
  });

  const scrollPosition = localStorage.getItem('scrollPosition');
  if (scrollPosition) {
   window.scrollTo(0, parseInt(scrollPosition));
   localStorage.removeItem('scrollPosition');
  }
 });
</script>