<?php

namespace JOSE\component;

use ECDSA\Algorithms;
use ECDSA\curves\Curves;

class ProtectedHeader{
    private String $kID;

    private AlgorithmTypes $algorithm;

    private CurvesType $curve;

    function __construct(String $kid, CurvesType $curve, AlgorithmTypes $algorithm) {
        $this->kID = $kid;
        $this->curve = $curve;
        $this->algorithm = $algorithm;
    }

    /**
     * @return Algorithms
     */
    public function getAlgorithm(): String
    {
        return $this->algorithm->name;
    }

    /**
     * @return Curves
     */
    public function getCurve(): String
    {
        return $this->curve->name;
    }

    /**
     * @return String
     */
    public function getKID(): string
    {
        return $this->kID;
    }

    public function __toString() : String {
        return "{".$this->kID.", ".$this->curve->name.", ".$this->algorithm->name."}";
    }
}