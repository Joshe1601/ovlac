<?php


namespace App\Helpers;

//require_once 'functions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require_once base_path('/app/Helpers/lib/mail/Exception.php');
require_once base_path('app/Helpers/lib/mail/PHPMailer.php');
require_once base_path('app/Helpers/lib/mail/SMTP.php');





class MailHelper
{

    public static function sendMailSMTP($mailTo, $mailName, $mailSubject) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       //Enable verbose debug output
            $mail->Debugoutput = 'html';
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'remexperience.com';                    //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'no-reply@remexperience.com';           //SMTP username
            $mail->Password   = ')m2~2J|436#s';                         //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('no-reply@remexperience.com', $mailSubject);
            $mail->addAddress($mailTo, $mailName);                      //Add a recipient

            //Attachment
            //$mail->addAttachment('images/' .$imgName. '.' .$fileType);        //Add attachments

            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = $mailSubject;  //. $imgName;
            $mail->Body    = 'Hola esto es una prueba de presupuesto por mail';
            $mail->AltBody = 'Muchas gracias por confiar en nosotros';

            $mail->send();
           // echo 'Message has been sent<br>';
        } catch (Exception $e) {
            echo "Message could not be sent." . $e;
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
        }

    }
    public static function sendTextMail($mailTo, $mailName, $mailSubject, $mailBody = null, $fileName = null) {
        //dd('Llegamos al helper ahora');
      // MailHelper::sendMailSMTP($mailTo, $mailName, $mailSubject);
        MailHelper::sendFileMail($mailTo, $mailName, $mailSubject, $mailBody, $fileName);
    }


    public static function sendFileMail($mailTo, $mailName, $mailSubject, $mailBody, $fileName = null) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       //Enable verbose debug output
            $mail->Debugoutput = 'html';
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'remexperience.com';                    //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'no-reply@remexperience.com';           //SMTP username
            $mail->Password   = ')m2~2J|436#s';                         //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('no-reply@remexperience.com', $mailSubject);
            $mail->addAddress($mailTo, $mailName);                      //Add a recipient

            //Attachment
            $fileType = 'html';
            $mail->addAttachment($fileName. '.' .$fileType);        //Add attachments

            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = $mailSubject;  //. $imgName;
            $mail->Body    = 'Hola esto es una prueba de presupuesto por mail con File';
            $mail->AltBody = 'Muchas gracias por confiar en nosotros';

            $mail->send();
            // echo 'Message has been sent<br>';
        } catch (Exception $e) {
            echo "Message could not be sent." . $e;
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
        }
    }

}
