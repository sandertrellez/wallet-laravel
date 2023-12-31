# Wallet Laravel

Este proyecto implementa un sistema simple de billetera electrónica utilizando Laravel 10.

## Requisitos

- PHP 8.2
- Composer
- Docker (opcional)

## Instalación

1. **Clonar el repositorio:**

   ```bash
   git clone https://github.com/sandertrellez/wallet-laravel.git


### Instalar dependencias:

   ```bash
   composer install
   ```

### Configurar el archivo .env:

 ```bash
 cp .env.example .env
 ```
Edita el archivo .env con las configuraciones de la base de datos y otras variables necesarias.

### Generar la clave de aplicación:

php artisan key:generate

### Ejecutar migraciones:

```
php artisan migrate
```

## Ejecutar con Docker (opcional)
Si prefieres ejecutar la aplicación con Docker, sigue estos pasos:

### Construir la imagen e instanciar el contenedor:

```
docker compose up -d
```
Accede a http://localhost en tu navegador.