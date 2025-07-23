# ASODAT - Sistema de Gestión

Sistema de gestión desarrollado con Laravel y Filament para ASODAT.

## 📋 Requisitos

- **Node.js** 18.x o superior
- **PHP** 8.3.14
- **Composer** 2.x

## 🚀 Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/ESPE-PRJ/asodat-prj.git
   cd asodat-prj
   ```

2. **Instalar dependencias de PHP**
   ```bash
   composer install
   ```

3. **Instalar dependencias de Node.js**
   ```bash
   npm install
   ```

4. **Configurar variables de entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configurar base de datos**
   
   El proyecto está configurado para usar **SQLite en desarrollo**:
   ```bash
   touch database/database.sqlite
   ```
   
   > **Nota**: En producción se utilizará **PostgreSQL**

6. **Ejecutar migraciones**
   ```bash
   php artisan migrate
   ```

7. **Compilar assets**
   ```bash
   npm run build
   ```

## 🔧 Comandos de Desarrollo

### Servidor de desarrollo
```bash
php artisan serve
```

### Compilar assets en modo watch
```bash
npm run dev
```

### Ejecutar migraciones con seeders
```bash
php artisan migrate:fresh --seed
```

### Limpiar cache
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 🗄️ Base de Datos

- **Desarrollo**: SQLite (`database/database.sqlite`)
- **Producción**: PostgreSQL

### Migraciones
```bash
# Ejecutar migraciones
php artisan migrate

# Rollback de migraciones
php artisan migrate:rollback

# Refresh migraciones con seeders
php artisan migrate:fresh --seed
```

## 📦 Tecnologías Utilizadas

- **Laravel** 12.x
- **Filament** 3.x - Panel de administración
- **Livewire** - Componentes reactivos
- **Tailwind CSS** - Framework CSS
- **Vite** - Build tool
