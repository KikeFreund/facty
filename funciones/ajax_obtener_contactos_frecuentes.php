<?php
/**
 * Endpoint AJAX para obtener todos los contactos frecuentes del usuario
 * Retorna JSON con la lista de contactos para llenar un select
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once('buscar_contacto_frecuente.php');

try {
    // Obtener todos los contactos frecuentes del usuario
    $contactos = obtenerTodosLosContactosFrecuentes();
    
    if ($contactos && count($contactos) > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Contactos obtenidos correctamente',
            'contactos' => $contactos,
            'total' => count($contactos)
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No hay contactos frecuentes disponibles',
            'contactos' => [],
            'total' => 0
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener contactos: ' . $e->getMessage(),
        'contactos' => [],
        'total' => 0
    ]);
}
?>
