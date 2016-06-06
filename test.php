<?php
// Autoloader inclusion
require_once 'vendor/autoload.php';

$mailer = sfContext::getInstance()->getMailer();
$mailer->composeAndSend(
  'harkatamir@gmail.com',
  'daigo-a@hotmail.com',
  'Subject',
  'Body'
);