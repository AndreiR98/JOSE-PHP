<?php
namespace JOSE\sign1;

use CBOR\CBOREncoder;
use ECDSA\curves\Curves;
use ECDSA\ECDSA;
use ECDSA\Math;
use ECDSA\Signature;
use JOSE\component\Header;
use JOSE\component\Payload;
use JOSE\GenericMessage;
use JOSE\JOSEmessageTraits;
use JOSE\keys\ECKey;
use JOSE\MessageType;
use JsonSerializable;

Class Sign1Message extends GenericMessage {

    private Header $header;

    private Payload $payload;

    private Signature $signature;

    private ECKey $key;

    function __construct(Header $header, Payload $payload){
        $this->header = $header;
        $this->payload = $payload;
    }

    public function getMessageType() : MessageType {
        return MessageType::SIGN1;
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

    /**
     * @param Signature $signature
     */
    public function setSignature(Signature $signature): void
    {
        $this->signature = $signature;
    }

    public function setKey(ECKey $key) : void {
        $this->key = $key;
    }

    public function sign(): void
    {
        if($this->key != null) {
            //Prepare the hash digest
            $toDigest = pack("H*", bin2hex(serialize($this->getHeader()->getProtected()))) .pack("H*", bin2hex(serialize($this->getPayload()->getPayload())));

            $signature = ECDSA::Sign($toDigest, $this->key);

            if(ECDSA::Verify($toDigest, $signature, $this->key)){
                $this->signature = $signature;
            }
        }
    }

    public function encode(): Mixed
    {
        return $this->encoding();
    }

    public function jsonSerialize(): Mixed
    {
        return [
            'type'=>$this->getMessageType()->name,
            'header'=>[
                'protected'=>[
                    'kID'=>$this->header->getProtected()->getKID(),
                    'curve'=>$this->header->getProtected()->getCurve(),
                    'algorithm'=>$this->header->getProtected()->getAlgorithm()
                ],
                'unprotected'=>$this->header->getUnprotected()
            ],
            'payload'=>$this->payload->getPayload(),
            'signature'=>[
                'r'=>gmp_export($this->signature->getR()),
                's'=>gmp_export($this->signature->getS())
            ]
        ];
    }
}
?>