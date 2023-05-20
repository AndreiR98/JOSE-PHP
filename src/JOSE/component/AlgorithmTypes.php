<?php

namespace JOSE\component;

enum AlgorithmTypes
{
    case ES256;

    public static function getByName(String $name) : AlgorithmTypes {
        return match ($name) {
            self::ES256->name => AlgorithmTypes::ES256,
            default => throw new \Exception('Unexpected match value'),
        };
    }
}
