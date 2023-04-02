<?php
// Get user input from the form
$email = $_POST['search'];
$category = $_POST['category'];
$address = $_POST['Address'];
$price = $_POST['max-price'];

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "learning";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Insert user input into the database
$sql = "INSERT INTO property (email, category, address, price) VALUES ('$email', '$category', '$address', '$price')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Send email with user input
$to = "rawart.media@gmail.com";
$subject = "New Property Inquiry";
$message = "Email: $email\nCategory: $category\nAddress: $address\nPrice: $price";
$headers = "From: webmaster@example.com" . "\r\n" .
           "Reply-To: webmaster@example.com" . "\r\n" .
           "X-Mailer: PHP/" . phpversion();

mail($to, $subject, $message, $headers);
?>