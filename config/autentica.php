<?php
session_start();
// CLASSE PARA AUTENTICAÇÃO
require_once $_SERVER['DOCUMENT_ROOT']."/config/classes/auth.php";
// SE NÃO ESTIVER AUTENTICADO
if ( !$_SESSION['auth'] ) {
    // SE ESTIVER COM VALORES VINDO POR POST
    if ( $_POST ) {
        // SE NÃO AUTENTICAR
        if ( !Auth::login( $_POST['login'] , $_POST['password'] ) ) {
           $_SESSION['finalizacao'] = "erro";
           $_SESSION['msg-final'] = "Dados incorretos ou você não possui permissão 1";
           Header( "Location:/admin/login.php" );
           die();
       }
        // SE AUTENTICAR
       else{
           $_SESSION['auth'] = true;
           Header( "Location:index.php" ); 
       }
   }
       else{
        $_SESSION['finalizacao'] = "erro";
        $_SESSION['msg-final'] = "Dados incorretos ou você não possui permissão 2";
        Header( "Location:/admin/login.php" );
        die();
    }
}
?>