<?php

require_once('vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function validateInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = validateInput($_POST['name']);
    $phone = validateInput($_POST['phone']);
    $email = validateInput($_POST['email']);

    if (empty($name) || empty($phone) || empty($email)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        try {
        	$mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtppro.zoho.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'contact@debtcw.com';
            $mail->Password = '#Howiedoit0321';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('contact@debtcw.com', 'DebtCW Website Contact');
            $mail->addAddress('paul@debtcw.com');
            $mail->addAddress('intake@debtcw.com');
    		//$mail->addAddress('usamtg@hotmail.com');

            $mail->isHTML(true);
            $mail->Subject = 'New Collection Claim Submission';
            $mail->Body    = "
                <h3>New Collection Claim Submission</h3>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> $phone</p>
            ";

            $mail->send();
            
            // Redirect to thank_you.html on success
            header("Location: thank_you.html");
            exit();
        } catch (Exception $e) {
            $error = "Message could not be sent. Please try again later.";
        }
    }
}

// If there's an error, display it
if (!empty($error)) {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <title>Submission Error - DebtCW</title>
    </head>
    <body>
        <div class='container'>
            <div class='alert alert-danger' role='alert'>
                $error
            </div>
            <a href='form.html'>Back to Form</a>
        </div>
    </body>
    </html>";
}
?>