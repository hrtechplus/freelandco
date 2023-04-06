<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if(isset($_POST['search'])) {

    $email_to = "testupworkhr@gmail.com";
    $email_subject = "New form submission";
    
    function died($error) {
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
    
    // validation expected data exists
    if(!isset($_POST['search']) ||
        !isset($_POST['category']) ||
        !isset($_POST['max-price'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
    
    $email_from = $_POST['search']; // required
    $category = $_POST['category']; // required
    $Address = $_POST['Address']; // not required
    $max_price = $_POST['max-price']; // required
    
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
    
    $string_exp = "/^[A-Za-z0-9 .',-]+$/";
    
  if(!preg_match($string_exp,$category)) {
    $error_message .= 'The Category you entered does not appear to be valid.<br />';
  }
    
  if(strlen($error_message) > 0) {
    died($error_message);
  }
    
    $email_message = "Form details below.\n\n";
    
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
    
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Category: ".clean_string($category)."\n";
    if(isset($Address)) {
        $email_message .= "Address: ".clean_string($Address)."\n";
    }
    $email_message .= "Max Price: ".clean_string($max_price)."\n";
    
    // create email headers
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 2;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'testupworkhr@gmail.com';                     // SMTP username
        $mail->Password   = '8atCk6CSK^EQY7RZ';                               // SMTP password
        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom($email_from, 'Mailer');
        $mail->addAddress($email_to);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $email_subject;
        $mail->Body    = $email_message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>