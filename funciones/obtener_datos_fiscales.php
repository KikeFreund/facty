<?php
// Deshabilitar la salida de errores de PHP
error_reporting(0);
ini_set('display_errors', 0);

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

// Incluir la conexión a la base de datos
require_once('../assets/php/conexiones/conexionMySqli.php');

try {
    // Verificar que se recibió un ID
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception('ID no proporcionado');
    }

    $id = intval($_GET['id']); // Convertir a entero para prevenir inyección SQL

    // Preparar y ejecutar la consulta
    $query = "SELECT * FROM datosFiscales WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta: ' . $conn->error);
    }

    $stmt->bind_param('i', $id);
    
    if (!$stmt->execute()) {
        throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('No se encontraron datos fiscales para el ID proporcionado');
    }

    $datos = $result->fetch_assoc();

    // Formatear la respuesta
    $response = [
        'rfc' => $datos['rfc'] ?? '',
        'razon_social' => $datos['razonSocial'] ?? '',
        'regimen_fiscal' => $datos['regimenFiscal'] ?? '',
        'correo' => $datos['correo'] ?? '',
        'calle' => $datos['calle'] ?? '',
        'cp' => $datos['cp'] ?? '',
        'colonia' => $datos['colonia'] ?? '',
        'municipio' => $datos['municipio'] ?? '',
        'estado' => $datos['estado'] ?? '',
        'telefono' => $datos['telefono'] ?? ''
    ];

    // Enviar la respuesta
    echo json_encode($response);

} catch (Exception $e) {
    // Enviar error en formato JSON
    http_response_code(400);
    echo json_encode([
        'error' => $e->getMessage()
    ]);
} finally {
    // Cerrar la conexión si existe
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>
<script>
alert('Entro');
    </script>