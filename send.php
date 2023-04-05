<?php
if(isset($_POST['search'])) {

    $email_to = "rawart.media@gmail.com";
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
        !isset($_POST['Address']) ||
        !isset($_POST['max-price'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
    
    $email_from = $_POST['search']; // required
    $category = $_POST['category']; // required
    $Address = $_POST['Address']; // required
    $max_price = $_POST['max-price']; // required
    
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
    
    $string_exp = "/^[A-Za-z .'-]+$/";
    
  if(!preg_match($string_exp,$category)) {
    $error_message .= 'The Category you entered does not appear to be valid.<br />';
  }
    
  if(!preg_match($string_exp,$Address)) {
    $error_message .= 'The Address you entered does not appear to be valid.<br />';
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
    $email_message .= "Address: ".clean_string($Address)."\n";
    $email_message .= "Max Price: ".clean_string($max_price)."\n";
    
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>
 
<!-- include your own success html here -->
 
Thank you for contacting us. We will be in touch with you very soon.
 
<?php
}
?>