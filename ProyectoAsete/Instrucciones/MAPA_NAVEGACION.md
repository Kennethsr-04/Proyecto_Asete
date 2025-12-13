# 🎯 MAPA DE NAVEGACIÓN - v1.1

## Diagrama de Flujos del Sistema

```
┌─────────────────────────────────────────────────────────────────────────┐
│                     VIDEOCLUB-BIBLIOTECA v1.1                           │
│                                                                           │
│  FLUJO PRINCIPAL DEL USUARIO:                                           │
│                                                                           │
│  1. SIN AUTENTICACIÓN                                                   │
│     └─→ index.html (portal)                                             │
│        └─→ login.php (login o registro)                                 │
│           ├─→ NUEVA: register.php (crear cuenta)                       │
│           │   ├─ Validar datos                                          │
│           │   ├─ Hash SHA256 contraseña                                 │
│           │   └─→ Auto-login → index.php                               │
│           │                                                              │
│           └─→ login.php (usuario existente)                             │
│               └─→ index.php (dashboard)                                 │
│                                                                           │
│  2. CON AUTENTICACIÓN                                                   │
│     └─→ index.php (dashboard con 4 opciones)                           │
│        │                                                                  │
│        ├─→ 🎬 PELÍCULAS                                                 │
│        │   ├─→ Catalogo.php (tabla con estado)                         │
│        │   │   ├─ Verde (Disponible) → Botón "Reservar"               │
│        │   │   └─ Rojo (Reservado) → Botón "Reservado" (deshabilitado)│
│        │   │       ├─→ NUEVO: reservar_pelicula.php (confirmación)    │
│        │   │       │   ├─ Ver detalles (director, duración, etc.)     │
│        │   │       │   ├─ Verificar disponibilidad                     │
│        │   │       │   └─→ Crear reserva en BD                        │
│        │   │       │       └─→ mis_reservas.php                       │
│        │   │       │                                                    │
│        │   │       └─ Si NO disponible: Mensaje de error               │
│        │   │                                                             │
│        │   └─→ filtro.php (filtro avanzado)                            │
│        │       ├─ Por director                                          │
│        │       ├─ Por género                                            │
│        │       ├─ Por año                                               │
│        │       └─→ Resultado → Catalogo.php                            │
│        │                                                                 │
│        ├─→ 📚 LIBROS                                                    │
│        │   ├─→ catalogo_libros.php (tabla con estado)                  │
│        │   │   ├─ Verde (Disponible) → Botón "Reservar"               │
│        │   │   └─ Rojo (Reservado) → Botón "Reservado" (deshabilitado)│
│        │   │       ├─→ NUEVO: reservar_libro.php (confirmación)       │
│        │   │       │   ├─ Ver detalles (autor, páginas, etc.)         │
│        │   │       │   ├─ Verificar disponibilidad                     │
│        │   │       │   └─→ Crear reserva en BD                        │
│        │   │       │       └─→ mis_reservas.php                       │
│        │   │       │                                                    │
│        │   │       └─ Si NO disponible: Mensaje de error               │
│        │   │                                                             │
│        │   └─→ filtro_libros.php (filtro avanzado)                     │
│        │       ├─ Por autor                                             │
│        │       ├─ Por género                                            │
│        │       ├─ Por año                                               │
│        │       └─→ Resultado → catalogo_libros.php                     │
│        │                                                                 │
│        ├─→ 📋 NUEVO: MIS RESERVAS                                      │
│        │   └─→ mis_reservas.php (2 secciones)                          │
│        │       │                                                         │
│        │       ├─ RESERVAS ACTIVAS (no devueltas)                      │
│        │       │  ├─ Muestra: Tipo, Título, Fecha, Detalles           │
│        │       │  └─ Botón "Devolver"                                  │
│        │       │      └─ UPDATE BD (Fecha_Devolucion = NOW())         │
│        │       │          └─ Item se mueve a Historial                 │
│        │       │                                                         │
│        │       └─ HISTORIAL DE DEVOLUCIONES (ya devueltas)             │
│        │           ├─ Muestra: Tipo, Título, Duración en días          │
│        │           └─ Información (sin acciones)                        │
│        │                                                                 │
│        └─→ 🔍 NUEVO: FILTRO POR ESTADO                                 │
│            └─→ filtro_estado.php (combinado)                           │
│                ├─ Switch: Libros ↔ Películas                           │
│                └─ Filtros:                                              │
│                   ├─ Todos (muestra contador total)                     │
│                   ├─ Disponibles (solo items sin reserva)               │
│                   └─ Reservados (solo items con reserva activa)         │
│                       └─ Resultado en tabla                             │
│                           └─ Botones contextuales:                      │
│                               ├─ "Reservar" si disponible               │
│                               └─ "Reservado" si no disponible           │
│                                   └─→ reservar_libro.php O             │
│                                       reservar_pelicula.php             │
│        │                                                                 │
│        └─ LOGOUT                                                        │
│            └─→ logout.php                                               │
│                └─→ Destroy sesión                                       │
│                    └─→ login.php                                        │
│                                                                           │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## 📊 Matriz de Transiciones

| DE | A | CONDICIÓN | NUEVO en v1.1 |
|---|---|-----------|---------------|
| index.html | login.php | - | - |
| login.php | register.php | "Regístrate aquí" | ✅ |
| register.php | index.php | Registro exitoso + auto-login | ✅ |
| index.php | Catalogo.php | Click "Películas" | ✅ Columna Estado |
| index.php | catalogo_libros.php | Click "Libros" | ✅ Columna Estado |
| index.php | mis_reservas.php | Click "Mis Reservas" | ✅ NUEVO |
| index.php | filtro_estado.php | Click "Filtro Estado" | ✅ NUEVO |
| Catalogo.php | filtro.php | Click botón Filtrar | - |
| catalogo_libros.php | filtro_libros.php | Click botón Filtrar | - |
| Catalogo.php | reservar_pelicula.php | Click "Reservar" | ✅ NUEVO |
| catalogo_libros.php | reservar_libro.php | Click "Reservar" | ✅ NUEVO |
| filtro_estado.php | reservar_libro.php | Click "Reservar" | ✅ NUEVO |
| filtro_estado.php | reservar_pelicula.php | Click "Reservar" | ✅ NUEVO |
| reservar_libro.php | mis_reservas.php | Confirmar reserva | ✅ NUEVO |
| reservar_pelicula.php | mis_reservas.php | Confirmar reserva | ✅ NUEVO |
| mis_reservas.php | mis_reservas.php | Click "Devolver" | ✅ NUEVO |
| * (cualquiera) | login.php | No autenticado | ✅ Protección |

---

## 🔄 Flujo de Datos - Reserva

```
┌──────────────────────────────────────────────────────────────┐
│ FLUJO COMPLETO DE UNA RESERVA (v1.1)                         │
└──────────────────────────────────────────────────────────────┘

1. USUARIO VE CATÁLOGO
   ↓
   Catalogo.php carga datos:
   - Obtiene lista de películas/libros
   - Para cada item: isDisponible(id)?
   - Muestra badge verde (Disponible) o rojo (Reservado)
   - Botón "Reservar" habilitado solo si disponible

2. USUARIO HALLA ITEM DISPONIBLE
   ↓
   Click botón "Reservar" → URL: reservar_libro.php?id=5

3. PÁGINA DE CONFIRMACIÓN
   ↓
   - Verifica autenticación
   - Obtiene ID cliente desde sesión
   - Carga datos del item (Libro/Película)
   - Verifica disponibilidad (isDisponible)
   - Muestra detalles + badge de disponibilidad
   - Presenta botón "Confirmar Reserva"

4. USUARIO CONFIRMA
   ↓
   POST a reservar_libro.php / reservar_pelicula.php
   - Verifica disponibilidad de nuevo (protección)
   - Llama: $catalogo->reservarLibro($id_cliente, $id_libro)

5. MÉTODO CATALOGO EJECUTA RESERVA
   ↓
   reservarLibro($id_cliente, $id_libro):
   {
       if (!isDisponible($id_libro)) {
           return false; // Ya no disponible
       }
       
       INSERT INTO Reservas (Id_Cliente, Id_Libro, Fecha_Reserva) 
       VALUES ($id_cliente, $id_libro, NOW())
       return true;
   }

6. BASE DE DATOS SE ACTUALIZA
   ↓
   Nueva fila en Reservas:
   id | Id_Cliente | Id_Libro | Fecha_Reserva | Fecha_Devolucion
   -- | ---------- | -------- | -------------- | ----------------
   42 | 5          | 12       | 2024-12-19...  | NULL

7. REDIRECCIONAMIENTO
   ↓
   header("Location: mis_reservas.php")
   $_SESSION['exito'] = "¡Libro reservado exitosamente!"

8. MIS RESERVAS MUESTRA
   ↓
   mis_reservas.php carga:
   - obtenerReservasActivasCliente($id_cliente)
   - Muestra item en "Reservas Activas"
   - Nuevo item aparece en tabla
   - Botón "Devolver" disponible

9. DEVOLUCIÓN (POSTERIOR)
   ↓
   Usuario click "Devolver":
   - POST con id de reserva
   - Llama: $catalogo->devolverLibro($id_cliente, $id_libro)
   - UPDATE Reservas SET Fecha_Devolucion = NOW()
   - Item se mueve a "Historial de Devoluciones"
```

---

## 🗄️ Flujo de Datos - Base de Datos

```
┌────────────────────────────────────────┐
│ ESTRUCTURA DE DATOS EN RESERVAS (v1.1) │
└────────────────────────────────────────┘

TABLA: Reservas

RESERVA ACTIVA (Libro):
┌────┬───────────┬─────────┬──────────────┬──────────────────┐
│id  │Id_Cliente │Id_Libro │Fecha_Reserva│Fecha_Devolucion  │
├────┼───────────┼─────────┼──────────────┼──────────────────┤
│ 42 │     5     │   12    │2024-12-19... │     NULL         │  ← ACTIVA
└────┴───────────┴─────────┴──────────────┴──────────────────┘
                                             (NULL = no devuelto)

RESERVA COMPLETADA (Película):
┌────┬───────────┬───────────┬──────────────┬──────────────────┐
│id  │Id_Cliente │Id_Pelicula│Fecha_Reserva│Fecha_Devolucion  │
├────┼───────────┼───────────┼──────────────┼──────────────────┤
│ 41 │     5     │   8       │2024-12-15... │2024-12-18 16:30  │  ← DEVUELTA
└────┴───────────┴───────────┴──────────────┴──────────────────┘
                                             (Timestamp = devuelto)

LÓGICA:
- Reserva ACTIVA: Fecha_Devolucion IS NULL
- Reserva COMPLETADA: Fecha_Devolucion IS NOT NULL
- Item DISPONIBLE: No existe reserva activa (NULL)
- Item RESERVADO: Existe al menos 1 reserva activa

CÁLCULO DE DURACIÓN:
- días = (Fecha_Devolucion - Fecha_Reserva) / 86400 segundos
```

---

## 🎨 Mapa Visual de Pantallas v1.1

```
┌─────────────────────────────────────────────────────────────┐
│ PANTALLA: index.php (Dashboard)                             │
├─────────────────────────────────────────────────────────────┤
│  🎬 PELÍCULAS        📚 LIBROS                              │
│  Ver películas       Ver libros                             │
│                                                              │
│  📋 MIS RESERVAS     🔍 FILTRO ESTADO  ← NUEVAS (v1.1)    │
│  Ver mis reservas    Buscar disponibles                     │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│ PANTALLA: Catalogo.php / catalogo_libros.php                │
├─────────────────────────────────────────────────────────────┤
│ Título | Detalles | ESTADO | ACCIONES  ← Columnas NUEVAS  │
├─────────────────────────────────────────────────────────────┤
│ Item 1 | Info...  | ✓ Disponible | [Reservar]            │
│ Item 2 | Info...  | ✗ Reservado  | [Reservado]           │
│ Item 3 | Info...  | ✓ Disponible | [Reservar]            │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│ PANTALLA: reservar_libro.php / reservar_pelicula.php        │
├─────────────────────────────────────────────────────────────┤
│ DETALLES DEL ITEM                                           │
│ Título: ...                                                  │
│ Autor/Director: ...                                          │
│ Otros detalles...                                            │
│                                                              │
│ Estado: ✓ DISPONIBLE para reservar                         │
│                                                              │
│ [Confirmar Reserva]  [Cancelar]                            │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│ PANTALLA: mis_reservas.php                                  │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│ RESERVAS ACTIVAS (2 items)                                 │
│ ┌───────────────────────────────────────────────────────┐  │
│ │ [Libro] Título | Autor | Fecha...  | [Devolver]     │  │
│ │ [Película] Título | Director | Fecha... | [Devolver] │  │
│ └───────────────────────────────────────────────────────┘  │
│                                                              │
│ HISTORIAL DE DEVOLUCIONES (5 items)                        │
│ ┌───────────────────────────────────────────────────────┐  │
│ │ [Libro] Título | Duración: 3 días                    │  │
│ │ [Película] Título | Duración: 2 días                 │  │
│ │ ... (más items sin botones)                          │  │
│ └───────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│ PANTALLA: filtro_estado.php                                 │
├─────────────────────────────────────────────────────────────┤
│ [Libros] [Películas]   ← Switch                            │
│                                                              │
│ [Todos] [Disponibles] [Reservados]   ← Filtros             │
│ Mostrando 15 resultados                                     │
│                                                              │
│ Tabla con título, detalles, estado, acciones               │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔐 Matriz de Seguridad

```
PROTECCIONES EN CADA PÁGINA:

                    │ Autenticación │ SQL Injection │ XSS │
────────────────────┼───────────────┼───────────────┼─────┤
login.php           │ NO (publica)  │ real_escape   │ ✓   │
register.php        │ NO (publica)  │ real_escape   │ ✓   │
index.php           │ ✓ session     │ no aplica     │ ✓   │
Catalogo.php        │ ✓ session     │ intval()      │ ✓   │
catalogo_libros.php │ ✓ session     │ intval()      │ ✓   │
mis_reservas.php    │ ✓ session     │ real_escape   │ ✓   │
reservar_libro.php  │ ✓ session     │ intval()      │ ✓   │
reservar_pelicula.php│ ✓ session     │ intval()      │ ✓   │
filtro_estado.php   │ ✓ session     │ intval()      │ ✓   │
classes/Catalogo.php│ N/A (backend) │ intval/escape │ N/A │
```

---

**Última actualización:** v1.1 - Diciembre 2024
**Estado:** ✅ Mapa de navegación completado
