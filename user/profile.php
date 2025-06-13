<?php
include '../guest/f1/database.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="../guest/general.css">
  <link rel="stylesheet" href="../guest/css/profile.css">

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
        <li><a id="profile" href="profile.php" class="active">Profile</a></li>
        <li><a id="cart" href="cart.php">Chart</a></li>
      </ul>
    </nav>
  </header>
  <div class="profile-container">
    <h2>User Profile</h2>
    <div class="user-info">
      <h3>Your Information</h3>
    </div>
    <div>
      <h3>Change Password</h3>
      <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
        <label for="currentPassword">Current Password:</label>
        <input type="password" id="currentPassword" name="currentPassword" required><br>

        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required><br>

        <label for="confirmPassword">Confirm New Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required><br>

        <button type="submit">Change Password</button>
      </form>
      <form action="profile.php" method="post"><button type="submit" name="logout">Logout</button></form>
    </div>
</body>

</html>
<?php
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $user = mysqli_fetch_assoc($result);
} else {
  echo "Error fetching user information.";
  exit();
}

// Handle password change form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $currentPassword = $_POST['currentPassword'];
  $newPassword = $_POST['newPassword'];
  $confirmPassword = $_POST['confirmPassword'];

  // Validate current password
  if (password_verify($currentPassword, $user['password'])) {
    // Check if new password and confirm password match
    if ($newPassword === $confirmPassword) {
      // Hash the new password
      $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

      // Update password in the database
      $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE user_id = '$user_id'";
      if (mysqli_query($conn, $updateQuery)) {
        echo "Password updated successfully.";
      } else {
        echo "Error updating password: " . mysqli_error($conn);
      }
    } else {
      echo "New password and confirm password do not match.";
    }
  } else {
    echo "Incorrect current password.";
  }
}
if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: ../guest/index.php");
  exit;
}
?>