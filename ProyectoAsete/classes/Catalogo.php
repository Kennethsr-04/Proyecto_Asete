<?php
require_once __DIR__ . "/../Pelicula.php";
require_once __DIR__ . "/../Libro.php";

class Catalogo {
    
    private $conexion;
    
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // =================== PELÍCULAS ===================

    public function obtenerPeliculas() {
        $sql = "SELECT * FROM Peliculas";
        $resultado = $this->conexion->query($sql);
        $peliculas = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $peliculas[] = new Pelicula($fila);
            }
        }
        return $peliculas;
    }

    public function obtenerPeliculaPorId($id) {
        $id = intval($id);
        $sql = "SELECT * FROM Peliculas WHERE Id = $id";
        $resultado = $this->conexion->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            return new Pelicula($fila);
        }
        return null;
    }

    public function agregarPelicula($titulo, $anio, $director, $actores, $genero) {
        $titulo = $this->conexion->real_escape_string($titulo);
        $director = $this->conexion->real_escape_string($director);
        $actores = $this->conexion->real_escape_string($actores);
        $genero = $this->conexion->real_escape_string($genero);
        $anio = intval($anio);
        $sql = "INSERT INTO Peliculas (Título, Año_estreno, Director, Actores, Género, Tipo_adaptación, Adaptación_ID) 
                VALUES ('$titulo', '$anio-01-01', '$director', '$actores', '$genero', 'Película', NULL)";
        return $this->conexion->query($sql);
    }

    public function actualizarPelicula($id, $titulo, $anio, $director, $actores, $genero) {
        $id = intval($id);
        $titulo = $this->conexion->real_escape_string($titulo);
        $director = $this->conexion->real_escape_string($director);
        $actores = $this->conexion->real_escape_string($actores);
        $genero = $this->conexion->real_escape_string($genero);
        $anio = intval($anio);
        $sql = "UPDATE Peliculas 
                SET Título='$titulo', Año_estreno='$anio-01-01', Director='$director', 
                    Actores='$actores', Género='$genero'
                WHERE Id=$id";
        return $this->conexion->query($sql);
    }

    public function eliminarPelicula($id) {
        $id = intval($id);
        $sql = "DELETE FROM Peliculas WHERE Id=$id";
        return $this->conexion->query($sql);
    }

    public function isDisponiblePelicula($id_pelicula) {
        $id_pelicula = intval($id_pelicula);
        $sql = "SELECT * FROM Reservas WHERE Id_Pelicula = $id_pelicula AND Fecha_Devolucion IS NULL LIMIT 1";
        $resultado = $this->conexion->query($sql);
        return ($resultado && $resultado->num_rows === 0);
    }

    public function reservarPelicula($id_cliente, $id_pelicula) {
        $id_cliente = intval($id_cliente);
        $id_pelicula = intval($id_pelicula);
        if (!$this->isDisponiblePelicula($id_pelicula)) return false;
        $sql = "INSERT INTO Reservas (Id_Cliente, Id_Pelicula, Fecha_Reserva) VALUES ($id_cliente, $id_pelicula, NOW())";
        return $this->conexion->query($sql);
    }

    public function devolverPelicula($id_cliente, $id_pelicula) {
        $id_cliente = intval($id_cliente);
        $id_pelicula = intval($id_pelicula);
        $sql = "UPDATE Reservas 
                SET Fecha_Devolucion = NOW() 
                WHERE Id_Cliente = $id_cliente AND Id_Pelicula = $id_pelicula AND Fecha_Devolucion IS NULL 
                LIMIT 1";
        return $this->conexion->query($sql);
    }

    // =================== LIBROS ===================

    public function obtenerLibros() {
        $sql = "SELECT l.*, a.Nombre as Autor_Nombre 
                FROM Libros l
                LEFT JOIN Autores a ON l.Autor_Id = a.Id
                ORDER BY l.Titulo";
        $resultado = $this->conexion->query($sql);
        $libros = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $libros[] = new Libro($fila);
            }
        }
        return $libros;
    }

    public function obtenerLibroPorId($id) {
        $id = intval($id);
        $sql = "SELECT l.*, a.Nombre as Autor_Nombre 
                FROM Libros l
                LEFT JOIN Autores a ON l.Autor_Id = a.Id
                WHERE l.id = $id";
        $resultado = $this->conexion->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            return new Libro($fila);
        }
        return null;
    }

    public function agregarLibro($titulo, $autorId, $genero, $editorial, $paginas, $anio, $precio) {
        $titulo = $this->conexion->real_escape_string($titulo);
        $editorial = $this->conexion->real_escape_string($editorial);
        $genero = $this->conexion->real_escape_string($genero);
        $autorId = intval($autorId);
        $paginas = intval($paginas);
        $anio = intval($anio);
        $precio = intval($precio);
        $sql = "INSERT INTO Libros (Titulo, Autor_Id, Genero, Editorial, Paginas, Año, Precio) 
                VALUES ('$titulo', $autorId, '$genero', '$editorial', $paginas, '$anio-01-01', $precio)";
        return $this->conexion->query($sql);
    }

    public function actualizarLibro($id, $titulo, $autorId, $genero, $editorial, $paginas, $anio, $precio) {
        $id = intval($id);
        $titulo = $this->conexion->real_escape_string($titulo);
        $editorial = $this->conexion->real_escape_string($editorial);
        $genero = $this->conexion->real_escape_string($genero);
        $autorId = intval($autorId);
        $paginas = intval($paginas);
        $anio = intval($anio);
        $precio = intval($precio);
        $sql = "UPDATE Libros 
                SET Titulo='$titulo', Autor_Id=$autorId, Genero='$genero', 
                    Editorial='$editorial', Paginas=$paginas, Año='$anio-01-01', Precio=$precio
                WHERE id=$id";
        return $this->conexion->query($sql);
    }

    public function eliminarLibro($id) {
        $id = intval($id);
        $sql = "DELETE FROM Libros WHERE id=$id";
        return $this->conexion->query($sql);
    }

    public function isDisponible($id_libro) {
        $id_libro = intval($id_libro);
        $sql = "SELECT * FROM Reservas WHERE Id_Libro = $id_libro AND Fecha_Devolucion IS NULL LIMIT 1";
        $resultado = $this->conexion->query($sql);
        return ($resultado && $resultado->num_rows === 0);
    }

    public function reservarLibro($id_cliente, $id_libro) {
        $id_cliente = intval($id_cliente);
        $id_libro = intval($id_libro);
        if (!$this->isDisponible($id_libro)) return false;
        $sql = "INSERT INTO Reservas (Id_Cliente, Id_Libro, Fecha_Reserva) VALUES ($id_cliente, $id_libro, NOW())";
        return $this->conexion->query($sql);
    }

    public function devolverLibro($id_cliente, $id_libro) {
        $id_cliente = intval($id_cliente);
        $id_libro = intval($id_libro);
        $sql = "UPDATE Reservas 
                SET Fecha_Devolucion = NOW() 
                WHERE Id_Cliente = $id_cliente AND Id_Libro = $id_libro AND Fecha_Devolucion IS NULL 
                LIMIT 1";
        return $this->conexion->query($sql);
    }

    // =================== RESERVAS CLIENTE ===================

    public function obtenerReservasCliente($id_cliente) {
        $id_cliente = intval($id_cliente);
        $sql = "SELECT r.*, 
                l.id as libro_id, l.Titulo as libro_titulo, l.Genero as libro_genero,
                p.Id as pelicula_id, p.Título as pelicula_titulo, p.Director as pelicula_director
                FROM Reservas r
                LEFT JOIN Libros l ON r.Id_Libro = l.id
                LEFT JOIN Peliculas p ON r.Id_Pelicula = p.Id
                WHERE r.Id_Cliente = $id_cliente
                ORDER BY r.Fecha_Reserva DESC";
        $resultado = $this->conexion->query($sql);
        $reservas = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $reservas[] = $fila;
            }
        }
        return $reservas;
    }

    public function obtenerReservasActivasCliente($id_cliente) {
        $id_cliente = intval($id_cliente);
        $sql = "SELECT r.*, 
                l.id as libro_id, l.Titulo as libro_titulo, l.Genero as libro_genero,
                p.Id as pelicula_id, p.Título as pelicula_titulo, p.Director as pelicula_director
                FROM Reservas r
                LEFT JOIN Libros l ON r.Id_Libro = l.id
                LEFT JOIN Peliculas p ON r.Id_Pelicula = p.Id
                WHERE r.Id_Cliente = $id_cliente AND r.Fecha_Devolucion IS NULL
                ORDER BY r.Fecha_Reserva DESC";
        $resultado = $this->conexion->query($sql);
        $reservas = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $reservas[] = $fila;
            }
        }
        return $reservas;
    }

    public function obtenerHistorialDevolucionesCliente($id_cliente) {
        $id_cliente = intval($id_cliente);
        $sql = "SELECT r.*, 
                l.id as libro_id, l.Titulo as libro_titulo, l.Genero as libro_genero,
                p.Id as pelicula_id, p.Título as pelicula_titulo, p.Director as pelicula_director
                FROM Reservas r
                LEFT JOIN Libros l ON r.Id_Libro = l.id
                LEFT JOIN Peliculas p ON r.Id_Pelicula = p.Id
                WHERE r.Id_Cliente = $id_cliente AND r.Fecha_Devolucion IS NOT NULL
                ORDER BY r.Fecha_Devolucion DESC";
        $resultado = $this->conexion->query($sql);
        $reservas = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $reservas[] = $fila;
            }
        }
        return $reservas;
    }
}
?>
