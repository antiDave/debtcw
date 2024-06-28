<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$name = isset($_POST['name']) ? $_POST['name'] : 'Unknown';
$email = isset($_POST['email']) ? $_POST['email'] : 'Unknown';

try {
    // Check if files were uploaded
    if (empty($_FILES['files']['name'][0])) {
        throw new Exception("No files were uploaded.");
    }

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtppro.zoho.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'contact@debtcw.com';
    $mail->Password = '#Howiedoit0321';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom('contact@debtcw.com', 'DebtCW Website Contact');
	$mail->addAddress('paul@debtcw.com');
    $mail->addAddress('intake@debtcw.com');
    //$mail->addAddress('usamtg@hotmail.com');
    
    $mail->isHTML(true);
    $mail->Subject = "New files uploaded by $name - $email";
    $mail->Body = "Files uploaded by:<br>Name: $name<br>Email: $email<br><br>Please find the attached files.";

    // Attach files
    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['files']['error'][$key] === UPLOAD_ERR_OK) {
            $mail->addAttachment($tmp_name, $_FILES['files']['name'][$key]);
        } else {
            throw new Exception("Error uploading file: " . $_FILES['files']['name'][$key]);
        }
    }

    // Enable debug mode
    $mail->SMTPDebug = 2;
    ob_start();
    $result = $mail->send();
    $debug = ob_get_clean();

    if (!$result) {
        throw new Exception($mail->ErrorInfo);
    }

    echo json_encode(['status' => 'success', 'message' => 'Files have been sent successfully']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => "Message could not be sent. Error: " . $e->getMessage(), 'debug' => $debug ?? '']);
}