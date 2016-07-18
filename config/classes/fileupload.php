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
	// create object with ( FILEPATH , $_FILES received , PREFIX , and TRUE OF FALSE for multiples )
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
	// make upload (after constructed)
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
	// remove file
	public static function removeFile( $path ){
		return unlink( $path );
	}
	// delete all files of a folder and remove the directory
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
	// create folder
	public static function createFolder( $path ){
		return mkdir( $path );
	}
	// clear a folder (remove all folder and create again)
	public static function clearFolder( $path ){
		return ( FileUpload::removeFolder( $path ) && FileUpload::createFolder( $path ) ) ? true : false;
	}
	// verify if file exists and return true or false
	public static function verifyFile( $path ){
		return file_exists ( $path );
	}
	// receive filename string and return extension
	public static function verifyExtension( $path ){
		$path = explode( '/' , $path );
		$path = explode( '.' , ( $path[ count( $path ) - 1 ] ) );
		$path = $path[ count( $path ) - 1 ];
		return $path;
	}
}
?>