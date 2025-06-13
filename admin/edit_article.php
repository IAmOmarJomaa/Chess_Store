<?php
session_start();


include '../guest/f1/database.php';
global $row;
$article_id = $_POST['article_id'];
$sql = "SELECT * FROM articles WHERE article_id=$article_id";
$result = mysqli_query($conn, $sql);
if ($result) {
   $row = mysqli_fetch_assoc($result);
   mysqli_free_result($result);
} else {
   echo "Error: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Article Management</title>
   <link rel="stylesheet" href="../guest/general.css">
   <link rel="stylesheet" href="../guest/css/edit_article.css">

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
            <li><a id="cart" href="cart.php">Cart</a></li>
         </ul>
      </nav>
   </header>

   <div>
      <form action="edit_product.php" method="post">
         <label for="title">Change Title:</label>
         <input type="text" id="title" name="title" value="<?php echo "{$row['title']}"; ?>" required><br>

         <label for="content">Change Content:</label>
         <textarea id="content" name="content" required><?php echo "{$row['content']}"; ?></textarea><br>

         <button type="submit" name="SAVE">Save Changes</button><br>
      </form>
   </div>
   <br>
   <hr>
   <div>
      <form action="edit_article.php" method="post" enctype="multipart/form-data">
         <label for="image">Image:</label>
         <input type="file" id="image" name="image" accept="image/*" required><br>
         <input type="hidden" name="article_id" value="<?php echo $row['article_id']; ?>">
         <button type="submit" name="add_image">Add Image</button>
      </form>
   </div>
</body>

<?php
if (isset($_POST["SAVE"])) {
   $title = $_POST["title"];
   $content = $_POST["content"];
   $article_id = $row['article_id'];


   $sql = "UPDATE articles SET title='$title', name='$name', content='$content' WHERE article_id='$article_id'";
   if (mysqli_query($conn, $sql)) {
      echo "Article updated successfully";
   } else {
      echo "Error updating product: " . mysqli_error($conn);
   }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_image"])) {
   $article_id = $row['article_id'];
   if ($_FILES["image"]["error"] > 0) {
      echo "Error: " . $_FILES["image"]["error"];
   } else {
      $targetDirectory = "artimages/";
      $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);

      $mrigl = 1;

      $check = getimagesize($_FILES["image"]["tmp_name"]);
      if ($check === false) {
         echo "File is not an image.";
         $mrigl = 0;
      }
      if ($_FILES["image"]["size"] > 500000) {
         // 0.48 MB
         echo "Sorry, your file is too large.";
         $mrigl = 0;
      }
      if ($mrigl == 0) {
         echo "Sorry, your file was not uploaded.";
      }

      if ($mrigl != 0) {
         if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
            $article_id = $row['article_id'];
            $targetDirectory1 = "../admin/artimages/" . basename($_FILES["image"]["name"]);
            $insertSql = "INSERT INTO art_images (article_id, image_path) VALUES ('$article_id', '$targetDirectory1')";
            if (mysqli_query($conn, $insertSql)) {
               echo "Image path inserted into prod_images table successfully";
            } else {
               echo "Sorry, there was an error uploading your file.";
            }
         }
      }
   }
}

?>