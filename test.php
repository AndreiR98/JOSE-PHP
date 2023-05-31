<?php
require_once(__DIR__.'/vendor/autoload.php');

use ECDSA\Algorithms;
use ECDSA\curves\Curves;
use JOSE\component\CurvesType;
use JOSE\component\AlgorithmTypes;
use JOSE\component\Header;
use JOSE\component\Payload;
use JOSE\component\ProtectedHeader;
use JOSE\GenericMessage;
use JOSE\JOSEmessageTraits;
use JOSE\Keys;
use ECDSA\points\ECpoint;
use JOSE\sign1\Sign1Message;

function GenerateId(
    int $length = 10,
    string $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'): string {
    if ($length < 1){
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;

    for($i = 0; $i < $length; $i++){
        $pieces[] = $keyspace[random_int(0, $max)];
    }

    return implode('', $pieces);
}


$pem = '-----BEGIN EC PRIVATE KEY-----
MHcCAQEEIAbBbDZcMA9iUs2MW3pMXy7/g3of9zCy7YBvarQMo2W7oAoGCCqGSM49
AwEHoUQDQgAEdwNmeCnpsK1SZde5ncQ9OwAq3XpAKx6+4Tlm7NkcTv1o1FmxxjdQ
2o3WEyEGiIm7lkRENwwqelFA361CeAdd7A==
-----END EC PRIVATE KEY-----';


$curve = Curves::NIST256p();
$algorithm = Algorithms::ES256();

$key = Keys::ECkey($curve, $algorithm);
$key->fromPemFormat($pem);

$protectedHeader = new ProtectedHeader("dddf674c", CurvesType::NIST256p, AlgorithmTypes::ES256);

$header = new Header($protectedHeader, []);
$add = 3600 * rand(1,23)+60*rand(1, 59)+rand(1, 59);
$at = ($add + time())*1000;
$payload = [
    'train'=>[
        'v'=>'IR7707',
        'at'=>(int)$at,
        'dt'=>time()*1000,
        'fl'=>(string)'Bucuresti',
        'tl'=>(string)'Pitesti',
    ],
    'ticket'=>[
        'id'=>GenerateId(12),
        'bt'=>time()*1000,
        'et'=>$at+3600,
        'cl'=>1,
        'c'=>4,
        's'=>44
    ],
    'person'=>[
        'fname'=>'Rotaru',
        'sname'=>'Andrei'
    ]
];

$message = new Sign1Message($header, new Payload($payload));

$message->setKey($key);
//
echo "<pre>";
//
////print_r(serialize($message));
$message->sign();
//
//
$encoded = new \JOSE\JOSEMessage($message->encode());

$publicKeyPem = '-----BEGIN PUBLIC KEY-----
MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEtEok4xNWhpu60cIWJlsibAkr9O3l
n3UIO8AGknGJWOfHhYQ5sDPidYT7j7VIxazOJp3By8fmvmZkRIsFVVXy0w==
-----END PUBLIC KEY-----';

$curve = Curves::NIST256p();
$algorithm = Algorithms::ES256();

$publicKey = Keys::ECkey($curve, $algorithm);
$publicKey->fromPemFormat($publicKeyPem);

$encoded->setKey($publicKey);



$encoded->decode();

print_r($encoded->getHeader()->getProtected()->getKID());





