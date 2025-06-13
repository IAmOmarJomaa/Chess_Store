<?php
session_start();
include 'f1/database.php';
$firstName = $lastName = $username = $password = $email = $age = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $firstName = test_input($_POST["firstName"]);
 $lastName = test_input($_POST["lastName"]);
 $username = test_input($_POST["username"]);
 $password = test_input($_POST["password"]);
 $password = password_hash($password, PASSWORD_DEFAULT);
 $email = test_input($_POST["email"]);
 $age = test_input($_POST["age"]);
 $sql = "INSERT INTO users (first_name, last_name, username, password, email, age, reg_date, type) VALUES ('$firstName', '$lastName', '$username', '$password', '$email', '$age', NOW(), 'user')";

 if (mysqli_query($conn, $sql)) {
  header("Location: signin.php");
  exit();
 } else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
 }
}
function test_input($data)
{
 $data = trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
 return $data;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="general.css">
 <link rel="stylesheet" href="css/signup.css">

 <title>Sign Up</title>
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
 <h2>Sign Up</h2>
 <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
  <div>
   <label for="firstName">First Name:</label>
   <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>">
   <label for="lastName">Last Name:</label>
   <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>">

   <label for="username">Username:</label>
   <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>

   <label for="password">Password:</label>
   <input type="password" id="password" name="password" required>

   <label for="email">Email:</label>
   <input type="email" id="email" name="email" value="<?php echo $email; ?>">

   <label for="age">Age:</label>
   <input type="number" id="age" name="age" value="<?php echo $age; ?>">
  </div>
  <button type="submit">Sign Up</button>
 </form>
</body>

</html>