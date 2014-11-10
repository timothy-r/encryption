<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application(); 

$pub_key_file = __DIR__.'/../config/mykey.pub';
$priv_key_file = __DIR__.'/../config/mykey.pem';

$app->get('/encrypt/{string}', function($string) use($app, $pub_key_file) {
    $key_text = file_get_contents($pub_key_file);
    openssl_public_encrypt($string, $crypt_text, $key_text);
    return $app->json(['encrypted' => base64_encode($crypt_text)]); 
});

$app->get('/decrypt/{string}', function($string) use($app, $priv_key_file) { 
    $key_text = file_get_contents($priv_key_file);
    $private_key = openssl_get_privatekey($key_text);
    openssl_private_decrypt(base64_decode($string), $decrypted, $private_key);
    return $app->json(['plain_text' => $decrypted]);
});

$app->run();


