# JOSE-PHP
 JSON Object Signing and Ecryption
 
 You need ECDSA-PHP for this library to work.
 
 For now you only have one option and it's 'Sign1Message', Sign1Messages are used when there is a single signature attached to the structure, consisting of headers and payload, Receivers must know the public key to verify the message.
 
 The basic structure of Sign1Message:
 ['Sign1Message', {phdr}, {uhdr}, {payload}, {signature}]
 
 phdr = Protected header, this field contains informations that needs to be protected.This information is taken into account during signing.
 uhdr = Unprotected header, this field contains information that DO NOT needs to be protected therefor is not taken in consideration while signing.
 Payload = Contains the main message body taken in consideration while signing
 Signature = (r, s) paire signature
 
Examples:

Signing message:
<?php
require(__DIR__.'/vendor/autoload.php');

use \ECDSA\Curves;
use \ECDSA\Algorithms;
use \JOSE\JOSEmessage;
use \JOSE\Sign1Message;
use \JOSE\Keys;


//Set information for protected header
$phdr = 'JON DOE';
$uhdr = '';

//Set the paylaod
$payload = 'This is a test';

$pem = 'PRIVATE EC KEY HERE';

//Set params
$curve = Curves::NIST256P();
$algo = Algorithms::ES256();

//Set the Key ID
$KID = '';

$key = new Keys($pem, $KID, $curve, $algo);

$message = new Sign1Message($phdr, $uhdr, $payload);

//Assign the key to the message
$message->key = $key;

//Encode the message
$message->encode();
?>
