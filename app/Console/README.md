# Comandos de Consola - Gestión de Roles y Permisos

## 📋 **Comandos Disponibles**

### **1. Gestión de Roles**

#### **Crear Roles Básicos**
```bash
php artisan db:seed --class=RolesSeeder
```
- Crea los roles: `super_admin`, `presidente`, `socio`
- No duplica roles existentes
- Seguro de ejecutar múltiples veces

#### **Asignar Rol a Usuario Específico**
```bash
php artisan roles:asignar {email} {rol}
```
**Ejemplos:**
```bash
php artisan roles:asignar admin@example.com presidente
php artisan roles:asignar socio@example.com socio
php artisan roles:asignar super@example.com super_admin
```

#### **Asignar Socio por Defecto**
```bash
# Solo usuarios sin roles
php artisan roles:socio-por-defecto

# Forzar a todos los usuarios
php artisan roles:socio-por-defecto --force
```

### **2. Consultas y Listados**

#### **Listar Todos los Usuarios con Roles**
```bash
php artisan roles:listar-usuarios
```

#### **Filtrar Usuarios por Rol**
```bash
php artisan roles:listar-usuarios --rol=socio
php artisan roles:listar-usuarios --rol=presidente
php artisan roles:listar-usuarios --rol=super_admin
```

### **3. Consultas Rápidas con Tinker**

#### **Ver Usuarios por Rol**
```bash
php artisan tinker --execute="echo 'Usuarios con rol socio: ' . App\Models\User::role('socio')->pluck('name')->implode(', ');"
```

#### **Ver Estadísticas**
```bash
php artisan tinker --execute="echo 'Total usuarios: ' . App\Models\User::count() . ', Sin rol: ' . App\Models\User::whereDoesntHave('roles')->count();"
```

#### **Ver Todos los Usuarios con Roles**
```bash
php artisan tinker --execute="App\Models\User::with('roles')->get()->each(function(\$u) { echo \$u->name . ' - ' . \$u->getRoleNames()->implode(', ') . PHP_EOL; });"
```

## 🎯 **Flujo de Trabajo Recomendado**

### **1. Configuración Inicial**
```bash
# Crear roles básicos
php artisan db:seed --class=RolesSeeder

# Asignar roles específicos
php artisan roles:asignar admin@example.com presidente
php artisan roles:asignar super@example.com super_admin

# Asignar socio por defecto a usuarios restantes
php artisan roles:socio-por-defecto
```

### **2. Verificación**
```bash
# Ver estado actual
php artisan roles:listar-usuarios

# Ver estadísticas
php artisan tinker --execute="echo 'Usuarios por rol: ' . App\Models\User::with('roles')->get()->groupBy('roles.0.name')->map->count();"
```

### **3. Mantenimiento**
```bash
# Asignar rol a nuevo usuario
php artisan roles:asignar nuevo@example.com socio

# Verificar usuarios sin roles
php artisan roles:listar-usuarios
```

## 🔧 **Estructura de Roles**

### **Super Admin**
- ✅ Acceso completo a todo
- ✅ Gestión de roles y permisos
- ✅ Panel de Shield completo

### **Presidente**
- ✅ CRUD completo de aportes
- ✅ Gestión de socios
- ✅ Reportes y dashboard
- ❌ Gestión de roles

### **Socio**
- ✅ Ver sus aportes
- ✅ Ver lista básica de socios
- ✅ Dashboard limitado
- ❌ Crear/editar/eliminar

## 📊 **Comandos de Diagnóstico**

### **Verificar Estado de la Base de Datos**
```bash
# Ver roles disponibles
php artisan tinker --execute="echo 'Roles: ' . Spatie\Permission\Models\Role::pluck('name')->implode(', ');"

# Ver usuarios sin roles
php artisan tinker --execute="echo 'Sin rol: ' . App\Models\User::whereDoesntHave('roles')->count();"

# Ver estadísticas por rol
php artisan tinker --execute="echo 'Por rol: ' . App\Models\User::with('roles')->get()->groupBy('roles.0.name')->map->count();"
```

### **Limpiar Cache (si hay problemas)**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## 🚨 **Comandos de Emergencia**

### **Resetear Roles de Usuario**
```bash
# Remover todos los roles de un usuario
php artisan tinker --execute="App\Models\User::where('email', 'usuario@example.com')->first()->syncRoles([]);"

# Asignar solo rol socio
php artisan tinker --execute="App\Models\User::where('email', 'usuario@example.com')->first()->syncRoles(['socio']);"
```

### **Verificar Integridad**
```bash
# Verificar que todos los usuarios tengan al menos un rol
php artisan tinker --execute="echo 'Usuarios sin rol: ' . App\Models\User::whereDoesntHave('roles')->pluck('email')->implode(', ');"
```

## 📝 **Notas Importantes**

- **Los comandos son seguros** de ejecutar múltiples veces
- **`firstOrCreate()`** evita duplicados en roles
- **`syncRoles()`** reemplaza todos los roles existentes
- **`assignRole()`** agrega roles sin eliminar los existentes
- **El panel web** (`/admin/shield/users`) es más visual para gestión manual

## 🔗 **Enlaces Útiles**

- **Panel de Shield**: `/admin/shield/users`
- **Panel de Roles**: `/admin/shield/roles`
- **Documentación Spatie**: https://spatie.be/docs/laravel-permission
- **Documentación Shield**: https://github.com/bezhanSalleh/filament-shield 