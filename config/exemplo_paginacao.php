<!DOCTYPE html>
<html>
<head>
  <title>Sindisan</title>
  <?php include 'includes/partial-head.php';?>
</head>
<body>
  <?php include 'includes/header.php';?>
  <section class="section internas quem-somos">
    <ul class="breadcrumb-list wrapper">
      <li class="breadcrumb-item">Você está em:</li>
      <li class="breadcrumb-item">Home</li>
      <li class="breadcrumb-item">Legislação Aplicável</li>
    </ul>
    <div class="clear spaceblock"></div>
    <div class="wrapper clearfix">
      <section class="internas-conteudo">
        <h2 class="page-title color-green marged">Legislação Aplicável</h2>
        <div class="clear spaceblock"></div>
        <ul class="legislacao-list">
          <?php
          
          # CONFIGURACAO DA PAGINACAO
          # QTD por pagina
          $qtdPerPage = 5;
          # LIMITE
          $limit = 5;
          #offset inicial ( que vai ser utilizado na paginacao )
          $initialOffset = $_GET['offset']
          # OFFSET (com base no limite, pra ser utilizado na busca DENTRO da pagina)
          $offset = ( $_GET['offset'] == 1 ) ? 0 : ( $_GET['offset'] - 1  ) * $qtdPerPage;

          $banco = new Banco();
          $banco->preparaSQL( "SELECT * FROM legislacao ORDER BY id_legislacao DESC LIMIT $limit OFFSET $offset" );
          $consulta = $banco->executaSQL();
          $consulta = $consulta->fetchAll();

          if ( !empty( $consulta ) ) :
            foreach ( $consulta as $campo ) :
              ?>
            <li class="legislacao-item">
              <a <?= ( $campo['nm_tipo_integra']  == "url" ) ? 'href="'.$campo['ds_integra'].'"' : 'href="/arquivos/legislacao/'.$campo['ds_integra'].'" download' ?> target="_blank" class="legislacao-link">
                <i class="fa fa-file"></i>
                <div class="legislacao-info">
                  <strong class="legislacao-title">#<?=$campo['id_legislacao']?>#  <?= utf8_encode( $campo['nm_titulo'] )?><span class="legislacao-subtitle"><?= utf8_encode( $campo['nm_tipo'] )?></span></strong>
                  <div class="legislacao-desc">
                    <span class="legislacao-tipo"><?= utf8_encode( $campo['ds_ementa'] )?></span>
                  </div>
                </div>
              </a>
            </li>
            <?php
            endforeach;
            else:
              ?>
            <li class="legislacao-item">
              <a class="legislacao-link">
                <i class="fa fa-file"></i>
                <div class="legislacao-info">
                  <strong class="legislacao-title">Sem legislações cadastradas</strong>
                </div>
              </a>
            </li>
            <?php
            endif;
            ?>
          </ul>
          <div class="clear spaceblock"></div>
          <?php
          require_once ( $_SERVER['DOCUMENT_ROOT'].'classes/paginate.php' );
          $paginacao = new Paginate( 'legislacao' , $limit , $initialOffset , $qtdPerPage , 'legislacao-aplicavel.php?offset='.( $offset + 1) , 'active' );
          $paginacao->createPagination();
          ?>
        </section>
        <?php include 'includes/aside.php';?>
      </div>
    </section>
    <?php include 'includes/footer.php';?>
  </body>
  </html>