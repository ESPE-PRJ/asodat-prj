# Comandos de Gestión de Roles y Permisos

Este documento describe todos los comandos Artisan personalizados para la gestión de roles y permisos en el sistema.

## 📋 Comandos Disponibles

### 1. `roles:asignar` - Asignar un rol
**Descripción**: Asigna un rol específico a un usuario por email.

**Sintaxis**:
```bash
php artisan roles:asignar {email} {rol}
```

**Ejemplos**:
```bash
# Asignar rol 'socio' a un usuario
php artisan roles:asignar usuario@ejemplo.com socio

# Asignar rol 'presidente' a un usuario
php artisan roles:asignar admin@ejemplo.com presidente

# Asignar rol 'super_admin' a un usuario
php artisan roles:asignar admin@ejemplo.com super_admin
```

**Características**:
- ✅ Verifica que el usuario existe
- ✅ Verifica que el rol existe
- ✅ Muestra roles actuales del usuario
- ✅ Permite asignar múltiples roles (acumulativo)

### 2. `roles:asignar-multiples` - Asignar múltiples roles
**Descripción**: Asigna múltiples roles a un usuario por email.

**Sintaxis**:
```bash
php artisan roles:asignar-multiples {email} {roles...} [--replace]
```

**Ejemplos**:
```bash
# Asignar múltiples roles (agregar)
php artisan roles:asignar-multiples usuario@ejemplo.com socio presidente

# Reemplazar roles existentes
php artisan roles:asignar-multiples usuario@ejemplo.com socio presidente --replace

# Asignar solo un rol
php artisan roles:asignar-multiples usuario@ejemplo.com super_admin
```

**Opciones**:
- `--replace`: Reemplaza roles existentes en lugar de agregar

**Características**:
- ✅ Verifica que todos los roles existen
- ✅ Muestra roles actuales antes y después
- ✅ Opción para reemplazar o agregar roles
- ✅ Validación completa de roles

### 3. `roles:socio-por-defecto` - Asignar rol socio por defecto
**Descripción**: Asigna el rol 'socio' a usuarios que no tienen ningún rol asignado.

**Sintaxis**:
```bash
php artisan roles:socio-por-defecto [--force]
```

**Ejemplos**:
```bash
# Asignar rol socio solo a usuarios sin roles
php artisan roles:socio-por-defecto

# Asignar rol socio a todos los usuarios (forzar)
php artisan roles:socio-por-defecto --force
```

**Opciones**:
- `--force`: Asigna el rol a todos los usuarios, incluso si ya tienen roles

### 4. `roles:listar-usuarios` - Listar usuarios y roles
**Descripción**: Muestra una tabla con todos los usuarios y sus roles asignados.

**Sintaxis**:
```bash
php artisan roles:listar-usuarios [--rol={rol}]
```

**Ejemplos**:
```bash
# Listar todos los usuarios
php artisan roles:listar-usuarios

# Filtrar por rol específico
php artisan roles:listar-usuarios --rol=socio
php artisan roles:listar-usuarios --rol=presidente
php artisan roles:listar-usuarios --rol=super_admin
```

**Opciones**:
- `--rol`: Filtrar usuarios por rol específico

## 🔄 Flujo de Trabajo Recomendado

### Para un nuevo usuario:
1. **Crear el usuario** (registro normal)
2. **Asignar rol por defecto**:
   ```bash
   php artisan roles:socio-por-defecto
   ```
3. **Verificar asignación**:
   ```bash
   php artisan roles:listar-usuarios
   ```

### Para cambiar roles de un usuario:
1. **Ver roles actuales**:
   ```bash
   php artisan roles:listar-usuarios
   ```
2. **Asignar nuevos roles**:
   ```bash
   # Agregar roles (mantener existentes)
   php artisan roles:asignar-multiples usuario@ejemplo.com presidente socio
   
   # Reemplazar roles
   php artisan roles:asignar-multiples usuario@ejemplo.com super_admin --replace
   ```

### Para asignar múltiples roles:
```bash
# Usuario con roles de socio y presidente
php artisan roles:asignar-multiples usuario@ejemplo.com socio presidente

# Super admin con todos los roles
php artisan roles:asignar-multiples admin@ejemplo.com super_admin presidente socio
```

## ⚠️ Notas Importantes

### Roles Disponibles:
- `super_admin`: Acceso completo al sistema
- `presidente`: Gestión de aportes y socios
- `socio`: Acceso básico a información personal

### Comportamiento de Asignación:
- **`assignRole()`**: Agrega roles sin eliminar los existentes
- **`syncRoles()`**: Reemplaza todos los roles existentes
- **`assignRole()` múltiple**: Agrega múltiples roles a la vez

### Validaciones:
- ✅ Verifica que el usuario existe
- ✅ Verifica que los roles existen
- ✅ Muestra roles actuales antes y después
- ✅ Manejo de errores con mensajes claros

## 🔧 Comandos de Mantenimiento

### Limpiar caché después de cambios:
```bash
php artisan config:clear
php artisan cache:clear
```

### Verificar estado del sistema:
```bash
# Listar todos los usuarios y roles
php artisan roles:listar-usuarios

# Verificar usuarios sin roles
php artisan roles:listar-usuarios | grep "Sin roles"
```

## 🚨 Solución de Problemas

### Error: "Usuario no encontrado"
- Verificar que el email existe en la base de datos
- Usar `php artisan tinker` para verificar usuarios

### Error: "Rol no encontrado"
- Verificar que el rol existe: `php artisan tinker` → `Role::all()`
- Crear roles si es necesario: `php artisan db:seed --class=RolesSeeder`

### Roles no se muestran en el dashboard
- Limpiar caché: `php artisan config:clear && php artisan cache:clear`
- Verificar que el usuario tiene roles asignados
- Revisar logs: `tail -f storage/logs/laravel.log`

## 📊 Ejemplos de Uso Completo

### Configurar un super admin:
```bash
php artisan roles:asignar-multiples admin@ejemplo.com super_admin presidente socio --replace
```

### Configurar un presidente:
```bash
php artisan roles:asignar-multiples presidente@ejemplo.com presidente socio --replace
```

### Configurar un socio:
```bash
php artisan roles:asignar-multiples socio@ejemplo.com socio --replace
```

### Asignar rol socio a todos los usuarios nuevos:
```bash
php artisan roles:socio-por-defecto
``` 