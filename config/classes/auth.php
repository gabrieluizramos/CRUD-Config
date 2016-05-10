<?php
session_start();
require_once 'banco.php';
class Auth{
	public static function login( $usuario = "" , $senha = "" ){
		$banco = new Banco();
		$dados = $banco->executaQuery( "SELECT * FROM tb_usuarios WHERE ds_email = '$usuario' AND ds_senha = '$senha' ;" );
		if ( $dados->rowCount() < 1 ) {
			$_SESSION["auth-msg"] = "login inválido";
			$_SESSION["auth-type"] = "invalido";
			$_SESSION["auth"] = false;
			return false;
		}
		else{
			$_SESSION["auth"] = true;
			$_SESSION["auth-msg"] = "login válido";
			$_SESSION["auth-type"] = "valido";
			return true;
		}		
	}
	public static function logoff(){
		session_destroy();
		Header( "Location: " . DataSources::urlAdmin() . "login.php" );
		die();
	}
}
?>