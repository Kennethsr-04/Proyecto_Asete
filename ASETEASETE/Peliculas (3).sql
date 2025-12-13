-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: bbdd
-- Tiempo de generación: 13-12-2025 a las 23:20:14
-- Versión del servidor: 5.7.44
-- Versión de PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Peliculas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Autores`
--

CREATE TABLE `Autores` (
  `Id` int(100) NOT NULL,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Nacimiento` date NOT NULL,
  `Lugar` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Defuncion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Autores`
--

INSERT INTO `Autores` (`Id`, `Nombre`, `Fecha_Nacimiento`, `Lugar`, `Fecha_Defuncion`) VALUES
(1, 'J. R. R. Tolkien', '1892-01-03', 'Bloemfontein', '1973-09-02'),
(2, 'Ernest Hemingway', '1899-07-21', 'Oak Park', '1961-07-02'),
(3, 'C. S. Lewis', '1898-11-29', 'Belfast', '1963-11-22'),
(4, 'Susan E. Hinton', '1948-07-22', 'Tulsa', NULL),
(5, 'J. K. Rowling', '1965-07-31', 'Yate', NULL),
(6, 'George R. R. Martin', '1948-09-20', 'Bayonne', NULL),
(7, 'Fred Uhlman', '1901-01-19', 'Stuttgart', '1985-04-11'),
(8, 'Joël Dicker', '1985-06-16', 'Ginebra', NULL),
(9, 'Mary Ann Shaffer', '1934-12-13', 'Martinsburg', '2008-02-16'),
(10, 'Patricia García-Rojo', '1984-09-24', 'Jaén', NULL),
(11, 'Mark Haddon', '1962-10-28', 'Northampton', NULL),
(12, 'Berlie Doherty', '1943-11-06', 'Knotty Ash', NULL),
(13, 'Jane Austen', '1775-12-16', 'Steventon', '1817-07-18'),
(14, 'Mitch Albom', '1958-05-23', 'Passaic', NULL),
(15, 'David Lozano', '1974-10-30', 'Zaragoza', NULL),
(16, 'María Menéndez-Ponte', '1962-01-01', 'Coruña', NULL),
(17, 'Gabriel García Márquez', '1927-03-06', 'Aracataca', '2014-04-17'),
(18, 'Patrick Rothfuss', '1973-06-06', 'Madison', NULL),
(19, 'Michael Ende', '1929-11-12', 'Garmisch-Partenkirchen', '1995-08-28'),
(20, 'Brandon Sanderson', '1975-12-19', 'Lincoln', NULL),
(21, 'Philip K. Dick', '1928-12-16', 'Illinois', '1982-03-02'),
(22, 'Carlos Ruiz Zafón', '1964-09-25', 'Barcelona', '2020-06-19'),
(23, 'Laura Gallego', '1977-10-11', 'Cuart de Poblet', NULL),
(24, 'R. L. Stevenson', '1850-11-13', 'Edimburgo', '1894-12-03'),
(25, 'Roald Dahl', '1916-09-13', 'Llandaff', '1990-11-23'),
(26, 'Scott Fitzgerald', '1986-09-26', 'Minnesota', '1940-12-21'),
(27, 'Ray Bradbury ', '1920-08-22', 'Illinois', '2012-06-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Clientes`
--

CREATE TABLE `Clientes` (
  `Id` int(100) NOT NULL,
  `Nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `Apellidos` varchar(100) COLLATE utf8_bin NOT NULL,
  `Fecha_Nacimiento` date NOT NULL,
  `Localidad` varchar(100) COLLATE utf8_bin NOT NULL,
  `Password` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `Clientes`
--

INSERT INTO `Clientes` (`Id`, `Nombre`, `Apellidos`, `Fecha_Nacimiento`, `Localidad`, `Password`) VALUES
(1, 'Pedro', 'Díaz', '1990-01-01', 'Gijón', '����l�tx���*o���f��i��uB����'),
(2, 'Guillermo', 'Rosas', '1985-03-01', 'Gijón', ''),
(3, 'Martina', 'Martínez', '1984-07-25', 'Avilés', ''),
(4, 'Francisco', 'Villalba', '1996-03-02', 'Oviedo', ''),
(5, 'Lorena', 'López', '1997-04-15', 'Langreo', ''),
(6, 'Fernanda', 'Fernández', '1992-02-15', 'Mieres', ''),
(7, 'Roberto', 'Ibáñez', '1990-08-31', 'Grado', ''),
(8, 'Alejandra', 'Álvarez', '2006-06-06', 'Oviedo', ''),
(9, 'Marcos', 'Llorente', '2001-01-02', 'Grado', ''),
(10, 'Jorge', 'Molina', '1900-01-05', 'Gijón', ''),
(11, 'Luis', 'Hernández', '1985-05-05', 'Gijón', ''),
(12, 'Fernando', 'Torres', '2003-02-23', 'Avilés', ''),
(13, 'Santiago', 'Arias', '1986-06-16', 'Oviedo', ''),
(14, 'Rodrigo', 'Moreno', '1990-02-14', 'Oviedo', ''),
(15, 'Manuel', 'García', '1980-03-30', 'Oviedo', ''),
(16, 'Ángela', 'Sánchez', '1973-09-11', 'Mieres', ''),
(17, 'Lucía', 'López', '1985-12-25', 'Grado', ''),
(18, 'Míriam', 'Fernández', '1986-12-31', 'Avilés', ''),
(19, 'Daniel', 'Menéndez', '1980-08-08', 'Avilés', ''),
(20, 'Juan', 'Guzmán', '1990-04-23', 'Grado', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Libros`
--

CREATE TABLE `Libros` (
  `id` int(100) NOT NULL,
  `Titulo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Autor_Id` int(100) NOT NULL,
  `Genero` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Editorial` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Paginas` int(100) NOT NULL,
  `Año` date NOT NULL,
  `Precio` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Libros`
--

INSERT INTO `Libros` (`id`, `Titulo`, `Autor_Id`, `Genero`, `Editorial`, `Paginas`, `Año`, `Precio`) VALUES
(1, 'El Señor de los anillos: La comunidad del anillo', 1, 'Fantástico', 'Minotauro', 488, '1954-01-01', 18),
(2, 'El viejo y el mar', 2, 'Novela', 'Debolsillo', 208, '1952-01-01', 11),
(3, 'Las Crónicas de Narnia: El león, la bruja y el armario', 3, 'Fantástico', 'Destino', 240, '1950-01-01', 15),
(4, 'Rebeldes', 4, 'Drama', 'Alfaguara', 224, '1967-01-01', 12),
(5, 'Harry Potter y la prisionero de Azkaban', 5, 'Fantástico', 'Salamandra', 264, '1999-01-01', 18),
(6, 'Canción de hielo y fuego: Juego de Tronos', 6, 'Fantástico', 'Planeta', 800, '1996-01-01', 20),
(7, 'Reencuentro', 7, 'Drama', 'Tusquets', 128, '1971-01-01', 10),
(8, 'La verdad sobre el caso Harry Quebert', 8, 'Policíaco', 'Alfaguara', 672, '2012-01-01', 13),
(9, 'La sociedad literaria y el pastel de piel de patata de Guernsey', 9, 'Novela epistolar', 'Salamandra', 274, '2007-01-01', 10),
(10, 'El mar', 10, 'Fantástico', 'SM', 260, '2015-01-01', 13),
(11, 'El curioso incidente del perro a medianoche', 11, 'Novela', 'Salamandra', 270, '2003-01-01', 10),
(12, 'La hija del mar', 12, 'Fantástico', 'SM', 112, '1996-01-01', 10),
(13, 'Orgullo y prejuicio', 13, 'Novela', 'Penguin', 448, '1813-01-01', 12),
(14, 'Martes con mi viejo profesor', 14, 'Novela biográfica', 'Maeva', 143, '1997-01-01', 13),
(15, 'Desconocidos', 15, 'Policíaco', 'Edebé', 221, '2018-01-01', 12),
(16, 'Nunca seré tu héroe', 16, 'Novela', 'SM', 192, '1998-01-01', 11),
(17, 'Crónica de una muerte anunciada', 17, 'Policíaco', 'Debolsillo', 156, '1981-01-01', 10),
(18, 'El nombre del viento', 18, 'Fantástico', 'Debolsillo', 880, '2007-01-01', 22),
(19, 'La historia interminable', 19, 'Fantástico', 'Alfaguara', 496, '1979-01-01', 15),
(20, 'La ley de la calle', 4, 'Drama', 'Alfaguara', 112, '1975-01-01', 10),
(21, 'Nacidos de la bruma: El imperio final', 20, 'Fantástico', 'Nova', 841, '2006-01-01', 20),
(22, '¿Sueñan los androides con ovejas eléctricas?', 21, 'Ciencia ficción', 'Minotauro', 272, '1968-01-01', 10),
(23, 'El príncipe de la niebla', 22, 'Fantástico', 'Edebé', 240, '1993-01-01', 14),
(24, 'La leyenda del rey errante', 23, 'Fantástico', 'SM', 560, '2004-01-01', 21),
(25, 'La isla del tesoro', 24, 'Aventuras', 'Edelvives', 288, '1883-01-01', 25),
(26, 'Matilda', 25, 'Infantil', 'Loqueleo', 288, '1988-01-01', 10),
(27, 'El gran Gatsby', 26, 'Drama', 'Austral', 224, '1925-01-01', 12),
(28, 'Fahrenheit 451', 27, 'Ciencia ficción', 'Debolsillo', 192, '1953-01-01', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Peliculas`
--

CREATE TABLE `Peliculas` (
  `Id` int(100) NOT NULL,
  `Título` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Año_estreno` date NOT NULL,
  `Director` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Actores` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Género` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Tipo_adaptación` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Adaptación_ID` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Peliculas`
--

INSERT INTO `Peliculas` (`Id`, `Título`, `Año_estreno`, `Director`, `Actores`, `Género`, `Tipo_adaptación`, `Adaptación_ID`) VALUES
(1, 'El editor de libros', '2016-01-01', 'Michael Grandage', 'Colin Firth, Jude Law, Nicole Kidman', 'Biografía', 'Película', NULL),
(2, 'La historia interminable', '1984-01-01', 'Wolfgang Petersen', 'Barret Oliver, Noah Hathaway, Moses Gunn', 'Fantasía', 'Película', 19),
(3, 'La ladrona de libros', '2013-01-01', 'Brian Percival', 'Sophie Nélisse, Geoffrey Rush, Emily Watson, Nico Liersch', 'Drama', 'Película', NULL),
(4, 'La bruja novata', '1971-01-01', 'Robert Stevenson', 'Angela Lansbury, David Tomlinson, Roddy McDowall', 'Fantasía', 'Película', NULL),
(5, 'Harry Potter y el prisionero de Azkaban', '2004-01-01', 'Alfonso Cuarón', 'Daniel Radcliffe, Rupert Grint, Emma Watson', 'Fantasía', 'Película', 5),
(6, 'El señor de los anillos: La comunidad del anillo', '2001-01-01', 'Peter Jackson', 'Elijah Wood, Ian McKellen, Viggo Mortensen', 'Fantasía', 'Película', 1),
(7, 'Charlie y la fábrica de chocolate', '2005-01-01', 'Tim Burton', 'Johnny Depp, Freddie Highmore, David Kelly, Deep Roy', 'Fantasía', 'Película', NULL),
(8, 'Las Crónicas de Narnia: El león, la bruja y el armario', '2005-01-01', 'Andrew Adamson', 'Georgie Henley, William Moseley, Skandar Keynes, Anna Popplewell, Tilda Swinton', 'Fantasía', 'Película', NULL),
(9, 'Rebeldes', '1983-01-01', 'Francis Ford Coppola', 'C. Thomas Howell, Matt Dillon, Ralph Macchio, Diane Lane, Rob Lowe, Patrick Swayze, Emilio Estévez, Tom Cruise', 'Drama', 'Película', 4),
(10, 'Juego de Tronos: Temporada 1', '2011-01-01', 'David Benioff, D.B. Weiss', 'Emilia Clarke, Kit Harington, Lena Headey, Peter Dinklage, Maisie Williams, Nikolaj Coster-Waldau, Sophie Turner', 'Fantasía', 'Serie', 6),
(11, 'La verdad sobre el caso Harry Quebert', '2018-01-01', 'Jean-Jacques Annaud', 'Patrick Dempsey, Ben Schnetzer, Kristine Froseth, Damon Wayans Jr.', 'Policíaco', 'Serie', 8),
(12, 'La sociedad literaria y el pastel de piel de patata de Guernsey', '2018-01-01', 'Mike Newell', 'Lily James, Michiel Huisman, Glen Powell, Jessica Brown Findlay, Matthew Goode', 'Drama', 'Película', 9),
(13, 'Orgullo y prejuicio', '2005-01-01', 'Joe Wright', 'Keira Knightley, Matthew Macfadyen, Brenda Blethyn, Donald Sutherland', 'Romance', 'Película', 13),
(14, 'Orgullo y prejuicio', '1995-01-01', 'Simon Langton', 'Colin Firth, Jennifer Ehle, David Bamber, Crispin Bonham-carter, Anna Chancellor', 'Romance', 'Serie', 13),
(15, 'Crónica de una muerte anunciada', '1987-01-01', 'Francesco Rosi', 'Anthony Delon, Rupert Everett, Lucía Bosé, Ornella Muti, Gian Maria Volonté', 'Drama', 'Película', NULL),
(16, 'La ley de la calle', '1983-01-01', 'Francis Ford Coppola', 'Matt Dillon, Mickey Rourke, Diane Lane, Dennis Hopper, Nicolas Cage', 'Drama', 'Película', 20),
(17, 'Blade Runner', '1982-01-01', 'Ridley Scott', 'Harrison Ford, Rutger Hauer, Sean Young, Daryl Hannah, Edward James Olmos', 'Ciencia ficción', 'Película', 22),
(18, 'La isla del tesoro', '1934-01-01', 'Victor Fleming', 'Jackie Cooper, Wallace Beery, Lewis Stone, Lionel Barrymore, Otto Kruger', 'Aventuras', 'Película', 25),
(19, 'La isla del tesoro', '1950-01-01', 'Byron Haskin', 'Bobby Driscoll, Robert Newton, Basil Sydney, Walter Fitzgerald, Denis O\'Dea', 'Aventuras', 'Película', 25),
(20, 'La isla del tesoro', '1990-01-01', 'Fraser Clarke Heston', 'Charlton Heston, Christian Bale, Oliver Reed, Christopher Lee, Richard Johnson', 'Aventuras', 'Serie', 25),
(21, 'Matilda', '1996-01-01', 'Danny DeVito', 'Mara Wilson, Danny DeVito, Rhea Perlman, Embeth Davidtz, Pam Ferris', 'Infantil', 'Película', NULL),
(22, 'Un mundo de fantasía', '1971-01-01', 'Mel Stuart', 'Gene Wilder, Jack Albertson, Peter Ostrum, Roy Kinnear, Michael Bollner', 'Infantil', 'Película', NULL),
(23, 'Por quién doblan las campanas', '1943-01-01', 'Sam Wood', 'Gary Cooper, Ingrid Bergman, Akim Tamiroff, Arturo de Córdova, Vladimir Sokoloff', 'Drama', 'Película', NULL),
(24, 'Harry Potter y el cáliz de fuego', '2005-01-01', 'Mike Newell', 'Daniel Radcliffe, Rupert Grint, Emma Watson, Robbie Coltrane, Michael Gambon', 'Fantasía', 'Película', NULL),
(25, 'El gran Gatsby', '1949-01-01', 'Elliott Nugent', 'Alan Ladd, Betty Field, Macdonald Carey, Ruth Hussey, Barry Sullivan', 'Drama', 'Película', 27),
(26, 'El gran Gatsby', '1974-01-01', 'Jack Clayton', 'Robert Redford, Mia Farrow, Bruce Dern, Karen Black, Scott Wilson', 'Drama', 'Película', 27),
(27, 'El gran Gatsby', '2000-01-01', 'Robert Markowitz', 'Mira Sorvino, Toby Stephens, Paul Rudd, Martin Donovan, Francie Swift', 'Drama', 'Serie', 27),
(28, 'El gran Gatsby', '2013-01-01', 'Baz Luhrmann', 'Leonardo DiCaprio, Tobey Maguire, Carey Mulligan, Joel Edgerton, Isla Fisher', 'Drama', 'Película', 27),
(29, 'Fahrenheit 451', '1966-01-01', 'François Truffaut', 'Julie Christie, Oskar Werner, Cyril Cusack, Anton Diffring, Jeremy Spenser, Ann Bell', 'Ciencia ficción', 'Película', 26),
(30, 'Fahrenheit 451', '2018-01-01', 'Ramin Bahrani', 'Michael B. Jordan, Michael Shannon, Sofia Boutella, Laura Harrier, Lilly Singh', 'Ciencia ficción', 'Película', 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Reservas`
--

CREATE TABLE `Reservas` (
  `Id_Cliente` int(100) NOT NULL,
  `Id_Libro` int(100) NOT NULL,
  `Fecha_Reserva` date NOT NULL,
  `Id_Pelicula` int(100) NOT NULL,
  `Fecha_Devolucion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `id` int(100) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `contraseña` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Autores`
--
ALTER TABLE `Autores`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `Clientes`
--
ALTER TABLE `Clientes`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `Libros`
--
ALTER TABLE `Libros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Autores` (`Autor_Id`);

--
-- Indices de la tabla `Peliculas`
--
ALTER TABLE `Peliculas`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_libros` (`Adaptación_ID`);

--
-- Indices de la tabla `Reservas`
--
ALTER TABLE `Reservas`
  ADD KEY `fk_ReservaL` (`Id_Libro`),
  ADD KEY `fk_ReservaC` (`Id_Cliente`),
  ADD KEY `fk_Peliculas` (`Id_Pelicula`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Autores`
--
ALTER TABLE `Autores`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `Clientes`
--
ALTER TABLE `Clientes`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `Libros`
--
ALTER TABLE `Libros`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `Peliculas`
--
ALTER TABLE `Peliculas`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Libros`
--
ALTER TABLE `Libros`
  ADD CONSTRAINT `fk_Autores` FOREIGN KEY (`Autor_Id`) REFERENCES `Autores` (`Id`);

--
-- Filtros para la tabla `Peliculas`
--
ALTER TABLE `Peliculas`
  ADD CONSTRAINT `fk_libros` FOREIGN KEY (`Adaptación_ID`) REFERENCES `Libros` (`id`);

--
-- Filtros para la tabla `Reservas`
--
ALTER TABLE `Reservas`
  ADD CONSTRAINT `fk_Peliculas` FOREIGN KEY (`Id_Pelicula`) REFERENCES `Peliculas` (`Id`),
  ADD CONSTRAINT `fk_Reserva` FOREIGN KEY (`Id_Libro`) REFERENCES `Libros` (`id`),
  ADD CONSTRAINT `fk_ReservaC` FOREIGN KEY (`Id_Cliente`) REFERENCES `Clientes` (`Id`);

--
-- Filtros para la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD CONSTRAINT `fk_Clientes` FOREIGN KEY (`id`) REFERENCES `Clientes` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
