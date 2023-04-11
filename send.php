<?php

// Establish database connection
$servername = "localhost";
$username = "freelandco_users";
$password = "s9*$9@&EKjns";
$dbname = "freelandco_users";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve form values
$email = $_POST['search'];
$contact_number = $_POST['category'];
$address = $_POST['Address'];
$submission_date = date("Y-m-d");
$recaptcha_response = $_POST['g-recaptcha-response'];

// Verify reCAPTCHA response
    // Verify reCAPTCHA response
    $recaptcha_secret_key = "6Lf6sXolAAAAAL3WRoR63ryDn9wndsU-2U6oOd2c";
    $recaptcha_response = $_POST["g-recaptcha-response"];
    $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify";
    $recaptcha_data = array(
        "secret" => $recaptcha_secret_key,
        "response" => $recaptcha_response
    );
    $recaptcha_options = array(
        "http" => array(
            "method" => "POST",
            "content" => http_build_query($recaptcha_data)
        )
    );
    $recaptcha_context = stream_context_create($recaptcha_options);
    $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
    $recaptcha_json = json_decode($recaptcha_result);
    if (!$recaptcha_json->success) {
        die("reCAPTCHA verification failed");
    }

// Generate random ID
$id = uniqid();

// Insert values into database
$sql = "INSERT INTO homeowners (id, email, contact_number, address, submission_date)
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

?>
