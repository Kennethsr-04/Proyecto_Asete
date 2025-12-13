# Videoclub-Biblioteca - Proyecto ASETE

**Versión:** 1.1 (Diciembre 2024)

## Descripción
Sistema web completo de gestión de películas y libros con autenticación de usuarios, sistema de reservas, y control de disponibilidad.

## ¿Qué es nuevo en v1.1?
- ✅ Sistema completo de registro de clientes
- ✅ Sistema de reservas de libros y películas
- ✅ Vista de mis reservas con historial
- ✅ Indicadores de disponibilidad/estado
- ✅ Filtros mejorados por estado
- ✅ Auto-login después del registro
- ✅ Métodos de devolución de items

## Requisitos
- PHP 8.2+
- MySQL 5.7+ (Servidor: bbdd, Usuario: root, Contraseña: bbdd)
- Navegador web moderno
- Base de datos "Peliculas" con tablas:
  - Autores
  - Clientes
  - Libros
  - Peliculas
  - Reservas (con campos: Id_Cliente, Id_Libro, Id_Pelicula, Fecha_Reserva, Fecha_Devolucion)
  - Usuarios

## Instalación

1. Coloca los archivos en la carpeta `ProyectoAsete` en tu servidor web (Apache, Nginx, etc.)
2. Asegúrate de que la base de datos MySQL está configurada con:
   - Servidor: bbdd
   - Usuario: root
   - Contraseña: bbdd
   - Base de datos: Peliculas

3. Abre tu navegador e ingresa a: `http://localhost/ProyectoAsete/`

## Guía de Uso

### Para Nuevos Usuarios
1. Ve a la página de login
2. Haz clic en "Regístrate aquí"
3. Completa el formulario de registro con tus datos
4. Se te hará login automáticamente

### Para Reservar Items
1. Ve a "Catálogo de Libros" o "Películas"
2. Haz clic en "Reservar" para items disponibles
3. Confirma la reserva en la página de confirmación
4. El item se agregará a "Mis Reservas"

### Para Devolver Items
1. Ve a "Mis Reservas"
2. En la sección "Reservas Activas"
3. Haz clic en "Devolver" para cualquier item
4. El item se moverá al historial

### Para Filtrar por Estado
1. Ve a "Filtrar por Estado" desde el dashboard
2. Selecciona entre Libros o Películas
3. Filtra por: Todos, Disponibles, o Reservados
4. Haz clic en "Reservar" desde cualquier item disponible

## Estructura del Proyecto

### Archivos principales:
- `index.php` - Página de inicio (dashboard)
- `login.php` - Página de autenticación
- `register.php` - Página de registro
- `logout.php` - Cierre de sesión
- `Catalogo.php` - Catálogo de películas
- `catalogo_libros.php` - Catálogo de libros
- `agregar_peliculas.php` - Formulario para añadir películas
- `agregar_libros.php` - Formulario para añadir libros
- `filtro.php` - Filtro de películas
- `filtro_libros.php` - Filtro de libros
- `filtro_estado.php` - Filtro por estado (disponible/reservado)
- `reservar_libro.php` - Página de confirmación para reservar libro
- `reservar_pelicula.php` - Página de confirmación para reservar película
- `mis_reservas.php` - Panel de reservas del cliente

### Clases (en carpeta `classes/`):
- `Catalogo.php` - Clase Data Access Object con +15 métodos CRUD

### Modelos (en raíz):
- `Producto.php` - Clase abstracta padre
- `Pelicula.php` - Clase para películas
- `Libro.php` - Clase para libros
- `InfoComun.php` - Trait con métodos compartidos### Base de datos:
- `db.php` - Conexión a MySQL

### Estilos (en carpeta `style/`):
- `catalogo.css` - Estilos del catálogo
- `agregar_pelicula.css` - Estilos de formularios
- `filtro.css` - Estilos de filtros
- `login.css` - Estilos de login
- `idioma.css` - Estilos de selector de idioma

### Idiomas (en carpeta `lang/`):
- `es.php` - Traducciones al español
- `en.php` - Traducciones al inglés

## Datos de Acceso

Para probar la aplicación, puedes usar cualquiera de los clientes registrados en la base de datos.

**Nota:** Las contraseñas están almacenadas en hash SHA256.

## Funcionalidades

### Películas
- ✅ Ver catálogo completo de películas
- ✅ Filtrar por género, año y director
- ✅ Añadir nuevas películas
- ✅ Base de datos integrada

### Libros
- ✅ Ver catálogo completo de libros
- ✅ Filtrar por género, año y autor
- ✅ Mostrar nombre del autor (relación con tabla Autores)
- ✅ Añadir nuevos libros
- ✅ Base de datos integrada

### Seguridad
- ✅ Autenticación de usuarios
- ✅ Sesiones de usuario
- ✅ Protección contra inyección SQL (real_escape_string)
- ✅ Escapado de salida (htmlspecialchars)

### Internacionalización
- ✅ Soporte para español e inglés
- ✅ Selector de idioma en cada página

## Notas Técnicas

### Conexión a BD
La conexión utiliza mysqli (no PDO) y se configura en `db.php`.

### Seguridad
- Todas las entradas de usuario se escapan con `real_escape_string()`
- Todas las salidas HTML se escapan con `htmlspecialchars()`
- Las contraseñas se validan contra hashes SHA256

### Filtros
Los filtros se guardan en `$_SESSION` para mantener la selección del usuario entre páginas.

### Clases y Herencia
- `Producto` (clase abstracta) → `Pelicula` y `Libro` (clases concretas)
- `InfoComun` (trait) → Utilizado por `Pelicula` y `Libro`
- `Catalogo` (clase de acceso a datos) → Operaciones CRUD

## Solución de problemas

### Error: "Cannot connect to database"
- Verifica que MySQL esté corriendo
- Comprueba las credenciales en `db.php`
- Verifica que la base de datos "Peliculas" exista

### Error: "User not found"
- Asegúrate de que existen registros en la tabla `Clientes`
- Verifica el nombre de usuario (sensible a mayúsculas/minúsculas)

### El formulario no inserta datos
- Verifica los permisos de INSERT en la tabla
- Comprueba que el usuario de BD tiene permisos suficientes

## Contacto
Para soporte técnico, contacta al profesor de la materia ASETE.

---
**Última actualización:** Diciembre 2024
**Versión:** 1.0
