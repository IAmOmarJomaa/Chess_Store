<?php
include 'f1/database.php';
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="general.css">
 <link rel="stylesheet" href="css/signin.css">



 <title>Chess Store</title>
</head>


<body>
 <header>
  <h1>Chess Store</h1>
  <nav>
   <ul>
    <li><a id="home" href="index.php">Home</a></li>
    <li><a id="products" href="products/products.php">Products</a></li>
    <li><a id="about" href="about.php">About</a></li>
    <li><a id="contact" href="contact.php">Contact</a></li>
    <li><a id="signin" href="signin.php" class="active">Sign In</a></li>
   </ul>
  </nav>
 </header>
 <main>
  <h2>Sign In</h2>
  <form action="signin.php" method="post">
   <div class="form-group">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
   </div>
   <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
   </div>
   <button type="submit">Sign In</button>
  </form>
  <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
 </main>
 <footer>
  <p>&copy; 2024 Chess Store</p>
 </footer>
</body>


</html>
<?php
$redirectPath1 = isset($_SESSION['redirectPath']) ? $_SESSION['redirectPath'] : '../user/user.php';
$redirectPath2 = isset($_SESSION['redirectPath']) ? $_SESSION['redirectPath'] : '../admin/admin.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"])) {
 $username = $_POST["username"];
 $password = $_POST["password"];
 $query = "SELECT * FROM users WHERE username='$username'";
 $result = mysqli_query($conn, $query);
 if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  if (password_verify($password, $row["password"])) {
   $_SESSION["loggedin"] = true;
   $_SESSION["user_id"] = $row["user_id"];
   $_SESSION["username"] = $row["username"];
   $_SESSION["user_type"] = $row["type"];
   if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
   }


   if ($_SESSION["user_type"] == "admin") {
    header("Location: $redirectPath2");
    exit();
   } else {
    header("Location: $redirectPath1");
    exit();
   }
  } else {
   $error_message = "Invalid username or password. Please try again.";
  }
 } else {
  $error_message = "Invalid username or password. Please try again.";
 }
}
?>