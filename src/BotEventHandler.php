<?php


namespace InfoBot;

include __DIR__ . '/../vendor/autoload.php';

use \danog\MadelineProto\EventHandler;

class BotEventHandler extends EventHandler {

    public function onUpdateNewMessage ($update) {
      if(!isset($update['message']['message'])) {
        return;
      }
      if(!empty($update['message']['out'])) {
        return;
      }

      $this->logger($update);
    }
}
