<?php

namespace JOSE;

use ECDSA\Signature;
use JOSE\component\Header;
use JOSE\component\Payload;
use JOSE\keys\ECKey;

class GenericMessage
{
    use JOSEmessageTraits;

    private Header $header;

    private Payload $payload;

    private Signature $signature;

    private ECKey $key;

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
}