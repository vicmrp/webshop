<?php
namespace vezit\classes\mail;

require_once __DIR__.'/../../global-requirements.php';
require_once _from_top_folder().'/composer/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
  
  // ----- Eksempel ----- //
  // use vezit\classes\mail as Mail;
  // (array)$recipients = array(array("victor.reipur@gmail.com", "Victor Reipur"));
  // (string)$subject = "Here is the subject 2";
  // (string)$body = "This is the HTML message body <b>in bold!</b>";
  // Mail\Mail::send_mail($recipients, $subject, $body);
  // ----- Eksempel ----- //
  public static function send_mail (
      array  $recipients,
      string $subject,
      string $body,
      array  $attachments = null,
      array  $setFrom = array(
        'dev.victor.reipur@gmail.com', 
        'Victor Reipur'       
    )): void {
    try {

      global $g_smtp_mail_credential;
      // Instantiation and passing `true` enables exceptions
      $mail = new PHPMailer(true);
    
      // Server settings
      // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                       // Enable verbose debug output
      $mail->isSMTP();                                                // Send using SMTP
      $mail->Host       = $g_smtp_mail_credential->host;              // Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                       // Enable SMTP authentication
      $mail->Username   = $g_smtp_mail_credential->username;          // SMTP username
      $mail->Password   = $g_smtp_mail_credential->password;          // SMTP password
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
}
