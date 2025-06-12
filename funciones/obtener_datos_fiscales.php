<?php
session_start();
require('../assets/php/conexiones/conexionMySqli.php');
header('Content-Type: application/json');

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

// Verificar que los datos fiscales pertenezcan al usuario
$query = "SELECT df.*, rf.descripcion AS regimenf, u.descripcion AS usoNombre 
          FROM datosFiscales df
          LEFT JOIN regimenesFiscales rf ON rf.id = df.regimen
          LEFT JOIN usosCfdi u ON u.id = df.usoFavorito
          WHERE df.id = ? AND df.id_usuario = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $datos = $result->fetch_assoc();
    
    // Verificamos que los campos existan antes de usarlos
    $response = [
        'rfc' => $datos['rfc'] ?? '',
        'razon_social' => $datos['razonSocial'] ?? '',
        'regimen_fiscal' => $datos['regimenf'] ?? '',
        'correo' => $datos['correo'] ?? '',
        'calle' => $datos['calle'] ?? '',
        'cp' => $datos['cp'] ?? '',
        'colonia' => $datos['colonia'] ?? '',
        'municipio' => $datos['municipio'] ?? '',
        'estado' => $datos['estado'] ?? '',
        'id_usoFavorito' => $datos['usoFavorito'] ?? '',
        'nombre_usoFavorito' => $datos['usoNombre'] ?? '',
        'telefono' => $datos['telefono'] ?? ''
    ];

    // Debug: Imprimir la consulta y los datos
    error_log("Query ejecutada: " . $query);
    error_log("Datos obtenidos: " . print_r($datos, true));
    error_log("Respuesta JSON: " . json_encode($response));

    echo json_encode($response);
} else {
    error_log("No se encontraron datos para el ID: " . $id);
    http_response_code(404);
    echo json_encode(['error' => 'Datos fiscales no encontrados o no autorizados']);
}

$stmt->close();
?> 