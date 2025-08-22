<?php
/**
 * Archivo de prueba para verificar la variable $ruta
 * Este archivo se puede eliminar después de las pruebas
 */

// Simular la variable $ruta como si fuera "cliente"
$ruta = 'cliente';

echo "<h2>🧪 Prueba de Variable \$ruta</h2>";
echo "<p><strong>Valor de \$ruta:</strong> " . $ruta . "</p>";
echo "<p><strong>Ruta completa:</strong> " . $ruta . "/contactos-frecuentes.php</p>";

// Verificar si el archivo existe
$archivo_a_incluir = $ruta . "/contactos-frecuentes.php";
if (file_exists($archivo_a_incluir)) {
    echo "<p style='color: green;'>✅ El archivo existe: " . $archivo_a_incluir . "</p>";
} else {
    echo "<p style='color: red;'>❌ El archivo NO existe: " . $archivo_a_incluir . "</p>";
}

// Verificar la estructura de directorios
echo "<h3>📁 Estructura de Directorios:</h3>";
echo "<ul>";
echo "<li>Directorio actual: " . getcwd() . "</li>";
echo "<li>Directorio cliente: " . (is_dir('cliente') ? '✅ Existe' : '❌ No existe') . "</li>";
echo "<li>Archivo en cliente: " . (file_exists('cliente/contactos-frecuentes.php') ? '✅ Existe' : '❌ No existe') . "</li>";
echo "</ul>";

echo "<hr>";
echo "<h3>🔧 Solución:</h3>";
echo "<p>La variable \$ruta debe contener solo el nombre del tipo de usuario (cliente, empresa, etc.)</p>";
echo "<p>La ruta completa será: \$ruta . '/contactos-frecuentes.php'</p>";
echo "<p>Para el usuario 'cliente': cliente/contactos-frecuentes.php</p>";
?>
