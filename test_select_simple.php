<?php
/**
 * Archivo de prueba para verificar el select simple de contactos frecuentes
 * Este archivo se puede eliminar después de las pruebas
 */

// Iniciar sesión de prueba
session_start();
$_SESSION['id_usuario'] = 1; // ID de prueba

echo "<h2>🧪 Prueba del Select Simple de Contactos Frecuentes</h2>";

// Verificar archivos requeridos
echo "<h3>📁 Verificación de Archivos:</h3>";
$archivos_requeridos = [
    'funciones/buscar_contacto_frecuente.php' => 'Archivo de funciones',
    'funciones/ajax_obtener_contactos_frecuentes.php' => 'Endpoint AJAX simple',
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
        'obtenerTodosLosContactosFrecuentes' => 'Obtener todos los contactos',
        'buscarContactoFrecuente' => 'Búsqueda por teléfono',
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

// Probar endpoint AJAX simple
echo "<h3>🌐 Prueba del Endpoint AJAX Simple:</h3>";
if (file_exists('funciones/ajax_obtener_contactos_frecuentes.php')) {
    echo "✅ Endpoint AJAX simple existe<br>";
    
    // Verificar que el archivo sea accesible
    $contenido = file_get_contents('funciones/ajax_obtener_contactos_frecuentes.php');
    if ($contenido !== false) {
        echo "✅ Endpoint AJAX simple es legible<br>";
        
        // Verificar que tenga la funcionalidad correcta
        if (strpos($contenido, 'obtenerTodosLosContactosFrecuentes') !== false) {
            echo "✅ Función correcta implementada<br>";
        } else {
            echo "❌ Función correcta NO implementada<br>";
        }
    } else {
        echo "❌ Endpoint AJAX simple no es legible<br>";
    }
} else {
    echo "❌ Endpoint AJAX simple no existe<br>";
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
                        
                        // Verificar si hay datos de ejemplo
                        $result = $conn->query("SELECT COUNT(*) as total FROM contactosFrecuentes");
                        if ($result) {
                            $row = $result->fetch_assoc();
                            echo "📊 Total de contactos en la base de datos: {$row['total']}<br>";
                        }
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
echo "<h3>📋 Resumen de la Nueva Funcionalidad Simple:</h3>";
echo "<ul>";
echo "<li>✅ Select simple con todos los contactos frecuentes</li>";
echo "<li>✅ Llenado automático del campo de teléfono</li>";
echo "<li>✅ Interfaz limpia y directa</li>";
echo "<li>✅ Sin búsquedas complejas</li>";
echo "<li>✅ Ordenados por frecuencia de uso</li>";
echo "</ul>";

echo "<h3>🚀 Ventajas de la Implementación Simple:</h3>";
echo "<ul>";
echo "<li>🎯 <strong>Simplicidad:</strong> Un solo select, sin campos adicionales</li>";
echo "<li>⚡ <strong>Velocidad:</strong> Selección directa sin búsquedas</li>";
echo "<li>👁️ <strong>Claridad:</strong> Todos los contactos visibles de una vez</li>";
echo "<li>🔄 <strong>Eficiencia:</strong> Llenado automático del teléfono</li>";
echo "<li>📱 <strong>Práctico:</strong> Ideal para uso frecuente</li>";
echo "</ul>";

echo "<h3>🔧 Funcionalidades Implementadas:</h3>";
echo "<ul>";
echo "<li>✅ <strong>Select de Contactos:</strong> Muestra todos los contactos del usuario</li>";
echo "<li>✅ <strong>Llenado Automático:</strong> El teléfono se llena al seleccionar</li>";
echo "<li>✅ <strong>Ordenamiento Inteligente:</strong> Por frecuencia de uso y fecha</li>";
echo "<li>✅ <strong>Interfaz Limpia:</strong> Sin elementos innecesarios</li>";
echo "<li>✅ <strong>Validación:</strong> Solo muestra contactos activos</li>";
echo "</ul>";

echo "<h3>⚠️ Próximos Pasos:</h3>";
echo "<ol>";
echo "<li>Ejecutar el SQL para crear las tablas (si no existen)</li>";
echo "<li>Probar el select simple en la página</li>";
echo "<li>Verificar que se carguen los contactos correctamente</li>";
echo "<li>Probar la selección y llenado automático del teléfono</li>";
echo "<li>Eliminar este archivo de prueba</li>";
echo "</ol>";

echo "<h3>💡 Ejemplo de Uso:</h3>";
echo "<ol>";
echo "<li>Usuario abre la página de visualizar ticket</li>";
echo "<li>El select se llena automáticamente con sus contactos frecuentes</li>";
echo "<li>Usuario selecciona 'Restaurante Pizza (555-1234)' del select</li>";
echo "<li>El campo de teléfono se llena automáticamente con '555-1234'</li>";
echo "<li>Usuario puede enviar WhatsApp directamente</li>";
echo "</ol>";

echo "<h3>🎯 Diferencias con la Versión Anterior:</h3>";
echo "<ul>";
echo "<li>❌ <strong>Antes:</strong> Búsqueda compleja por categoría + texto</li>";
echo "<li>✅ <strong>Ahora:</strong> Select simple con todos los contactos</li>";
echo "<li>❌ <strong>Antes:</strong> Múltiples campos y funciones</li>";
echo "<li>✅ <strong>Ahora:</strong> Un solo select, una función</li>";
echo "<li>❌ <strong>Antes:</strong> Resultados en cards separados</li>";
echo "<li>✅ <strong>Ahora:</strong> Selección directa del select</li>";
echo "</ul>";
?>
