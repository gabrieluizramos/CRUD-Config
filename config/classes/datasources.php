<?php
class DataSources{
	//valores do banco de dados 
	public static $database = array(
		"host" => "dbhost" ,
		"dbname" => "dbname" ,
		"user" => "dbuser" ,
		"password" => "dbpassword"
		);
	// retorna url principal
	public static function url(){
		return "http://{$_SERVER['SERVER_NAME']}/";
	}
	// caminho fisico do site
	public static function path(){
		return $_SERVER['DOCUMENT_ROOT'];
	}
	// url admin
	public static function urlAdmin(){
		return self::url()."admin/";
	}
	// url uploads
	public static function urlUploads(){
		return self::path()."uploads/";
	}
}
?>