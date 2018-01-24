<?php

// example: https://github.com/onlinetuts/line-bot-api/blob/master/php/example/chapter-01.php

include ('line-bot-api/php/line-bot.php');

$channelSecret = 'a1e4e88d6473b48c6d2692042a98c15e
';
$access_token  = '8bTVBFQXcYpHylZhuRZqtHLEKZeMJmtruPYAjCyNQ4xreHNMfTyJ+5jIscH5HlmUm4SdFCezBQjddXs1EgjLXmCJgBorihv3bfwUxW8zMCqtc4heMF4AZu2Ms1I+RNMw1cghN00LnBGnmdbZ76NAEgdB04t89/1O/w1cDnyilFU=';

$bot = new BOT_API($channelSecret, $access_token);
	
if (!empty($bot->isEvents)) {
		
	$bot->replyMessageNew($bot->replyToken, json_encode($bot->message));

	if ($bot->isSuccess()) {
		echo 'Succeeded!';
		exit();
	}

	// Failed
	echo $bot->response->getHTTPStatus . ' ' . $bot->response->getRawBody(); 
	exit();

}
