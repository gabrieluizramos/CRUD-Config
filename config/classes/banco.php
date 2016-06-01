<?php
// DATASOURCES REQUIRE
require_once 'datasources.php';
// CLASSE DO BANCO
class Banco{

	protected $database;
	public $conn;
	public $query;

	public function __construct(){
		$this->database = DataSources::$database;
		$this->conn = new PDO( "mysql:host={$this->database['host']};dbname={$this->database['dbname']}" , $this->database['user'] , $this->database['password'] ); 
		// linha para nao se preocupar com o tipo do dado
		$this->conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
		
	}

	public function preparaSQL( $SQL ){
		$this->query = $this->conn->prepare( $SQL );
	}

	public function bindSQL( $regras ){
		foreach ( $regras as $regra => $valor ) {
			$this->query->bindValue( $regra , $valor );
		}
		/*
		// can use like this too
		foreach ( $regras as $regra => &$valor ) {
			$this->query->bindParam( $regra , $valor );
		}
		*/
	}

	public function executaSQL(){
		$this->query->execute();
		return $this->query;
	}

	public function debugQuery(){
		return var_dump( $this->query->debugDumpParams() );
	}	

	public function executaQuery( $SQL ){
		return $this->conn->query( $SQL );
	}
	
}
?>