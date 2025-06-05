<?php
require('../assets/php/conexiones/conexionMySqli.php');

// Verificamos si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_archivo = trim($_POST['nombre_archivo']);
    $ticket_id = trim($_POST['ticket_id']);

    // Archivos
    $pdf = $_FILES['archivo_pdf'];
    $xml = $_FILES['archivo_xml'];

    // Validación básica
    $errores = [];

    // Validar extensiones
    $ext_pdf = strtolower(pathinfo($pdf['name'], PATHINFO_EXTENSION));
    $ext_xml = strtolower(pathinfo($xml['name'], PATHINFO_EXTENSION));

    if ($ext_pdf !== 'pdf') $errores[] = "El archivo PDF no es válido.";
    if ($ext_xml !== 'xml') $errores[] = "El archivo XML no es válido.";

    // Verifica errores
    if (empty($errores)) {
        $carpeta = 'facturas/';
        $nombre_pdf = uniqid("pdf_") . '.pdf';
        $nombre_xml = uniqid("xml_") . '.xml';

        $ruta_pdf = $carpeta . $nombre_pdf;
        $ruta_xml = $carpeta . $nombre_xml;

        // Mover archivos
        if (move_uploaded_file($pdf['tmp_name'], $ruta_pdf) && move_uploaded_file($xml['tmp_name'], $ruta_xml)) {

            // Insertar en la BD
            $stmt = $conn->prepare("INSERT INTO facturas (ticket_id, nombre_archivo, archivo_pdf, archivo_xml, creado_en) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssss", $ticket_id, $nombre_archivo, $ruta_pdf, $ruta_xml);

            if ($stmt->execute()) {
                echo "Factura subida correctamente.";
            } else {
                echo "Error al guardar en la base de datos: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error al mover los archivos.";
        }
    } else {
        foreach ($errores as $e) {
            echo "<p style='color:red;'>$e</p>";
        }
    }
} else {
    echo "Acceso no permitido.";
}
?>
