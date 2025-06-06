<?php
// obtener_datos_fiscales.php
header('Content-Type: application/json');
require('assets/php/conexiones/conexionMySqli.php');
$id = $_GET['id'] ?? null;
if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

// Aquí tu consulta a la base de datos
$query = "SELECT * FROM datosFiscales WHERE id = ?";
$result =  $conn->query($query);
$datos = $result->fetch_assoc();
echo json_encode($datos);
?>
<script>
alert('Entro');
    </script>