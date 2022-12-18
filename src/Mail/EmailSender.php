<?php

namespace App\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailSender
{
    public function createMailSender()
    {
        $e=new PHPMailer(true);
        $e->isSMTP();
        $e->Host= 'smtp.gmail.com';
        $e->SMTPAuth=true;
        $e->Username='masteriareims@gmail.com';
        $e->Password='fvovijvmjtgfrjac';
        $e->SMTPSecure='ssl';
        $e->Port=465;
        return $e;
    }

    /**
     * @throws Exception
     */
    public function sendEmail(PHPMailer $mailer, String $from, string $to, string $subject, string $body)
    {
        $mailer->setFrom($from);
        $mailer->addAddress($to);
        $mailer->isHTML();
        $mailer->Subject=$subject;
        $body=nl2br("Message de $from :\n $body");
        $mailer->Body=$body;
        $mailer->send();
    }
}
