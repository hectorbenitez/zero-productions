# Zero Productions - Sitio Web de Marketing

Sitio web de marketing para una productora de conciertos y eventos, construido con Laravel 11, Blade y Tailwind CSS. Diseñado para desplegarse en Heroku.

## Características

### Sitio Público
- **Inicio**: Hero section, próximos eventos y CTA
- **Eventos**: Listado de eventos próximos y pasados
- **Detalle de Evento**: Información completa, enlaces de boletos y galería
- **Contacto**: Formulario de contacto e información de la empresa

### Panel de Administración
- Gestión de eventos (CRUD)
- Subida de imágenes (portadas y galerías)
- Enlaces de boletos por evento
- Configuración del sitio
- Mensajes de contacto

### Características Técnicas
- **Almacenamiento de imágenes en base de datos**: Las imágenes se almacenan como bytea en PostgreSQL, compatible con el sistema de archivos efímero de Heroku
- **SEO básico**: Títulos, descripciones y OpenGraph por página
- **URLs limpias**: `/eventos/{slug}`
- **Interfaz en español**

## Requisitos

- PHP 8.2+
- Composer
- Node.js 20+ (para compilar assets)
- PostgreSQL (producción) o SQLite (desarrollo local)

## Instalación Local

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd zero-productions
```

### 2. Instalar dependencias

```bash
composer install
npm install
```

### 3. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Edita `.env` según tus necesidades. Para desarrollo local con SQLite:

```env
DB_CONNECTION=sqlite
# El archivo database/database.sqlite se creará automáticamente
```

### 4. Ejecutar migraciones y seeders

```bash
php artisan migrate
php artisan db:seed
```

Esto creará:
- Usuario admin: `admin@example.com` / `password`
- Configuración inicial del sitio
- Eventos de ejemplo

### 5. Compilar assets

```bash
npm run build
# o para desarrollo:
npm run dev
```

### 6. Iniciar el servidor

```bash
php artisan serve
```

Visita `http://localhost:8000`

## Despliegue en Heroku

### 1. Crear aplicación en Heroku

```bash
heroku create tu-app-name
```

### 2. Agregar PostgreSQL

```bash
heroku addons:create heroku-postgresql:essential-0
```

### 3. Configurar variables de entorno

```bash
# Generar APP_KEY
php artisan key:generate --show
# Copiar el resultado

# Configurar en Heroku
heroku config:set APP_NAME="Zero Productions"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY=base64:TU_KEY_GENERADA
heroku config:set APP_URL=https://tu-app-name.herokuapp.com
heroku config:set LOG_CHANNEL=stderr
heroku config:set SESSION_SECURE_COOKIE=true
heroku config:set DB_CONNECTION=pgsql
```

### 4. Configurar correo (opcional)

Para enviar correos de contacto, configura un servicio SMTP:

```bash
# Ejemplo con Mailgun
heroku config:set MAIL_MAILER=smtp
heroku config:set MAIL_HOST=smtp.mailgun.org
heroku config:set MAIL_PORT=587
heroku config:set MAIL_USERNAME=tu-usuario
heroku config:set MAIL_PASSWORD=tu-password
heroku config:set MAIL_FROM_ADDRESS=noreply@tudominio.com
```

### 5. Desplegar

```bash
git push heroku main
```

### 6. Ejecutar migraciones y seeders

```bash
heroku run php artisan migrate --force
heroku run php artisan db:seed --force
```

### 7. Acceder

```bash
heroku open
```

## Configuración de Correo

El formulario de contacto envía correos a la dirección configurada en "Configuración del sitio" en el admin. 

Para desarrollo local, usa `MAIL_MAILER=log` para ver correos en `storage/logs/laravel.log`.

Para producción, configura un servicio SMTP como:
- **Mailgun** (recomendado)
- **SendGrid**
- **Amazon SES**
- **Postmark**

## Notas sobre Almacenamiento de Imágenes

Las imágenes se almacenan en la base de datos PostgreSQL como datos binarios (bytea). Esto es compatible con Heroku pero tiene limitaciones:

### Limitaciones
- **Tamaño máximo**: 2MB por imagen (configurable)
- **Capacidad**: Depende del plan de PostgreSQL
- **Rendimiento**: Las imágenes grandes pueden impactar el rendimiento

### Recomendaciones para Producción
Para sitios con muchas imágenes, considera migrar a:
- **Amazon S3** con el paquete `league/flysystem-aws-s3-v3`
- **Cloudinary** para optimización automática
- **DigitalOcean Spaces**

El código está preparado para esta migración futura sin cambios mayores en las vistas.

## Estructura del Proyecto

```
app/
├── Http/Controllers/
│   ├── Admin/           # Controladores del panel admin
│   ├── ContactController.php
│   ├── EventController.php
│   ├── HomeController.php
│   └── MediaController.php  # Sirve imágenes desde la BD
├── Mail/
│   └── ContactFormSubmitted.php
└── Models/
    ├── ContactMessage.php
    ├── Event.php
    ├── EventLink.php
    ├── Image.php
    └── SiteSetting.php

resources/views/
├── admin/               # Vistas del panel admin
├── components/          # Componentes Blade
├── emails/              # Plantillas de correo
├── layouts/             # Layouts (public, admin)
├── partials/            # Parciales (navbar, footer)
└── public/              # Vistas públicas
```

## Rutas Principales

### Públicas
- `GET /` - Inicio
- `GET /eventos` - Listado de eventos
- `GET /eventos/{slug}` - Detalle de evento
- `GET /contacto` - Página de contacto
- `POST /contacto` - Enviar mensaje
- `GET /media/{id}` - Servir imagen

### Admin (requiere autenticación)
- `GET /admin` - Dashboard
- `GET /admin/events` - Gestión de eventos
- `GET /admin/events/{id}/links` - Enlaces del evento
- `GET /admin/events/{id}/gallery` - Galería del evento
- `GET /admin/settings` - Configuración
- `GET /admin/contact-messages` - Mensajes de contacto

## Credenciales por Defecto

**⚠️ IMPORTANTE: Cambiar en producción**

- **Email**: admin@example.com
- **Contraseña**: password

Para cambiar la contraseña:
1. Inicia sesión en `/login`
2. Ve a tu perfil y actualiza la contraseña
3. O usa tinker: `php artisan tinker` y actualiza el usuario

## Comandos Útiles

```bash
# Limpiar cachés
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Regenerar autoload
composer dump-autoload

# Ejecutar en Heroku
heroku run php artisan [comando]

# Ver logs de Heroku
heroku logs --tail
```

## Licencia

Este proyecto es privado. Todos los derechos reservados.
