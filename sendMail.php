<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  http_response_code(200);
  exit();
}

//require __DIR__ . '/../vendor/autoload.php'; // Composer autoload
require __DIR__ . '/vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

$mail = new PHPMailer(true);

try {
  // SMTP Configuration
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';       // e.g., smtp.gmail.com
  $mail->SMTPAuth = true;
  $mail->Username = 'lokeshyadav31290@gmail.com';          // Your SMTP username
  $mail->Password = 'jvis wyhb ohwp adzc';            // Your SMTP password
  $mail->SMTPSecure = 'tls';                   // Or 'ssl'
  $mail->Port = 587;                           // Or 465 for SSL

  // Form Data
  $firstName     = $_POST['firstName'] ?? '';
  $lastName      = $_POST['lastName'] ?? '';
  $email         = $_POST['email'] ?? '';
  $phone = $_POST['phone'] ?? '';
if ($phone && strpos($phone, '+') !== 0) {
  $phone = '+' . $phone;
}
  $dob           = $_POST['dob'] ?? '';
  $maritalStatus = $_POST['maritalStatus'] ?? '';
  $passport      = $_POST['passport'] ?? '';
  $package       = $_POST['package'] ?? '';
  $message       = $_POST['message'] ?? '';
  $consent1      = isset($_POST['consent1']) ? 'Yes' : 'No';
  $consent2      = isset($_POST['consent2']) ? 'Yes' : 'No';

  // Email Content
  $mail->setFrom($email, "$firstName $lastName");
  $mail->addAddress('lokeshyadav31290@gmail.com'); // Receiver
  $mail->Subject = 'New Cruise Enquiry';
  $mail->Body = <<<EOT
New enquiry received:

Name: $firstName $lastName
Email: $email
Phone: $phone
Date of Birth: $dob
Marital Status: $maritalStatus
Passport: $passport
Package: $package
Message: $message

Consent 1: $consent1
Consent 2: $consent2
EOT;

  $mail->send();
  echo json_encode(['success' => true]);
} catch (Exception $e) {
  echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
}
