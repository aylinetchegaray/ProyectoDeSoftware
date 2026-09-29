# Panel de Gestión de Usuarios (ABMC) - Sprint 2

Correspondiente al **Sprint 2** de la materia **Proyecto de Software** de la Licenciatura en Sistemas en la UNRN.

## Objetivo del Proyecto
Desarrollo de un sistema web funcional de administración de usuarios (ABMC) conectado a base de datos relacional, implementando control de acceso basado en roles y baja lógica para garantizar integridad referencial y auditoría:
1. **Listado Principal (`index.php`):** Grilla centralizada con consulta de usuarios activos, badges de estado visual y acciones dinámicas según permisos.
2. **Alta de Usuarios (`alta.php`):** Formulario integrado con validaciones en frontend y backend (unicidad de nickname y email, formato de correo y asignación de rol).
3. **Modificación (`editar.php`):** Edición de datos personales y roles asignados restringida a perfiles autorizados (Administrador y Editor).
4. **Baja Lógica (`eliminar.php`):** Desactivación controlada (`activo = 0`) sin destrucción física de registros para preservar la trazabilidad del sistema.
5. **Histórico y Recuperación (`restaurar.php`):** Vista de usuarios inactivos con capacidad de reactivación al estado operativo.

## Tecnologías y Estándares Utilizados
Arquitectura web dinámica basada íntegramente en tecnologías nativas (*Vanilla Backend*), alineada con las pautas de la cátedra:
* **Backend:** PHP 8.x nativo orientado a la gestión de peticiones, validación de sesiones (`$_SESSION`) y renderizado dinámico del lado del servidor.
* **Persistencia:** MySQL / MariaDB mediante la extensión `mysqli` con consultas preparadas para mitigar inyecciones SQL.
* **Presentación:** HTML5 semántico y CSS3 moderno bajo arquitectura *Dark Theme*, empleando **Custom Properties (Variables)**, **Flexbox** y tablas estilizadas libres de frameworks externos.
* **Control de Acceso (RBAC):** Simulación y validación de tres niveles jerárquicos: Administrador (acceso total), Editor (edición) y Lector (solo lectura), con bloqueo estricto a cuentas inactivas.
* **Restricciones Técnicas:** Sin frameworks backend (sin Laravel ni Symfony), sin ORMs y sin librerías frontend (sin Bootstrap ni Tailwind).

## Estructura del Proyecto
El árbol de directorios respeta la modularización de scripts y la persistencia relacional:

```text
abm-usuarios/
│
├── css/              # Hojas de estilo modulares en CSS3
│   └── styles.css    # Diseño de la interfaz, dashboard y tablas
│
├── AGENT.md          # Especificaciones de contexto e instrucciones de desarrollo
├── alta.php          # Lógica de inserción y procesamiento de nuevos usuarios
├── conexion.php      # Parámetros y objeto de conexión centralizada a MySQL
├── database.sql      # Script DDL y DML (tablas rol/usuario y datos de prueba)
├── editar.php        # Formulario y procesamiento de actualización de registros
├── eliminar.php      # Lógica de baja lógica (soft delete)
├── index.php         # Panel principal: formulario de alta y listado de usuarios
├── login.php         # Gestión y simulación de inicio de sesión
├── logout.php        # Cierre y destrucción de sesión activa
├── migrate.php       # Script de migración y actualización de esquema
└── restaurar.php     # Reactivación de usuarios desde el histórico
```

## Instrucciones de Ejecución
Al ser una aplicación web dinámica con base de datos, requiere un entorno con servidor Apache y motor MySQL (ej. XAMPP):

- Clonar el repositorio en tu máquina local dentro del directorio público del servidor:
```text
cd C:\xampp\htdocs
git clone [https://github.com/aylinetchegaray/proyecto-de-software.git](https://github.com/aylinetchegaray/proyecto-de-software.git)
```

- Acceder al directorio correspondiente a esta iteración:
```text
cd proyecto-de-software/sprint-2
```

- Importar la base de datos en phpMyAdmin:
  Iniciar los servicios de Apache y MySQL desde el panel de XAMPP.
  Acceder a http://localhost/phpmyadmin/.
  Importar el archivo database.sql incluido en esta carpeta (crea la base sistema_abmc, las tablas rol y usuario, y la carga inicial con usuarios activos e históricos).

- Ejecutar el proyecto:
  Abrir el navegador e ingresar a: http://localhost/proyecto-de-software/sprint-2/index.php

Desarrollado por: Aylín Etchegaray
Desarrollo Aumentado mediante Antigravity AI Agent
















