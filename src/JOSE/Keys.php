<?php
namespace JOSE;

use ECDSA\Math;
use ECDSA\ECDSA;

class Keys{

	public $d;

	public $x;

	public $y;

	public $KID;

	public function __construct($pem='', $KID='', $curve){
		try{
			$res = openssl_pkey_get_private($pem);
		    $key_res = openssl_pkey_get_details($res)['ec'];
            
            $this->d = $key_res['d'];
			$this->x = $key_res['x'];
			$this->y = $key_res['y'];
		}catch(Exception $e){
			$res = openssl_pkey_get_public($pem);
			$key_res = openssl_pkey_get_details($res)['ec'];

            $this->d = 1;
			$this->x = $key_res['x'];
			$this->y = $key_res['y'];
		}

		$this->KID = $KID;
	}
}
?>