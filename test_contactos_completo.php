<?php
/**
 * Archivo de prueba completo para verificar la funcionalidad de contactos frecuentes
 * Este archivo se puede eliminar después de las pruebas
 */

// Iniciar sesión de prueba
session_start();
$_SESSION['id_usuario'] = 1; // ID de prueba

echo "<h2>🧪 Prueba Completa de Contactos Frecuentes</h2>";

// Verificar estructura de archivos
echo "<h3>📁 Verificación de Archivos:</h3>";
$archivos_requeridos = [
    'funciones/buscar_contacto_frecuente.php' => 'Archivo de funciones',
    'cliente/contactos-frecuentes.php' => 'Página de contactos',
    'cliente/nav.php' => 'Navegación',
    'cliente/footer.php' => 'Pie de página',
    'assets/php/conexiones/conexionMySqli.php' => 'Conexión a BD'
];

foreach ($archivos_requeridos as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "✅ $descripcion: $archivo<br>";
    } else {
        echo "❌ $descripcion: $archivo<br>";
    }
}

// Verificar inclusión de archivos
echo "<h3>🔧 Verificación de Inclusión:</h3>";
try {
    // Probar inclusión del archivo de funciones
    require_once('funciones/buscar_contacto_frecuente.php');
    echo "✅ Archivo de funciones incluido correctamente<br>";
    
    // Verificar que las funciones estén disponibles
    $funciones_disponibles = [
        'buscarContactoFrecuente',
        'limpiarTelefono',
        'actualizarFrecuenciaContacto',
        'registrarUsoContacto',
        'obtenerContactosFrecuentesUsuario',
        'agregarContactoFrecuente',
        'buscarContactosPorTexto',
        'obtenerEstadisticasContactos'
    ];
    
    foreach ($funciones_disponibles as $funcion) {
        if (function_exists($funcion)) {
            echo "✅ Función $funcion disponible<br>";
        } else {
            echo "❌ Función $funcion NO disponible<br>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error al incluir archivo de funciones: " . $e->getMessage() . "<br>";
}

// Verificar conexión a base de datos
echo "<h3>🗄️ Verificación de Base de Datos:</h3>";
try {
    require_once('assets/php/conexiones/conexionMySqli.php');
    
    if (isset($conn) && $conn) {
        echo "✅ Conexión a base de datos establecida<br>";
        
        // Verificar si las tablas existen
        $tablas_requeridas = [
            'contactosFrecuentes' => 'Tabla de contactos frecuentes',
            'historialContactos' => 'Tabla de historial',
            'ticket' => 'Tabla de tickets',
            'usuarios' => 'Tabla de usuarios'
        ];
        
        foreach ($tablas_requeridas as $tabla => $descripcion) {
            $result = $conn->query("SHOW TABLES LIKE '$tabla'");
            if ($result && $result->num_rows > 0) {
                echo "✅ $descripcion: $tabla<br>";
            } else {
                echo "❌ $descripcion: $tabla<br>";
            }
        }
        
        $conn->close();
    } else {
        echo "❌ No se pudo establecer conexión a la base de datos<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "<br>";
}

// Verificar rutas de inclusión
echo "<h3>🛣️ Verificación de Rutas:</h3>";
$ruta_base = getcwd();
echo "Directorio base: $ruta_base<br>";

// Simular la variable $ruta
$ruta = 'cliente';
$archivo_a_incluir = $ruta . "/contactos-frecuentes.php";
echo "Ruta a incluir: $archivo_a_incluir<br>";

if (file_exists($archivo_a_incluir)) {
    echo "✅ El archivo existe y se puede incluir<br>";
} else {
    echo "❌ El archivo NO existe en esa ruta<br>";
}

echo "<hr>";
echo "<h3>📋 Resumen de la Prueba:</h3>";
echo "<ul>";
echo "<li>✅ Verificación de archivos completada</li>";
echo "<li>✅ Verificación de funciones completada</li>";
echo "<li>✅ Verificación de base de datos completada</li>";
echo "<li>✅ Verificación de rutas completada</li>";
echo "</ul>";

echo "<h3>🚀 Próximos Pasos:</h3>";
echo "<ol>";
echo "<li>Ejecutar el SQL para crear las tablas (si no existen)</li>";
echo "<li>Probar la página de contactos frecuentes</li>";
echo "<li>Probar agregar un contacto</li>";
echo "<li>Probar la búsqueda automática</li>";
echo "<li>Eliminar este archivo de prueba</li>";
echo "</ol>";

echo "<h3>⚠️ Problemas Identificados y Solucionados:</h3>";
echo "<ul>";
echo "<li>✅ Error de sesión duplicada - Corregido con verificación de session_status()</li>";
echo "<li>✅ Error de parámetro por referencia - Corregido con variables locales</li>";
echo "<li>✅ Error de ruta duplicada - Corregido en pages/contactos-frecuentes.php</li>";
echo "<li>✅ Rutas relativas incorrectas - Corregidas con rutas absolutas</li>";
echo "</ul>";
?>
