<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require_once 'composer/vendor/autoload.php';

function myMailFunction (
    array  $recipients,
    string $subject,
    string $body,
    array  $attachments = null,
    array  $setFrom = array(
        'dev.victor.reipur@gmail.com', 
        'Victor Reipur'
    
    
    )): void {
        try {
            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);

            // Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                       // Enable verbose debug output
            $mail->isSMTP();                                                // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                           // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                       // Enable SMTP authentication
            $mail->Username   = 'dev.victor.reipur@gmail.com';              // SMTP username
            $mail->Password   = 'fsukliqvywlvllrh';                         // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;             // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                        // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->CharSet    = 'UTF-8';
            // Afsender
            $mail->setFrom($setFrom[0], $setFrom[1]);
            
            // Recipients
            foreach ($recipients as $recipient) {
                $mail->addAddress($recipient[0], $recipient[1]); 
            }

            if ($attachments !== null) {
                // Vedhæftede filer
                foreach ($attachments as $attachment) {
                    $mail->addAttachment($attachment);
                }
            }

            // Content
            $mail->isHTML(true);                                                        // Set email format to HTML
            $mail->Subject =  $subject;
            $mail->Body    =  $body;
            $mail->send();
            
        } catch (Exception $e) { 
            error_log($e, 0); 
            echo "Error 500";
        }
}

// // // Eksempel
// (array)$recipients = array(array("victor.reipur@gmail.com", "Victor Reipur"));
// (string)$subject = "Here is the subject 2";
// (string)$body = "This is the HTML message body <b>in bold!</b>";
// myMailFunction($recipients, $subject, $body);

?>