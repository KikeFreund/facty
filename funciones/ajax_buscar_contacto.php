<?php
/**
 * Endpoint AJAX para buscar contactos frecuentes
 * Retorna JSON con el resultado de la búsqueda
 * Soporta búsqueda por teléfono, texto o categoría
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once('buscar_contacto_frecuente.php');

// Verificar si se recibió un teléfono, texto o categoría para buscar
$telefono = $_GET['telefono'] ?? $_POST['telefono'] ?? null;
$texto = $_GET['texto'] ?? $_POST['texto'] ?? null;
$categoria = $_GET['categoria'] ?? $_POST['categoria'] ?? null;
$action = $_GET['action'] ?? $_POST['action'] ?? null;

// Si se solicita obtener categorías
if ($action === 'categorias') {
    try {
        $categorias = obtenerCategoriasDisponibles();
        
        echo json_encode([
            'success' => true,
            'message' => 'Categorías obtenidas',
            'categorias' => $categorias,
            'total' => count($categorias)
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al obtener categorías: ' . $e->getMessage(),
            'categorias' => []
        ]);
    }
    exit;
}

// Si no se proporcionó ningún parámetro
if (!$telefono && !$texto && !$categoria) {
    echo json_encode([
        'success' => false,
        'message' => 'No se proporcionó teléfono, texto ni categoría para buscar',
        'contacto' => null,
        'contactos' => []
    ]);
    exit;
}

try {
    // Búsqueda por teléfono
    if ($telefono) {
        // Limpiar y validar el teléfono
        $telefono = preg_replace('/[^0-9]/', '', $telefono);
        
        if (strlen($telefono) < 7) {
            echo json_encode([
                'success' => false,
                'message' => 'Número de teléfono demasiado corto',
                'contacto' => null,
                'contactos' => []
            ]);
            exit;
        }
        
        // Buscar contacto frecuente por teléfono
        $contacto = buscarContactoFrecuente($telefono);
        
        if ($contacto) {
            echo json_encode([
                'success' => true,
                'message' => 'Contacto encontrado',
                'contacto' => $contacto,
                'contactos' => [$contacto]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se encontró contacto frecuente',
                'contacto' => null,
                'contactos' => [],
                'sugerencia' => 'Puedes agregar este número como contacto frecuente'
            ]);
        }
    }
    
    // Búsqueda por texto y/o categoría
    if ($texto || $categoria) {
        // Validar que el texto tenga al menos 2 caracteres si se proporciona
        if ($texto && strlen($texto) < 2) {
            echo json_encode([
                'success' => false,
                'message' => 'El texto de búsqueda debe tener al menos 2 caracteres',
                'contacto' => null,
                'contactos' => []
            ]);
            exit;
        }
        
        // Buscar contactos frecuentes por texto y/o categoría
        $contactos = buscarContactosPorTextoYCategoria($texto, $categoria);
        
        if ($contactos && count($contactos) > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Contactos encontrados',
                'contacto' => null,
                'contactos' => $contactos,
                'total' => count($contactos),
                'filtros' => [
                    'texto' => $texto,
                    'categoria' => $categoria
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se encontraron contactos frecuentes',
                'contacto' => null,
                'contactos' => [],
                'sugerencia' => 'Puedes agregar este contacto como frecuente',
                'filtros' => [
                    'texto' => $texto,
                    'categoria' => $categoria
                ]
            ]);
        }
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error en la búsqueda: ' . $e->getMessage(),
        'contacto' => null,
        'contactos' => []
    ]);
}
?>
