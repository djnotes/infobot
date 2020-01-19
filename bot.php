<?php


include __DIR__ . '/vendor/autoload.php';

use \danog\MadelineProto\API;


$api = new API(__DIR__ . '/session.madeline');

$api->async(true);

$api->loop(function() use ($api) {
  yield $api->start();
  yield $api->setEventHandler('InfoBot\BotEventHandler');
});

$api->loop();
