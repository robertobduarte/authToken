<?php

include_once __DIR__ . "/../config.php";

class AuthToken_objeto extends AuthToken {
	
	protected $token = "1YZT15ERV3M95PR";
	protected $prazoToken = "1"; //hora

	function __construct( $params ){
		parent::__construct( $params );
	}

	
}
?>