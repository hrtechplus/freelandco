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
$to = "your_email@gmail.com";
$subject = "New Property Inquiry";
$message = "Email: $email\nCategory: $category\nAddress: $address\nPrice: $price";
$headers = "From: your_email@gmail.com" . "\r\n" .
           "Reply-To: your_email@gmail.com" . "\r\n" .
           "X-Mailer: PHP/" . phpversion();

// Authenticate with Gmail SMTP server
$username = "testupworkhr@gmail.com";
$password = "^Bu7hSRkJsiD^wF9";
$smtp = array(
  'host' => 'smtp.gmail.com',
  'port' => 587,
  'auth' => true,
  'username' => $username,
  'password' => $password
);

// Send email using SMTP
$transport = new \Swift_SmtpTransport($smtp['host'], $smtp['port']);
$transport->setUsername($smtp['username']);
$transport->setPassword($smtp['password']);
$transport->setEncryption('tls');
$mailer = new \Swift_Mailer($transport);
$message = new \Swift_Message($subject);
$message->setFrom(array('your_email@gmail.com' => 'Your Name'));
$message->setTo(array($to));
$message->setBody($message);
$result = $mailer->send($message);
?>