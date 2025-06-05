<?php
require_once('../verificacion.php');

// Verificar que la petición sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Intentar mantener la sesión activa
    if (estaAutenticado()) {
        mantenerSesionActiva();
        http_response_code(200);
        echo json_encode(['status' => 'success']);
    } else {
        http_response_code(401);
        echo json_encode(['status' => 'unauthorized']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'method_not_allowed']);
}
?> 