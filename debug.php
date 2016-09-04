<?php

/*
 * > cp ./.debug-credentials.example ./.debug-credentials
 * > php -S localhost:8001
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function dd(...$params){call_user_func('dump', $params); die;}

require './vendor/autoload.php';

$credentials = json_decode(file_get_contents('./.debug-credentials'));
$vk = $credentials->vk;
$accessToken = $credentials->vk->access_token;

$driver = new \ContactsGrabber\Driver\Vkontakte($vk->client_id, $vk->client_secret, $vk->redirect_url);

if (!isset($_GET['code']) && is_null($accessToken)) {
    $authUrl = $driver->getAuthorizationRequestUrl();
    echo "<a href='{$authUrl}'>{$authUrl}</a>";
    die;
}

if (is_null($accessToken)) {
    $code = $_GET['code'];
    $accessToken = $driver->fetchAccessToken($code);
}

$driver->setAccessToken($accessToken);

dump($accessToken);

$grabber = new \ContactsGrabber\Grabber($driver);
$contacts = $grabber->fetchContacts();

dd($contacts);