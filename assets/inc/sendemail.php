<?php
// ===============================================
// Survivors Affected By Violence - Contact Form
// File: assets/inc/sendemail.php
// ===============================================

// --- CONFIGURATION ---
define("RECIPIENT_NAME", "Leatha Sherill-Bush");
define("brandongines@gmail.com", "brandongines@gmail.com");

// --- READ FORM FIELDS AND SANITIZE INPUT ---
$name    = isset($_POST['name']) ? trim($_POST['name']) : '';
$email   = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone   = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// --- BASIC VALIDATION ---
if (empty($name) || empty($email) || empty($message)) {
    echo "<div class='inner error'><p class='error'>Please fill out all required fields (Name, Email, and Message).</p></div>";
    exit;
}

// --- CLEAN INPUTS TO PREVENT HEADER INJECTION ---
$pattern = "/(content-type|bcc:|cc:|to:|href)/i";
if (preg_match($pattern, $name . $email . $message)) {
    echo "<div class='inner error'><p class='error'>Invalid input detected.</p></div>";
    exit;
}

// --- BUILD THE EMAIL ---
$email_subject = "Contact Form: " . (!empty($subject) ? $subject : "New Message from Website");
$email_body  = "You have received a new message from Survivors Affected By Violence website.\n\n";
$email_body .= "Name: $name\n";
$email_body .= "Email: $email\n";
if (!empty($phone))   $email_body .= "Phone: $phone\n";
if (!empty($subject)) $email_body .= "Subject: $subject\n";
$email_body .= "\nMessage:\n$message\n";

// --- SET HEADERS ---
$recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
$headers   = "From: $name <$email>\r\n";
$headers  .= "Reply-To: $email\r\n";
$headers  .= "X-Mailer: PHP/" . phpversion();

// --- SEND EMAIL ---
$success = mail($recipient, $email_subject, $email_body, $headers);

// --- RETURN RESPONSE ---
if ($success) {
    echo "<div class='inner success'><p class='success'>Thank you, $name. Your message has been sent successfully. We’ll get back to you soon.</p></div>";
} else {
    echo "<div class='inner error'><p class='error'>Something went wrong. Please try again later.</p></div>";
}
?>