-- Script para crear tabla de contactos frecuentes simplificada
-- Esta tabla almacenará información básica de empresas/comercios frecuentes
-- para reutilizar automáticamente cuando se genere un ticket

-- Crear tabla de contactos frecuentes simplificada
CREATE TABLE `contactosFrecuentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(100) NOT NULL COMMENT 'Nombre de la empresa o comercio',
  `telefono` varchar(20) NOT NULL COMMENT 'Número de teléfono principal',
  `categoria` varchar(50) DEFAULT NULL COMMENT 'Categoría del negocio (restaurante, tienda, etc.)',
  `notas` text DEFAULT NULL COMMENT 'Notas adicionales sobre el contacto',
  `frecuencia_uso` int(11) DEFAULT 0 COMMENT 'Contador de veces usado',
  `ultimo_uso` datetime DEFAULT NULL COMMENT 'Última vez que se usó',
  `creado_por` int(11) DEFAULT NULL COMMENT 'Usuario que creó el contacto',
  `creado_en` datetime DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estatus` tinyint(1) DEFAULT 1 COMMENT '1=activo, 0=inactivo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `telefono_unico` (`telefono`),
  KEY `idx_nombre_empresa` (`nombre_empresa`),
  KEY `idx_categoria` (`categoria`),
  KEY `idx_frecuencia` (`frecuencia_uso`),
  KEY `idx_ultimo_uso` (`ultimo_uso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear tabla para historial de uso de contactos
CREATE TABLE `historialContactos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_contacto` int(11) NOT NULL COMMENT 'ID del contacto frecuente usado',
  `id_ticket` int(11) NOT NULL COMMENT 'ID del ticket donde se usó',
  `id_usuario` int(11) NOT NULL COMMENT 'Usuario que usó el contacto',
  `fecha_uso` datetime DEFAULT current_timestamp(),
  `datos_usados` text DEFAULT NULL COMMENT 'JSON con los datos específicos que se usaron',
  PRIMARY KEY (`id`),
  KEY `idx_contacto` (`id_contacto`),
  KEY `idx_ticket` (`id_ticket`),
  KEY `idx_usuario` (`id_usuario`),
  KEY `idx_fecha_uso` (`fecha_uso`),
  CONSTRAINT `fk_historial_contacto` FOREIGN KEY (`id_contacto`) REFERENCES `contactosFrecuentes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_historial_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_historial_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar algunos contactos de ejemplo
INSERT INTO `contactosFrecuentes` (`nombre_empresa`, `telefono`, `categoria`, `notas`) VALUES
('Restaurante El Buen Sabor', '5551234567', 'Restaurante', 'Comida mexicana, horario 8:00-22:00'),
('Farmacia San José', '5559876543', 'Farmacia', 'Atención 24 horas, entrega a domicilio'),
('Supermercado Central', '5555555555', 'Supermercado', 'Productos frescos, estacionamiento gratuito');

-- Crear función para buscar contacto por teléfono
DELIMITER //
CREATE FUNCTION `buscarContactoFrecuente`(telefono_buscar VARCHAR(20)) 
RETURNS INT
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE contacto_id INT DEFAULT NULL;
    
    -- Buscar por teléfono principal
    SELECT id INTO contacto_id 
    FROM contactosFrecuentes 
    WHERE telefono = telefono_buscar
    AND estatus = 1
    LIMIT 1;
    
    -- Si se encuentra, actualizar frecuencia y último uso
    IF contacto_id IS NOT NULL THEN
        UPDATE contactosFrecuentes 
        SET frecuencia_uso = frecuencia_uso + 1,
            ultimo_uso = NOW()
        WHERE id = contacto_id;
    END IF;
    
    RETURN contacto_id;
END //
DELIMITER ;

-- Crear procedimiento para obtener datos del contacto
DELIMITER //
CREATE PROCEDURE `obtenerDatosContacto`(IN contacto_id INT)
BEGIN
    SELECT 
        nombre_empresa,
        telefono,
        categoria,
        notas
    FROM contactosFrecuentes 
    WHERE id = contacto_id AND estatus = 1;
END //
DELIMITER ;

-- Crear trigger para actualizar timestamp de actualización
DELIMITER //
CREATE TRIGGER `actualizar_timestamp_contactos` 
BEFORE UPDATE ON `contactosFrecuentes`
FOR EACH ROW
BEGIN
    SET NEW.actualizado_en = NOW();
END //
DELIMITER ;

-- Comentarios sobre la funcionalidad simplificada:
-- 
-- 1. TABLA contactosFrecuentes (SIMPLIFICADA):
--    - Solo campos esenciales: nombre, teléfono, categoría, notas
--    - Campo único en teléfono para evitar duplicados
--    - Contador de frecuencia de uso
--    - Categorización para mejor organización
--    - Notas para información adicional personalizada
--
-- 2. TABLA historialContactos:
--    - Registra cada vez que se usa un contacto
--    - Permite análisis de uso y estadísticas
--    - Mantiene trazabilidad completa
--
-- 3. FUNCIÓN buscarContactoFrecuente:
--    - Busca automáticamente por número de teléfono
--    - Actualiza contadores automáticamente
--    - Retorna ID del contacto encontrado
--
-- 4. PROCEDIMIENTO obtenerDatosContacto:
--    - Obtiene solo los datos básicos del contacto
--    - Solo retorna contactos activos
--    - Formato simple para usar en tickets
--
-- USO EN LA APLICACIÓN:
-- 1. Al generar ticket, buscar por teléfono
-- 2. Si se encuentra, mostrar nombre, categoría y notas
-- 3. Si no se encuentra, sugerir agregar nuevo contacto
-- 4. Opción para agregar contacto con datos mínimos
