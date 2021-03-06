<?php

namespace App\Services;

use Swift_Mailer;
use Swift_SmtpTransport;
use Swift_Message;

class SendMailer
{
    /**
     * SendMailer constructor.
     * @param $env
     */
    public function __construct($env)
    {
        $this->env = $env;
    }

    /**
     * @param $email
     * @param $access_token
     * @param $access_name
     * @param $access_firstname
     * @return int
     */
    public function sendMailer($email, $access_token, $access_name, $access_firstname)
    {

        // Create the Transport
        $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 2525))
            ->setUsername('caa22725bc661f')
            ->setPassword('a2f2923eb65310');
        // Create the content
        $content = '<a href="http://projet_5_test.test/public/admin.php?action=click2validate&token=' . $access_token . '"> Cliquez-ici pour finaliser votre inscription</a>';

        if ($_SERVER['SERVER_NAME'] == 'sc19dev.fr') {
            $transport = (new Swift_SmtpTransport('smtp.ionos.fr', 587, 'tls'))
                ->setUsername($this->env['mail_user'])
                ->setPassword($this->env['mail_pwd']);
            $content = '<a href="http://sc19dev.fr/ReportMe/public/admin.php?action=click2validate&token=' . $access_token . '"> Cliquez-ici pour finaliser votre inscription</a>';

        }
// Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

// Create a message
        $message = (new Swift_Message('Confirm your inscription'))
            ->setFrom([$this->env['mail_user'] => 'ReportMe Regisration'])
            ->setTo([$email => $access_name . ' ' . $access_firstname])
            ->setBody($content);

        // HTML Content
        $message->setContentType("text/html");

// Send the message
        $result = $mailer->send($message);

        return $result;
    }

}
