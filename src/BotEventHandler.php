<?php


namespace InfoBot;

include __DIR__ . '/../vendor/autoload.php';

use \danog\MadelineProto\EventHandler;

class BotEventHandler extends EventHandler {

    public static $ADMIN = getenv("ADMIN_ID") ?? null; 

    public function onStart(){
	    if (self::$ADMIN) {
		    $this->messages->sendMessage(
		    peer: self::$ADMIN,
		    message: "Bot started"
		    );
	    }
	    else {
		    echo "Bot started";
	    }
		
    }

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

        case '/idof':
          if(!isset($msgParts[1])) {
            yield $this->messages->sendMessage(['peer' => $update['message']['from_id'], 'parse_mode' =>  'MarkdownV2' , 'message' => "You must specify an @id or `https://t.me/link`"]);
              return;
          }
          try{
            $details = yield $this->getPwrChat($msgParts[1], false);
            yield $this->messages->sendMessage(['peer' => $update['message']['from_id'], 'message' => "Type: {$details['type']}\n ID: {$details['id']}"]);
          } catch(\Exception $e) {
            yield $this->messages->sendMessage(['peer' => $update['message']['from_id'], 'message' => "Oh no! An error occurred."]);
            $this->logger($e);
          }
        break;

        case '/help':
            yield $this->messages->sendMessage(['peer' => $update['message']['from_id'], 'message' => 'Use bot commands to get id for the current user or other types of peers (channels, groups, etc.)']);
            break;


        default:
           yield $this->messages->sendMessage(['peer' => $update['message']['from_id'], 'message' => "Could not understand you. Please use one of the bot commands."]);
           break;
      }
    }
}
