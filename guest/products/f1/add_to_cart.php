<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['product_id']) && isset($_POST['redirect']))) {
 $product_id = $_POST['product_id'];
 $_SESSION['cart'][] = $product_id;
 $_path = $_POST['redirect'];
 header("Location: $_path");
 exit();
}
