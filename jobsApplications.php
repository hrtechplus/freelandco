<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if all required fields are completed
  if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['hear-about-us']) && !empty($_FILES['resume']['name'])) {
    // Connect to the database
    $servername = "localhost";
    $username = "freelandco";
    $password = "6stzZzMDJszuhE8";
    $dbname = "jobsApplications";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO jobApplication (name, email, phone, hear_about_us, resume) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $hear_about_us, $resume);

    // Set the variables and execute the statement
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $hear_about_us = $_POST['hear-about-us'];
    $resume = $_FILES['resume']['name'];
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to a success page
    header("Location: success.php");
    exit();
  } else {
    // Display an error message if required fields are missing
    echo "Please complete all required fields.";
  }
}
?>