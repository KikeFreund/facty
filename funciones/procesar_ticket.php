<?php
session_start();
require_once('../assets/php/conexiones/conexionMySqli.php');

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../login.php');
    exit;
}

// Función para validar y procesar la imagen
function procesarImagen($archivo) {
    $tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png'];
    $tamanoMaximo = 5 * 1024 * 1024; // 5MB en bytes
    
    // Verificar si se subió un archivo
    if (!isset($archivo) || $archivo['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Error al subir la imagen: ' . 
            ($archivo['error'] === UPLOAD_ERR_INI_SIZE || $archivo['error'] === UPLOAD_ERR_FORM_SIZE 
                ? 'La imagen excede el tamaño máximo permitido' 
                : 'Error al procesar la imagen'));
    }

    // Verificar tipo de archivo
    if (!in_array($archivo['type'], $tiposPermitidos)) {
        throw new Exception('Tipo de archivo no permitido. Solo se aceptan JPG, JPEG y PNG.');
    }

    // Verificar tamaño
    if ($archivo['size'] > $tamanoMaximo) {
        throw new Exception('La imagen excede el tamaño máximo de 5MB.');
    }

    // Crear directorio si no existe
    $directorio = '../../archivos/tickets/';
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // Generar nombre único para el archivo
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombreArchivo = uniqid('ticket_') . '.' . $extension;
    $rutaCompleta = $directorio . $nombreArchivo;

    // Mover el archivo
    if (!move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
        throw new Exception('Error al guardar la imagen.');
    }

    return $nombreArchivo;
}

try {
    // Validar datos requeridos
    $camposRequeridos = ['monto', 'datos_fiscales', 'uso_cfdi', 'rfc', 'razon_social', 'regimen_fiscal'];
    foreach ($camposRequeridos as $campo) {
        if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
            throw new Exception("El campo {$campo} es requerido.");
        }
    }

    // Validar monto
    $monto = filter_var($_POST['monto'], FILTER_VALIDATE_FLOAT);
    if ($monto === false || $monto <= 0) {
        throw new Exception('El monto debe ser un número válido mayor a 0.');
    }

    // Procesar la imagen si se subió una
    $nombreImagen = null;
    if (isset($_FILES['imagen_ticket']) && $_FILES['imagen_ticket']['error'] !== UPLOAD_ERR_NO_FILE) {
        $nombreImagen = procesarImagen($_FILES['imagen_ticket']);
    }

    // Preparar la consulta SQL
    $query = "INSERT INTO tickets (
        id_usuario, 
        monto, 
        id_datos_fiscales, 
        uso_cfdi, 
        rfc, 
        razon_social, 
        regimen_fiscal, 
        correo, 
        calle, 
        cp, 
        colonia, 
        municipio, 
        estado, 
        telefono, 
        imagen_ticket, 
        fecha_creacion, 
        estado_ticket
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'pendiente')";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta: ' . $conn->error);
    }

    // Vincular parámetros
    $stmt->bind_param(
        'idsssssssssssss',
        $_SESSION['id_usuario'],
        $monto,
        $_POST['datos_fiscales'],
        $_POST['uso_cfdi'],
        $_POST['rfc'],
        $_POST['razon_social'],
        $_POST['regimen_fiscal'],
        $_POST['correo'],
        $_POST['calle'],
        $_POST['cp'],
        $_POST['colonia'],
        $_POST['municipio'],
        $_POST['estado'],
        $_POST['telefono'],
        $nombreImagen
    );

    // Ejecutar la consulta
    if (!$stmt->execute()) {
        throw new Exception('Error al guardar el ticket: ' . $stmt->error);
    }

    $idTicket = $stmt->insert_id;
    $stmt->close();

    // Redirigir al usuario con mensaje de éxito
    $_SESSION['mensaje'] = [
        'tipo' => 'success',
        'texto' => 'Ticket generado exitosamente. ID: ' . $idTicket
    ];
    header('Location: ../cliente/tickets.php');
    exit;

} catch (Exception $e) {
    // Si hubo un error, redirigir con mensaje de error
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'texto' => $e->getMessage()
    ];
    header('Location: ../cliente/generar-ticket.php');
    exit;
} finally {
    // Cerrar la conexión
    if (isset($conn)) {
        $conn->close();
    }
}
?>
