<?php
require_once(__DIR__.'/vendor/autoload.php');

use JOSE\JOSEmessage;
use \ECDSA\Curves;
use \ECDSA\Algorithms;
use \JOSE\Sign1Message;
use \JOSE\Keys;



$algorithm = Algorithms::ES256();
$curve = Curves::NIST256p();

$pem = '-----BEGIN EC PRIVATE KEY-----
MHcCAQEEIEHh7c1PWmCz8Tg6+/j/aglRrUpEXD63ehnw6CpPB8KyoAoGCCqGSM49
AwEHoUQDQgAEpLBrrfV4rovv/4ZZxvjvJ1AFuwYisWdrqhCfVug+D9HJSlC4iiAO
wijqvVShK79hiqea+r8p0vP5g6mtaZARrA==
-----END EC PRIVATE KEY-----';

$JOSE_Key = new Keys($pem, 'd51dabbd92ce6670', $curve, $algorithm);

echo $JOSE_Key;



