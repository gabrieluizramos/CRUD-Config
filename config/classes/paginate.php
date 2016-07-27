<?php

require_once 'banco.php';

class Paginate{

	public $limit;
	public $offset;
	public $classPageActive;
	public $consultTable;
	public $totalRowCount;
	public $qtdPerPage;
	public $totalPages;
	public $url;

	public function __construct( $consultTable , $limit = 5 , $offset = 0 ,  $qtdPerPage = 3 , $url , $classPageActive = 'active' ){

		$this->consultTable = $consultTable;
		$this->limit = (int)$limit;
		$this->offset = (int)$offset;
		$this->qtdPerPage = (int)$qtdPerPage;
		$this->classPageActive = $classPageActive;
		$this->url = $url;

		// valores de maximo
		$banco = new Banco();
		$SQL = "SELECT COUNT(*) FROM ".$this->consultTable;
		$banco->preparaSQL( $SQL );
		$count = $banco->executaSQL();
		$count = $count->fetchColumn();
		$this->totalRowCount = (int)$count;

		$this->totalPages = (int)ceil( $this->totalRowCount / $this->qtdPerPage );

		$this->paginationTerm = "offset";

	}

	public function createPagination(){

		$inicioPaginacao =  (int)( $this->offset < $this->totalPages ) ? $this->offset : $this->totalPages;
		$fimPaginacao = (int)( ( $inicioPaginacao + 3 ) > $this->totalPages ) ? $this->totalPages : ( $inicioPaginacao + 3 );

		if ( $this->totalPages > 1 ) :
		?>
		<ul class="paginacao-list">

		<?php if( $this->offset > 1 ) :?>

		<li class="paginacao-item">
			<a href="<?=$this->url?>?<?=$this->paginationTerm ?>=1" class="paginacao-link">&laquo;</a>
		</li>

		<li class="paginacao-item">
			<a href="<?=$this->url?>?<?=$this->paginationTerm ?>=<?= ( $this->offset - 1 )?>" class="paginacao-link">&lsaquo;</a>
		</li>

		<?php endif;?>

		<li class="paginacao-item">
			<a href="<?=$this->url?>?<?=$this->paginationTerm ?>=1" class="paginacao-link"><?= $this->offset ?></a>
		</li>

		<?php 

		for ( $i = $inicioPaginacao ; $i < $fimPaginacao ; $i++ ) : ?>

		<li class="paginacao-item">
			<a href="<?=$this->url?>?<?=$this->paginationTerm ?>=<?= ( $i + 1 )?>" class="paginacao-link"><?= ( $i + 1 )?></a>
		</li>

		<?php endfor; ?>

		<?php if( $fimPaginacao < $this->totalPages ) :?>

		<li class="paginacao-item">
			<a href="<?=$this->url?>?<?=$this->paginationTerm ?>=<?= ( $fimPaginacao + 1 )?>" class="paginacao-link">&rsaquo;</a>
		</li>

		<?php endif;?>


		<?php if( $this->offset < $this->totalPages ) :?>

		<li class="paginacao-item">
			<a href="<?=$this->url?>?<?=$this->paginationTerm ?>=<?= $this->totalPages?>" class="paginacao-link">&raquo;</a>
		</li>

		<?php endif;?>

	</ul>
	<?php
	endif;
	}
}
?>