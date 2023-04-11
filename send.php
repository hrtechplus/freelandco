<?php

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    // Define database connection parameters
    $servername = "localhost";
    $username = "freelandco";
    $password = "6stzZzMDJszuhE8";
    $dbname = "freelandco_Users";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get input data from form
    $email = $_POST["search"];
    $category = $_POST["category"];
    $address = $_POST["Address"];

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO house_owners (email, category, address) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $category, $address);

    // Execute SQL statement
    if ($stmt->execute() === TRUE) {
        // Redirect to success page
        header("Location: index.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close database connection
    $stmt->close();
    $conn->close();
}

?>
