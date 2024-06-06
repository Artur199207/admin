<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->isHTML(true);

$mail->setFrom('artcomputers92@gmail.com', 'Artur Paronyan');
$mail->addAddress('artcomputers92@gmail.com');
$mail->Subject = 'hello brat';

$hand = 'pravaya';
if ($_POST['hand'] == 'left') {
    $hand = 'levaya';
}

$body = '<h1>hello world</h1>';
if (!empty(trim($_POST['name']))) {
    $body .= '<p><strong>Name:</strong> ' . $_POST['name'] . '</p>';
}
if (!empty(trim($_POST['email']))) {
    $body .= '<p><strong>Email:</strong> ' . $_POST['email'] . '</p>';
}
if (!empty(trim($_POST['hand']))) {
    $body .= '<p><strong>Ruka:</strong> ' . $hand . '</p>';
}
if (!empty(trim($_POST['age']))) {
    $body .= '<p><strong>Age:</strong> ' . $_POST['age'] . '</p>';
}
if (!empty(trim($_POST['message']))) {
    $body .= '<p><strong>Message:</strong> ' . $_POST['message'] . '</p>';
}

if (!empty($_FILES['image']['tmp_name'])) {
    $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
    if (copy($_FILES['image']['tmp_name'], $filePath)) {
        $fileAttach = $filePath;
        $body .= '<p><strong>Foto:</strong></p>';
        $mail->addAttachment($fileAttach);
    }
}

$mail->Body = $body;

if (!$mail->send()) {
    $message = 'error: ' . $mail->ErrorInfo;
} else {
    $message = 'loaded';
}

$response = ['message' => $message];
header('Content-type: application/json');
echo json_encode($response);

?>
