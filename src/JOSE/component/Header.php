<?php

namespace JOSE\component;

use ECDSA\Algorithms;

class Header{
    private ProtectedHeader $protected;
    private Array $unprotected;

    function __construct(ProtectedHeader $protected, $unprotected) {
        $this->protected = $protected;
        $this->unprotected = $unprotected;
    }

    public function getProtected() : ProtectedHeader {
        return $this->protected;
    }

    public function getUnprotected() : Array {
        return $this->unprotected;
    }
}