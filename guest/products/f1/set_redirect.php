<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['product_id']) && isset($_POST['redirect']))) {
 $_SESSION['redirectPath'] = $_POST['redirect'];
 $product_id = $_POST['product_id'];
 if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
 }
 $_SESSION['cart'][] = $product_id;
 header("Location: ../../signin.php");
 exit();
}
// 