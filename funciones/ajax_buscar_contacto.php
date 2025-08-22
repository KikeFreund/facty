<?php
/**
 * Endpoint AJAX para buscar contactos frecuentes
 * Retorna JSON con el resultado de la búsqueda
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once('buscar_contacto_frecuente.php');

// Verificar si se recibió un teléfono
$telefono = $_GET['telefono'] ?? $_POST['telefono'] ?? null;

if (!$telefono) {
    echo json_encode([
        'success' => false,
        'message' => 'No se proporcionó número de teléfono',
        'contacto' => null
    ]);
    exit;
}

// Limpiar y validar el teléfono
$telefono = preg_replace('/[^0-9]/', '', $telefono);

if (strlen($telefono) < 7) {
    echo json_encode([
        'success' => false,
        'message' => 'Número de teléfono demasiado corto',
        'contacto' => null
    ]);
    exit;
}

try {
    // Buscar contacto frecuente
    $contacto = buscarContactoFrecuente($telefono);
    
    if ($contacto) {
        echo json_encode([
            'success' => true,
            'message' => 'Contacto encontrado',
            'contacto' => $contacto
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró contacto frecuente',
            'contacto' => null,
            'sugerencia' => 'Puedes agregar este número como contacto frecuente'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error en la búsqueda: ' . $e->getMessage(),
        'contacto' => null
    ]);
}
?>
