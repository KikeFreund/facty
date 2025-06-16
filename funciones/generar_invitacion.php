<?php
session_start();
require('../assets/php/conexiones/conexionMySqli.php');
header('Content-Type: application/json');

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id_usuario = $_SESSION['id_usuario'];
        $mensaje = trim($_POST['mensaje'] ?? '');
        
        // Validar mensaje
        if (empty($mensaje)) {
            throw new Exception('El mensaje es requerido');
        }
        
        if (strlen($mensaje) > 200) {
            throw new Exception('El mensaje no puede exceder 200 caracteres');
        }
        
        // Obtener fecha y hora actual
        $fecha_generacion = date('Y-m-d H:i:s');
        
        // Insertar la invitación en la base de datos
        $query = "INSERT INTO invitaciones (id_usuario, usada, fecha_generacion, id_referido, mensaje) 
                  VALUES (?, 0, ?, 0, ?)";
        
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }
        
        $stmt->bind_param("iss", $id_usuario, $fecha_generacion, $mensaje);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al generar la invitación: " . $stmt->error);
        }
        
        $id_invitacion = $stmt->insert_id;
        
        // Generar el link de invitación
        $link_invitacion = "https://factu.movilistica.com/unirse?id=" . $id_invitacion;
        
        echo json_encode([
            'success' => true,
            'id_invitacion' => $id_invitacion,
            'link_invitacion' => $link_invitacion,
            'mensaje' => 'Invitación generada exitosamente'
        ]);
        
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Método no permitido'
    ]);
}
?> 