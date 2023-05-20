<?php

namespace JOSE\component;

use ECDSA\curves\Curves;

enum CurvesType
{
    case NIST256p;

    public static function getByName(String $name) : CurvesType {
        return match ($name) {
            self::NIST256p->name => CurvesType::NIST256p,
            default => throw new \Exception('Unexpected match value'),
        };
    }
}
