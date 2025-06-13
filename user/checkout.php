<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['total'])) {
  $total_price = $_POST['total'];
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['total1'])) {

    echo "<div id='thanksmsg'> Thank you for your purchase ! Your total was $$total_price.</div>";

    echo "<div id='redirect-message'>You will be redirected to the home page in 5 seconds.</div>";
    echo "<script>
                function startCountdown() {
                  var seconds = 5;
                  var countdownElement = document.getElementById('redirect-message');
                  var timerInterval = setInterval(function() {
                    countdownElement.textContent = 'You will be redirected to the home page in ' + seconds + ' seconds.';
                    if (seconds == 0) {
                      clearInterval(timerInterval);
                      window.location.href = 'user.php';
                    }
                    seconds--;
                  }, 1000);
                }
                startCountdown();
              </script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../guest/general.css">
  <title>Checkout</title>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #1a1a1a;
      color: #f0f0f0;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    h1 {
      color: #ffcc00;
      font-size: 3em;
      margin-bottom: 1.5rem;
    }

    p {
      font-size: 1.5em;
      margin-bottom: 1.5rem;
    }

    form {
      background-color: #2c2c2c;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 300px;
    }

    label {
      font-size: 1.2em;
      margin-bottom: 1rem;
      color: #ffcc00;
    }

    select {
      padding: 0.5rem;
      border-radius: 4px;
      border: none;
      margin-bottom: 1.5rem;
      width: 100%;
      font-size: 1em;
    }

    button {
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 4px;
      background-color: #4CAF50;
      color: white;
      font-size: 1.2em;
      cursor: pointer;
      transition: background-color 0.3s;
      width: 100%;
    }

    button:hover {
      background-color: #45a049;
    }

    #thanksmsg {
      font-size: 3em;
      text-align: center;
      color: #ffcc00;
      margin-bottom: 8px;
    }

    #redirect-message {
      font-size: 1.5em;
      text-align: center;
      color: #ccc;
      margin-bottom: 1.5rem;
    }
  </style>
</head>

<body>
  <h1>Checkout</h1>
  <p>Total Price: $<?php echo $total_price; ?></p>
  <form action="checkout.php" method="post">
    <label for="payment_method">Select Payment Method:</label>
    <select id="payment_method" name="payment_method" required>
      <option value="credit_card">Credit Card</option>
      <option value="paypal">PayPal</option>
    </select>
    <input type="hidden" name="total" value="<?php echo $total_price; ?>">
    <button type="submit" name="total1">Complete Purchase</button>
  </form>
</body>

</html>