<?php
session_start();
require_once 'banco.php';
class Auth{
	public static function login( $usuario = "" , $senha = "" ){
		$banco = new Banco();
		$SQL = "SELECT * FROM tb_usuarios WHERE ds_login = :login AND ds_senha = :senha ;" ;
		$banco->preparaSQL( $SQL );
		$regras = array(
			':login' => $usuario ,
			':senha' => $senha
			);
		$banco->bindSQL( $regras );
		$dados = $banco->executaSQL();
		if ( $dados->rowCount() < 1 ) {
			$_SESSION["auth-msg"] = "login inválido";
			$_SESSION["auth-type"] = "erro";
			$_SESSION["auth"] = false;
			return false;
		}
		else{
			$_SESSION["auth"] = true;
			$_SESSION["auth-msg"] = "login válido";
			$_SESSION["auth-type"] = "sucesso";
			return true;
		}		
	}
	public static function logoff(){
		session_destroy();
		Header( "Location: " . DataSources::urlAdmin() . "login.php" );
	}
}
?>