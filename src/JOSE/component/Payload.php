<?php



namespace JOSE\component;

class Payload
{
    private Mixed $payload;

    function __construct(Mixed $payload)
    {
        $this->payload = $payload;
    }

    public function getPayload() {
        return $this->payload;
    }
}