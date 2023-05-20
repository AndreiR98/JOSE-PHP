<?php

namespace JOSE;

use ECDSA\Algorithms;
use ECDSA\curves\Curves;
use ECDSA\Math;
use ECDSA\ECDSA;
use JOSE\keys\ECKey;

class Keys {

    public static function ECKey(Curves $curves, Algorithms $algorithm) : ECkey {
        return new ECKey($curves, $algorithm);
    }
}