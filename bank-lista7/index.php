<?php
if(!session_id()) {
session_start();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<title></title>
<script type="text/javascript">
        var auth2 = auth2 || {};

        (function () {
            var po = document.createElement('script');
            po.type = 'text/javascript';
            po.async = true;
            po.src = 'https://plus.google.com/js/client:plusone.js?onload=startApp';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(po, s);
        })();
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<meta charset="utf-8"/>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
<h1>Bank</h1>
<p>
To jest strona mojego banku.
</p>

<h3>Logowanie do konta:</h3>
<form method="post" action="login.php">
	<span>Indentyfikator: </span> <input type="text"     name="login"><br>
	<span>Hasło:     </span> <input  type="password" name="passwd"> <br>
	<div class="g-recaptcha" data-sitekey="6LebxhAUAAAAAF2vVqRrmHzobF8Tf-u-6qw7WiLN"></div>
	<input type="submit"  class="button" value="Zaloguj się">
</form>

<?php
require_once __DIR__ . '/vendor/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '515361855300868', // Replace {app-id} with your app id
  'app_secret' => '9fbc31409ea686345d21ab1985cc2beb',
  'default_graph_version' => 'v2.8',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://bank.com/bank/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';


?>

<div id="gConnect">
    <img id="customBtn" src="./signin_button.png" onClick="signInClick()"
         alt="Sign in with Google+"/>
</div>
<script type="text/javascript">
    var helper = (function () {
        var authResult = undefined;

        return {
            /**
             * Hides the sign-in button and connects the server-side app after
             * the user successfully signs in.
             *
             * @param {Object} authResult An Object which contains the access token and
             *   other authentication information.
             */
            onSignInCallback: function (authResult) {
                if (authResult['access_token']) {
                    // The user is signed in
                    this.authResult = authResult;

                    // After we load the Google+ API, render the profile data from Google+.

                    // After we load the profile, retrieve the list of activities visible
                    // to this app, server-side.
                } else if (authResult['error']) {
                    // There was an error, which means the user is not signed in.
                    // As an example, you can troubleshoot by writing to the console:
                    console.log('There was an error: ' + authResult['error']);
                }
                console.log('authResult', authResult);
            },
            /**
             * Calls the server endpoint to connect the app for the user. The client
             * sends the one-time authorization code to the server and the server
             * exchanges the code for its own tokens to use for offline API access.
             * For more information, see:
             *   https://developers.google.com/+/web/signin/server-side-flow
             */
            connectServer: function (code) {
                console.log(code);
                $.ajax({
                    type: 'POST',
                    url: $(location).attr('origin') + '/bank/gplus-quickstart-php/signin.php',
                    contentType: 'application/octet-stream; charset=utf-8',
                    success: function (result) {
                        console.log(result);
                        onSignInCallback(auth2.currentUser.get().getAuthResponse());
                        window.location.replace("http://bank.com/bank/logged.php")
                    },
                    processData: false,
                    data: code
                });
            }
        };
    })();

    /**
     * Perform jQuery initialization and check to ensure that you updated your
     * client ID.
     */
    $(document).ready(function () {
        if ($('[data-clientid="YOUR_CLIENT_ID"]').length > 0) {
            alert('This sample requires your OAuth credentials (client ID) ' +
                'from the Google APIs console:\n' +
                '    https://code.google.com/apis/console/#:access\n\n' +
                'Find and replace YOUR_CLIENT_ID with your client ID and ' +
                'YOUR_CLIENT_SECRET with your client secret in the project sources.'
            );
        }
	
        start();
    });

	function start(){
		if(typeof gapi !== 'undefined'){
			startApp();
		}else{
			setTimeout(start, 250);
		}
	}
	

    /**
     * Called after the Google client library has loaded.
     */
    function startApp() {
        gapi.load('auth2', function () {
            console.log('application started');
            // Retrieve the singleton for the GoogleAuth library and setup the client.
            gapi.auth2.init({
                client_id: '802922095882-4pfksb6e0g4aljh08c12jd694rn2dbod.apps.googleusercontent.com',
                cookiepolicy: 'single_host_origin',
                fetch_basic_profile: false,
                scope: 'https://www.googleapis.com/auth/plus.login'
            }).then(function () {
                console.log('init');
                auth2 = gapi.auth2.getAuthInstance();
            });
        });
    }

    /**
     * Either signs the user in or authorizes the back-end.
     */
    function signInClick() {
        auth2.grantOfflineAccess().then(
            function (result) {
                helper.connectServer(result.code);
            });
    }

    /**
     * Calls the helper method that handles the authentication flow.
     *
     * @param {Object} authResult An Object which contains the access token and
     *   other authentication information.
     */
    function onSignInCallback(authResult) {
        helper.onSignInCallback(authResult);
    }
</script>

<a href="http://bank.com/bank/passRemaind.php">Przepomnij hasło!</a>
</body>
</html>
