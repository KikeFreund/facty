<?php
 require('../assets/php/conexiones/conexionMySqli.php');

function generarToken() {
    return bin2hex(random_bytes(32)); // 64 caracteres
}

function obtenerIp() {
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function obtenerUserAgent() {
    return $_SERVER['HTTP_USER_AGENT'] ?? 'desconocido';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = strtolower(trim($_POST['correo']));
    $password = $_POST['password'];
    $device_id = trim($_POST['device_id']);

    $stmt = $conn->prepare("SELECT id, pass, tipo  FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $usuario = $res->fetch_assoc();

        if (password_verify($password, $usuario['pass'])) {
            //Guardar tipo de usuario 
            session_start();
            $_SESSION['tipoUsuario']=$usuario['tipo'];
            
            // ✅ Generar token con 30 días de expiración
            $token = generarToken();
            $expiracion = date('Y-m-d H:i:s', time() + (60 * 60 * 24 * 30)); // 30 días
            $ultima_actividad = date('Y-m-d H:i:s');

            $ip = obtenerIp();
            $user_agent = obtenerUserAgent();

            $stmt2 = $conn->prepare("INSERT INTO sesiones (id_usuario, token, expiracion, ip, user_agent, device_id, estatus, ultima_actividad) VALUES (?, ?, ?, ?, ?, ?, 1, ?)");
            $stmt2->bind_param("issssss", $usuario['id'], $token, $expiracion, $ip, $user_agent, $device_id, $ultima_actividad);
            $stmt2->execute();

            // ✅ Guardar token en cookie (30 días, httpOnly)
            setcookie("token_sesion", $token, [
                'expires' => time() + (60 * 60 * 24 * 30),
                'path' => '/',
                'httponly' => true,
                'secure' => isset($_SERVER['HTTPS']),
                'samesite' => 'Lax'
            ]);

            // ✅ Redirección
            header("Location: /index");
            exit;
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Correo no encontrado";
    }
}
?>
