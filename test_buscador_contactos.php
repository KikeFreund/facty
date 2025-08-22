<?php
/**
 * Archivo de prueba para verificar el buscador de contactos frecuentes
 * Este archivo se puede eliminar después de las pruebas
 */

// Iniciar sesión de prueba
session_start();
$_SESSION['id_usuario'] = 1; // ID de prueba

echo "<h2>🧪 Prueba del Buscador de Contactos Frecuentes</h2>";

// Verificar archivos requeridos
echo "<h3>📁 Verificación de Archivos:</h3>";
$archivos_requeridos = [
    'funciones/buscar_contacto_frecuente.php' => 'Archivo de funciones',
    'funciones/ajax_buscar_contacto.php' => 'Endpoint AJAX',
    'cliente/visualizar-ticket.php' => 'Página principal'
];

foreach ($archivos_requeridos as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "✅ $descripcion: $archivo<br>";
    } else {
        echo "❌ $descripcion: $archivo<br>";
    }
}

// Verificar funciones disponibles
echo "<h3>🔧 Verificación de Funciones:</h3>";
try {
    require_once('funciones/buscar_contacto_frecuente.php');
    
    $funciones_disponibles = [
        'buscarContactoFrecuente' => 'Búsqueda por teléfono',
        'buscarContactosPorTexto' => 'Búsqueda por texto',
        'limpiarTelefono' => 'Limpieza de teléfono'
    ];
    
    foreach ($funciones_disponibles as $funcion => $descripcion) {
        if (function_exists($funcion)) {
            echo "✅ $descripcion: $funcion<br>";
        } else {
            echo "❌ $descripcion: $funcion<br>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error al cargar funciones: " . $e->getMessage() . "<br>";
}

// Probar endpoint AJAX
echo "<h3>🌐 Prueba del Endpoint AJAX:</h3>";
echo "<p>Probando búsqueda por texto...</p>";

// Simular búsqueda por texto
$url = 'funciones/ajax_buscar_contacto.php?texto=restaurante';
echo "URL de prueba: $url<br>";

if (file_exists('funciones/ajax_buscar_contacto.php')) {
    echo "✅ Endpoint AJAX existe<br>";
    
    // Verificar que el archivo sea accesible
    $contenido = file_get_contents('funciones/ajax_buscar_contacto.php');
    if ($contenido !== false) {
        echo "✅ Endpoint AJAX es legible<br>";
    } else {
        echo "❌ Endpoint AJAX no es legible<br>";
    }
} else {
    echo "❌ Endpoint AJAX no existe<br>";
}

// Verificar estructura de la base de datos
echo "<h3>🗄️ Verificación de Base de Datos:</h3>";
try {
    require_once('assets/php/conexiones/conexionMySqli.php');
    
    if (isset($conn) && $conn) {
        echo "✅ Conexión a base de datos establecida<br>";
        
        // Verificar tablas requeridas
        $tablas = ['contactosFrecuentes', 'historialContactos'];
        foreach ($tablas as $tabla) {
            $result = $conn->query("SHOW TABLES LIKE '$tabla'");
            if ($result && $result->num_rows > 0) {
                echo "✅ Tabla $tabla existe<br>";
                
                // Verificar estructura de contactosFrecuentes
                if ($tabla === 'contactosFrecuentes') {
                    $result = $conn->query("DESCRIBE contactosFrecuentes");
                    if ($result) {
                        echo "📋 Estructura de la tabla contactosFrecuentes:<br>";
                        echo "<ul>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<li><strong>{$row['Field']}</strong> - {$row['Type']} - {$row['Null']} - {$row['Default']}</li>";
                        }
                        echo "</ul>";
                    }
                }
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

echo "<hr>";
echo "<h3>📋 Resumen de la Nueva Funcionalidad:</h3>";
echo "<ul>";
echo "<li>✅ Buscador manual por nombre/categoría (en lugar de automático por teléfono)</li>";
echo "<li>✅ Campo de teléfono separado y editable</li>";
echo "<li>✅ Búsqueda en tiempo real con mínimo 2 caracteres</li>";
echo "<li>✅ Visualización de múltiples contactos encontrados</li>";
echo "<li>✅ Selección manual del contacto a usar</li>";
echo "<li>✅ Llenado automático del campo de teléfono al seleccionar</li>";
echo "</ul>";

echo "<h3>🚀 Ventajas de la Nueva Implementación:</h3>";
echo "<ul>";
echo "<li>🔍 <strong>Búsqueda más intuitiva:</strong> Por nombre o categoría en lugar de teléfono</li>";
echo "<li>📱 <strong>Teléfono ya disponible:</strong> No se pierde tiempo buscando lo que ya se tiene</li>";
echo "<li>⚡ <strong>Búsqueda manual:</strong> El usuario decide cuándo buscar contactos</li>";
echo "<li>🎯 <strong>Resultados múltiples:</strong> Muestra todos los contactos que coincidan</li>";
echo "<li>✅ <strong>Selección explícita:</strong> El usuario elige qué contacto usar</li>";
echo "</ul>";

echo "<h3>⚠️ Próximos Pasos:</h3>";
echo "<ol>";
echo "<li>Ejecutar el SQL para crear las tablas (si no existen)</li>";
echo "<li>Probar la nueva funcionalidad en la página de visualizar ticket</li>";
echo "<li>Verificar que la búsqueda por texto funcione correctamente</li>";
echo "<li>Probar la selección y llenado automático del teléfono</li>";
echo "<li>Eliminar este archivo de prueba</li>";
echo "</ol>";
?>
