# Solución Textil

Este README describe cómo configurar y utilizar la aplicación.
Este proyecto es una plataforma desarrollada con **Laravel 12** que utiliza Livewire y Volt para la construcción de interfaces dinámicas. Incluye Vite y TailwindCSS para compilar los activos.

## Requisitos

- PHP >= 8.2
- Composer
- Node.js y npm

Se utiliza SQLite como base de datos por defecto, aunque puedes cambiar la conexión en el archivo `.env`.

## Instalación

1. Clona el repositorio y entra en la carpeta del proyecto.
2. Instala las dependencias de PHP:
   ```bash
   composer install
   ```
3. Instala las dependencias de JavaScript:
   ```bash
   npm install
   ```
4. Copia el archivo de ejemplo de entorno y genera la clave de la aplicación:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
5. Crea la base de datos (por defecto `database/database.sqlite`) y ejecuta las migraciones:
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

## Uso en desarrollo

Compila los activos y levanta el servidor de desarrollo ejecutando:

```bash
npm run dev &
php artisan serve
```

También puedes usar el script `composer dev` para iniciar simultáneamente el servidor, las colas y Vite.

## Compilación para producción

Ejecuta el siguiente comando para generar los archivos optimizados:

```bash
npm run build
```

Luego despliega la aplicación en tu servidor web preferido.
