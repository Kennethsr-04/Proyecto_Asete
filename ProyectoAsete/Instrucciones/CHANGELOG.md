# 📋 CHANGELOG - Videoclub-Biblioteca

## Versión 1.1 - Diciembre 2024 (Actualización)

### ✨ Nuevas Características

#### Sistema de Registro
- ✅ **register.php** - Página de registro de nuevos clientes
  - Validación de campos (obligatorios, longitud, coincidencia de contraseñas)
  - Prevención de nombres de usuario duplicados
  - Hash SHA256 para contraseñas
  - Auto-login después del registro exitoso
  - Diseño responsive

#### Sistema de Reservas Completo
- ✅ **reservar_libro.php** - Página para reservar libros
  - Verificación de disponibilidad
  - Confirmación antes de reserva
  - Redirección a mis_reservas después de éxito

- ✅ **reservar_pelicula.php** - Página para reservar películas
  - Interfaz similar a libros
  - Validación de disponibilidad

- ✅ **mis_reservas.php** - Panel de reservas del cliente
  - Vista de reservas activas
  - Historial de devoluciones completadas
  - Botón para devolver items
  - Cálculo de días de préstamo

#### Métodos en Catalogo.php (Data Access Object)
- ✅ `isDisponible($id_libro)` - Verifica disponibilidad de libro
- ✅ `isDisponiblePelicula($id_pelicula)` - Verifica disponibilidad de película
- ✅ `reservarLibro($id_cliente, $id_libro)` - Crea reserva de libro
- ✅ `reservarPelicula($id_cliente, $id_pelicula)` - Crea reserva de película
- ✅ `devolverLibro($id_cliente, $id_libro)` - Marca libro como devuelto
- ✅ `devolverPelicula($id_cliente, $id_pelicula)` - Marca película como devuelta
- ✅ `obtenerReservasCliente($id_cliente)` - Obtiene todas las reservas del cliente
- ✅ `obtenerReservasActivasCliente($id_cliente)` - Obtiene solo reservas no devueltas
- ✅ `obtenerHistorialDevolucionesCliente($id_cliente)` - Obtiene reservas completadas

#### Filtros Mejorados
- ✅ **filtro_estado.php** - Página para filtrar por estado (disponible/reservado)
  - Switch entre libros y películas
  - Contador dinámico de resultados
  - Visualización clara del estado de cada item
  - Botones de acción (reservar/reservado)

#### Interfaz de Usuario
- ✅ Botones de "Reservar" en catalogo_libros.php
- ✅ Botones de "Reservar" en Catalogo.php (películas)
- ✅ Indicadores de estado (Disponible/Reservado) con colores
- ✅ Tarjeta "Mis Reservas" en panel principal
- ✅ Tarjeta "Filtrar por Estado" en panel principal
- ✅ Link de registro en login.php

#### Mejoras a Existentes
- ✅ index.php - Agregadas 2 nuevas tarjetas de navegación
- ✅ login.php - Agregado link a página de registro
- ✅ catalogo_libros.php - Columnas de estado y acciones
- ✅ Catalogo.php - Columnas de estado y acciones

### 🔄 Cambios Importantes
- Auto-login después de registro exitoso (mejor UX)
- Tabla de reservas usa campos Id_Libro e Id_Pelicula (nullable)
- Fecha_Devolucion NULL indica reserva activa
- Fecha_Devolucion establecida indica devolución completada

---

## Versión 1.0 - Diciembre 2024

### ✨ Nuevas Características

#### Páginas
- ✅ **index.php** - Panel principal con acceso a catálogos
- ✅ **Catalogo.php** - Catálogo de películas con filtros y búsqueda
- ✅ **catalogo_libros.php** - Catálogo de libros con filtros y búsqueda
- ✅ **filtro.php** - Formulario de filtrado de películas
- ✅ **filtro_libros.php** - Formulario de filtrado de libros
- ✅ **agregar_peliculas.php** - Formulario para agregar películas
- ✅ **agregar_libros.php** - Formulario para agregar libros
- ✅ **login.php** - Autenticación de usuarios
- ✅ **logout.php** - Cierre de sesión
- ✅ **verificar_instalacion.php** - Verificador de configuración

#### Clases
- ✅ **classes/Catalogo.php** - Data Access Object para películas y libros
- ✅ **Pelicula.php** - Modelo de películas mejorado
- ✅ **Libro.php** - Modelo de libros con soporte de autores
- ✅ **Producto.php** - Clase abstracta base (existente)
- ✅ **InfoComun.php** - Trait con funcionalidades compartidas (existente)

#### Base de Datos
- ✅ Integración completa con MySQL
- ✅ Conexión mediante mysqli
- ✅ Soporte para 7 tablas: Autores, Clientes, Libros, Peliculas, Reservas, Usuarios
- ✅ Foreign Keys configuradas correctamente
- ✅ LEFT JOIN para relación Libros-Autores

#### Seguridad
- ✅ Autenticación de usuarios con sesiones
- ✅ Protección contra inyección SQL (real_escape_string)
- ✅ Protección contra XSS (htmlspecialchars)
- ✅ Validación de contraseñas con hash SHA256
- ✅ Control de acceso por sesión en todas las páginas

#### Internacionalización
- ✅ Soporte para español e inglés
- ✅ Selector de idioma en todas las páginas
- ✅ Traducciones completas de interfaz

#### Características de Películas
- ✅ Ver catálogo completo
- ✅ Filtrar por: género, año, director (búsqueda parcial)
- ✅ Agregar nuevas películas
- ✅ Interfaz profesional con toolbar
- ✅ Información: título, director, actores, año, género
- ✅ Soporte para películas adaptadas de libros (FK)

#### Características de Libros
- ✅ Ver catálogo completo
- ✅ Filtrar por: género, autor, año
- ✅ Mostrar autor desde tabla Autores (LEFT JOIN)
- ✅ Agregar nuevos libros
- ✅ Interfaz profesional con toolbar
- ✅ Información: título, autor, editorial, año, género, páginas, precio

#### Características de Filtrado
- ✅ Filtros persistentes por sesión
- ✅ Aplicación múltiple de filtros (acumulativo)
- ✅ Botón para limpiar todos los filtros
- ✅ Mensajes "no hay resultados"
- ✅ Dropdowns dinámicos (género, autores)

### 🔧 Cambios Técnicos

#### Archivos Modificados
- **Pelicula.php**
  - Agregados getters: getDirector(), getActores(), getTipoAdaptacion(), getAdaptacionId()
  - Mejora de documentación

- **Libro.php**
  - Reemplazado $autor genérico por $autorId y $autorNombre
  - Agregados getters: getAutorId(), getAutorNombre(), getEditorial(), getPaginas()
  - Soporte completo para FK a tabla Autores
  - Fallback a "Desconocido" si autor es NULL

- **Catalogo.php** (vista)
  - Reemplazado con versión database-integrada
  - Implementado uso de clase Catalogo (DAO)
  - Agregados filtros con sessionamiento
  - Diseño moderno con toolbar y containers
  - Seguridad mejorada (htmlspecialchars en salidas)

- **filtro.php**
  - Actualizado para usar clase Catalogo
  - Géneros dinámicos desde BD
  - Interfaz modernizada
  - Soporte para limpiar filtros

- **agregar_peliculas.php**
  - Reemplazado sistema de sesión/serialización por BD
  - Implementado uso de clase Catalogo para INSERT
  - Formulario mejorado con validaciones
  - Mensajes de éxito/error formateados

- **login.php**
  - Actualizado para redirigir a index.php (no catalogo.php)

#### Archivos Creados
- **classes/Catalogo.php** - 190 líneas, 11 métodos públicos
- **catalogo_libros.php** - Catálogo de libros
- **filtro_libros.php** - Filtro de libros
- **agregar_libros.php** - Agregador de libros
- **index.php** - Dashboard principal
- **verificar_instalacion.php** - Herramienta de verificación
- **README.md** - Documentación general
- **INSTRUCCIONES.md** - Manual de usuario
- **ESTRUCTURA.md** - Arquitectura técnica
- **CHANGELOG.md** - Este archivo

### 🎨 Interfaz de Usuario

#### Diseño Visual
- ✅ Gradientes modernos (Purple/Pink/Blue)
- ✅ Containers con rounded corners
- ✅ Botones con hover effects y animaciones
- ✅ Íconos emoji para mejor UX
- ✅ Responsivo en dispositivos móviles

#### Componentes
- ✅ Toolbar con 5 botones de navegación
- ✅ Panel de información de usuario
- ✅ Tablas con estilos profesionales
- ✅ Formularios validados con campos requeridos
- ✅ Mensajes de estado (éxito/error)
- ✅ Selector de idioma visual

### 📊 Base de Datos

#### Conexión
- Servidor: bbdd
- Usuario: root
- Contraseña: bbdd
- Base de datos: Peliculas

#### Tablas Utilizadas
```
Peliculas (30 registros)
├─ Campos: Id, Título, Año_estreno, Director, Actores, Género, Tipo_adaptación, Adaptación_ID

Libros (28 registros)
├─ Campos: id, Titulo, Autor_Id (FK), Genero, Editorial, Paginas, Año, Precio

Autores (27 registros)
├─ Campos: Id, Nombre, Fecha_Nacimiento, Lugar, Fecha_Defuncion

Clientes (20 registros)
├─ Campos: Id, Nombre, Apellidos, Fecha_Nacimiento, Localidad, Password

Usuarios
Reservas
```

### 🔒 Seguridad

#### Implementaciones
- ✅ Sesiones PHP con session_start()
- ✅ Validación de existencia de sesión en cada página
- ✅ Escaping de SQL con real_escape_string()
- ✅ Conversión de números con intval()
- ✅ Escaping de salida con htmlspecialchars()
- ✅ Hash de contraseñas SHA256
- ✅ Protección de método POST en formularios

### 🐛 Correcciones

- **Rutas de includes:** Actualizado __DIR__ para rutas absolutas
- **Redirección de login:** Ahora va a index.php
- **Nombres de variables:** Consistencia en nombres (genero, anio, director)
- **HTML cerrado:** Eliminado </html> duplicado en filtro.php

### 📚 Documentación

Incluido:
- README.md (Introducción y setup)
- INSTRUCCIONES.md (Manual de usuario)
- ESTRUCTURA.md (Arquitectura técnica)
- CHANGELOG.md (Este archivo)
- Comentarios en código (PHPDoc)

### 🚀 Performance

- Consultas optimizadas con índices
- LEFT JOIN para evitar N+1 queries
- Sesiones del lado del servidor (no cookies)
- Caché en memoria de resultados

### ✅ Testing

Todos los componentes probados:
- ✅ Login con credenciales válidas
- ✅ Filtrado de películas por género, año, director
- ✅ Filtrado de libros por autor, género, año
- ✅ Agregación de nuevas películas
- ✅ Agregación de nuevos libros
- ✅ Cambio de idioma
- ✅ Limpiar filtros
- ✅ Navegación entre páginas
- ✅ Cierre de sesión

### 🔄 Flujos de Trabajo

#### Flujo de Autenticación
```
login.php → Validar → Crear sesión → index.php
```

#### Flujo de Catálogo
```
Catalogo.php → Filtro → Aplicar → Mostrar resultados
```

#### Flujo de Agregación
```
agregar_*.php → Validar → INSERT → Mensaje de éxito
```

### ⚠️ Notas Importantes

- Las contraseñas de ejemplo están en hash SHA256
- La BD debe estar corriendo en servidor "bbdd"
- Usar PHP 8.2+ recomendado
- MySQLi debe estar habilitado
- Las sesiones se guardan en servidor (configurar session.save_path si es necesario)

### 📝 Próximas Versiones (Futuro)

Características planeadas para versiones futuras:
- [ ] Editar películas/libros existentes
- [ ] Eliminar películas/libros
- [ ] Sistema de reservas de libros
- [ ] Recomendaciones personalizadas
- [ ] Búsqueda avanzada
- [ ] Paginación de resultados
- [ ] Dashboard con estadísticas
- [ ] API REST
- [ ] Interfaz de administración

### 🤝 Contribuciones

Este proyecto fue desarrollado como parte del curso ASETE.

### 📄 Licencia

Proyecto educativo. Uso libre para fines didácticos.

---

**Fecha de Creación:** Diciembre 2024  
**Última Actualización:** Diciembre 2024  
**Versión:** 1.0  
**Estado:** Estable ✅
