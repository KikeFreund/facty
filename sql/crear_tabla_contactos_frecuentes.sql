-- Script para crear tabla de contactos frecuentes
-- Esta tabla almacenará información de empresas/comercios frecuentes
-- para reutilizar automáticamente cuando se genere un ticket

-- Crear tabla de contactos frecuentes
CREATE TABLE `contactosFrecuentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(100) NOT NULL COMMENT 'Nombre de la empresa o comercio',
  `telefono` varchar(20) NOT NULL COMMENT 'Número de teléfono principal',
  `telefono_alternativo` varchar(20) DEFAULT NULL COMMENT 'Número alternativo si existe',
  `rfc` varchar(20) DEFAULT NULL COMMENT 'RFC de la empresa si está disponible',
  `razon_social` varchar(150) DEFAULT NULL COMMENT 'Razón social completa',
  `direccion` text DEFAULT NULL COMMENT 'Dirección completa',
  `colonia` varchar(100) DEFAULT NULL,
  `municipio` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
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
INSERT INTO `contactosFrecuentes` (`nombre_empresa`, `telefono`, `rfc`, `razon_social`, `direccion`, `colonia`, `municipio`, `estado`, `codigo_postal`, `categoria`) VALUES
('Restaurante El Buen Sabor', '5551234567', 'RBS001010ABC', 'Restaurante El Buen Sabor S.A. de C.V.', 'Av. Principal 123', 'Centro', 'Cuauhtémoc', 'Chihuahua', '31000', 'Restaurante'),
('Farmacia San José', '5559876543', 'FSJ002020DEF', 'Farmacia San José S.A. de C.V.', 'Calle Secundaria 456', 'San José', 'Chihuahua', 'Chihuahua', '31000', 'Farmacia'),
('Supermercado Central', '5555555555', 'SMC003030GHI', 'Supermercado Central S.A. de C.V.', 'Blvd. Comercial 789', 'Zona Comercial', 'Chihuahua', 'Chihuahua', '31000', 'Supermercado');

-- Crear función para buscar contacto por teléfono
DELIMITER //
CREATE FUNCTION `buscarContactoFrecuente`(telefono_buscar VARCHAR(20)) 
RETURNS INT
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE contacto_id INT DEFAULT NULL;
    
    -- Buscar por teléfono principal o alternativo
    SELECT id INTO contacto_id 
    FROM contactosFrecuentes 
    WHERE (telefono = telefono_buscar OR telefono_alternativo = telefono_buscar)
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
        rfc,
        razon_social,
        direccion,
        colonia,
        municipio,
        estado,
        codigo_postal,
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

-- Comentarios sobre la funcionalidad:
-- 
-- 1. TABLA contactosFrecuentes:
--    - Almacena información de empresas/comercios frecuentes
--    - Campo único en teléfono para evitar duplicados
--    - Contador de frecuencia de uso
--    - Categorización para mejor organización
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
--    - Obtiene todos los datos del contacto
--    - Solo retorna contactos activos
--    - Formato consistente para usar en tickets
--
-- USO EN LA APLICACIÓN:
-- 1. Al generar ticket, buscar por teléfono
-- 2. Si se encuentra, usar datos del contacto
-- 3. Si no se encuentra, usar datos del cliente
-- 4. Opción para agregar nuevo contacto frecuente
