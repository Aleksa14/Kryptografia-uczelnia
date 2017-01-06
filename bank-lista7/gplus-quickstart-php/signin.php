<?php
/*
 * Sample application for Google+ client to server authentication.
 * Remember to fill in the OAuth 2.0 client id and client secret,
 * which can be obtained from the Google Developer Console at
 * https://code.google.com/apis/console
 *
 * Copyright 2013 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * Note (Gerwin Sturm):
 * Include path is still necessary despite autoloading because of the require_once in the libary
 * Client library should be fixed to have correct relative paths
 * e.g. require_once '../Google/Model.php'; instead of require_once 'Google/Model.php';
 */
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/vendor/google/apiclient/src');

require_once __DIR__ . '/vendor/autoload.php';

require_once("databaseConnection.php");

	$db = myDb();

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Simple server to demonstrate how to use Google+ Sign-In and make a request
 * via your own server.
 *
 * @author silvano@google.com (Silvano Luciani)
 */

/**
 * Replace this with the client ID you got from the Google APIs console.
 */
const CLIENT_ID = '802922095882-4pfksb6e0g4aljh08c12jd694rn2dbod.apps.googleusercontent.com';

/**
 * Replace this with the client secret you got from the Google APIs console.
 */
const CLIENT_SECRET = 'DIn7L-Ag2foK7ln4hEuRg-l8';

/**
 * Optionally replace this with your application's name.
 */
const APPLICATION_NAME = "Google+ PHP Quickstart";

$client = new Google_Client();
$client->setApplicationName(APPLICATION_NAME);
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri('postmessage');

$plus = new Google_Service_Plus($client);

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__,
));
$app->register(new Silex\Provider\SessionServiceProvider());

// Upgrade given auth code to token, and store it in the session.
// POST body of request should be the authorization code.
// Example URI: /connect?state=...&gplus_id=...
$app->post('/', function (Request $request) use ($app, $client, $db) {

    // Normally the state would be a one-time use token, however in our
    // simple case, we want a user to be able to connect and disconnect
    // without reloading the page.  Thus, for demonstration, we don't
    // implement this best practice.
    //$app['session']->set('state', '');

    $code = $request->getContent();
    // Exchange the OAuth 2.0 authorization code for user credentials.
    $client->authenticate($code);
    $token = json_decode($client->getAccessToken());

    // You can read the Google user ID in the ID token.
    // "sub" represents the ID token subscriber which in our case
    // is the user ID. This sample does not use the user ID.
    $attributes = $client->verifyIdToken($token->id_token, CLIENT_ID)
        ->getAttributes();
    $gplus_id = $attributes["payload"]["sub"];



	$row = myDbSelect($db, "SELECT login, rachunek FROM users WHERE guser_id = '$gplus_id'");

	setcookie("login", $row[0]['login'], time()+10*60, "/");
	setcookie("nr_rachunku", $row[0]['rachunek'], time()+10*60, "/");
  

    // Store the token in the session for later use.
    $app['session']->set('token', json_encode($token));
    $response = 'Successfully connected with token: ' . print_r($token, true);
    return new Response($response, 200);
});

// Revoke current user's token and reset their session.
$app->post('/disconnect', function () use ($app, $client) {
    $token = json_decode($app['session']->get('token'))->access_token;
    $client->revokeToken($token);
    // Remove the credentials from the user's session.
    $app['session']->set('token', '');
    return new Response('Successfully disconnected', 200);
});

$app->run();
