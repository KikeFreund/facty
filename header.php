
<?php 
session_start();
if(isset($_SESSION['tipoUsuario'])){
$tipoUsuario=$_SESSION['tipoUsuario'];

}
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Facturación</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>