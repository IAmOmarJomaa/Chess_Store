<?php
include '../guest/f1/database.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="../guest/general.css">
 <link rel="stylesheet" href="../guest/css/contact.css">

 <title>Contact Us</title>
</head>

<body>
 <header>
  <h1>Chess Store</h1>
  <nav>
   <ul>
    <li><a id="home" href="user.php">Home</a></li>
    <li><a id="products" href="../guest/products/products.php">Products</a></li>
    <li><a id="about" href="about.php">About</a></li>
    <li><a id="contact" href="contact.php" class="active">Contact</a></li>
    <li><a id="profile" href="profile.php">Profile</a></li>
    <li><a id="profile" href="cart.php">Chart</a></li>
   </ul>
  </nav>
 </header>
 <h1>Contact Us</h1>

 <div class="info">
  <p>Contact Information:</p>
  <p>Email: chess.store@gmail.com</p>
  <p>Phone: 999-139-4555</p>
  <p>Address: sahloul4, Sousse, Tunisia</p>
 </div>

 <h2>Send us a message</h2>
 <form action="index.php" method="POST">
  <label for="name">Name:</label>
  <input type="text" id="name" name="name" required><br>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required><br>

  <label for="subject">Subject:</label>
  <input type="text" id="subject" name="subject" required><br>

  <label for="message">Message:</label><br>
  <textarea id="message" name="message" rows="4" required></textarea><br>

  <button type="submit">Send Message</button>
 </form>
 <footer>
  <p>&copy; 2024 Chess Store</p>
 </footer>
</body>

</html>