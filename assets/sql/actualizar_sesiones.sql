ALTER TABLE sesiones
ADD COLUMN ultima_actividad DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
ADD INDEX idx_ultima_actividad (ultima_actividad); 