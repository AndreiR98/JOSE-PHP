<?php

namespace JOSE;

use ECDSA\Signature;
use JOSE\component\Header;
use JOSE\component\Payload;

interface Message {
    public function getHeader() : Header;

    public function getPayload() : Payload;

    public function getSignature() : Signature;

    public function sign() : void;

    public function encode() : Mixed;

    public function decode(): GenericMessage;
}