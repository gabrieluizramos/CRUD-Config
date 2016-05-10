<?php
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


	public function __construct( $path,  $file , $prefix , $isMultiple = false){
		// variaveis gerais
		$this->filePath = $path;
		$this->prefix = $prefix;
		$this->file = $file;
		$this->isMultiple = $isMultiple;
		if ( !$this->isMultiple ) {
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
}
?>