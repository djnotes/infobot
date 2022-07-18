<?php


include __DIR__ . '/vendor/autoload.php';

use \danog\MadelineProto\API;
use \danog\MadelineProto\Settings;


//Check for environment variables

$apiId= getenv("API_ID");
$apiHash = getenv("API_HASH");
$botToken = getenv("BOT_TOKEN");
$admin = getenv("ADMIN");

if ( ! $apiId || ! $apiHash || ! $botToken || ! $admin ) {
	echo "Required environment variables are not provided. Exiting...\n";

	exit(1);
}




$settings = new Settings;
$settings ->setAppInfo(
		(new Settings\AppInfo)
    		->setApiId($apiId)
		->setApiHash($apiHash)
	);


$api = new API(__DIR__ . '/session.madeline', $settings);
$api->botLogin($botToken);

$api->async(true);

$api->loop(function() use ($api) {
  yield $api->start();
  yield $api->setEventHandler('InfoBot\BotEventHandler');
});

$api->loop();
