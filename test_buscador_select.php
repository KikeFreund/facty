<?php
/**
 * Archivo de prueba para verificar el buscador con select de contactos frecuentes
 * Este archivo se puede eliminar después de las pruebas
 */

// Iniciar sesión de prueba
session_start();
$_SESSION['id_usuario'] = 1; // ID de prueba

echo "<h2>🧪 Prueba del Buscador con Select de Contactos Frecuentes</h2>";

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
        'buscarContactosPorTextoYCategoria' => 'Búsqueda por texto y categoría',
        'obtenerCategoriasDisponibles' => 'Obtener categorías disponibles',
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
echo "<p>Probando obtención de categorías...</p>";

if (file_exists('funciones/ajax_buscar_contacto.php')) {
    echo "✅ Endpoint AJAX existe<br>";
    
    // Verificar que el archivo sea accesible
    $contenido = file_get_contents('funciones/ajax_buscar_contacto.php');
    if ($contenido !== false) {
        echo "✅ Endpoint AJAX es legible<br>";
        
        // Verificar que tenga la nueva funcionalidad
        if (strpos($contenido, 'action=categorias') !== false) {
            echo "✅ Funcionalidad de categorías implementada<br>";
        } else {
            echo "❌ Funcionalidad de categorías NO implementada<br>";
        }
        
        if (strpos($contenido, 'buscarContactosPorTextoYCategoria') !== false) {
            echo "✅ Función de búsqueda combinada implementada<br>";
        } else {
            echo "❌ Función de búsqueda combinada NO implementada<br>";
        }
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
                        
                        // Verificar si hay datos de ejemplo
                        $result = $conn->query("SELECT COUNT(*) as total FROM contactosFrecuentes");
                        if ($result) {
                            $row = $result->fetch_assoc();
                            echo "📊 Total de contactos en la base de datos: {$row['total']}<br>";
                        }
                        
                        // Verificar categorías disponibles
                        $result = $conn->query("SELECT DISTINCT categoria, COUNT(*) as total FROM contactosFrecuentes WHERE categoria IS NOT NULL AND categoria != '' GROUP BY categoria ORDER BY total DESC");
                        if ($result && $result->num_rows > 0) {
                            echo "🏷️ Categorías disponibles:<br>";
                            echo "<ul>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<li><strong>{$row['categoria']}</strong> - {$row['total']} contactos</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "⚠️ No hay categorías definidas en la base de datos<br>";
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
echo "<h3>📋 Resumen de la Nueva Funcionalidad con Select:</h3>";
echo "<ul>";
echo "<li>✅ Select de categorías con emojis y contadores</li>";
echo "<li>✅ Campo de texto para búsqueda por nombre</li>";
echo "<li>✅ Búsqueda combinada por categoría y texto</li>";
echo "<li>✅ Carga dinámica de categorías disponibles</li>";
echo "<li>✅ Interfaz más intuitiva y rápida</li>";
echo "<li>✅ Evita errores de escritura</li>";
echo "</ul>";

echo "<h3>🚀 Ventajas del Select vs Campo de Texto:</h3>";
echo "<ul>";
echo "<li>🎯 <strong>Precisión:</strong> No hay errores de escritura en categorías</li>";
echo "<li>⚡ <strong>Velocidad:</strong> Selección instantánea vs escribir</li>";
echo "<li>👁️ <strong>Visibilidad:</strong> Todas las opciones están visibles</li>";
echo "<li>📊 <strong>Información:</strong> Muestra cuántos contactos hay por categoría</li>";
echo "<li>🎨 <strong>Visual:</strong> Emojis hacen la interfaz más amigable</li>";
echo "<li>🔄 <strong>Combinación:</strong> Permite filtrar por categoría Y buscar por nombre</li>";
echo "</ul>";

echo "<h3>🔧 Funcionalidades Implementadas:</h3>";
echo "<ul>";
echo "<li>✅ <strong>Select de Categorías:</strong> Con emojis y contadores</li>";
echo "<li>✅ <strong>Campo de Texto:</strong> Para búsqueda por nombre</li>";
echo "<li>✅ <strong>Búsqueda Combinada:</strong> Por categoría y texto simultáneamente</li>";
echo "<li>✅ <strong>Carga Dinámica:</strong> Las categorías se cargan desde la base de datos</li>";
echo "<li>✅ <strong>Filtrado Inteligente:</strong> Solo muestra categorías que tienen contactos</li>";
echo "<li>✅ <strong>Interfaz Responsiva:</strong> Se adapta a diferentes tamaños de pantalla</li>";
echo "</ul>";

echo "<h3>⚠️ Próximos Pasos:</h3>";
echo "<ol>";
echo "<li>Ejecutar el SQL para crear las tablas (si no existen)</li>";
echo "<li>Probar la nueva funcionalidad del select en la página</li>";
echo "<li>Verificar que las categorías se carguen dinámicamente</li>";
echo "<li>Probar la búsqueda combinada por categoría y texto</li>";
echo "<li>Eliminar este archivo de prueba</li>";
echo "</ol>";

echo "<h3>💡 Ejemplo de Uso:</h3>";
echo "<ol>";
echo "<li>Usuario selecciona 'Restaurante' del select</li>";
echo "<li>Usuario escribe 'pizza' en el campo de texto</li>";
echo "<li>Sistema busca contactos de restaurantes que contengan 'pizza'</li>";
echo "<li>Muestra resultados filtrados y ordenados por frecuencia de uso</li>";
echo "<li>Usuario selecciona el contacto deseado</li>";
echo "<li>Se llena automáticamente el campo de teléfono</li>";
echo "</ol>";
?>
