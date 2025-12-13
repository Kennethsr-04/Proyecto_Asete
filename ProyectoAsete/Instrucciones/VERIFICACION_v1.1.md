# 🚀 Guía Rápida de Verificación - v1.1

## Pasos de Verificación Post-Instalación

### 1. Verificar Base de Datos
```sql
-- Ejecutar en MySQL para verificar estructura
SELECT COUNT(*) FROM Clientes;
SELECT COUNT(*) FROM Libros;
SELECT COUNT(*) FROM Peliculas;
SELECT COUNT(*) FROM Reservas;
```

### 2. Acceso al Sistema

#### A. Página de Inicio
- URL: `http://localhost/ProyectoAsete/`
- Esperado: Redirige a login.php (no autenticado)

#### B. Registro de Nuevo Usuario
1. Ir a `login.php`
2. Clic en "Regístrate aquí"
3. Completa formulario:
   - Nombre: Juan
   - Apellidos: Pérez
   - Fecha nacimiento: 1990-01-15
   - Localidad: Madrid
   - Usuario: **juan_perez** (único)
   - Contraseña: **123456**
   - Confirmar: **123456**
4. Click Registrarse
5. ✅ Debe hacer login automático y ir a index.php

#### C. Catálogo de Libros
1. Clic en tarjeta "Libros"
2. ✅ Ver tabla con columnas:
   - Título, Autor, Editorial, Año, Género, Páginas, Precio
   - **NUEVO:** Estado (Disponible/Reservado)
   - **NUEVO:** Acciones (botón Reservar)

#### D. Catálogo de Películas
1. Clic en tarjeta "Películas"
2. ✅ Ver tabla con columnas:
   - Título, Año, Director, Actores, Género
   - **NUEVO:** Estado
   - **NUEVO:** Acciones

#### E. Reservar un Libro
1. En catálogo de libros, encontrar uno disponible
2. Clic en botón "Reservar"
3. ✅ Ir a página `reservar_libro.php?id=X`
4. Ver detalles del libro
5. Ver badge "✓ Disponible para reservar"
6. Clic en "Confirmar Reserva"
7. ✅ Redirige a `mis_reservas.php`
8. ✅ Libro aparece en "Reservas Activas"

#### F. Mis Reservas
1. Clic en tarjeta "Mis Reservas"
2. ✅ Ver secciones:
   - "Reservas Activas" con botón "Devolver"
   - "Historial de Devoluciones" (vacío al principio)
3. Clic en "Devolver"
4. ✅ Item se mueve a "Historial"
5. ✅ Muestra días de préstamo

#### G. Filtro por Estado
1. Clic en tarjeta "Filtrar por Estado"
2. ✅ Ver switches: Libros/Películas
3. ✅ Ver filtros: Todos/Disponibles/Reservados
4. Seleccionar "Películas"
5. Seleccionar "Disponibles"
6. ✅ Ver tabla con películas disponibles
7. Clic en "Reservar"
8. ✅ Ir a página de confirmación

#### H. Reservar Película
1. En filtro de estado, encontrar película disponible
2. Clic en "Reservar"
3. ✅ Ir a `reservar_pelicula.php?id=X`
4. Ver detalles (Director, Duración, Formato, etc.)
5. Ver badge "✓ Disponible para reservar"
6. Clic "Confirmar Reserva"
7. ✅ Redirige a `mis_reservas.php`
8. ✅ Película aparece en "Reservas Activas"

### 3. Validaciones que Deben Funcionar

#### Registro
- [ ] No permite campos vacíos
- [ ] Contraseña mínimo 6 caracteres
- [ ] Contraseñas deben coincidir
- [ ] No permite usuario duplicado
- [ ] Se crea usuario en BD
- [ ] Auto-login funciona

#### Reservas
- [ ] No puedes reservar 2 veces el mismo item
- [ ] Item reservado muestra "Reservado" (botón deshabilitado)
- [ ] Item disponible muestra "Disponible" (botón activo)
- [ ] Devolución marca como devuelto
- [ ] Historial muestra duración en días

### 4. Urls Clave a Verificar

| URL | Descripción | Esperado |
|-----|-------------|----------|
| `/index.php` | Dashboard | 4 tarjetas (Películas, Libros, Mis Reservas, Filtro) |
| `/login.php` | Login | Link a registro |
| `/register.php` | Registro | Formulario de 6 campos |
| `/Catalogo.php` | Películas | Columna Estado + Acciones |
| `/catalogo_libros.php` | Libros | Columna Estado + Acciones |
| `/mis_reservas.php` | Mis Reservas | 2 secciones (Activas + Historial) |
| `/filtro_estado.php` | Filtro Estado | Switches + 3 filtros |
| `/reservar_libro.php?id=1` | Confirmar | Página de confirmación |
| `/reservar_pelicula.php?id=1` | Confirmar | Página de confirmación |

### 5. Tabla de Datos Esperados

```
Clientes: ~20 registros
Libros: ~28 registros  
Películas: ~30 registros
Reservas: Creadas durante pruebas
```

### 6. Mensajes de Éxito Esperados

- "¡Registro exitoso! Bienvenido."
- "¡Libro reservado exitosamente!"
- "¡Película reservada exitosamente!"
- "Devolución registrada exitosamente."

### 7. Validaciones de Seguridad

- [ ] No puedo acceder a páginas sin login
- [ ] No puedo ver datos de otros usuarios
- [ ] Las contraseñas se guardan hasheadas (SHA256)
- [ ] Los campos se escapan (real_escape_string)
- [ ] XSS protection (htmlspecialchars)

### 8. Errores Comunes y Soluciones

| Error | Solución |
|-------|----------|
| "Connection refused" | Verificar que MySQL está running en puerto 3306 |
| "Access denied" | Verificar credenciales (root/bbdd) |
| "Unknown database" | Verificar base de datos "Peliculas" existe |
| "Table doesn't exist" | Verificar todas las tablas están creadas |
| Registro sin auto-login | Verificar db.php tiene $conexion global |
| Estado no actualiza | Limpiar cache del navegador (Ctrl+F5) |

---

## ✅ Lista de Verificación Final

- [ ] Acceso a login sin autenticación
- [ ] Registro de nuevo usuario funciona
- [ ] Auto-login después de registro funciona
- [ ] Catálogo de libros muestra estado
- [ ] Catálogo de películas muestra estado
- [ ] Botones de reserva funciona (libro)
- [ ] Botones de reserva funciona (película)
- [ ] Página "Mis Reservas" funciona
- [ ] Devolver item funciona
- [ ] Filtro por estado funciona
- [ ] Dashboard muestra 4 tarjetas
- [ ] Logout funciona
- [ ] Items reservados no se pueden reservar 2 veces

---

**Versión:** 1.1  
**Última actualización:** Diciembre 2024  
**Estado:** ✅ Listo para Testing
