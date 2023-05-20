<?php


namespace JOSE;

use CBOR\CBOREncoder;
use ECDSA\Math;

use ECDSA\Signature;
use JOSE\component\AlgorithmTypes;
use JOSE\component\CurvesType;
use JOSE\component\Header;
use JOSE\component\Payload;
use JOSE\component\ProtectedHeader;
use JOSE\sign1\Sign1Message;
use stdClass;

trait JOSEmessageTraits {
    public function encoding(): Mixed
    {
        //print_r();
        return CBOREncoder::encode($this->jsonSerialize());
    }

    public function decoding(): Mixed {
        $decoded = CBOREncoder::decode($this->message);

        $header = $decoded['header']['protected'];
        $payload = $decoded['payload'];
        $signature = $decoded['signature'];

        $this->header = new Header(new ProtectedHeader($header['kID'], CurvesType::getByName($header['curve']), AlgorithmTypes::getByName($header['algorithm'])), $decoded['header']['unprotected']);
        $this->payload = new Payload($payload);
        $this->signature = new Signature(gmp_init(Math::hexlify($signature['r']), 16), gmp_init(Math::hexlify($signature['s']), 16));


        return $decoded;
    }
}
?>