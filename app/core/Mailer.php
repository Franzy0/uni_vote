<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    protected $cfg;
    public function __construct()
    {
        $this->cfg = require __DIR__ . '/../config/config.php';
    }

    public function send($to, $subject, $htmlBody)
    {
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) return false;
        $mCfg = $this->cfg['mail'];
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $mCfg['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $mCfg['username'];
            $mail->Password = $mCfg['password'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = $mCfg['port'];
            $mail->setFrom($mCfg['from_email'], $mCfg['from_name']);
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $htmlBody;
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('Mail error: '.$e->getMessage());
            return false;
        }
    }
}
