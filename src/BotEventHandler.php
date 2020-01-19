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
      $msgParts = explode(" ", $update['message']['message']);

      switch($msgParts[0]) {
        case '/id':
          yield $this->messages->sendMessage(['peer' => $update['message']['from_id'], 'message' => "Your id is: {$update['message']['from_id']}"  ]);
        break;

        case '/channelid':
          if(!isset($msgParts[1])) {
            yield $this->messages->sendMessage(['peer' => $update['message']['from_id'], 'message' => "You must specify channel @id or link as in ```/channelid https://t.me/channel_name_goes_here```"]);
              return;
          }
          try{
            $details = yield $this->getPwrChat($msgParts[1]);
            yield $this->messages->sendMessage(['peer' => $update['message']['from_id'], 'message' => "Type: {$details['type']}\n ID: {$details['id']}"]);
          } catch(\Exception $e) {
            yield $this->messages->sendMessage(['peer' => $update['message']['from_id'], 'message' => "Oh no! An error occurred."]);
            $this->logger($e);
          }
        break;

      }
    }
}
