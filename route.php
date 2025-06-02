<?php
//Route se encarga de crear la variable $ruta que se usa para no necesitar estar muchos select
$ruta='';


if(isset($tipoUsuario)){
   require('assets/php/conexiones/conexionMySqli.php');
   $ruta = $conn->query("SELECT * FROM tiposUsuarios WHERE id='$tipoUsuario'")->fetch_assoc()['nombre'];

    
}else{
    $ruta='logout';
} 
    ?>
