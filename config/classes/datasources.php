<?php
class DataSources{
	//valores do banco de dados 
	public static $database = array(
		"host" => "127.0.0.1 " ,
		"dbname" => "nova_era" ,
		"user" => "gabrieluizramos" ,
		"password" => ""
		);
	// valores para upload de arquivos
	public static $file = array(
		'size'				=>		5000000		,
		'width'				=>		2000		,
		'height'			=>		2000		,
		'thumbnail_width'	=>		200			,
		'thumbnail_height'	=>		200			,
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