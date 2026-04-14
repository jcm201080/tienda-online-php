# 🪵 Leñas Parra - Tienda Online

Ecommerce desarrollado en PHP y MySQL para la venta de leña online.  
Proyecto enfocado a simular una tienda real con carrito, pedidos y panel de administración.

---

## 🚀 Funcionalidades actuales

### 🛍️ Tienda

* Catálogo dinámico de productos desde base de datos
* Diseño en grid responsive (desktop, tablet, móvil)
* Imágenes de productos con fallback automático (`default.jpg`)
* Etiquetas por tipo de leña (encina, olivo, pino)
* Navegación con menú activo
* Página de inicio tipo landing

---

### 🛒 Carrito

* Carrito con sesiones
* Añadir productos
* Gestión de cantidades
* Eliminación de productos
* Cálculo automático del total
* Diseño visual tipo ecommerce

---

### 👤 Usuarios

* Registro de usuarios
* Login con contraseña encriptada
* Sesión persistente
* Datos de usuario (dirección, ciudad, CP)

---

### 📦 Pedidos

* Creación de pedidos desde carrito
* Asociación a usuario (o invitado)
* Guardado en base de datos
* Tabla `detalle_pedido` con productos
* Gestión de estado y pago
* Relación correcta entre pedidos y usuarios mediante `usuario_id` (modelo relacional)
* Eliminación de duplicidades por nombre de cliente
* Mejora en consultas mediante JOIN con tabla usuarios

---

### 👥 Gestión de clientes (Admin)

* Listado de clientes registrados
* Búsqueda por nombre o email
* Exclusión automática de usuarios administradores
* Número de pedidos por cliente
* Total gastado por cliente
* Identificación de clientes VIP (más de 1000€)
* Acceso al perfil completo del cliente

### 👤 Perfil de cliente

* Visualización de datos personales (dirección, ciudad, CP)
* Historial completo de pedidos
* Detalle de productos por pedido
* Estados de pedido y pago
* Estadísticas:
  * Total gastado
  * Número de pedidos
  * Clasificación VIP

### 🧾 Facturación

* Generación de factura por pedido
* Visualización detallada:
  * Productos
  * Cantidad
  * Precio
  * Total
* Diseño preparado para impresión
* Base preparada para exportación a PDF

### 🛠️ Panel de administración

#### 📊 Dashboard

* 💸 Total ganado
* 📦 Pedidos pendientes
* ⚠️ Pedidos no pagados
* Filtros por estado

#### 📦 Gestión de productos (CRUD completo)

* ➕ Crear productos
* ✏️ Editar productos
* 🗑️ Eliminar productos
* 📸 Subida de imágenes
* 👁️ Vista previa de imagen
* 🌳 Selección de tipo de leña

---

## 🧠 Características técnicas destacadas

* Sistema de rutas dinámicas (`BASE_URL`) compatible con local y VPS
* Auto-reparación de base de datos:
  * Añade columnas automáticamente (`imagen`, `tipo`)
* Uso de `default.jpg` para evitar errores de imagen
* Código modular con `header` y `footer`
* Separación de estilos por páginas
* Modelo de datos relacional mejorado:
  * Uso de claves foráneas (`usuario_id`)
  * Eliminación de dependencias por nombre
* Uso de JOINs para consultas eficientes
* Preparado para escalabilidad real (estructura tipo ecommerce profesional)

---

## 🛠️ Tecnologías

* PHP (backend)
* MySQL (base de datos)
* HTML5
* CSS3 (sin frameworks)
* XAMPP (entorno local)

---

## 📂 Estructura del proyecto
mi_tienda_php/
│
├── config/ # Conexión a BD
├── views/
│ └── partials/ # Header y Footer
├── public/
│ ├── css/
│ ├──  img/
| └── js /ia.js              ← frontend del chat
|──ia/
|    chat.php           ← endpoint (backend)
|    prompts.php        ← lógica + prompt base
|    respuestas.php     ← fallback sin IA
│
├── index.php # Landing
├── tienda.php # Catálogo
├── carrito.php
├── login.php
├── registro.php
│
├── admin.php
├── admin_productos.php
├── crear_producto.php
├── editar_producto.php
├── guardar_producto.php
├── actualizar_producto.php
├── eliminar_producto.php
│
├── agregar_carrito.php
├── eliminar_carrito.php
├── procesar_pedido.php
├── cambiar_estado.php
├── cambiar_pago.php
├── admin_clientes.php
├── cliente_detalle.php
├── factura_pedido.php
|── views/partials/
       ia_chat.php        ← HTML del chat (lo metes en footer)
       footer.php
       header.php



---

## ⚡ Cómo ejecutar el proyecto

1. Clonar el repositorio
2. Copiar en `htdocs` (XAMPP)
3. Iniciar Apache y MySQL
4. Crear base de datos:
tienda_lena

5. Crear tablas:

* productos
* usuarios
* pedidos
* detalle_pedido

6. Añadir carpeta:
5. Crear tablas:

* productos
* usuarios
* pedidos
* detalle_pedido

6. Añadir carpeta:

/public/img/

con archivo:

default.jpg


7. Acceder a:

http://localhost/mi_tienda_php

---

## 🌐 Despliegue en VPS

El sistema detecta automáticamente el entorno:

* Local → configuración XAMPP
* VPS → configuración producción

Además:
* Crea automáticamente columnas faltantes en la base de datos
* Evita errores por imágenes inexistentes

---

## 📌 Próximas mejoras

### 🎨 Frontend

* Hover en tarjetas de productos
* Animaciones en botones
* Badge “🔥 Más vendido”
* Carrito lateral tipo Amazon
* Área privada de cliente ("Mis pedidos")
* Descarga de facturas en PDF
* Envío de facturas por email
* Sistema de numeración de facturas
* Panel de métricas avanzadas (clientes top, ventas por mes)

---

### 🛒 Ecommerce

* Métodos de pago (simulados)
* Confirmación de pedido
* Historial de pedidos por usuario

---

### 🔐 Seguridad

* Protección contra SQL Injection (prepared statements)
* Validación de formularios
* Mejora de sesiones

---

## 🧠 Aprendizajes clave

* Diseño de base de datos relacional
* Gestión de sesiones en PHP
* Desarrollo de un flujo completo de ecommerce
* Implementación de panel de administración funcional
* Separación de lógica, vistas y estilos

### 🤖 Extras

* Asistente con IA (chat para clientes)
* Recomendación de productos
* Filtros por tipo de leña

---

## 💡 Autor

Jesús  
Proyecto práctico enfocado a desarrollo web y ecommerce real 🚀