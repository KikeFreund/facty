<?php
require('../assets/php/conexiones/conexionMySqli.php');

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id_usuario = $_SESSION['id_usuario'];
        $nombre = trim($_POST['nombre']);
        $apellido = trim($_POST['apellido']);
        $telefono = trim($_POST['telefono']);

        // Validar campos
        if (empty($nombre) || empty($apellido) || empty($telefono)) {
            throw new Exception('Todos los campos son requeridos');
        }

        // Validar teléfono (solo números y algunos caracteres especiales)
        if (!preg_match('/^[\d\s\-\+\(\)]+$/', $telefono)) {
            throw new Exception('Formato de teléfono inválido');
        }

        // Actualizar información del usuario
        $query = "UPDATE usuarios SET nombre = ?, apellido = ?, telefono = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt->bind_param("sssi", $nombre, $apellido, $telefono, $id_usuario);

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar los datos: " . $stmt->error);
        }

        if ($stmt->affected_rows > 0) {
            $_SESSION['mensaje'] = "Información personal actualizada correctamente";
        } else {
            $_SESSION['mensaje'] = "No se realizaron cambios en la información";
        }

        header('Location: ../cliente/informacion-personal.php');
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: ../cliente/informacion-personal.php');
        exit();
    }
} else {
    header('Location: ../cliente/informacion-personal.php');
    exit();
}
?> 