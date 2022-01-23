<?php
namespace JOSE;

use \ECDSA\ECDSA;
use \CBOR\CBOREncoder;
use \ECDSA\Math;

Class Sign1Message extends JOSEmessage{

    public $phdr;

    public $uhdr;

    public $KID;

    public $payload;

    public $algorithm;

    public $curve;

	public function __construct($phdr='', $uhdr='', $payload){
		$this->phdr = $phdr;
		$this->uhdr = $uhdr;
		$this->payload = $payload;
	}

	public function Sign(){
		if($this->phdr == ''){
			$header = '';

			$structure = json_encode($this->payload);
		}else{
			$header = $this->phdr;

			$structure = json_encode([$header, $this->payload]);
		}

		$curve = $this->curve;
		$algorithm = $this->algorithm;

		$computedSignature = '';

		try{
			$computedSignature = ECDSA::Sign($structure, $curve, $algorithm, $this->key->d);
		}catch(Exception $e){
			die('Error occured while signing!');
		}

		return $this->signature = $computedSignature;
	}

	public function encode(){
		$this->Sign();

		$headers = $this->phdr;

		$payload = \CBOR\CBOREncoder::encode($this->payload);

		$KID = Math::unhexlify($this->KID);

		if($this->signature == ''){
			return [$headers, $KID, $payload];
		}else{

			$signature = \CBOR\CBOREncoder::encode($this->signature);

			return [$headers, $KID, $payload, $signature];
		}
	}

	public function decode(){
		return $this->phdr;
	}
}
?>