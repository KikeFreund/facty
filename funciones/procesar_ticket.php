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
    $camposRequeridos = ['monto', 'datos_fiscales', 'uso_cfdi'];
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

    // Obtener número de ticket (si se proporcionó)
    $numeroTicket = $_POST['numeroTicket'] ?? '';
    $fecha = date('Y-m-d H:i:s');

    // Preparar la consulta SQL
    $query = "INSERT INTO tickets (
        id_cliente, 
        monto, 
        usoCfdi,
        numeroTicket,
        fecha, 
        id_datos, 
        imagen_ticket
    ) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta: ' . $conn->error);
    }

    // Vincular parámetros
    $stmt->bind_param(
        'idsssss',
        $_SESSION['id_usuario'],
        $monto,
        $_POST['uso_cfdi'],
        $numeroTicket,
        $fecha,
        $_POST['datos_fiscales'],
        $nombreImagen
    );

    // Ejecutar la consulta
    if (!$stmt->execute()) {
        throw new Exception('Error al guardar el ticket: ' . $stmt->error);
    echo 'error al guardar el ticket';
    }

    $idTicket = $stmt->insert_id;
    $stmt->close();

    // Redirigir al usuario con mensaje de éxito
    $_SESSION['mensaje'] = [
        'tipo' => 'success',
        'texto' => "Ticket generado exitosamente" . ($numeroTicket ? ". Número de ticket: {$numeroTicket}" : "")
    ];
    header("Location: generar_qr.php?id={$idTicket}");
    exit;

} catch (Exception $e) {
    // Si hubo un error, redirigir con mensaje de error
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'texto' => $e->getMessage()
    ];
   // header('Location: ../generar-ticket');
    exit;
} finally {
    // Cerrar la conexión
    if (isset($conn)) {
        $conn->close();
    }
}
?>
