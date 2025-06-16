<?php
require('../assets/php/conexiones/conexionMySqli.php');

function verificarYCrearTablaInvitaciones($conn) {
    // Verificar si la tabla existe
    $result = $conn->query("SHOW TABLES LIKE 'invitaciones'");
    
    if ($result->num_rows === 0) {
        // La tabla no existe, crearla
        $sql = "CREATE TABLE `invitaciones` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_usuario` int(11) NOT NULL COMMENT 'Usuario que envía la invitación',
            `usada` int(11) NOT NULL DEFAULT 0 COMMENT '0 = no usada, 1 = usada',
            `fecha_generacion` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Fecha y hora de generación',
            `id_referido` int(11) NOT NULL DEFAULT 0 COMMENT 'ID del usuario referido (se actualiza cuando se registra)',
            `mensaje` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mensaje personalizado de la invitación',
            PRIMARY KEY (`id`),
            KEY `idx_id_usuario` (`id_usuario`),
            KEY `idx_usada` (`usada`),
            KEY `idx_id_referido` (`id_referido`),
            KEY `idx_fecha_generacion` (`fecha_generacion`),
            KEY `idx_invitacion_usuario` (`id_usuario`, `usada`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla para gestionar invitaciones de usuarios'";
        
        if ($conn->query($sql)) {
            return true; // Tabla creada exitosamente
        } else {
            return false; // Error al crear la tabla
        }
    }
    
    return true; // La tabla ya existe
}

// Ejecutar verificación
if (verificarYCrearTablaInvitaciones($conn)) {
    echo "Tabla de invitaciones verificada/creada correctamente";
} else {
    echo "Error al crear la tabla de invitaciones";
}
?> 