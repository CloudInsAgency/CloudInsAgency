<?php
// process-form.php - Place this file in the same directory as your index.html

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data and sanitize
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $insurance_type = strip_tags(trim($_POST["insurance_type"]));
    $message = strip_tags(trim($_POST["message"]));
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email address";
        exit;
    }
    
    // Set recipient email
    $recipient = "cfoskey@thecloudins.com";
    
    // Set email subject
    $subject = "New Quote Request from $name - Cloud Insurance Website";
    
    // Build email content
    $email_content = "New Quote Request from Cloud Insurance Website\n\n";
    $email_content .= "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Insurance Type: $insurance_type\n";
    $email_content .= "Additional Information:\n$message\n";
    $email_content .= "\n---\n";
    $email_content .= "This form was submitted from cloudinsuranceagency.com\n";
    $email_content .= "Date: " . date('Y-m-d H:i:s') . "\n";
    
    // Build email headers
    $email_headers = "From: Cloud Insurance Website <noreply@thecloudins.com>\r\n";
    $email_headers .= "Reply-To: $name <$email>\r\n";
    
    // Send email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Success - redirect to thank you page or show success message
        http_response_code(200);
        echo "Thank you! Your quote request has been sent. We will contact you shortly.";
    } else {
        // Error
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
    
} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
