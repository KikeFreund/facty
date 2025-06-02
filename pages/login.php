<?php
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

<style>
    .login-section {
        min-height: calc(100vh - 200px); /* Ajusta según el alto de tu nav y footer */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .login-container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        width: 100%;
        max-width: 420px;
        backdrop-filter: blur(10px);
    }
    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    .login-header i {
        font-size: 3rem;
        color: #667eea;
        margin-bottom: 1rem;
    }
    .login-header h2 {
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .login-header p {
        color: #718096;
        font-size: 0.95rem;
    }
    .form-floating {
        margin-bottom: 1rem;
    }
    .form-floating input {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 1rem 0.75rem;
    }
    .form-floating input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    .btn-login {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 0.8rem;
        font-weight: 600;
        width: 100%;
        margin-top: 1rem;
        transition: all 0.3s ease;
    }
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    .error-message {
        background-color: #fff5f5;
        color: #c53030;
        padding: 0.75rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        text-align: center;
        border: 1px solid #feb2b2;
        display: none;
    }
    .error-message.show {
        display: block;
    }
</style>

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
