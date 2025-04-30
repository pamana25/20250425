<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer/src/Exception.php';
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';

include 'conf.php';

// SENDERs

class Mailer
{
    private $senderHost = 'smtp.titan.email';
    private $senderEmail = 'community@pamana.org';
    private $senderName = 'Pamana.org';

    // HOST
    // private $pamanaMainURL = 'https://pamana.org/';
    private $pamanaMainURL = 'https://pamana.org/';


    public function __construct($senderHost = null, $senderEmail = null, $senderName = null, $pamanaMainURL = null)
    {
        if ($senderHost) {
            $this->senderHost = $senderHost;
        }
        if ($senderEmail) {
            $this->senderEmail = $senderEmail;
        }
        if ($senderName) {
            $this->senderName = $senderName;
        }
        if ($pamanaMainURL) {
            $this->pamanaMainURL = $pamanaMainURL;
        }
    }
    // AUTOMATED EMAIL TO USER
    // Signup – The user shall receive an email with a link to verify their email address. - applied
    public function send_verifyaccount_email_to_user($recipientEmail, $recipientFirstName, $token)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $this->senderHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->senderEmail;
            $mail->Password   = confi();
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom($this->senderEmail, $this->senderName);
            $mail->addAddress($recipientEmail);
            $mail->addReplyTo($this->senderEmail, $this->senderName);
            $mail->XMailer = ' ';

            $mail->isHTML(true);
            $mail->Subject = 'Pamana.org - Verify our email address';
            $mail->Body    = 'Hi ' . ucfirst($recipientFirstName) . ',';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'Thank you for joining our community! In order to get full access to Pamana.org features, you need to confirm your email address by following the link below.';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'Click this link <a href="' . $this->pamanaMainURL . 'accountverified?verify=' . $token . '">' . $this->pamanaMainURL . 'accountverified?verify=' . $token . '</a> to confirm your account.';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'Cheers from all of us @Pamana.org.';


            $mail->send();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    // Forgot Password – The user shall receive an email with a link to reset their password. - applied
    public function send_passwordreset_email_to_user($recipientEmail, $recipientFirstName, $token)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $this->senderHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->senderEmail;
            $mail->Password   = confi();
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom($this->senderEmail, $this->senderName);
            $mail->addAddress($recipientEmail);
            $mail->addReplyTo($this->senderEmail, $this->senderName);
            $mail->XMailer = ' ';

            $mail->isHTML(true);
            $mail->Subject = 'Pamana.org - Password reset';
            $mail->Body    = 'Hi ' . ucfirst($recipientFirstName) . ',';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'There was a request to reset your password!';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'If you did not make this request then please ignore this email.';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'Otherwise, please click the link below to reset your password:';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= '<a href="' . $this->pamanaMainURL . 'resetpassword?token=' . $token . '">' . $this->pamanaMainURL . 'resetpassword?token=' . $token . '</a> ';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'Cheers from all of us @Pamana.org.';


            $mail->send();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    // Uploaded Files – The user shall receive an email that their uploaded file is to be reviewed by the admin. - applied
    public function send_filetobereviewed_email_to_user($recipientEmail, $recipientFirstName)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $this->senderHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->senderEmail;
            $mail->Password   = confi();
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom($this->senderEmail, $this->senderName);
            $mail->addAddress($recipientEmail);
            $mail->addReplyTo($this->senderEmail, $this->senderName);
            $mail->XMailer = ' ';

            $mail->isHTML(true);
            $mail->Subject = 'Pamana.org - Uploaded File to be Reviewed';
            $mail->Body    = 'Hi ' . ucfirst($recipientFirstName) . ',';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'The file that you uploaded to Pamana.org is now to be reviewed by the admin.';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'Cheers from all of us @Pamana.org.';


            $mail->send();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    // Uploaded Files –The user shall receive an email once their uploaded file(s) are approved by the email and are already in the Pamana Gallery or disapproved/denied. - not yet applied (admin function)
    public function send_filestatusnotif_email_to_user($recipientEmail, $recipientFirstName, $fileStatus)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $this->senderHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->senderEmail;
            $mail->Password   = confi();
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom($this->senderEmail, $this->senderName);
            $mail->addAddress($recipientEmail);
            $mail->addReplyTo($this->senderEmail, $this->senderName);
            $mail->XMailer = ' ';

            $mail->isHTML(true);
            $mail->Subject = 'Pamana.org - Uploaded File Status';
            $mail->Body    = 'Hi ' . ucfirst($recipientFirstName) . ',';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'The file that you uploaded to Pamana.org has been <b>' . $fileStatus . '</b> by the admin.';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'Cheers from all of us @Pamana.org.';


            $mail->send();
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }


    // AUTOMATED EMAIL TO ADMIN
    // Signup – The admin shall receive an email with information about the user that just created an account and is still in need of account/email address verification.
    public function send_newlycreatedaccount_email_to_webmaster($userEmail)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $this->senderHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->senderEmail;
            $mail->Password   = confi();
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom($this->senderEmail, $this->senderName);
            $mail->addAddress($this->senderEmail);
            $mail->addReplyTo($this->senderEmail, $this->senderName);
            $mail->XMailer = ' ';

            $mail->isHTML(true);
            $mail->Subject = 'Pamana.org - New account has been created';
            $mail->Body    .= 'New account with an email <b>' . $userEmail . '</b> has been created.';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'Pamana.org';


            $mail->send();
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    // Verify Email – The admin shall receive an email that the user has verified their account.
    public function send_verifiedaccount_email_to_webmaster($recipientEmail)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $this->senderHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->senderEmail;
            $mail->Password   = confi();
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom($this->senderEmail, $this->senderName);
            $mail->addAddress($this->senderEmail);
            $mail->addReplyTo($this->senderEmail, $this->senderName);
            $mail->XMailer = ' ';

            $mail->isHTML(true);
            $mail->Subject = 'Pamana.org - Verified email';
            $mail->Body    .= 'An account with an email <b>' . $recipientEmail . '</b> has been verified.';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'Pamana.org';


            $mail->send();
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    // Uploads – The admin shall receive an email when a user uploads file(s) and is for pending or for approval.
    public function send_uploadnotif_email_to_webmaster($recipientEmail)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $this->senderHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->senderEmail;
            $mail->Password   = confi();
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom($this->senderEmail, $this->senderName);
            $mail->addAddress($this->senderEmail);
            $mail->addReplyTo($this->senderEmail, $this->senderName);
            $mail->XMailer = ' ';

            $mail->isHTML(true);
            $mail->Subject = 'Pamana.org - New Upload';
            $mail->Body    .= 'An account with an email <b>' . $recipientEmail . '</b> has uploaded files to Pamana.org. Please review the file.';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'Thank you!';
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'Pamana.org';

            $mail->send();
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    // Disapprove notifications email messages
    public function send_disapprove_email_to_user( $recipientEmail, $recipientFirstName, $email_subject, $email_body1, $email_body2, $email_body3, $email_body4, $email_body5, $email_value_other)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $this->senderHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->senderEmail;
            $mail->Password   = confi();
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom($this->senderEmail, $this->senderName);
            $mail->addAddress($recipientEmail);
            $mail->addReplyTo($this->senderEmail, $this->senderName);
            $mail->XMailer = ' ';

            $mail->isHTML(true);
            $mail->Subject = 'Pamana.org - Uploaded File Status : ' . $email_subject . '';
            $mail->Body    = 'Hi ' . ucfirst($recipientFirstName) . ',';
            $mail->Body    .= '<br/><br/>';
            if ($email_value_other != '') {
                $mail->Body    .= $email_value_other;
            } else {
                $mail->Body    .= $email_body1;
                $mail->Body    .= '<br/><br/>';
                $mail->Body    .= $email_body2;
                $mail->Body    .= '<br/><br/>';
                $mail->Body    .= $email_body3;
                $mail->Body    .= '<br/><br/>';
                $mail->Body    .= $email_body4;
                $mail->Body    .= '<br/><br/>';
                if ($email_body5 != '') {
                    $mail->Body    .= $email_body5;
                }
            }
            $mail->Body    .= '<br/><br/>';
            $mail->Body    .= 'Cheers from all of us at Pamana.org.';


            $mail->send();
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }
}
