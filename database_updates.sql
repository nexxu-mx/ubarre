-- ============================================
-- ACTUALIZACIONES DE BASE DE DATOS UBARRE
-- ============================================

-- TICKET 1: Modificar tabla smoothies para soportar productos
ALTER TABLE smoothies
ADD COLUMN IF NOT EXISTS costo DECIMAL(10,2) DEFAULT 0.00 AFTER descrip,
ADD COLUMN IF NOT EXISTS tipo VARCHAR(50) DEFAULT 'smoothie' AFTER costo,
ADD COLUMN IF NOT EXISTS activo TINYINT(1) DEFAULT 1 AFTER tipo;

-- Crear tabla de ventas para registrar ventas de productos
CREATE TABLE IF NOT EXISTS ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT UNSIGNED NOT NULL,
    nombre_producto VARCHAR(255) NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    vendedor_id INT NOT NULL,
    vendedor_nombre VARCHAR(255),
    metodo_pago VARCHAR(50) DEFAULT 'efectivo',
    fecha_venta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY idx_producto (id_producto),
    KEY idx_vendedor (vendedor_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TICKET 2: Agregar campo en_espera a reservaciones
ALTER TABLE reservaciones
ADD COLUMN IF NOT EXISTS en_espera TINYINT(1) DEFAULT 0 AFTER activo,
ADD COLUMN IF NOT EXISTS fecha_ingreso_espera TIMESTAMP NULL AFTER en_espera;

-- Crear índice para optimizar búsquedas de lista de espera
CREATE INDEX IF NOT EXISTS idx_en_espera ON reservaciones(en_espera, idClase, fecha_ingreso_espera);

-- ============================================
-- DATOS INICIALES (OPCIONAL)
-- ============================================

-- Actualizar smoothies existentes con precios por defecto
UPDATE smoothies SET costo = 60.00, tipo = 'smoothie', activo = 1 WHERE costo = 0.00 OR costo IS NULL;

-- ============================================
-- FIN DE ACTUALIZACIONES
-- ============================================
