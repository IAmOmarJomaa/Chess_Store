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
   <link rel="stylesheet" href="../guest/css/manageproducts.css">

   <title>Product Management</title>
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
            <li><a id="Cart" href="cart.php">Cart</a></li>
         </ul>
      </nav>
   </header>
   <!-- zid produit -->
   <div>
      <form action="manageproducts.php" method="post">

         <label for="category">Category:</label>
         <select id="category" name="category" required>
            <option value="">Select a category</option>
            <option value="Accessories">Accessories</option>
            <option value="Apparel">Apparel</option>
            <option value="Boards">Boards</option>
            <option value="Books">Books</option>
            <option value="Chess Sets">Sets</option>
            <option value="Software">Software</option>
         </select><br>

         <label for="name">Name:</label>
         <input type="text" id="name" name="name" required><br>

         <label for="description">Description:</label>
         <textarea id="description" name="description" required></textarea><br>

         <label for="price">Price:</label>
         <input type="text" id="price" name="price" pattern="[0-9]+(\.[0-9]+)?" required><br>

         <label for="quantity">Quantity:</label>
         <input type="number" id="price" name="quantity" required><br>

         <button type="submit" name="add_product">Add Product</button><br>
      </form>
      <hr>


      <form action="manageproducts.php" method="get">
         <label for="search">Search:</label>
         <input type="text" id="search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

         <button type="submit">Search</button>
      </form>
      <div>
         <table>
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Category</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Creation</th>
                  <th>Modification</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               function les_produit_li_mawjoudin($search)
               {
                  global $conn;
                  $sql = "SELECT * FROM products";
                  if (!empty($search)) {
                     $sql = $sql . " WHERE name LIKE '%$search%' OR description LIKE '%$search%' OR price LIKE '%$search%'";
                  }
                  $sql = $sql . " ORDER BY created_at DESC";
                  $result = mysqli_query($conn, $sql);
                  if ($result) {
                     $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
                     mysqli_free_result($result);

                     return $products;
                  } else {
                     return [];
                  }
               }

               $search = isset($_GET['search']) ? $_GET['search'] : '';
               $products = les_produit_li_mawjoudin($search);

               foreach ($products as $product) {
                  echo "<tr>";
                  echo "<td>{$product['product_id']}</td>";
                  echo "<td>{$product['category']}</td>";
                  echo "<td>{$product['name']}</td>";
                  echo "<td>{$product['description']}</td>";
                  echo "<td>{$product['price']}</td>";
                  echo "<td>{$product['quantity']}</td>";
                  echo "<td>{$product['created_at']}</td>";
                  echo "<td>{$product['updated_at']}</td>";
                  echo "<td>";
                  echo "<form action=\"edit_product.php\" method=\"post\">
    <input type=\"hidden\" name=\"product_id\" value=\"{$product['product_id']}\">
    <button type=\"submit\" name=\"edit_product\">Edit</button>
</form>";
                  echo "<form action=\"manageproducts.php\" method=\"post\">
    <input type=\"hidden\" name=\"product_id\" value=\"{$product['product_id']}\">
    <button type=\"submit\" name=\"delete_product\">Delete</button>
</form></td>";
                  echo "</tr>";
                  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_product"])) {
                     $product_id = $_POST["product_id"];
                     $sql = "DELETE FROM products WHERE product_id = $product_id";
                     mysqli_query($conn, $sql);
                  }
               }
               if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_product"])) {
                  $category = $_POST["category"];
                  $name = $_POST["name"];
                  $description = $_POST["description"];
                  $price = $_POST["price"];
                  $quantity = $_POST["quantity"];
                  $sql = "INSERT INTO products (category,name, description, price, quantity) VALUES ('$category','$name', '$description', '$price', '$quantity')";
                  $i;

                  if (mysqli_query($conn, $sql)) {
                     echo "Prodect added";
                  }
               }
               ?>

            </tbody>
         </table>
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