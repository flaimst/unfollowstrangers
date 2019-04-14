<?php 
session_start();

include('vendor/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY','');
define('CONSUMER_SECRET','');

$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
    die('ERROR!');
}

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);

$access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);

$_SESSION['access_token'] = $access_token;

header('location:profile.php');