<?php
session_start();

include('vendor/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY','');
define('CONSUMER_SECRET','');
$lang = 'tr';

$access_token = $_SESSION['access_token'];

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

$cursors = array();

function destroyStrangerFriends($cursor = -1){	
	global $connection;
	global $cursors;

	$friends = $connection->get('friends/list',['count'=>200,'cursor'=>$cursor]);
	if($friends->errors[0]->message == 'Rate limit exceeded'){
		echo 'Wait 15 minutes.';
		return;
	}
	foreach ($friends->users as $friend) {
		if($friend->lang != $lang && $friend->status->lang != $lang){
				$connection->post('friendships/destroy', ['user_id'=>$friend->id]);
		}else{
			echo $friend->name.'-'.$friend->status->lang.'<br>';
		}
	}
	if(!in_array($friends->next_cursor, $cursors)){
		$cursors[] = $friends->next_cursor;
		sleep(60);
		destroyStrangerFriends($friends->next_cursor);
	}
}

destroyStrangerFriends();




