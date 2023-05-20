# JOSE(JSON Object Signing and Ecryption)

JOSE is analogue to COSE(CBOR Object Signing and Encryption)


[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

## Introduction
For now you only have one option and it's 'Sign1Message', Sign1Messages are used when there is a single signature attached to the structure, consisting of headers and payload, Receivers must know the public key to verify the message.
 
 The basic structure of Sign1Message:
 ['Sign1Message', {phdr}, {uhdr}, {payload}, {signature}]
 
 phdr = Protected header, this field contains informations that needs to be protected.This information is taken into account during signing.
 uhdr = Unprotected header, this field contains information that DO NOT needs to be protected therefor is not taken in consideration while signing.
 Payload = Contains the main message body taken in consideration while signing
 Signature = (r, s) paire signature
 
 ## Install

Install with [composer](https://getcomposer.org/).

``` bash
$ composer require randrei98/josephp
```

## Signing and encoding


``` php
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
$encoded = $message->encode();

var_dump($encoded);
```

## Decoding and Signature verification

```php
use ECDSA\Algorithms;use JOSE\JOSEmessageTraits;use JOSE\Keys;

$curve = Curves::NIST256P();
$algo = Algorithms::ES256();

$publicKey_pem = 'PUBLIC EC KEY HERE';

$key = $key = new Keys($pem, '', $curve, $algo);

$decoded = JOSEmessageTraits::decode($encoded);
$decoded->key = $key;

var_dump($decoded->Verify_Signature());

```
