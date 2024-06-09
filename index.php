<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manual Payment Form</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    :root {
      --surface-color: #fff;
      --curve: 40;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Noto Sans JP', sans-serif;
      background-color: #fef8f8;
    }

    .payment-form {
      max-width: 400px;
      margin: 50px auto;
      background-color: var(--surface-color);
      padding: 20px;
      border-radius: calc(var(--curve) * 1px);
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      color: #6A515E;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form-group textarea {
      resize: none;
    }

    button[type="submit"] {
      background-color: #6A515E;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: #5D4553;
    }

    /* Styles for the dropdown select */
    select {
      appearance: none;
      -moz-appearance: none;
      -webkit-appearance: none;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="%23000" d="M3.293 5.293a1 1 0 011.414 0L8 8.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>');
      background-repeat: no-repeat;
      background-position: right 10px center;
      background-size: 16px;
    }

    /* Styles for the copy button */
    .copy-button {
      background-color: #6A515E;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .copy-button:hover {
      background-color: #5D4553;
    }
  </style>
</head>
<body>
  <div class="payment-form">
    <h2>Manual Payment</h2>
    <form action="submit_payment.php" method="POST"> <!-- Specify the action and method -->
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required>
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>
      </div>
      <div class="form-group">
        <label for="payment-method">Payment Method:</label>
        <select id="payment-method" name="payment-method" onchange="handlePaymentMethodChange()" required>
          <option value="">Select Payment Method</option>
          <option value="Payeer">Payeer</option>
          <option value="USDT">USDT</option>
        </select>
      </div>
      <div class="form-group" id="payeer-wallet" style="display: none;">
        <label for="payeer-account">Payeer Wallet:</label>
        <input type="text" id="payeer-account" name="payeer-account" value="P1076739266" disabled>
        <button type="button" class="copy-button" onclick="copyPayeerWallet()">Copy</button>
      </div>
      <button type="submit" id="submit-button" >Submit Payment</button>
    </form>
  </div>

  <script>
    function handlePaymentMethodChange() {
      var paymentMethod = document.getElementById("payment-method").value;
      var payeerWallet = document.getElementById("payeer-wallet");

      if (paymentMethod === "Payeer") {
        payeerWallet.style.display = "block";
        document.getElementById("submit-button").disabled = true;
      } else {
        payeerWallet.style.display = "none";
        document.getElementById("submit-button").disabled = false;
      }
    }

    function copyPayeerWallet() {
      var payeerAccount = document.getElementById("payeer-account");
      payeerAccount.select();
      document.execCommand("copy");
      alert("Payeer wallet copied!");
    }
  </script>
</body>
</html>
