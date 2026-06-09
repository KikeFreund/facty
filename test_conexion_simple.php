<?php
/**
 * Archivo de prueba simple para verificar solo la conexión a la base de datos
 * Este archivo se puede eliminar después de las pruebas
 */

echo "<h2>🧪 Prueba Simple de Conexión a Base de Datos</h2>";

// Verificar archivo de conexión
echo "<h3>📁 Verificación de Archivo de Conexión:</h3>";
$archivo_conexion = 'assets/php/conexiones/conexionMySqli.php';

if (file_exists($archivo_conexion)) {
    echo "✅ Archivo de conexión existe: $archivo_conexion<br>";
} else {
    echo "❌ Archivo de conexión NO existe: $archivo_conexion<br>";
}

// Probar conexión a base de datos
echo "<h3>🗄️ Prueba de Conexión:</h3>";
try {
    require_once($archivo_conexion);
    
    if (isset($conn) && $conn) {
        echo "✅ Conexión a base de datos establecida<br>";
        echo "✅ Host: " . $conn->host_info . "<br>";
        echo "✅ Base de datos: " . $conn->database . "<br>";
        
        // Verificar si existen las tablas
        $tablas = ['contactosFrecuentes', 'historialContactos'];
        foreach ($tablas as $tabla) {
            $result = $conn->query("SHOW TABLES LIKE '$tabla'");
            if ($result && $result->num_rows > 0) {
                echo "✅ Tabla $tabla existe<br>";
            } else {
                echo "❌ Tabla $tabla NO existe<br>";
            }
        }
        
        $conn->close();
    } else {
        echo "❌ No se pudo establecer conexión a la base de datos<br>";
        echo "❌ Variable \$conn no está definida o es null<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "<br>";
    echo "❌ Tipo de error: " . get_class($e) . "<br>";
}

echo "<hr>";
echo "<h3>📋 Resumen:</h3>";
echo "<p>Si ves '❌ Tabla contactosFrecuentes NO existe', necesitas ejecutar el SQL para crear las tablas.</p>";
echo "<p>Si ves '❌ Conexión a base de datos establecida', el problema está en otro lugar.</p>";
?>
