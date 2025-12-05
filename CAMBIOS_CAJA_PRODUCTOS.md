# Sistema de Caja y Administración de Productos - UBARRE

**Fecha:** 2025-12-05
**Mejora:** Separación de funcionalidades por roles

---

## 🎯 Objetivo

Separar las funcionalidades de venta y administración:
- **Recepción (tipoUser=4)**: Acceso a módulo "Caja" para registrar ventas
- **Admin (tipoUser=3)**: Acceso completo a finanzas + administración de productos

---

## ✅ Cambios Implementados

### 1. **Nuevo Módulo: Caja** (`/caja.php`)

**Acceso:** Recepción (tipoUser=4) y Admin (tipoUser=3)

#### Funcionalidades:
- ✅ Vista de productos disponibles (cards interactivas)
- ✅ Registro de ventas con 1 click
- ✅ Selección de método de pago (Efectivo/Tarjeta)
- ✅ Estadísticas en tiempo real:
  - Total en efectivo
  - Total en tarjeta
  - Total general del día
  - Número de ventas
- ✅ Historial de ventas del día
- ✅ Actualización automática cada 30 segundos
- ✅ Generación de corte de caja (PDF imprimible)
- ✅ Solo admin puede eliminar ventas

#### Características:
- Interfaz moderna y responsive
- SweetAlert2 para confirmaciones
- AJAX para actualizaciones sin recargar
- Diseño limpio enfocado en velocidad

---

### 2. **Módulo Finanzas Actualizado** (`/app/finanzas.php`)

**Acceso:** SOLO Admin (tipoUser=3)

#### Cambios:
- ❌ **Recepción ya NO tiene acceso** (redirige a inicio)
- ✅ Nueva pestaña "Productos" para administración
- ✅ CRUD completo de productos:
  - Crear nuevo producto
  - Editar producto existente
  - Activar/Desactivar producto
  - Ver todos los productos (activos e inactivos)

#### Funcionalidades Admin:
- Ver todos los productos del sistema
- Agregar nuevos tipos: smoothie, producto, bebida, snack
- Editar nombre, descripción, tipo y precio
- Activar/desactivar productos (afecta visibilidad en Caja)
- Interfaz de tabla con acciones rápidas

---

### 3. **Corte de Caja** (`/app/corte-caja.php`)

#### Características:
- 📄 Documento imprimible
- 📊 Resumen ejecutivo:
  - Total efectivo + número de transacciones
  - Total tarjeta + número de transacciones
  - Total general
- 📋 Detalle completo de ventas
- ✍️ Espacio para firma del responsable
- 🖨️ Optimizado para impresión

#### Información incluida:
- Fecha y hora del corte
- Usuario que generó el corte
- Desglose por método de pago
- Detalle de cada venta (hora, producto, cantidad, precio, método, vendedor)
- Totales parciales y general

---

## 📁 Archivos Nuevos

### Frontend
1. `/app/caja.php` - Módulo de caja para recepción (con UX/UI del admin panel)

### Backend
2. `/app/get-todos-productos.php` - Lista TODOS los productos (admin)
3. `/app/get-producto.php` - Obtener un producto por ID
4. `/app/guardar-producto.php` - Crear nuevo producto
5. `/app/actualizar-producto.php` - Actualizar producto existente
6. `/app/toggle-producto.php` - Activar/desactivar producto
7. `/app/eliminar-venta.php` - Eliminar venta (solo admin)
8. `/app/corte-caja.php` - Generador de corte de caja PDF

### Documentación
9. `/CAMBIOS_CAJA_PRODUCTOS.md` - Este documento

---

## 📝 Archivos Modificados

### 1. `/app/finanzas.php`
**Cambios:**
- Restricción de acceso: Solo admin (tipoUser=3)
- Eliminado sistema de ventas de la interfaz
- Agregada pestaña "Productos" con CRUD
- JavaScript actualizado para administración

### 2. `/app/get-ventas-dia.php`
**Cambios:**
- Agregado campo `id` en SELECT
- Agregado desglose por método de pago
- Response incluye: `por_metodo.efectivo` y `por_metodo.tarjeta`

### 3. `/header.php`
**Cambios:**
- Enlace "💰 Caja" visible para admin y recepción
- Enlace en menú desktop (junto al nombre) → apunta a `app/caja.php`
- Enlace en menú móvil → apunta a `app/caja.php`

---

## 🔐 Permisos por Rol

### Recepción (tipoUser=4)
| Módulo | Acceso | Funciones |
|--------|--------|-----------|
| Caja | ✅ SÍ | Ver productos, registrar ventas, ver historial, corte |
| Finanzas | ❌ NO | Redirige a inicio |
| Admin Panel | ✅ SÍ | Limitado (clases, asistencia, usuarios) |

### Admin (tipoUser=3)
| Módulo | Acceso | Funciones |
|--------|--------|-----------|
| Caja | ✅ SÍ | Todo + eliminar ventas |
| Finanzas | ✅ SÍ | Reportes completos + admin productos |
| Admin Panel | ✅ SÍ | Acceso completo |

---

## 🔄 Flujo de Trabajo

### Para Recepción:

1. **Login** → Sistema automático de limpieza de descuentos
2. **Clic en "💰 Caja"** en header (abre `/app/caja.php`)
3. **Ver productos disponibles** (solo activos)
4. **Clic en producto** → Modal con opciones
5. **Seleccionar método**: Efectivo o Tarjeta
6. **Venta registrada** → Actualiza estadísticas
7. **Fin del día**: Clic en "Generar Corte"
8. **Imprimir corte** → Documento PDF

### Para Admin:

**Administrar Productos:**
1. Login → Panel admin
2. Finanzas → Pestaña "Productos"
3. Ver todos los productos
4. Opciones:
   - Nuevo: Agregar producto
   - Editar: Modificar existente
   - Activar/Desactivar: Controlar visibilidad

**Ver Reportes:**
1. Finanzas → Otras pestañas
2. Home: Gráficas y resumen
3. Transacciones: Movimientos
4. Ventas: Paquetes vendidos
5. Ingresos: Entradas de dinero
6. Egresos: Salidas de dinero

---

## 💾 Base de Datos

### Tabla: `smoothies`
**Nuevos campos ya existentes:**
- `costo` - Precio del producto
- `tipo` - smoothie/producto/bebida/snack
- `activo` - 1=visible en caja, 0=oculto

### Tabla: `ventas`
**Ya existente - sin cambios estructurales**

### Queries Importantes:

```sql
-- Productos activos (para Caja)
SELECT * FROM smoothies WHERE activo = 1 ORDER BY tipo, sabor ASC;

-- Todos los productos (para Admin)
SELECT * FROM smoothies ORDER BY tipo, sabor ASC;

-- Ventas del día con desglose
SELECT
    id, DATE_FORMAT(fecha_venta, '%H:%i') as hora,
    nombre_producto, cantidad, precio_unitario, total,
    vendedor_nombre, metodo_pago
FROM ventas
WHERE DATE(fecha_venta) = CURDATE()
ORDER BY fecha_venta DESC;

-- Corte de caja
SELECT
    SUM(CASE WHEN metodo_pago = 'efectivo' THEN total ELSE 0 END) as total_efectivo,
    SUM(CASE WHEN metodo_pago = 'tarjeta' THEN total ELSE 0 END) as total_tarjeta,
    COUNT(*) as total_ventas
FROM ventas
WHERE DATE(fecha_venta) = CURDATE();
```

---

## 📊 APIs Disponibles

### Públicas (Auth requerido):

#### `GET /app/get-productos.php`
**Permiso:** Recepción + Admin
**Response:**
```json
{
  "success": true,
  "productos": [
    {
      "id": 1,
      "nombre": "Smoothie Verde",
      "descripcion": "Con espinaca",
      "costo": 60.00,
      "tipo": "smoothie",
      "imagen": "./assets/images/smoothies/1.png"
    }
  ]
}
```

#### `GET /app/get-ventas-dia.php`
**Permiso:** Recepción + Admin
**Response:**
```json
{
  "success": true,
  "ventas": [...],
  "total": 480.00,
  "por_metodo": {
    "efectivo": 240.00,
    "tarjeta": 240.00
  }
}
```

#### `POST /app/procesar-venta.php`
**Permiso:** Recepción + Admin
**Body:**
```json
{
  "id_producto": 1,
  "cantidad": 1,
  "metodo_pago": "efectivo"
}
```

### Solo Admin:

#### `GET /app/get-todos-productos.php`
Retorna TODOS los productos (activos e inactivos)

#### `GET /app/get-producto.php?id=1`
Obtener detalles de un producto

#### `POST /app/guardar-producto.php`
Crear nuevo producto

#### `POST /app/actualizar-producto.php`
Actualizar producto existente

#### `POST /app/toggle-producto.php`
Activar/desactivar producto

#### `POST /app/eliminar-venta.php`
Eliminar una venta

---

## 🧪 Testing

### Test 1: Acceso por Roles
1. Login como recepción (tipoUser=4)
2. Verificar enlace "Caja" visible
3. Acceder a `/caja.php` → ✅ OK
4. Intentar `/app/finanzas.php` → ❌ Debe redirigir

### Test 2: Registro de Ventas
1. En Caja, ver productos
2. Click en un producto
3. Seleccionar "Efectivo"
4. Verificar:
   - Alert de éxito
   - Actualización de estadísticas
   - Venta en historial

### Test 3: Corte de Caja
1. Registrar varias ventas (mix efectivo/tarjeta)
2. Click "Generar Corte"
3. Verificar:
   - Totales correctos
   - Desglose por método
   - Detalle completo
   - Formato imprimible

### Test 4: Admin - CRUD Productos
1. Login como admin
2. Finanzas → Productos
3. Crear nuevo producto "Agua"
4. Editar producto (cambiar precio)
5. Desactivar producto
6. Verificar en Caja: No debe aparecer

### Test 5: Eliminación de Ventas (Admin)
1. Login como admin
2. Ir a Caja
3. Ver historial con botón "Eliminar"
4. Eliminar venta
5. Verificar actualización

---

## 🔒 Seguridad

### Validaciones Implementadas:
- ✅ Verificación de sesión en todos los endpoints
- ✅ Validación de permisos por tipoUser
- ✅ Prepared statements en todas las queries
- ✅ Sanitización de inputs con trim()
- ✅ Validación de tipos de datos
- ✅ HTML encoding en outputs (htmlspecialchars)

### Headers de Seguridad:
```php
header('Content-Type: application/json');
http_response_code(403); // Cuando no autorizado
```

---

## 📈 Mejoras Futuras (Opcionales)

1. **Inventario**: Control de stock de productos
2. **Código de Barras**: Scanner para ventas rápidas
3. **Propinas**: Registro de propinas en efectivo
4. **Múltiples Cajas**: Corte por caja/usuario
5. **Historial**: Ver cortes de días anteriores
6. **Exportar**: Excel de ventas mensuales
7. **Notificaciones**: Alert cuando producto se agota

---

## 📞 Soporte

**Errores comunes:**

### "No autorizado" al acceder a Caja
- **Causa:** Sesión expirada o tipoUser incorrecto
- **Solución:** Logout y login nuevamente

### Productos no aparecen en Caja
- **Causa:** Producto está inactivo
- **Solución:** Admin → Finanzas → Productos → Activar

### Corte no se genera
- **Causa:** Bloqueador de popups
- **Solución:** Permitir popups para el sitio

### Ventas no se actualizan
- **Causa:** Error de JavaScript o conexión
- **Solución:** F12 → Console → Verificar errores

---

## 🎨 Diseño

### Colores:
- **Primary:** #986C5D (café übarre)
- **Success:** #28a745 (verde efectivo)
- **Info:** #007bff (azul tarjeta)
- **Danger:** #dc3545 (rojo eliminar)

### Iconos:
- 💰 Caja
- 💵 Efectivo
- 💳 Tarjeta
- 📊 Corte/Reportes
- ✏️ Editar
- ❌ Eliminar/Desactivar
- ✅ Activar

---

**Estado:** ✅ Implementado y funcional
**Versión:** 2.0
**Fecha:** 2025-12-05
