<?php

require_once __DIR__.'/../vendor/autoload.php';

use \SE\Component\Pilight;

$device = new Pilight\Device('elro', array(
    's' => 31,
    'u' => 1,
));

$sender = new Pilight\Sender();
$sender->setSudo(true);

$device->addArgument('t');
$sender->send($device);

$device->addArgument('f');
$sender->send($device);