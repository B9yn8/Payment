<?php
// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$amount = $_POST['amount'];
$description = $_POST['description'];
$paymentMethod = $_POST['payment-method'];
$transactionID = $_POST['transaction-id'];

// Handle file upload
$targetDir = "uploads/";
$fileName = basename($_FILES["confirmation"]["name"]);
$targetFilePath = $targetDir . $fileName;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFilePath,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["confirmation"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($targetFilePath)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["confirmation"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["confirmation"]["tmp_name"], $targetFilePath)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["confirmation"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Send the data to Telegram bot
$botToken = "YOUR_BOT_TOKEN"; // Replace with your Telegram bot token
$chatId = "YOUR_CHAT_ID"; // Replace with your chat ID

$message = "New payment submission:\n";
$message .= "Name: $name\n";
$message .= "Email: $email\n";
$message .= "Amount: $amount\n";
$message .= "Description: $description\n";
$message .= "Payment Method: $paymentMethod\n";
$message .= "Transaction ID: $transactionID\n";
$message .= "Confirmation Image: $fileName";

// Send message to Telegram
$telegramUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";
$telegramParams = [
    'chat_id' => $chatId,
    'text' => $message
];

// Make POST request to Telegram API
$ch = curl_init($telegramUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $telegramParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Check Telegram API response
if (!$response) {
    echo "Failed to send message to Telegram.";
} else {
    echo "Payment submitted successfully!";
}
?>
