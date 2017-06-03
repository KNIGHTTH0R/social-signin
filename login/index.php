<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="819680576476-s5phonpej9rg25cso6ci5bpmnj3m80k9.apps.googleusercontent.com">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h1>Hellow World!</h1>

          <div class="g-signin2" data-onsuccess="onSignIn" data-width="300" data-height="40"
            data-theme="dark" data-longtitle="true"></div>

        </div
      </div>

      <div class="row">
        <div class="col-xs-12">
           <div class="fb-login-button" data-width="300" data-max-rows="1" data-size="large"
            data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false"
            data-use-continue-as="true" onlogin="checkLoginState();"></div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <br>
            <a href="#" id="sign-out">Sign out</a>
        </div>
      </div>
    </div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>

<script>
  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
    //FB.login(function(response) {
      console.log(response);
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        FB.api('/me', function(response) {
          console.log('Successful login for: ' + response.name);
        });
      } else {
        // The person is not logged into your app or we are unable to tell.
        console.log('Please log into this app.');
      }
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '211228196051665',
      cookie     : true,  // enable cookies to allow the server to access the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.9' // use graph api version 2.8
    });

    // Now that we've initialized the JavaScript SDK, we call
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.
    FB.getLoginStatus(function(response) {
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        FB.api('/me', function(response) {
          console.log('Initially logged in as: ' + response.name);
        });
      }
    });
  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

</script>


<script type="text/javascript">
function onSignIn(googleUser) {
  /*var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
  */

  var id_token = googleUser.getAuthResponse().id_token;
  console.log('Token: ' + id_token);

  post('/login/tokensignin.php', {idtoken : id_token}, "google-login", "_self", "post");
}

$('#sign-out').click(function(e){
  e.preventDefault();

  signOut();
});

function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
}

function post (path, params, formName, target, method) {
    method = method || "post"; // Set method to post by default if not specified.
    target = target || "_self";

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);
    form.setAttribute("name", formName);
    form.setAttribute("target", target);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}
</script>
