<?php
/**
 * Archivo de prueba simple para verificar contactos frecuentes
 * Este archivo se puede eliminar después de las pruebas
 */

// Iniciar sesión de prueba
session_start();
$_SESSION['id_usuario'] = 1; // ID de prueba

echo "<h2>🧪 Prueba Simple de Contactos Frecuentes</h2>";

// Verificar archivos requeridos
echo "<h3>📁 Verificación de Archivos:</h3>";
$archivos_requeridos = [
    'funciones/buscar_contacto_frecuente.php' => 'Archivo de funciones',
    'funciones/ajax_obtener_contactos_frecuentes.php' => 'Endpoint AJAX',
    'assets/php/conexiones/conexionMySqli.php' => 'Conexión a BD'
];

foreach ($archivos_requeridos as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "✅ $descripcion: $archivo<br>";
    } else {
        echo "❌ $descripcion: $archivo<br>";
    }
}

// Probar conexión a base de datos
echo "<h3>🗄️ Prueba de Conexión:</h3>";
try {
    require_once('assets/php/conexiones/conexionMySqli.php');
    
    if (isset($conn) && $conn) {
        echo "✅ Conexión a base de datos establecida<br>";
        
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
    }
    
} catch (Exception $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "<br>";
}

// Probar función de contactos
echo "<h3>🔧 Prueba de Funciones:</h3>";
try {
    require_once('funciones/buscar_contacto_frecuente.php');
    
    if (function_exists('obtenerTodosLosContactosFrecuentes')) {
        echo "✅ Función obtenerTodosLosContactosFrecuentes existe<br>";
        
        // Probar la función
        $contactos = obtenerTodosLosContactosFrecuentes();
        if (is_array($contactos)) {
            echo "✅ Función retorna array con " . count($contactos) . " contactos<br>";
        } else {
            echo "❌ Función no retorna array<br>";
        }
    } else {
        echo "❌ Función obtenerTodosLosContactosFrecuentes NO existe<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error al cargar funciones: " . $e->getMessage() . "<br>";
}

// Probar endpoint AJAX
echo "<h3>🌐 Prueba del Endpoint AJAX:</h3>";
$url = 'funciones/ajax_obtener_contactos_frecuentes.php';
echo "URL: $url<br>";

if (file_exists($url)) {
    echo "✅ Endpoint existe<br>";
    
    // Simular llamada AJAX
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => 'Content-Type: application/json'
        ]
    ]);
    
    $response = file_get_contents($url, false, $context);
    if ($response !== false) {
        echo "✅ Endpoint responde<br>";
        $data = json_decode($response, true);
        if ($data) {
            echo "✅ Respuesta JSON válida<br>";
            echo "Success: " . ($data['success'] ? 'Sí' : 'No') . "<br>";
            echo "Mensaje: " . $data['message'] . "<br>";
            echo "Total contactos: " . $data['total'] . "<br>";
        } else {
            echo "❌ Respuesta no es JSON válido<br>";
        }
    } else {
        echo "❌ Endpoint no responde<br>";
    }
} else {
    echo "❌ Endpoint no existe<br>";
}

echo "<hr>";
echo "<h3>📋 Resumen:</h3>";
echo "<p>Si ves errores arriba, esos son los problemas que necesitan resolverse.</p>";
echo "<p>Si todo está bien, el select de contactos debería funcionar en la página principal.</p>";
?>
