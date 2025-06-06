<?php
// obtener_datos_fiscales.php
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

// Aquí tu consulta a la base de datos
$query = "SELECT * FROM datosFiscales WHERE id = ?";
// ... ejecutar consulta y obtener datos ...

echo json_encode($datos);
?>