<?php
header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate email
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);

    if (!$email) {
        echo json_encode(['success' => false, 'message' => 'Invalid email']);
        exit;
    }

    // Email content
    $subject = "Welcome to Our Mailing List!";
    $message = "Hi there!\n\nThank you for subscribing to our mailing list. We will keep you updated with news, offers, and special deals.\n\nBest regards,\nYour Company Name";
    
    // Set headers
    $headers = "From: no-reply@hostitservices.com\r\n";
    $headers .= "Reply-To: no-reply@hostitservices.com\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Send email
    if (mail($email, $subject, $message, $headers)) {
        echo json_encode(['success' => true, 'message' => 'Confirmation email sent successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send email.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>