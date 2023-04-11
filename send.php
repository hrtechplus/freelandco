<?php

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Define database connection parameters
    $servername = "localhost";
    $username = "freelandco";
    $password = "6stzZzMDJszuhE8";
    $dbname = "freelandco_users";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form values
$email = $_POST['search'];
$contact_number = $_POST['category'];
$address = $_POST['Address'];
$submission_date = date("Y-m-d");

// Generate random ID
$id = uniqid();

// Insert values into database
$sql = "INSERT INTO users (id, email, contact_number, address, submission_date)
VALUES ('$id', '$email', '$contact_number', '$address', '$submission_date')";

if (mysqli_query($conn, $sql)) {
    // Redirect to index.html after successful submission
    header("Location: index.html");
    exit();
} else {
    echo "Error inserting data: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
}

?>
