<?php
require_once('../assets/php/conexiones/conexionMySqli.php');


// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../cliente/login.php');
    exit();
}

// Verificar si es una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../cliente/registrar-datos-fiscales.php');
    exit();
}

// Función para validar y procesar el archivo de constancia
function procesarConstancia($archivo, $id_usuario) {
    // Verificar si se subió un archivo
    if (!isset($archivo['constancia']) || $archivo['constancia']['error'] !== UPLOAD_ERR_OK) {
        if (isset($_POST['id_datos'])) {
            return true; // Si es actualización y no se subió archivo, mantener el existente
        }
        throw new Exception('Por favor suba su constancia de situación fiscal');
    }

    $file = $archivo['constancia'];
    
    // Validar tipo de archivo
    $allowed_types = ['application/pdf'];
    if (!in_array($file['type'], $allowed_types)) {
        throw new Exception('Solo se permiten archivos PDF');
    }

    // Validar tamaño (máximo 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new Exception('El archivo es demasiado grande. Máximo 5MB');
    }

    // Crear directorio si no existe
    $upload_dir = '../archivos/constancias/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Generar nombre único para el archivo
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $nombre_archivo = 'constancia_' . $id_usuario . '_' . time() . '.' . $extension;
    $ruta_completa = $upload_dir . $nombre_archivo;

    // Mover el archivo
    if (!move_uploaded_file($file['tmp_name'], $ruta_completa)) {
        throw new Exception('Error al guardar el archivo');
    }

    return 'archivos/constancias/' . $nombre_archivo;
}

try {
    // Validar campos requeridos
    $campos_requeridos = ['razonSocial', 'rfc', 'regimen', 'uso_cfdi', 'correo', 'telefono', 
                         'calle', 'colonia', 'codigoPostal', 'municipio', 'estado'];
    
    foreach ($campos_requeridos as $campo) {
        if (empty($_POST[$campo])) {
            throw new Exception("El campo {$campo} es requerido");
        }
    }

    // Validar RFC
    if (!preg_match('/^[A-ZÑ&]{3,4}[0-9]{6}[A-Z0-9]{3}$/', $_POST['rfc'])) {
        throw new Exception('RFC inválido');
    }

    // Validar correo
    if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Correo electrónico inválido');
    }

    // Validar código postal
    if (!preg_match('/^[0-9]{5}$/', $_POST['codigoPostal'])) {
        throw new Exception('Código postal inválido');
    }

    // Procesar constancia
    $ruta_constancia = procesarConstancia($_FILES, $_SESSION['id_usuario']);

    // Preparar la consulta SQL
    if (isset($_POST['id_datos'])) {
        // Actualización
        $query = "UPDATE datosFiscales SET 
                  razonSocial = ?, rfc = ?, regimen = ?, uso_cfdi = ?, 
                  correo = ?, telefono = ?, calle = ?, colonia = ?, 
                  codigoPostal = ?, municipio = ?, estado = ?";
        
        if ($ruta_constancia !== true) {
            $query .= ", constancia = ?";
        }
        
        $query .= " WHERE id = ? AND id_usuario = ?";
        
        $stmt = $conn->prepare($query);
        
        if ($ruta_constancia === true) {
            $stmt->bind_param("ssiisssssssii", 
                $_POST['razonSocial'], $_POST['rfc'], $_POST['regimen'], $_POST['uso_cfdi'],
                $_POST['correo'], $_POST['telefono'], $_POST['calle'], $_POST['colonia'],
                $_POST['codigoPostal'], $_POST['municipio'], $_POST['estado'],
                $_POST['id_datos'], $_SESSION['id_usuario']
            );
        } else {
            $stmt->bind_param("ssiissssssssii", 
                $_POST['razonSocial'], $_POST['rfc'], $_POST['regimen'], $_POST['uso_cfdi'],
                $_POST['correo'], $_POST['telefono'], $_POST['calle'], $_POST['colonia'],
                $_POST['codigoPostal'], $_POST['municipio'], $_POST['estado'],
                $ruta_constancia, $_POST['id_datos'], $_SESSION['id_usuario']
            );
        }
    } else {
        // Inserción
        $query = "INSERT INTO datosFiscales (id_usuario, razonSocial, rfc, regimen, uso_cfdi, 
                  correo, telefono, calle, colonia, codigoPostal, municipio, estado, constancia) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssissssssss", 
            $_SESSION['id_usuario'], $_POST['razonSocial'], $_POST['rfc'], $_POST['regimen'], 
            $_POST['uso_cfdi'], $_POST['correo'], $_POST['telefono'], $_POST['calle'], 
            $_POST['colonia'], $_POST['codigoPostal'], $_POST['municipio'], $_POST['estado'],
            $ruta_constancia
        );
    }

    // Ejecutar la consulta
    if (!$stmt->execute()) {
        throw new Exception("Error al guardar los datos: " . $stmt->error);
    }

    // Redirigir con mensaje de éxito
    $_SESSION['mensaje'] = "Datos fiscales " . (isset($_POST['id_datos']) ? "actualizados" : "registrados") . " correctamente";
    header('Location: ../cliente/registrar-datos-fiscales.php');
    exit();

} catch (Exception $e) {
    // Redirigir con mensaje de error
    $_SESSION['error'] = $e->getMessage();
    header('Location: ../cliente/registrar-datos-fiscales.php');
    exit();
}
?> 