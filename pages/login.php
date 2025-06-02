<?php
if (isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}else{
 
require('assets/php/conexiones/conexionMySqli.php');

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

<div class="login-section">
    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-file-invoice"></i>
            <h2>Bienvenido</h2>
            <p>Ingresa tus credenciales para continuar</p>
        </div>

        <?php if (isset($error)): ?>
        <div class="error-message show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="funciones/login.php">
            <div class="form-floating">
                <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electrónico" required>
                <label for="correo"><i class="fas fa-envelope me-2"></i>Correo electrónico</label>
            </div>
            
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                <label for="password"><i class="fas fa-lock me-2"></i>Contraseña</label>
            </div>

            <input type="hidden" name="device_id" id="device_id">
            
            <button type="submit" class="btn btn-login text-white">
                <i class="fas fa-sign-in-alt me-2"></i>
                Iniciar Sesión
            </button>
        </form>
    </div>
</div>

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
<?php
}