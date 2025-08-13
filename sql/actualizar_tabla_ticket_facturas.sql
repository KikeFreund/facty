-- Script para actualizar la tabla ticket con campos para gestión de facturas
-- Ejecutar este script en la base de datos para agregar las nuevas funcionalidades

-- Agregar campo para estado de factura
ALTER TABLE ticket ADD COLUMN estado_factura ENUM('pendiente', 'facturada', 'recibida_manual') DEFAULT 'pendiente';

-- Agregar campo para nota de factura
ALTER TABLE ticket ADD COLUMN nota_factura TEXT NULL;

-- Agregar campo para fecha de recepción manual
ALTER TABLE ticket ADD COLUMN fecha_recepcion_manual DATETIME NULL;

-- Agregar campo para canal de recepción
ALTER TABLE ticket ADD COLUMN canal_recepcion VARCHAR(50) NULL;

-- Crear índice para mejorar consultas por estado
CREATE INDEX idx_ticket_estado_factura ON ticket(estado_factura);

-- Crear índice para consultas por fecha
CREATE INDEX idx_ticket_fecha ON ticket(fecha);

-- Actualizar registros existentes que ya tienen facturas
UPDATE ticket t 
INNER JOIN facturas f ON t.id = f.ticket_id 
SET t.estado_factura = 'facturada' 
WHERE t.estado_factura = 'pendiente';

-- Comentarios sobre los nuevos campos:
-- estado_factura: 
--   - 'pendiente': Aún no se ha recibido la factura
--   - 'facturada': Se subió la factura al sistema
--   - 'recibida_manual': Se recibió por otro medio (correo, WhatsApp, etc.)
--
-- nota_factura: Almacena información sobre cómo se recibió la factura manualmente
-- fecha_recepcion_manual: Cuándo se marcó como recibida manualmente
-- canal_recepcion: Por qué medio se recibió (correo, WhatsApp, físico, etc.)
