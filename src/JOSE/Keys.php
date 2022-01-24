<?php
namespace JOSE;

use ECDSA\Math;
use ECDSA\ECDSA;

class Keys{

	public $d;

	public $x;

	public $y;

	public $KID;

	public $curve;

	public function __construct($pem='', $KID='', $curve, $algorithm){
		if(openssl_pkey_get_private($pem)){
			$res = openssl_pkey_get_private($pem);
			$key_res = openssl_pkey_get_details($res)['ec'];
            
            $this->d = $key_res['d'];
			$this->x = $key_res['x'];
			$this->y = $key_res['y'];
		}else{
			$res = openssl_pkey_get_public($pem);
			$key_res = openssl_pkey_get_details($res)['ec'];

            $this->d = '';
			$this->x = $key_res['x'];
			$this->y = $key_res['y'];
		}

		$this->KID = $KID;
		$this->curve = $curve;
		$this->algorithm = $algorithm;
	}

	public function __toString(){
		return "'".get_class($this)."':{'".$this->KID."', '".$this->curve->name."', '".$this->algorithm->name."', '".$this->d."', '".$this->x."', '".$this->y."'}";
	}
}
?>