<?php
require('assets/php/conexiones/conexionMySqli.php');

function verificarSesion() {
    global $conn;
    
    // Verificar si existe el token en las cookies
    if (!isset($_COOKIE['token_sesion'])) {
        return false;
    }

    $token = $_COOKIE['token_sesion'];
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'desconocido';
    $ultima_actividad = date('Y-m-d H:i:s');

    // Consultar la sesión en la base de datos con verificación de inactividad
    $stmt = $conn->prepare("
        SELECT s.*, u.tipo 
        FROM sesiones s 
        JOIN usuarios u ON s.id_usuario = u.id 
        WHERE s.token = ? 
        AND s.estatus = 1 
        AND s.expiracion > NOW()
        AND s.ip = ?
        AND s.user_agent = ?
        AND TIMESTAMPDIFF(DAY, s.ultima_actividad, NOW()) <= 30
    ");
    
    $stmt->bind_param("sss", $token, $ip, $user_agent);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $sesion = $resultado->fetch_assoc();
        
        // Iniciar o recargar la sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Recargar los datos de la sesión
        $_SESSION['tipoUsuario'] = $sesion['tipo'];
        $_SESSION['id_usuario'] = $sesion['id_usuario'];
        
        // Actualizar la expiración y última actividad
        $nueva_expiracion = date('Y-m-d H:i:s', time() + (60 * 60 * 24 * 30)); // 30 días
        $stmt = $conn->prepare("UPDATE sesiones SET expiracion = ?, ultima_actividad = ? WHERE token = ?");
        $stmt->bind_param("sss", $nueva_expiracion, $ultima_actividad, $token);
        $stmt->execute();

        // Actualizar la cookie
        setcookie("token_sesion", $token, [
            'expires' => time() + (60 * 60 * 24 * 30),
            'path' => '/',
            'httponly' => true,
            'secure' => isset($_SERVER['HTTPS']),
            'samesite' => 'Lax'
        ]);

        return true;
    }

    // Si la sesión no es válida, eliminar la cookie
    setcookie("token_sesion", "", [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'secure' => isset($_SERVER['HTTPS']),
        'samesite' => 'Lax'
    ]);

    return false;
}

// Función para verificar si el usuario está autenticado
function estaAutenticado() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Si ya hay una sesión activa, retornar true
    if (isset($_SESSION['tipoUsuario'])) {
        return true;
    }
    
    // Si no hay sesión, intentar verificar con el token
    return verificarSesion();
}

// Función para verificar si el usuario tiene un tipo específico
function verificarTipoUsuario($tipoRequerido) {
    if (!estaAutenticado()) {
        return false;
    }
    
    return $_SESSION['tipoUsuario'] === $tipoRequerido;
}

// Nueva función para mantener la sesión activa
function mantenerSesionActiva() {
    if (isset($_COOKIE['token_sesion'])) {
        global $conn;
        $token = $_COOKIE['token_sesion'];
        $ultima_actividad = date('Y-m-d H:i:s');
        
        $stmt = $conn->prepare("UPDATE sesiones SET ultima_actividad = ? WHERE token = ? AND estatus = 1");
        $stmt->bind_param("ss", $ultima_actividad, $token);
        $stmt->execute();
    }
}
?>
