<?php
require __DIR__ . '/vendor/autoload.php';
//
//use Swift_Mailer;
//use Swift_Message;
//use Swift_SmtpTransport;

$content = 'Bonjour ceci est un test de mail';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.ionos.fr', 587, 'tls'))
    ->setUsername('support@sc19dev.fr')
    ->setPassword('FTDNP9sXf3mZqs8H!');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create email
$email = 'serey.chhim@gmail.com';

// Create a message
$message = (new Swift_Message('Confirm your inscription'))
    ->setFrom(['support@sc19dev.fr' => 'Report Me Regisration'])
    ->setTo([$email => 'Client'])
    ->setBody($content);

// HTML Content
$message->setContentType("text/html");

// Send the message
$result = $mailer->send($message);