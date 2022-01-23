<?php
require_once(__DIR__.'/vendor/autoload.php');

use JOSE\JOSEmessage;
use \ECDSA\Curves;
use \ECDSA\Algorithms;
use \JOSE\Sign1Message;
use \JOSE\Keys;



$algorithm = Algorithms::ES256();
$curve = Curves::NIST256p();

$phdr = ['Algorithm'=>'Es256', 'KID'=>'d51dabbd92ce6670'];
$uhdr = ['Algorithm'=>'Es256', 'KID'=>'d51dabbd92ce6670'];

$payload = [
	'train'=>[
		'v'=>'IR-1781',
		'at'=>1647381540,
		'dt'=>1647359940,
		'fl'=>'BU',
		'tl'=>'PT'
	],
	'ticket'=>[
		'id'=>'J7I610EQ4D8',
		'bt'=>1642815622,
		'et'=>1647385140,
		't'=>1,
		'cl'=>1,
		'c'=>2,
		's'=>19
	],
	'p'=>[
		'lname'=>'JON',
		'sname'=>'DOE'
	]
];

$pem = '-----BEGIN EC PRIVATE KEY-----
MHcCAQEEIEHh7c1PWmCz8Tg6+/j/aglRrUpEXD63ehnw6CpPB8KyoAoGCCqGSM49
AwEHoUQDQgAEpLBrrfV4rovv/4ZZxvjvJ1AFuwYisWdrqhCfVug+D9HJSlC4iiAO
wijqvVShK79hiqea+r8p0vP5g6mtaZARrA==
-----END EC PRIVATE KEY-----';

$test = new Sign1Message($phdr, '', $payload);
$JOSE_Key = new Keys($pem, 'd51dabbd92ce6670', $curve);

$test->key = $JOSE_Key;

$test->KID = $JOSE_Key->KID;
$test->curve = $curve;
$test->algorithm = $algorithm;
$test->encode();


echo base64_encode($test->encode());

