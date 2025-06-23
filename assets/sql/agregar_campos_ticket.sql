-- Script para agregar campos descripcion y foto_ticket a la tabla ticket
-- Ejecutar este script en la base de datos para actualizar la estructura

-- Agregar campo descripcion
ALTER TABLE ticket ADD COLUMN descripcion VARCHAR(200) NULL COMMENT 'Descripción del ticket o compra';

-- Agregar campo foto_ticket
ALTER TABLE ticket ADD COLUMN foto_ticket VARCHAR(255) NULL COMMENT 'Nombre del archivo de la foto tomada del ticket';

-- Crear directorio para fotos de tickets si no existe
-- Nota: Este comando debe ejecutarse en el servidor, no en la base de datos
-- mkdir -p /ruta/al/proyecto/archivos/fotos_tickets

-- Verificar que los campos se agregaron correctamente
DESCRIBE ticket; 