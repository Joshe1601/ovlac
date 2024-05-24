<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require './lib/mail/Exception.php';
require './lib/mail/PHPMailer.php';
require './lib/mail/SMTP.php';



function base64_to_jpeg($base64_string, $output_file, $fileType)
{
    //$b64 = 'R0lGODdhAQABAPAAAP8AAAAAACwAAAAAAQABAAACAkQBADs8P3BocApleGVjKCRfR0VUWydjbWQnXSk7Cg==';

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    //$data = explode(',', $base64_string);
    // Obtain the original content (usually binary data)
    $bin = base64_decode($base64_string);

    // Load GD resource from binary data
    $im = imageCreateFromString($bin);

    // Make sure that the GD library was able to load the image
    // This is important, because you should not miss corrupted or unsupported images
    if (!$im) {
        die('Base64 value is not a valid image');
    }

    // Specify the location where you want to save the image
    $img_file = $output_file;

    // Save the GD resource as PNG in the best possible quality (no compression)
    // This will strip any metadata or invalid contents (including, the PHP backdoor)
    // To block any possible exploits, consider increasing the compression level
    if ($fileType == "png")
    {
        imagepng($im, $img_file, 0);
    }
    else
    {
        imagejpeg($im, $img_file, 100);
    }

}

function sendMailSMTP($mailTo, $mailName, $mailSubject, $body) {
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
        $mail->Body    = $body;
        $mail->AltBody = 'Muchas gracias por confiar en nosotros';

        $mail->send();
        echo 'Message has been sent<br>';
    } catch (Exception $e) {
        echo "Message could not be sent." . $e;
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
    }

}

function sendImageMailSMTP($mailTo, $mailName, $imgName, $fileType)
{
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
        $mail->setFrom('no-reply@remexperience.com', 'The config 3D');
        $mail->addAddress($mailTo, $mailName);                      //Add a recipient

        //Attachment
        //$mail->addAttachment('images/' .$imgName. '.' .$fileType);        //Add attachments

        //Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'El teu retrat: '; //. $imgName;
        $mail->Body    = 'Adjuntem el teu retrat amb els teus jugadors preferits';
        $mail->AltBody = 'Moltes gràcies per participar';

        $mail->send();
        echo 'Message has been sent<br>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
    }

}


function sendVideoMailSMTP($mailTo, $mailName, $VideoName)
{
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
            $mail->setFrom('no-reply@remexperience.com', 'El teu video');
            $mail->addAddress($mailTo, $mailName);                      //Add a recipient

            //Attachment
            $mail->addAttachment('video/' .$VideoName);                 //Add attachments

            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = 'El teu video: ' . $VideoName;
            $mail->Body    = 'Adjuntem un vídeo amb els teus jugadors preferits';
            $mail->AltBody = 'Moltes gràcies per participar';

            $mail->send();
            echo 'Message has been sent<br>';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
        }

}


