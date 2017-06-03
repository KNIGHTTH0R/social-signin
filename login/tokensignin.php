<?php

require_once '../lib/google-api-php-client/vendor/autoload.php';

// Get $id_token via HTTPS POST.

$id_token = $_POST['idtoken'];
if(empty($id_token)) die("invalid tolen id");
echo $id_token;

try {
  $client = new Google_Client(['client_id' => '819680576476-s5phonpej9rg25cso6ci5bpmnj3m80k9.apps.googleusercontent.com']);
  //$client = new Google_Client(['client_id' => 'lThe60sLueJNAQCVDFyuRb6u']);
  $payload = $client->verifyIdToken($id_token);
  if ($payload) {
    $userid = $payload['sub'];

    echo "<pre>".print_r($payload, ture)."</pre>";
  } else {
    echo "// Invalid ID token";
  }
}
catch(Exception $e){
  print_r($e);
}


 ?>
