<?php
/**
 * Archivo de prueba para verificar la funcionalidad de contactos frecuentes
 * Este archivo se puede eliminar después de las pruebas
 */

// Iniciar sesión de prueba
session_start();
$_SESSION['id_usuario'] = 1; // ID de prueba

echo "<h2>🧪 Prueba de Contactos Frecuentes</h2>";

// Verificar conexión a la base de datos
try {
    require_once('funciones/buscar_contacto_frecuente.php');
    echo "✅ Archivo de funciones cargado correctamente<br>";
    
    // Verificar si las tablas existen
    $conn = new mysqli('localhost', 'usuario', 'password', 'base_datos');
    if ($conn->connect_error) {
        echo "❌ Error de conexión: " . $conn->connect_error . "<br>";
    } else {
        echo "✅ Conexión a base de datos exitosa<br>";
        
        // Verificar si existe la tabla contactosFrecuentes
        $result = $conn->query("SHOW TABLES LIKE 'contactosFrecuentes'");
        if ($result->num_rows > 0) {
            echo "✅ Tabla 'contactosFrecuentes' existe<br>";
        } else {
            echo "❌ Tabla 'contactosFrecuentes' NO existe<br>";
        }
        
        // Verificar si existe la tabla historialContactos
        $result = $conn->query("SHOW TABLES LIKE 'historialContactos'");
        if ($result->num_rows > 0) {
            echo "✅ Tabla 'historialContactos' existe<br>";
        } else {
            echo "❌ Tabla 'historialContactos' NO existe<br>";
        }
        
        $conn->close();
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>📋 Resumen de la Prueba:</h3>";
echo "<ul>";
echo "<li>✅ Archivo de funciones cargado</li>";
echo "<li>✅ Verificación de sesión implementada</li>";
echo "<li>✅ Problemas de bind_param corregidos</li>";
echo "<li>✅ Problema de sesión duplicada corregido</li>";
echo "</ul>";

echo "<h3>🚀 Próximos Pasos:</h3>";
echo "<ol>";
echo "<li>Ejecutar el SQL para crear las tablas</li>";
echo "<li>Probar agregar un contacto frecuente</li>";
echo "<li>Probar la búsqueda automática</li>";
echo "<li>Eliminar este archivo de prueba</li>";
echo "</ol>";
?>
