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

enum MessageType{
    case SIGN1;
    case SIGNS;

    case ENCRYPT;

    public static function getEmptyMessage(String $type, Array $header, Mixed $payload, Array $signatureRaw) : GenericMessage {
        //prepare the header
        $header = new Header(new ProtectedHeader($header['protected']['kID'], CurvesType::getByName($header['protected']['curve']), AlgorithmTypes::getByName($header['protected']['algorithm'])), $header['unprotected']);

        //prepare the signature
        $signature = new Signature(gmp_init(Math::hexlify($signatureRaw['r']), 16), gmp_init(Math::hexlify($signatureRaw['s']), 16));

        return match ($type) {
            self::SIGN1->name => self::structureMessage($header, new Payload($payload), $signature),
            default => throw new \Exception('Unexpected match value'),
        };
    }

    private static function structureMessage(Header $header, Payload $payload, Signature $signature) : Sign1Message {
        $message = new Sign1Message($header, $payload);
        $message->setSignature($signature);

        return $message;
    }
}
