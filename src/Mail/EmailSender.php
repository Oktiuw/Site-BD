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
    }
}
