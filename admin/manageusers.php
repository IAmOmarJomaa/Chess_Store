<?php
session_start();


include '../guest/f1/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users Management</title>
  <link rel="stylesheet" href="../guest/general.css">
  <link rel="stylesheet" href="../guest/css/manageusers.css">

</head>

<body>
  <header>
    <h1>Chess Store</h1>
    <nav>
      <ul>
        <li><a id="home" href="admin.php">Home</a></li>
        <li><a id="manage users" href="manageusers.php" class="active">manage users</a></li>
        <li><a id="manage Products" href="manageproducts.php">manage Products</a></li>
        <li><a id="manage users" href="manageArticles.php">manage Articles</a></li>
        <li><a id="products" href="../guest/products/products.php">Products</a></li>
        <li><a id="profile" href="profile.php">Profile</a></li>
        <li><a id="Cart" href="cart.php">Cart</a></li>
      </ul>
    </nav>
  </header>
  <h2>Users Management</h2>
  <form action="" method="get">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <button type="submit">Search</button>
  </form>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>User Name</th>
        <th>Email</th>
        <th>Age</th>
        <th>Reg_Date</th>
        <th>Type</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      function les_users_il_mawjoudin($search)
      {
        global $conn;
        $sql = "SELECT * FROM users";
        if (!empty($search)) {
          $sql .= " WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%' OR age LIKE '%$search%'";
        }
        $sql = $sql . " ORDER BY FIELD(type, 'admin', 'user')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
          $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
          mysqli_free_result($result);

          return $users;
        } else {
          return [];
        }
      }
      $search = isset($_GET['search']) ? $_GET['search'] : '';
      $users = les_users_il_mawjoudin($search);
      foreach ($users as $user) {
        if ($user['user_id'] != $_SESSION["user_id"]) {
          echo "<tr>";
          echo "<td>{$user['user_id']}</td>";
          echo "<td>{$user['first_name']}</td>";
          echo "<td>{$user['last_name']}</td>";
          echo "<td>{$user['username']}</td>";
          echo "<td>{$user['email']}</td>";
          echo "<td>{$user['age']}</td>";
          echo "<td>{$user['reg_date']}</td>";
          echo "<td>{$user['type']}</td>";

          echo "<td>";
          echo "<form action=\"manageusers.php\" method=\"post\">
    <input type=\"hidden\" name=\"user_id\" value=\"{$user['user_id']}\">
    <button type=\"submit\" name=\"delete_user\">Delete</button>
</form>";
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_user"])) {
            $user_id = $_POST["user_id"];
            $sql = "DELETE FROM users WHERE user_id = $user_id";
            mysqli_query($conn, $sql);
          }
          if ($user['type'] == 'admin') {
            echo "<form action=\"manageusers.php\" method=\"post\">
    <input type=\"hidden\" name=\"user_id\" value=\"{$user['user_id']}\">
    <button type=\"submit\" name=\"make_user\">Make User</button>
</form>";
            echo "</td>";
          } else {
            echo "<form action=\"manageusers.php\" method=\"post\">
    <input type=\"hidden\" name=\"user_id\" value=\"{$user['user_id']}\">
    <button type=\"submit\" name=\"make_admin\">Make Admin</button>
</form>";
            echo "</td>";
          }
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["make_admin"])) {
            $user_id = $_POST["user_id"];
            $sql = "UPDATE users SET type = 'admin' WHERE user_id = $user_id;";
            mysqli_query($conn, $sql);
          }
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["make_user"])) {
            $user_id = $_POST["user_id"];
            $sql = "UPDATE users SET type = 'user' WHERE user_id = $user_id;";
            mysqli_query($conn, $sql);
          }
        }
        echo "</tr>";
      }
      ?>

    </tbody>
  </table>

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