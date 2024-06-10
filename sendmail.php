<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php'
require 'phpmailer/src/PHPMailer.php'


$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru','phpmailer/language/');
$mail->IsHTML(true);

$mail->setForm('artcomputers92@gmail.com','Artur Paronyan');
$mail->addAdress('artcomputers92@gmail.com');
$mail->Subject = 'hello brat';


$hand = 'pravaya';
if($_POST['hand']=='left'){
    $hand = 'levaya'
}

$body = '<h1>hello world</h1>';
if (!empty(trim($_POST['name']))) {
    $body .= '<p><strong>Name:</strong> ' . $_POST['name'] . '</p>';
}
if(trim(!empty($_POST['email']))){
    $body .= '<p><strong>Email:</strong> ' . $_POST['name'] . '</p>';
}
if(trim(!empty($_POST['hand']))){
    $body .= '<p><strong>Ruka:</strong> ' . $_POST['name'] . '</p>';
}
if(trim(!empty($_POST['age']))){
    $body .= '<p><strong>Age:</strong> ' . $_POST['name'] . '</p>';
}
if(trim(!empty($_POST['message']))){
    $body .= '<p><strong>message:</strong> ' . $_POST['name'] . '</p>';
}

if(!empty($_FILES['image']['tmp_name'])){
    $filePath  = __DIR__ . "/files/" . $_FILES['image']['name'];
    if(copy($_FILES['image']['tmp_name'],$filePath)){
        $fileAttach = $filePath;
    $body.='<p><strong>foto</strong></p>';
    $mail->addAttachment($fileAttach); 
    }
   
}
$mail->body = $body;

if(!$mail->send()){
    $message = 'error';
}else{
    $message = 'loaded';
}

$response = ['message' => $message];
header('Content-type:application/json');
echo json_encode($response)

?>