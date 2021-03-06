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

	public function __construct($phdr='', $uhdr='', $payload){
		$this->phdr = $phdr;
		$this->uhdr = $uhdr;
		$this->payload = $payload;
	}

	public function __toString(){
		

		if($this->signature == ''){
			return "".get_class($this).":{['".json_encode($this->phdr)."','".json_encode($this->payload)."']}";
		}else{
			$message = $this->encode();
			return "".get_class($this).":{['".json_encode($message[0])."','".$message[2]."','".$message[3]."']}";
		}
	}

	public function encoded(){
		$message = $this->encode();

		if($this->signature == ''){
			return "".get_class($this).":{['".json_encode($message[0])."','".$message[2]."']}";
		}else{
			return "".get_class($this).":{['".json_encode($message[0])."','".$message[2]."','".$message[3]."']}";
		}
	}

	public static function decode($encoded){
		$encoded = CBOREncoder::decode($encoded);
		try{
			if(isset($encoded[0])){
				if($encoded[0] == 'Sign1Message'){
					$message = new Sign1Message($encoded[1][0], $encoded[1][0], $encoded[2]);

					$message->signature = $encoded[3];
				}
			}
			return $message;
		}catch(Exception $e){
			die('Malformed message!');
		}	
	}
}

?>