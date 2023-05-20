<?php

namespace JOSE;

use CBOR\CBOREncoder;
use ECDSA\Algorithms;
use ECDSA\curves\Curves;
use ECDSA\ECDSA;
use ECDSA\Math;
use ECDSA\Signature;
use JOSE\component\AlgorithmTypes;
use JOSE\component\CurvesType;
use JOSE\component\Header;
use JOSE\component\Payload;
use JOSE\component\ProtectedHeader;
use JOSE\keys\ECKey;

class JOSEMessage extends GenericMessage implements Message
{
    use JOSEmessageTraits;

    private Header $header;

    private Payload $payload;

    private Signature $signature;

    private ECKey $key;

    private String $message;

    public function __construct(String $message) {
        $this->message = $message;
    }

    public function setKey(ECKey $key) : void {
        $this->key = $key;
    }

    public function getHeader(): Header
    {
        return $this->header;
    }

    public function getPayload(): Payload
    {
        return $this->payload;
    }

    public function getSignature(): Signature
    {
        return $this->signature;
    }

    public function sign(): void
    {
        // TODO: Implement sign() method.
    }

    public function verifySign() : bool {
        $header = pack("H*", bin2hex(serialize($this->getHeader()->getProtected())));
        $payload = pack("H*", bin2hex(serialize($this->getPayload()->getPayload())));

        if($this->key != null) {
            //Prepare the hash digest
            $toDigest = $header.$payload;

            return ECDSA::Verify($toDigest, $this->getSignature(), $this->key);
        }
        return false;
    }

    public function encode(): Mixed
    {
        return $this->encoding();
    }

    public function decode(): GenericMessage
    {
        $data = $this->decoding();

        $type = $data['type'];
        $headerRaw = $data['header'];
        $payloadRaw = $data['payload'];
        $signatureRaw = $data['signature'];

        return MessageType::getEmptyMessage($type, $headerRaw, $payloadRaw, $signatureRaw);
    }
}