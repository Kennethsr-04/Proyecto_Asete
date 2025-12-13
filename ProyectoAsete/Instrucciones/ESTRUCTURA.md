# 🏗️ ESTRUCTURA TÉCNICA - Videoclub-Biblioteca

## Arquitectura General

```
ProyectoAsete/
├── index.php                 # Panel principal (dashboard)
├── login.php                 # Página de autenticación
├── logout.php                # Cierre de sesión
├── Catalogo.php              # Catálogo de películas (vista)
├── catalogo_libros.php       # Catálogo de libros (vista)
├── filtro.php                # Filtro de películas
├── filtro_libros.php         # Filtro de libros
├── agregar_peliculas.php     # Formulario para añadir películas
├── agregar_libros.php        # Formulario para añadir libros
├── db.php                    # Conexión a base de datos
├── internacionalizacion.php  # Configuración de idiomas
├── caja-idiomas.html         # Selector de idiomas (UI)
│
├── classes/
│   └── Catalogo.php          # Clase de acceso a datos (DAO)
│
├── models/
│   ├── Producto.php          # Clase abstracta (padre)
│   ├── Pelicula.php          # Modelo de películas
│   ├── Libro.php             # Modelo de libros
│   ├── traits.php            # Traits reutilizables
│   └── pelicula.php          # [Archivo legacy]
│
├── lang/
│   ├── es.php                # Traducciones español
│   └── en.php                # Traducciones inglés
│
└── style/
    ├── catalogo.css          # Estilos para catálogos
    ├── agregar_pelicula.css  # Estilos para formularios
    ├── filtro.css            # Estilos para filtros
    ├── login.css             # Estilos para login
    └── idioma.css            # Estilos para selector de idioma
```

---

## Flujo de Datos

### Arquitectura de Capas

```
┌─────────────────────────────────────┐
│   CAPA DE PRESENTACIÓN              │
│  (HTML + PHP Templating)            │
│  ├── Catalogo.php                   │
│  ├── catalogo_libros.php            │
│  ├── agregar_*.php                  │
│  ├── filtro_*.php                   │
│  └── index.php                      │
└──────────────┬──────────────────────┘
               │
┌──────────────▼──────────────────────┐
│   CAPA DE LÓGICA DE NEGOCIO         │
│  (Clases y métodos)                 │
│  ├── Catalogo (DAO)                 │
│  ├── Pelicula (Modelo)              │
│  └── Libro (Modelo)                 │
└──────────────┬──────────────────────┘
               │
┌──────────────▼──────────────────────┐
│   CAPA DE ACCESO A DATOS            │
│  (Queries SQL)                      │
│  └── mysqli (PHP MySQLi)            │
└──────────────┬──────────────────────┘
               │
┌──────────────▼──────────────────────┐
│   CAPA DE BASE DE DATOS             │
│  (MySQL 5.7.44)                     │
│  └── Base de datos "Peliculas"      │
└─────────────────────────────────────┘
```

---

## Modelo de Clases

### 1. **Producto.php** (Clase Abstracta)

```php
abstract class Producto {
    protected $id;
    protected $titulo;
    protected $genero;
    protected $anio;
    protected $precio;
    
    abstract public function getTipo();
    
    // Getters concretos
    public function getId()
    public function getTitulo()
    public function getGenero()
    public function getAnio()
    public function getPrecio()
}
```

**Propósito:** Definir interfaz común para películas y libros.

---

### 2. **Pelicula.php** (Hereda de Producto)

```php
class Pelicula extends Producto {
    private $director;
    private $actores;
    private $tipoAdaptacion;
    private $adaptacionId;
    
    public function __construct($fila)
    public function getTipo(): string
    public function getDirector()
    public function getActores()
    public function getTipoAdaptacion()
    public function getAdaptacionId()
}
```

**Propósito:** Representar una película con sus características específicas.

**Campos de BD esperados:**
- `ID`, `Título`, `Año_estreno`, `Director`, `Actores`
- `Género`, `Tipo_adaptación`, `Adaptación_ID`

---

### 3. **Libro.php** (Hereda de Producto)

```php
class Libro extends Producto {
    private $autorId;
    private $autorNombre;
    private $editorial;
    private $paginas;
    
    public function __construct($fila)
    public function getTipo(): string
    public function getAutorId()
    public function getAutorNombre()
    public function getEditorial()
    public function getPaginas()
}
```

**Propósito:** Representar un libro con relación a autores.

**Campos de BD esperados:**
- `id`, `Titulo`, `Genero`, `Año`, `Precio`
- `Autor_Id`, `Autor_Nombre` (del JOIN)
- `Editorial`, `Paginas`

**Nota:** `Autor_Nombre` viene de un LEFT JOIN con la tabla Autores.

---

### 4. **Catalogo.php** (Data Access Object)

```php
class Catalogo {
    private $conexion;
    
    public function __construct($conexion)
    
    // PELÍCULAS
    public function obtenerPeliculas(): array
    public function obtenerPeliculaPorId($id): ?Pelicula
    public function agregarPelicula($titulo, $anio, $director, $actores, $genero): bool
    public function actualizarPelicula($id, ...): bool
    public function eliminarPelicula($id): bool
    
    // LIBROS
    public function obtenerLibros(): array
    public function obtenerLibroPorId($id): ?Libro
    public function agregarLibro($titulo, $autorId, $genero, $editorial, $paginas, $anio, $precio): bool
    public function actualizarLibro($id, ...): bool
    public function eliminarLibro($id): bool
    
    // UTILIDADES
    public function obtenerAutores(): array
}
```

**Propósito:** Centralizar todas las operaciones de base de datos (CRUD).

**Características:**
- Escapa todos los inputs con `real_escape_string()`
- Convierte valores numéricos a enteros con `intval()`
- Retorna objetos `Pelicula` y `Libro` instanciados

---

## Base de Datos

### Tabla: Peliculas

| Columna | Tipo | Descripción |
|---------|------|-------------|
| Id | INT (PK) | ID único |
| Título | VARCHAR | Nombre de la película |
| Año_estreno | INT | Año de estreno |
| Director | VARCHAR | Nombre del director |
| Actores | VARCHAR | Actores principales |
| Género | VARCHAR | Género cinematográfico |
| Tipo_adaptación | VARCHAR | Tipo (Película/Serie/Corto) |
| Adaptación_ID | INT (FK) | FK a Libros.id |

### Tabla: Libros

| Columna | Tipo | Descripción |
|---------|------|-------------|
| id | INT (PK) | ID único |
| Titulo | VARCHAR | Nombre del libro |
| Autor_Id | INT (FK) | FK a Autores.Id |
| Genero | VARCHAR | Género literario |
| Editorial | VARCHAR | Casa editora |
| Paginas | INT | Número de páginas |
| Año | INT | Año de publicación |
| Precio | DECIMAL | Precio en euros |

### Tabla: Autores

| Columna | Tipo | Descripción |
|---------|------|-------------|
| Id | INT (PK) | ID único |
| Nombre | VARCHAR | Nombre del autor |
| Fecha_Nacimiento | DATE | Fecha de nacimiento |
| Lugar | VARCHAR | Lugar de nacimiento |
| Fecha_Defuncion | DATE | Fecha de defunción (NULL si vivo) |

### Relaciones (Foreign Keys)

```
Libros.Autor_Id ──→ Autores.Id (1:N)
Peliculas.Adaptación_ID ──→ Libros.id (0:N)
Reservas.Id_Cliente ──→ Clientes.Id (N:1)
Reservas.Id_Libro ──→ Libros.id (N:1)
Usuarios.id ──→ Clientes.Id (1:1)
```

---

## Flujo de Autenticación

```
login.php
  ├─ Validar POST
  ├─ Buscar cliente en BD
  ├─ Comparar hash SHA256
  ├─ Crear sesión $_SESSION['usuario']
  └─→ Redirigir a index.php
     │
     ├─→ Catalogo.php    [Ver películas]
     │   └─→ filtro.php  [Filtrar]
     │   └─→ agregar_peliculas.php
     │
     ├─→ catalogo_libros.php  [Ver libros]
     │   └─→ filtro_libros.php  [Filtrar]
     │   └─→ agregar_libros.php
     │
     └─→ logout.php      [Cerrar sesión]
```

---

## Ciclo de Vida de una Página (Ejemplo: Catalogo.php)

### 1. **Inicio de Sesión**
```php
session_start();
if(!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
```

### 2. **Incluir Dependencias**
```php
require "internacionalizacion.php";  // Idiomas
require_once "db.php";                // Conexión BD
require_once "classes/Catalogo.php";  // DAO
```

### 3. **Procesar Parámetros GET**
```php
if (isset($_GET['clear'])) {
    // Limpiar filtros
    unset($_SESSION["genero"]);
    // ...
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Guardar nuevos filtros
    $_SESSION["genero"] = $_GET["genero"] ?? "";
    // ...
}
```

### 4. **Obtener Datos de BD**
```php
$catalogo = new Catalogo($conexion);
$peliculas = $catalogo->obtenerPeliculas();
```

### 5. **Renderizar HTML**
```php
<?php foreach ($peliculas as $pelicula): ?>
    <?php if ($pasa_filtros): ?>
        <tr>
            <td><?= htmlspecialchars($pelicula->getTitulo()) ?></td>
            <!-- Más datos escapados -->
        </tr>
    <?php endif; ?>
<?php endforeach; ?>
```

**Notas importantes:**
- Cada salida HTML usa `htmlspecialchars()` para prevenir XSS
- Los filtros se aplican en PHP (lógica de presentación)
- Los datos provienen siempre de la BD a través de la clase Catalogo

---

## Seguridad Implementada

### 1. **Prevención de Inyección SQL**
```php
// En clase Catalogo
$usuario_esc = $this->conexion->real_escape_string($usuario);
$sql = "WHERE Usuario = '$usuario_esc'";

// También usamos intval() para números
$id = intval($id);
$sql = "WHERE id = $id";
```

### 2. **Prevención de XSS (Cross-Site Scripting)**
```php
// En las vistas
<?= htmlspecialchars($datos) ?>
```

### 3. **Autenticación**
```php
// session_start() en cada página
// Verificación de $_SESSION['usuario']
```

### 4. **Contraseñas**
```php
$hash = hash("sha256", $contrasena);
// Comparación: $hash === $cliente["Password"]
```

---

## Patrones de Diseño

### 1. **Data Access Object (DAO)**
La clase `Catalogo` abstrae todas las operaciones de BD.

**Ventaja:** Cambiar BD sin afectar las vistas.

### 2. **Model-View-Controller (Parcial)**
- **Model:** Pelicula, Libro, Producto
- **View:** Catalogo.php, catalogo_libros.php, etc.
- **Controller:** Lógica en las vistas (no MVC puro)

### 3. **Inheritance (Herencia)**
```
Producto (abstracta)
├── Pelicula
└── Libro
```

### 4. **Trait (Composición)**
```php
trait InfoComun {
    public function resumen() { ... }
}

class Pelicula {
    use InfoComun;
}
```

---

## Configuración de Idiomas

### internacionalizacion.php
```php
$idioma = $_SESSION['idioma'] ?? 'es';
require "lang/$idioma.php";
// $traducciones['title'] = "Título" (en español)
```

### lang/es.php
```php
$traducciones = [
    'title' => 'Título',
    'genre' => 'Género',
    // ...
];
```

---

## Variables de Sesión

```php
$_SESSION['usuario']        // Nombre del usuario autenticado
$_SESSION['id_cliente']     // ID del cliente (de Clientes.Id)
$_SESSION['idioma']         // Idioma actual ('es' o 'en')
$_SESSION['genero']         // Filtro de película
$_SESSION['anio']           // Filtro de película
$_SESSION['director']       // Filtro de película
$_SESSION['genero_libro']   // Filtro de libro
$_SESSION['autor_libro']    // Filtro de libro
$_SESSION['anio_libro']     // Filtro de libro
```

---

## Flujo de Datos en un Filtro

### Ejemplo: Filtrar películas por género

**1. Usuario abre Catalogo.php**
```
GET /Catalogo.php
```

**2. Usuario hace clic en "🔍 Filtrar"**
```
GET /filtro.php
```

**3. Usuario selecciona "Drama" y hace clic "Buscar"**
```
GET /Catalogo.php?genero=Drama
```

**4. Catalogo.php procesa:**
```php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $_SESSION["genero"] = $_GET["genero"];  // Drama
}
```

**5. Catalogo.php filtra en PHP:**
```php
foreach ($peliculas as $pelicula) {
    if ($pelicula->getGenero() == "Drama") {
        // Mostrar en tabla
    }
}
```

**6. Filtro se mantiene entre páginas**
```php
$genero = $_SESSION["genero"] ?? "";  // Drama
```

---

## Testing Manual

### Caso 1: Agregar película
1. Login → Inicio → Películas → Añadir
2. Completar: Título, Año, Director, Género
3. Verificar que aparezca en el catálogo

### Caso 2: Filtrar libros
1. Login → Inicio → Libros → Filtrar
2. Seleccionar Autor y Género
3. Verificar que se aplique correctamente
4. Clic "Limpiar" y verificar que muestre todos

### Caso 3: Cambiar idioma
1. Hacer clic en selector de idioma (arriba derecha)
2. Verificar que toda la interfaz cambie de idioma
3. Verificar que el idioma persista entre páginas

---

## Debugging

### Habilitar errores de PHP
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Debugging de BD
```php
// En Catalogo.php
if (!$resultado) {
    echo "Error SQL: " . $this->conexion->error;
}
```

### Debugging de sesión
```php
<?php
var_dump($_SESSION);  // Ver contenido de sesión
var_dump($_GET);      // Ver parámetros GET
var_dump($_POST);     // Ver parámetros POST
?>
```

---

## Performance

- Las consultas se cachean en arrays en memoria
- Los filtros se aplican en PHP (no en BD)
- Las sesiones se guardan en servidor (no en cookies)

---

**Última actualización:** Diciembre 2024  
**Versión:** 1.0
