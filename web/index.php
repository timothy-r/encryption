<?php

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application(); 

$pub_key_file = __DIR__.'/../config/mykey.pub';
$priv_key_file = __DIR__.'/../config/mykey.pem';

$app->post('/encrypt', function(Request $request) use($app, $pub_key_file) {
    $key_text = file_get_contents($pub_key_file);
    $string = $request->get('string');
    openssl_public_encrypt($string, $crypt_text, $key_text);
    return $app->json(['encrypted' => base64_encode($crypt_text), 'plain_text' => $string]); 
});

$app->post('/decrypt', function(Request $request) use($app, $priv_key_file) { 
    $key_text = file_get_contents($priv_key_file);
    $private_key = openssl_get_privatekey($key_text);
    $string = $request->get('string');
    openssl_private_decrypt(base64_decode($string), $decrypted, $private_key);
    return $app->json(['plain_text' => $decrypted, 'encrypted' => $string]);
});

$app->run();


