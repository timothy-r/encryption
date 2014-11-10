<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application(); 

$pub_key_file = 'file:'.__DIR__.'/../config/mykey.pub';
$priv_key_file = 'file:'.__DIR__.'/../config/mykey.pem';

$app->get('/encrypt/{string}', function() use($app, $string, $pub_key_file) {
    openssl_public_encrypt($string, $crypttext, $pub_key_file);
    return base64_encode($crypttext); 
});

$app->get('/decrypt/{string}', function() use($app, $string, $priv_key_file) { 
    //$key_text = file_get_contents($key_file);
    //$private_key = openssl_get_privatekey($key_text);
    openssl_private_decrypt(base64_decode($string), $decrypted, $priv_key_file);
    return $decrypted;
});

$app->run();


