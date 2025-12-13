# 📚🎬 INSTRUCCIONES DE USO - Videoclub-Biblioteca

## Inicio de Sesión

1. Abre el navegador y ve a `http://localhost/ProyectoAsete/login.php`
2. Ingresa el nombre de un cliente registrado en la base de datos
3. Ingresa su contraseña SHA256
4. Haz clic en "Iniciar Sesión"

> **Nota:** Las contraseñas de prueba están almacenadas como hashes SHA256. Contacta al profesor para obtener credenciales de prueba.

---

## Panel Principal (Inicio)

Una vez autenticado, verás el **Panel Principal** con dos opciones:

### 🎬 **Películas**
Accede al catálogo completo de películas.

### 📚 **Libros**
Accede al catálogo completo de libros.

---

## Catálogo de Películas

### Ver Películas
- Muestra una tabla con todas las películas disponibles
- Información mostrada:
  - Título
  - Director
  - Actores
  - Año de estreno
  - Género

### Filtrar Películas
1. Haz clic en **"🔍 Filtrar"**
2. Selecciona los filtros deseados:
   - **Género:** Selecciona de la lista
   - **Año:** Ingresa un año específico
   - **Director:** Busca por nombre parcial
3. Haz clic en **"Buscar"**

### Limpiar Filtros
- Haz clic en **"↺ Limpiar Filtros"** para mostrar todas las películas nuevamente

### Añadir Película
1. Haz clic en **"➕ Añadir Película"**
2. Completa el formulario:
   - **Título:** Nombre de la película (obligatorio)
   - **Año:** Año de estreno (obligatorio)
   - **Director:** Nombre del director (obligatorio)
   - **Actores:** Actores principales (opcional)
   - **Género:** Selecciona de la lista (obligatorio)
3. Haz clic en **"Guardar Película"**
4. Se mostrará un mensaje de confirmación

---

## Catálogo de Libros

### Ver Libros
- Muestra una tabla con todos los libros disponibles
- Información mostrada:
  - Título
  - Autor
  - Editorial
  - Año de publicación
  - Género
  - Número de páginas
  - Precio

### Filtrar Libros
1. Haz clic en **"🔍 Filtrar"**
2. Selecciona los filtros deseados:
   - **Género:** Selecciona de la lista
   - **Autor:** Selecciona de la lista de autores
   - **Año:** Selecciona el año de publicación
3. Haz clic en **"Buscar"**

### Limpiar Filtros
- Haz clic en **"↺ Limpiar Filtros"** para mostrar todos los libros nuevamente

### Añadir Libro
1. Haz clic en **"➕ Añadir Libro"**
2. Completa el formulario:
   - **Título:** Nombre del libro (obligatorio)
   - **Autor:** Selecciona de la lista (obligatorio)
   - **Editorial:** Casa editora (obligatorio)
   - **Género:** Selecciona de la lista (obligatorio)
   - **Número de Páginas:** Cantidad de páginas (obligatorio)
   - **Año:** Año de publicación (obligatorio)
   - **Precio:** Precio en euros (obligatorio)
3. Haz clic en **"Guardar Libro"**
4. Se mostrará un mensaje de confirmación

---

## Cambio de Idioma

En todas las páginas encontrarás un selector de idioma en la esquina superior derecha:

- 🇪🇸 **Español** (por defecto)
- 🇬🇧 **Inglés**

Haz clic para cambiar el idioma de la interfaz.

---

## Navegación General

### Barra de Herramientas (en cada página)

| Botón | Función |
|-------|---------|
| 🔍 Filtrar | Abre la página de filtros |
| ↺ Limpiar Filtros | Elimina todos los filtros aplicados |
| ➕ Añadir | Abre el formulario para agregar un nuevo elemento |
| 🎬 Ver Películas | Va al catálogo de películas |
| 📚 Ver Libros | Va al catálogo de libros |
| 🏠 Inicio | Va al panel principal |

### Información del Usuario

En la esquina superior derecha verás:
- Tu nombre de usuario
- Botón **"Cerrar sesión"** para salir de tu cuenta

---

## Mensajes del Sistema

### ✓ Mensaje de Éxito
Aparece cuando:
- Se añade correctamente una película o libro
- Se realizan cambios exitosamente

### ✗ Mensaje de Error
Aparece cuando:
- Faltan campos obligatorios en un formulario
- Hay un problema con la base de datos
- Los datos ingresados son inválidos

---

## Consejos y Buenas Prácticas

### Búsqueda de Películas
- La búsqueda por director busca **coincidencias parciales**
- Ejemplo: Si buscas "Bur", encontrará películas dirigidas por Burton
- Los filtros son **acumulativos**: puedes aplicar varios al mismo tiempo

### Búsqueda de Libros
- El filtro de autor muestra una **lista desplegable** con todos los autores
- Puedes filtrar simultáneamente por autor, género y año

### Formularios
- Los campos marcados con **\*** son obligatorios
- Presiona **Tab** para moverte entre campos
- Haz clic en **"Cancelar"** para descartar cambios

---

## Solución de Problemas

### "No se encontraron películas/libros"
- Verifica que los filtros aplicados sean correctos
- Haz clic en "Limpiar Filtros" para ver todos los resultados
- Comprueba que exista al menos un registro en la base de datos

### "Error al añadir el elemento"
- Completa todos los campos obligatorios (marcados con *)
- Verifica que la conexión a la base de datos esté activa
- Contacta al administrador si el problema persiste

### Sesión expirada
- Vuelve a iniciar sesión
- Los datos agregados se guardan incluso si se cierra la sesión

### Error de idioma
- Recarga la página (F5)
- Comprueba que los archivos de idioma existan en la carpeta `lang/`

---

## Seguridad

- **Nunca** compartas tu contraseña con otros usuarios
- Las contraseñas se almacenan de forma segura (hash SHA256)
- Siempre haz clic en **"Cerrar sesión"** cuando termines
- No cierres el navegador sin cerrar sesión en computadoras compartidas

---

## Contacto y Soporte

Para reportar problemas o solicitar ayuda:

- **Profesor:** [Nombre del profesor]
- **Email:** [Email de contacto]
- **Horario de atención:** [Horario]

---

**Última actualización:** Diciembre 2024  
**Versión del Manual:** 1.0
