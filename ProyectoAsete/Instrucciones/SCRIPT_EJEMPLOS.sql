-- ============================================================
-- EJEMPLOS DE INSERCIÓN DE DATOS DE PRUEBA
-- Para: Videoclub-Biblioteca
-- ============================================================

-- NOTA: Estos son ejemplos. Los datos ya deberían existir en la BD.
-- Si necesitas agregar más películas o libros, puedes usar estos scripts
-- como referencia.

-- ============================================================
-- PELÍCULAS NUEVAS (Ejemplos)
-- ============================================================

-- Insertar una película sin adaptación de libro
INSERT INTO Peliculas (Título, Año_estreno, Director, Actores, Género, Tipo_adaptación, Adaptación_ID) 
VALUES ('Interestelar', 2014, 'Christopher Nolan', 'Matthew McConaughey, Anne Hathaway', 'Ciencia ficción', 'Película', NULL);

-- Insertar una película que es adaptación de un libro (Adaptación_ID = 5 como ejemplo)
INSERT INTO Peliculas (Título, Año_estreno, Director, Actores, Género, Tipo_adaptación, Adaptación_ID) 
VALUES ('El Hobbit', 2012, 'Peter Jackson', 'Martin Freeman, Ian McKellen', 'Fantasía', 'Película', 5);

-- Insertar una serie
INSERT INTO Peliculas (Título, Año_estreno, Director, Actores, Género, Tipo_adaptación, Adaptación_ID) 
VALUES ('Chernóbil', 2019, 'Johan Renck', 'Jared Harris, Stellan Skarsgård', 'Drama', 'Serie', NULL);

-- ============================================================
-- LIBROS NUEVOS (Ejemplos)
-- ============================================================

-- Insertar un libro nuevo (Autor_Id debe existir en tabla Autores)
-- Ejemplo: Autor_Id = 1 es un autor existente
INSERT INTO Libros (Titulo, Autor_Id, Genero, Editorial, Paginas, Año, Precio) 
VALUES ('Cien años de soledad', 1, 'Realismo Mágico', 'Sudamericana', 417, 1967, 25.99);

-- Otro ejemplo con diferentes valores
INSERT INTO Libros (Titulo, Autor_Id, Genero, Editorial, Paginas, Año, Precio) 
VALUES ('1984', 2, 'Distopía', 'Signet', 328, 1949, 18.50);

-- ============================================================
-- CLIENTES NUEVOS (Ejemplos)
-- ============================================================

-- Nota: Las contraseñas deben estar en formato SHA256
-- Usar: echo -n "tu_contraseña" | sha256sum

-- Insertar un cliente nuevo
INSERT INTO Clientes (Nombre, Apellidos, Fecha_Nacimiento, Localidad, Password) 
VALUES ('Juan', 'García López', '1990-05-15', 'Madrid', SHA2('password123', 256));

-- Otro cliente
INSERT INTO Clientes (Nombre, Apellidos, Fecha_Nacimiento, Localidad, Password) 
VALUES ('María', 'Rodríguez Pérez', '1985-08-20', 'Barcelona', SHA2('miPassword456', 256));

-- ============================================================
-- AUTORES NUEVOS (Ejemplos)
-- ============================================================

INSERT INTO Autores (Nombre, Fecha_Nacimiento, Lugar, Fecha_Defuncion) 
VALUES ('Stephen King', '1947-09-21', 'Portland, Maine', NULL);

INSERT INTO Autores (Nombre, Fecha_Nacimiento, Lugar, Fecha_Defuncion) 
VALUES ('J.R.R. Tolkien', '1892-01-03', 'Bloemfontein, Sudáfrica', '1973-09-02');

-- ============================================================
-- USUARIOS NUEVOS (Ejemplos)
-- ============================================================

-- Crea un usuario para un cliente existente
-- cliente_id debe corresponder a un cliente existente
INSERT INTO Usuarios (id, nombre, contraseña) 
VALUES (1, 'juan_garcia', SHA2('usuario123', 256));

-- ============================================================
-- RESERVAS (Ejemplos)
-- ============================================================

-- Crear una reserva de un libro
-- Id_Cliente y Id_Libro deben existir
INSERT INTO Reservas (Id_Cliente, Id_Libro, Fecha_Reserva) 
VALUES (1, 5, NOW());

-- ============================================================
-- COMANDOS ÚTILES DE VERIFICACIÓN
-- ============================================================

-- Ver todas las películas
SELECT * FROM Peliculas;

-- Ver todos los libros con sus autores
SELECT l.*, a.Nombre as Autor_Nombre 
FROM Libros l 
LEFT JOIN Autores a ON l.Autor_Id = a.Id;

-- Ver todos los clientes
SELECT * FROM Clientes;

-- Ver todas las reservas
SELECT r.*, c.Nombre as Cliente, l.Titulo as Libro
FROM Reservas r
JOIN Clientes c ON r.Id_Cliente = c.Id
JOIN Libros l ON r.Id_Libro = l.id;

-- Contar registros por tabla
SELECT 'Películas' as Tabla, COUNT(*) as Total FROM Peliculas
UNION ALL
SELECT 'Libros', COUNT(*) FROM Libros
UNION ALL
SELECT 'Autores', COUNT(*) FROM Autores
UNION ALL
SELECT 'Clientes', COUNT(*) FROM Clientes;

-- Ver películas que son adaptaciones de libros
SELECT p.Título, p.Director, l.Titulo as Libro_Original
FROM Peliculas p
LEFT JOIN Libros l ON p.Adaptación_ID = l.id
WHERE p.Adaptación_ID IS NOT NULL;

-- ============================================================
-- ACTUALIZAR DATOS (Ejemplos)
-- ============================================================

-- Actualizar el año de una película
UPDATE Peliculas SET Año_estreno = 2015 WHERE Título = 'Interestelar';

-- Actualizar el precio de un libro
UPDATE Libros SET Precio = 29.99 WHERE Titulo = '1984';

-- ============================================================
-- ELIMINAR DATOS (CUIDADO - Usar solo si es necesario)
-- ============================================================

-- Eliminar una película (la última insertada)
-- DELETE FROM Peliculas WHERE Título = 'Interestelar' LIMIT 1;

-- Eliminar un libro
-- DELETE FROM Libros WHERE Titulo = 'Cien años de soledad' LIMIT 1;

-- ============================================================
-- NOTAS IMPORTANTES
-- ============================================================

/*
1. CONTRASEÑAS:
   - Usar SHA2(contraseña, 256) para generar hashes
   - Ejemplo: SELECT SHA2('miPassword', 256);
   
2. FOREIGN KEYS:
   - Autor_Id en Libros debe existir en Autores.Id
   - Adaptación_ID en Películas debe existir en Libros.id (o ser NULL)
   - Id_Cliente en Reservas debe existir en Clientes.Id
   - Id_Libro en Reservas debe existir en Libros.id

3. RESTRICCIONES:
   - No se pueden eliminar autores que están en libros (FK constraint)
   - No se pueden eliminar clientes que tienen reservas
   - No se pueden eliminar libros que tienen películas adaptadas

4. VALORES NULL:
   - Fecha_Defuncion en Autores puede ser NULL
   - Adaptación_ID en Películas puede ser NULL
   - Tipo_adaptación: 'Película', 'Serie', 'Corto'

5. CARACTERES ESPECIALES:
   - MySQL puede contener caracteres acentuados (UTF-8)
   - Los títulos pueden contener comillas: usar escapes o comillas simples
*/

-- ============================================================
-- FIN DEL SCRIPT
-- ============================================================
