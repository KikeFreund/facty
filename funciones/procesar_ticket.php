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

// Función para procesar foto tomada con la cámara
function procesarFotoCamara($datosBase64) {
    // Verificar que los datos no estén vacíos
    if (empty($datosBase64)) {
        return null;
    }

    // Crear directorio si no existe
    $directorio = '../../archivos/fotos_tickets/';
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // Generar nombre único para el archivo
    $nombreArchivo = uniqid('foto_ticket_') . '.jpg';
    $rutaCompleta = $directorio . $nombreArchivo;

    // Decodificar y guardar la imagen
    $datosImagen = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $datosBase64));
    
    if (file_put_contents($rutaCompleta, $datosImagen) === false) {
        throw new Exception('Error al guardar la foto de la cámara.');
    }

    return $nombreArchivo;
}

try {
    // Debug de datos recibidos
    echo "<pre>";
    echo "POST recibido:\n";
    print_r($_POST);
    echo "\nFILES recibido:\n";
    print_r($_FILES);
    echo "</pre>";

    // Validar datos requeridos
    $camposRequeridos = ['monto', 'datos_fiscales', 'uso_cfdi', 'descripcion'];
    foreach ($camposRequeridos as $campo) {
        if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
            throw new Exception("El campo {$campo} es requerido.");
        }
    }

    // Debug de campos requeridos
    echo "<pre>";
    echo "Campos requeridos validados:\n";
    foreach ($camposRequeridos as $campo) {
        echo "{$campo}: " . ($_POST[$campo] ?? 'no definido') . "\n";
    }
    echo "</pre>";

    // Validar monto
    $monto = filter_var($_POST['monto'], FILTER_VALIDATE_FLOAT);
    if ($monto === false || $monto <= 0) {
        throw new Exception('El monto debe ser un número válido mayor a 0.');
    }

    // Debug del monto
    echo "<pre>";
    echo "Monto procesado: {$monto}\n";
    echo "</pre>";

    // Procesar la imagen si se subió una
    $nombreImagen = null;
    if (isset($_FILES['imagen_ticket']) && $_FILES['imagen_ticket']['error'] !== UPLOAD_ERR_NO_FILE) {
        $nombreImagen = procesarImagen($_FILES['imagen_ticket']);
        echo "<pre>";
        echo "Imagen procesada: {$nombreImagen}\n";
        echo "</pre>";
    }

    // Procesar foto de la cámara si se proporcionó
    $nombreFoto = null;
    if (isset($_POST['foto_camara']) && !empty($_POST['foto_camara'])) {
        $nombreFoto = procesarFotoCamara($_POST['foto_camara']);
        echo "<pre>";
        echo "Foto de cámara procesada: {$nombreFoto}\n";
        echo "</pre>";
    }

    // Obtener número de ticket (si se proporcionó)
    $numeroTicket = $_POST['numeroTicket'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fecha = date('Y-m-d H:i:s');

    // Debug de datos finales
    echo "<pre>";
    echo "Datos finales para insertar:\n";
    echo "ID Cliente: {$_SESSION['id_usuario']}\n";
    echo "Monto: {$monto}\n";
    echo "Descripción: {$descripcion}\n";
    echo "Uso CFDI: {$_POST['uso_cfdi']}\n";
    echo "Número Ticket: {$numeroTicket}\n";
    echo "Fecha: {$fecha}\n";
    echo "ID Datos: {$_POST['datos_fiscales']}\n";
    echo "Imagen: {$nombreImagen}\n";
    echo "Foto: {$nombreFoto}\n";
    echo "</pre>";

    // Preparar la consulta SQL
    $query = "INSERT INTO ticket (
        id_cliente, 
        monto, 
        descripcion,
        usoCfdi,
        numeroTicket,
        fecha, 
        id_datos, 
        metodoPago,
        imagen_ticket,
        foto_ticket
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta: ' . $conn->error);
    }

    // Vincular parámetros
    $stmt->bind_param(
        'idssssssss',
        $_SESSION['id_usuario'],
        $monto,
        $descripcion,
        $_POST['uso_cfdi'],
        $numeroTicket,
        $fecha,
        $_POST['datos_fiscales'],
        $_POST['metodopago'],
        $nombreImagen,
        $nombreFoto
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
