<?php


namespace JOSE;

use \ECDSA\ECDSA;
use \CBOR\CBOREncoder;
use \JOSE\Keys;
use \ECDSA\Math;

Class JOSEmessage{

	public $phdr;

	public $uhdr;

	public $payload;

	public $signature;

	public function __construct($phdr='', $uhdr='', $payload){
		$this->phdr = $phdr;
		$this->uhdr = $uhdr;
		$this->payload = $payload;
	}

	public function encoded(){
		$message = $this->encode();

		if($this->signature == ''){
			return "".get_class($this).":{['".json_encode($message[0])."','".$message[2]."']}";
		}else{
			return "".get_class($this).":{['".json_encode($message[0])."','".$message[2]."','".$message[3]."']}";
		}
	}
}

?>