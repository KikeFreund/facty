<?php
 require('assets/php/conexiones/conexionMySqli.php');
session_start();

// Función para generar token seguro
function generarTokenSeguro($longitud = 64) {
    return bin2hex(random_bytes($longitud / 2)); // 64 caracteres
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $clave = $_POST['clave'] ?? '';
    $deviceId = $_POST['device_id'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    // Buscar al usuario
    $stmt = $conn->prepare("SELECT id, clave FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($id_usuario, $clave_hash);

    if ($stmt->fetch()) {
        // Validar contraseña (usa password_verify si está hasheada)
        if ($clave === $clave_hash) {
            $token = generarTokenSeguro();
            $expiracion = date('Y-m-d H:i:s', time() + 86400); // 24 horas

            // Guardar sesión en la BD
            $insert = $conn->prepare("INSERT INTO sesiones 
                (id_usuario, token, expiracion, user_agent, ip, device_id, estatus) 
                VALUES (?, ?, ?, ?, ?, ?, 1)");
            $insert->bind_param("isssss", $id_usuario, $token, $expiracion, $userAgent, $ip, $deviceId);
            $insert->execute();

            // Guardar cookies
            setcookie("token", $token, time() + 86400, "/", "", false, true);
            setcookie("device_id", $deviceId, time() + 86400, "/", "", false, false);

            $_SESSION['id_usuario'] = $id_usuario;
            header("Location: index.php");
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - Facturación</title>
    <style>
        body { font-family: Arial; background: #f3f3f3; padding: 50px; }
        form { max-width: 400px; margin: auto; padding: 30px; background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin-bottom: 15px; }
        input[type="submit"] { padding: 10px 20px; background: #007bff; border: none; color: white; border-radius: 4px; cursor: pointer; }
        h2 { text-align: center; }
        .error { color: red; text-align: center; }
    </style>
</head>
<body>
   <form method="POST" action="funciones/login.php">
  <input type="email" name="correo" placeholder="Correo" required>
  <input type="password" name="password" placeholder="Contraseña" required>
  <input type="hidden" name="device_id" id="device_id">
  <button type="submit">Iniciar Sesión</button>
</form>

<script>
  // Simulación simple de device_id
  document.getElementById('device_id').value = btoa(navigator.userAgent + screen.width + screen.height);
</script>


    <script>
        function generarDeviceId() {
            return btoa(navigator.userAgent + screen.width + screen.height + Math.random()).substring(0, 64);
        }

        function leerCookie(nombre) {
            let match = document.cookie.match(new RegExp('(^| )' + nombre + '=([^;]+)'));
            return match ? match[2] : null;
        }

        let deviceId = leerCookie('device_id');
        if (!deviceId) {
            deviceId = generarDeviceId();
            document.cookie = `device_id=${deviceId}; path=/; max-age=31536000; SameSite=Strict`;
        }

        document.getElementById('device_id').value = deviceId;
    </script>
</body>
</html>
