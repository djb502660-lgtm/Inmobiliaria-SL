## 🏠 Inmobiliaria-SL (Web)

Aplicación web inmobiliaria desarrollada en **Laravel 12**, para la publicación, búsqueda y gestión de propiedades en la ciudad de **San Lorenzo**.

Incluye autenticación con roles, panel de administración, aprobación de publicaciones, chat inteligente de ayuda y mensajería privada comprador–vendedor.

---

## ✨ Funcionalidades principales

- **Roles de usuario**
  - Visitante: navega por el listado público y ve el detalle de propiedades aprobadas.
  - Usuario registrado (propietario): publica, edita, elimina y marca como “operación cerrada” sus propiedades.
  - Administrador: aprueba/rechaza publicaciones, ve estadísticas y supervisa conversaciones de chat.

- **Autenticación y seguridad**
  - Registro con nombre, correo y contraseña.
  - Inicio/cierre de sesión.
  - Redirección automática:
    - Admin → panel `/admin/dashboard`.
    - Usuario → listado público de propiedades.

- **Gestión de propiedades**
  - Campos: título, descripción, precio, tipo de operación (venta/arriendo), categoría, dirección, coordenadas.
  - Subida de múltiples imágenes por propiedad.
  - Estados:
    - `pending`: pendiente de aprobación.
    - `approved`: visible en el listado público.
    - `rejected`: rechazada por el administrador.
    - `operation_closed`: operación cerrada (vendida/arrendada) y oculta del listado público.

- **Búsqueda y filtrado**
  - Búsqueda por texto (título/dirección).
  - Filtro por categoría.
  - Listado paginado y responsivo con Tailwind CSS.

- **Panel de administración**
  - Métricas: total de usuarios, total de propiedades, propiedades pendientes, operaciones cerradas.
  - Lista de propiedades pendientes con acciones **Aprobar/Rechazar**.
  - Tabla de **últimas conversaciones** (chat privado y chat asistente) con acceso directo a cada chat.

- **Chat inteligente y mensajería privada**
  - **Asistente flotante** (“Ayuda”) disponible en todo el sitio:
    - Responde dudas comunes: registro, publicación, búsqueda, cierre de operación, uso del chat.
    - Guarda las conversaciones en base de datos.
  - **Chat privado comprador–vendedor**:
    - Botón **“Contactar vendedor”** en el detalle de cada propiedad aprobada.
    - Crea un canal de conversación entre comprador y propietario.
    - El administrador puede revisar estas conversaciones desde su panel.
  - Vista **“Mis chats”** para que cada usuario vea todas sus conversaciones activas.

- **Cierre de operación**
  - Desde `Mis Propiedades` el propietario puede marcar una publicación como **“Operación cerrada”**.
  - La propiedad deja de mostrarse en el listado público, pero queda registrada para estadísticas y seguimiento.

---

## 🧱 Tecnologías

- **Backend**: PHP 8.3+, Laravel 12 (MVC).
- **Frontend**: Blade + Tailwind CSS (CDN, mobile-first).
- **Base de datos**: MySQL / MariaDB.
- **Mapas**: Leaflet.js con OpenStreetMap para mostrar la ubicación de cada propiedad.

---

## 🚀 Puesta en marcha local

### Requisitos

- PHP >= 8.2 (recomendado 8.3).
- Composer.
- MySQL/MariaDB.
- Node.js (opcional si se quiere compilar assets).

### Pasos

1. Clonar el repositorio:

```bash
git clone https://github.com/djb502660-lgtm/Inmobiliaria-SL.git
cd Inmobiliaria-SL
```

2. Instalar dependencias PHP:

```bash
composer install
```

3. Configurar entorno:

```bash
cp .env.example .env
php artisan key:generate
```

Editar `.env` para apuntar a tu base de datos (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

4. Ejecutar migraciones:

```bash
php artisan migrate
```

5. Iniciar servidor de desarrollo:

```bash
php artisan serve
```

Luego abrir en el navegador: `http://127.0.0.1:8000`.

---

## 👤 Roles y acceso rápido

- **Visitante**
  - Página de inicio con hero y botón “CONOCER MÁS”.
  - Listado público: `/properties`.
  - Detalle de propiedad con galería de imágenes y mapa.

- **Propietario (usuario registrado)**
  - Registro: `/register`.
  - Inicio de sesión: `/login`.
  - Mis propiedades: `/my-properties`.
  - Publicar propiedad: botón desde `Mis Propiedades`.
  - Mis chats: `/my-chats`.

- **Administrador**
  - Acceso al panel: `/admin/dashboard` (requiere usuario con `role = 'admin'` en tabla `users`).
  - Desde ahí puede aprobar/rechazar propiedades y ver chats.

---

## 📄 Licencia

Proyecto basado en el esqueleto oficial de Laravel, licenciado bajo [MIT](https://opensource.org/licenses/MIT).
