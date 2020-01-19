<?php

namespace App\Controller;

//require __DIR__ . '/vendor/autoload.php';


class SendMailer extends Swift_Mailer
{

    public function testfonction()
    {
        // Create the Transport
        $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 2525))
            ->setUsername('caa22725bc661f')
            ->setPassword('a2f2923eb65310');

// Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

// Create a message
        $message = (new Swift_Message('Wonderful Subject'))
            ->setFrom(['john@doe.com' => 'John Doe'])
            ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
            ->setBody('test');

// Send the message
        $result = $mailer->send($message);
    }

}
