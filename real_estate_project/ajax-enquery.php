<?php
ob_start();
session_start();
include 'config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$arr = array();

if(isset($_POST['email'])) {
	try {
		if($_POST['full_name'] == '') {
            throw new Exception("Full name can not be empty");
        }
        if($_POST['email'] == '') {
            throw new Exception("Email can not be empty");
        }
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid");
        }
        if($_POST['phone'] == '') {
            throw new Exception("Phone can not be empty");
        }
        if($_POST['message'] == '') {
            throw new Exception("Message can not be empty");
        }

        $email_message = 'Full Name: '.$_POST['full_name'].'<br>';
        $email_message .= 'Email: '.$_POST['email'].'<br>';
        $email_message .= 'Phone: '.$_POST['phone'].'<br>';
        $email_message .= 'Message: '.$_POST['message'].'<br>';

		$mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        $mail->Port = SMTP_PORT;
        $mail->setFrom(SMTP_FROM);
        $mail->addAddress($_POST['agent_email']);
        $mail->isHTML(true);
        $mail->Subject = 'Enquery Form Email from Customer';
        $mail->Body = $email_message;
        $mail->send();

		$arr['success_message'] = "Your email is sent successfully. Agent will check and reply you soon.";
	}
	catch(Exception $e) {
		$error_message = $e->getMessage();
		$arr['error_message'] = $error_message;
	}
}
echo json_encode($arr);