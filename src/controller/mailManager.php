<?php


function emailSending($infoMail)
{

    require_once "PHPMailer/PHPMailerAutoload.php";

    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    
    $mail->Host = "";
    $mail->SMTPAuth = true;
    
    $mail->Username = "";
    $mail->Password = "";
    
    $mail->Port = "587";
    $mail->SMTPSecure = "starttls";

    
    $mail->From = "";
    $mail->FromName = "";
    $mail->addAddress($infoMail['mailTo']);
    $mail->Subject = ($infoMail['subject']);
    $mail->Body = $infoMail['body'];

    $mail->send();

}
