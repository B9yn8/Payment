<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $name = $_POST["name"];
  $email = $_POST["email"];
  $amount = $_POST["amount"];
  $paymentMethod = $_POST["payment-method"];
  $transactionID = $_POST["transaction-id"];

  // Handle image upload
  $targetDir = "uploads/";
  $fileName = basename($_FILES["payment-image"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

  if (move_uploaded_file($_FILES["payment-image"]["tmp_name"], $targetFilePath)) {
    // Prepare message for Telegram
    $message = "New payment received:\nName: $name\nEmail: $email\nAmount: $amount\nPayment Method: $paymentMethod\nTransaction ID: $transactionID\n";

    // Telegram API integration
    $botToken = "YOUR_BOT_TOKEN";
    $chatID = "YOUR_CHAT_ID";
    $telegramMessage = urlencode($message);
    $telegramURL = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatID&text=$telegramMessage";
    file_get_contents($telegramURL); // Send message to Telegram

    echo "<p>Thank you for your payment. We will verify it shortly.</p>";
  } else {
    echo "<p>Sorry, there was an error uploading your file.</p>";
  }
} else {
  echo "<p>Sorry, something went wrong. Please try again later.</p>";
}
?>
