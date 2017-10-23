<?php

abstract class AuthToken{

	protected $token;
	protected $prazoToken = 1; //minutos
	protected $dadosParam;
	protected $params = array();
	protected $retorno = array();
	
	function __construct( $param )	{

		$this->param( $params );
		$this->validaToken();

	}

    public function __get( $name ) {

	 	if( property_exists( $this, $name ) ){

	 		return $this->$name;
	 	}
    }

    /* $param = array('token', 'dados') */	
	protected function param( $params ){

		$this->dadosParam = base64_decode( $params['dados'] );

		$parametros = explode( '&', $this->dadosParam );

		foreach ($parametros as $param ) {
			
			$parametro = explode( '=', $param );			
			$this->params[$parametro[0]] = $parametro[1];

		}

		$this->params['token'] = $params['token'];		
	}

	protected function validaToken(){

		$token = base64_encode( md5( $this->dadosParam . $this->token ) );

		if( $token == $this->params['token'] ){

			if( $this->validaPrazoToken() ){

				$this->retorno['msg'] = 'OK';
				$this->retorno['cod'] = true;
			}					

		}else{

			$this->retorno['msg'] = 'Token inválido';
			$this->retorno['cod'] = false;
			return false;
		}

	}


	protected function validaPrazoToken(){

		$data = str_replace('/', '-', $this->params['data']);
		$dataExpiracao = new DateTime( $data );
		$dataExpiracao->modify("+". $this->prazoToken ." minutes");

		if( strtotime( $dataExpiracao->format('d-m-Y H:i:s') ) < strtotime( date('d-m-Y H:i:s') ) ){
			$this->retorno['msg'] = 'Token expirado';
			$this->retorno['cod'] = false;
			return false;
		}

		return true;
	}

}
?>
