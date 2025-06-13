<?php
session_start();


include '../guest/f1/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../guest/general.css">
  <link rel="stylesheet" href="../guest/css/managearticles.css">


  <title>Article Management</title>
</head>

<body>
  <header>
    <h1>Chess Store</h1>
    <nav>
      <ul>
        <li><a id="home" href="admin.php">Home</a></li>
        <li><a id="manage users" href="manageusers.php">manage users</a></li>
        <li><a id="manage Products" href="manageproducts.php">manage Products</a></li>
        <li><a id="manage users" href="manageArticles.php" class="active">manage Articles</a></li>
        <li><a id="products" href="../guest/products/products.php">Products</a></li>
        <li><a id="profile" href="profile.php">Profile</a></li>
        <li><a id="Cart" href="cart.php">Cart</a></li>
      </ul>
    </nav>
  </header>
  <div>
    <form action="manageArticles.php" method="post">
      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
      <label for="title">Title:</label>
      <input type="text" id="title" name="title" required><br>

      <label for="content">Content:</label>
      <textarea id="content" name="content" required></textarea><br>
      <button type="submit" name="add_article">Add Article</button><br>
    </form>
    <hr>
    <form action="manageArticles.php" method="get">
      <label for="search">Search:</label>
      <input type="text" id="search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
      <button type="submit">Search</button>
    </form>



    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Content</th>
          <th>Author</th>
          <th>Creation Date</th>
          <th>Image</th>
        </tr>
      </thead>

      <tbody>
        <?php
        global $user;
        $user = $_SESSION["user_id"];
        function les_article_li_mawjoudin($search)
        {
          global $conn;
          $sql = "SELECT * FROM articles";
          if (!empty($search)) {
            $sql = $sql . " WHERE title LIKE '%$search%' OR content LIKE '%$search%' OR author LIKE '%$search%' ";
          }
          $sql = $sql . " ORDER BY created_at DESC";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            $articles = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
            return $articles;
          } else {
            return [];
          }
        }

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $articles = les_article_li_mawjoudin($search);
        foreach ($articles as $article) {
          echo "<tr>";
          echo "<td>{$article['article_id']}</td>";
          echo "<td>{$article['title']}</td>";
          echo "<td>{$article['content']}</td>";
          echo "<td>{$article['author']}</td>";
          echo "<td>{$article['created_at']}</td>";
          echo "<td>";
          echo "<form action=\"manageArticles.php\" method=\"post\">
    <input type=\"hidden\" name=\"delete_article\" value=\"{$article['article_id']}\">
    <button type=\"submit\" name=\"delete_article\">Delete</button>
</form>";
          echo "<form action=\"edit_article.php\" method=\"post\">
    <input type=\"hidden\" name=\"article_id\" value=\"{$article['article_id']}\">
    <button type=\"submit\" name=\"edit_article\">edit article</button>
</form>";
          echo "</td>";
          echo "</tr>";
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_article"])) {
            $article_id = $article['article_id'];
            $sql = "DELETE FROM articles WHERE article_id = $article_id";
            mysqli_query($conn, $sql);
          }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_article"])) {
          $title = $_POST["title"];
          $content = $_POST["content"];
          $user_id = $_POST["user_id"];
          $sql = "INSERT INTO articles (title, content, author) VALUES ('$title', '$content', (SELECT CONCAT(first_name, ' ', last_name) FROM users WHERE user_id='$user_id'))";
          if (mysqli_query($conn, $sql)) {
            echo "article added";
          }
        } ?>

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