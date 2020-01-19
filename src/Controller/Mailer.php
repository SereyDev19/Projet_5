<?php


function sendMailerTest($email, $access_token)
{

    $content = '<a href="http://projet_5_test.test/admin.php?action=click2validate&token=' . $access_token . '">' . $access_token . '</a>';
    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 2525))
        ->setUsername('caa22725bc661f')
        ->setPassword('a2f2923eb65310');

    /*
    You could alternatively use a different transport such as Sendmail:

    // Sendmail
    $transport = new Swift_SendmailTransport('/usr/sbin/sendmail -bs');
    */

// Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

// Create a message
    $message = (new Swift_Message('Confirm your inscription'))
        ->setFrom(['john@doe.com' => 'John Doe'])
        ->setTo([$email => 'A name'])
        ->setBody($content);
// HTML Content
    $message->setContentType("text/html");

// Send the message
    $result = $mailer->send($message);
}
