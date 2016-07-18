<?php

require_once 'datasources.php';

class FileUpload{

	// geral
	public $file;
	public $filePath;
	public $fileExtension;
	public $prefix;
	public $fileName;
	public $fileFullName;
	// upload multiplo
	public $isMultiple;
	public $multipleFileFullName;
	public $multipleFileNames;
	// options do datasources
	public $generalFileOptions;
	public $fileInfo;
	public $multipleFileInfo;
	/*
	**to list file options
	list( $width , $height ) = $object->fileInfo;
	echo $width;
	*/
	public function __construct( $path,  $file , $prefix , $isMultiple = false ){
		// valores do datasources
		$this->generalFileOptions = DataSources::$file;
		// variaveis gerais
		$this->filePath = $path;
		$this->prefix = $prefix;
		$this->file = $file;
		$this->isMultiple = $isMultiple;
		if ( !$this->isMultiple ) {
			// informacoes sobre o arquivo
			$this->fileInfo = getimagesize( $this->file['tmp_name'] );
			// variaveis para unico arquivo
			$this->fileName = $this->prefix . "-" . rand();
			$this->fileExtension = explode( "." , $this->file["name"] );
			$this->fileExtension = end( $this->fileExtension );
			$this->fileName = $this->fileName . "." . $this->fileExtension;
			$this->fileFullName = $this->filePath . $this->fileName;
		}
		else{
			$this->isMultiple = $isMultiple;
			$this->multipleFileFullName = array();
			$this->multipleFileNames = array();
			$this->multipleFileInfo = array();
			// valores de informacao
			for ($i = 0 ; $i < count( $this->file['tmp_name'] ) ; $i++) {
				array_push( $this->multipleFileInfo , getimagesize( $this->file['tmp_name'][$i] ) );
			}
			// para os novos nomes
			foreach ( $this->file['name'] as $eachFile ) {
				$this->fileName = $this->prefix . "-" . rand();
				$this->fileExtension = explode( "." , $eachFile );
				$this->fileExtension = end( $this->fileExtension );
				$this->fileName = $this->fileName . "." . $this->fileExtension;
				$this->fileFullName = $this->filePath . $this->fileName;
				array_push( $this->multipleFileNames , $this->fileName );
				array_push( $this->multipleFileFullName , $this->fileFullName );
			}
		}
	}

	public function doUpload(){
		if ( !$this->isMultiple ) {
			return ( move_uploaded_file( $this->file['tmp_name'] , $this->fileFullName ) ) ? true : false;
		}
		else{
			for ( $i = 0 ; $i < count( $this->file['tmp_name'] ) ; $i++) { 
				move_uploaded_file( $this->file['tmp_name'][ $i ] , $this->multipleFileFullName[ $i ] );
			}
			return true;
		}		
	}

	public static function removeFile( $path ){
		return unlink( $path );
	}

	public static function removeFolder( $path ){
		if ( is_dir( $path ) === true)	{
			$files = array_diff( scandir( $path ), array('.', '..') );

			foreach ($files as $file){
				FileUpload::removeFolder( realpath( $path ) . '/' . $file );
			}

			return rmdir( $path );
		}

		else if ( is_file( $path ) === true ){
			return unlink( $path );
		}
		return false;
	}

	public static function createFolder( $path ){
		return mkdir( $path );
	}

	public static function clearFolder( $path ){
		return ( FileUpload::removeFolder( $path ) && FileUpload::createFolder( $path ) ) ? true : false;
	}
}
?>