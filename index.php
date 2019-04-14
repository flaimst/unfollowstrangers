<?php
session_start();

include('vendor/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY','');
define('CONSUMER_SECRET','');

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

$request_token = $connection->oauth('oauth/request_token');

$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

header("location:$url");





