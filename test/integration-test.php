<?php
require_once __DIR__.'/../vendor/autoload.php';

use GuzzleHttp\Client;

$server = $argv[1];
$string = 'my text to encrypt';

$encrypt_endpoint = sprintf('%s/encrypt', $server);
echo "$encrypt_endpoint\n";
$decrypt_endpoint = sprintf('%s/decrypt', $server);
echo "$decrypt_endpoint\n";

$client = new Client();
$response = $client->post($encrypt_endpoint, ['body' => ['string' => $string]]);

$encrypted_data = $response->json();
var_dump($encrypted_data);

$response = $client->post($decrypt_endpoint, ['body' => ['string' => $encrypted_data['encrypted']]]);

$decrypted_data = $response->json();

var_dump($decrypted_data);

if ($string === $decrypted_data['plain_text']){
    print "Success\n";
} else {
    print "Failure\n";
}
