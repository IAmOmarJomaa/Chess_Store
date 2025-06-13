<?php

session_start();
include '../guest/f1/database.php';

global $row;
$row = [
 "product_id" => "",
 "category" => "",
 "name" => "",
 "description" => "",
 "price" => "",
 "quantity" => "",
 "created_at" => "",
 "updated_at" => ""
];
$product_id = $_POST['product_id'];

$sql = "SELECT * FROM products WHERE product_id=$product_id";
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
 <title>Product Management</title>
 <link rel="stylesheet" href="../guest/general.css">
 <link rel="stylesheet" href="../guest/css/edit_product.css">

</head>

<body>
 <header>
  <h1>Chess Store</h1>
  <nav>
   <ul>
    <li><a id="home" href="admin.php">Home</a></li>
    <li><a id="manage users" href="manageusers.php">manage users</a></li>
    <li><a id="manage Products" href="manageproducts.php" class="active">manage Products</a></li>
    <li><a id="manage users" href="manageArticles.php">manage Articles</a></li>
    <li><a id="products" href="../guest/products/products.php">Products</a></li>
    <li><a id="profile" href="profile.php">Profile</a></li>
    <li><a id="cart" href="cart.php">Cart</a></li>
   </ul>
  </nav>
 </header>

 <div>
  <form action="edit_product.php" method="post">
   <label for="category">Change Category :</label>
   <select id="category" name="category" required>
    <option value="<?php echo "{$row['category']}"; ?>"><?php echo "{$row['category']}"; ?> </option>
    <option value="Accessories">Accessories</option>
    <option value="Apparel">Apparel</option>
    <option value="Boards">Boards</option>
    <option value="Books">Books</option>
    <option value="ChessSets">Sets</option>
    <option value="Software">Software</option>
   </select><br>
   <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
   <label for="name">Change Name :</label>
   <input type="text" id="name" name="name" value="<?php echo "{$row['name']}"; ?>" required><br>

   <label for="description">Change Description :</label>
   <textarea id="description" name="description" required><?php echo "{$row['description']}"; ?></textarea><br>

   <label for="price">Change Price:</label>
   <input type="text" id="price" name="price" pattern="[0-9]+(\.[0-9]+)?" value="<?php echo "{$row['price']}"; ?>" required><br>

   <label for="quantity">Change Quantity:</label>
   <input type="number" id="quantity" name="quantity" value="<?php echo "{$row['quantity']}"; ?>" required><br>

   <button type="submit" name="SAVE">Edit Product</button>
  </form>
 </div>
 <br>
 <hr>
 <div>
  <form action="edit_product.php" method="post" enctype="multipart/form-data">
   <label for="image">Image:</label>
   <input type="file" id="image" name="image" accept="image/*" required><br>
   <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
   <button type="submit" name="add_image">Add Image</button>
  </form>
 </div>
</body>

</html>
<?php

if (isset($_POST["SAVE"])) {
 $category = $_POST["category"];
 $name = $_POST["name"];
 $description = $_POST["description"];
 $price = $_POST["price"];
 $quantity = $_POST["quantity"];
 var_dump($product_id);
 $sql = "UPDATE products SET category='$category', name='$name', quantity='$quantity', description='$description', price='$price' WHERE product_id='$product_id'";
 if (mysqli_query($conn, $sql)) {
  echo "Product updated successfully";
 } else {
  echo "Error updating product: " . mysqli_error($conn);
 }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_image"])) {
 $product_id = $row['product_id'];
 if ($_FILES["image"]["error"] > 0) {
  echo "Error: " . $_FILES["image"]["error"];
 } else {
  $targetDirectory = "images/";


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
    $targetDirectory1 = "../../admin/images/" . basename($_FILES["image"]["name"]);
    $insertSql = "INSERT INTO prod_images (product_id, image_path) VALUES ('$product_id', '$targetDirectory1')";
    if (mysqli_query($conn, $insertSql)) {
     echo "Image path inserted into prod_images table successfully";
    }
   } else {
    echo "Sorry, there was an error uploading your file.";
   }
  }
 }
}
?>