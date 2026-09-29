# Agent Directives - Sprint 2: PHP & MySQL ABMC

## Project Overview
ABMC (CRUD) application for managing "Usuarios" and "Roles" entities, developed for the Software Project course (UNRN).
Target environment: Apache Web Server and MySQL Database (via XAMPP / htdocs).

## Technology Constraints
- **Backend:** Native PHP (no backend frameworks like Laravel, CodeIgniter, or Symfony).
- **Database:** MySQL. Standard SQL operations (SELECT, INSERT, UPDATE, DELETE).
- **Database Driver:** Use `mysqli` or `PDO` (prepared statements) for secure database queries.
- **Frontend:** Semantic HTML5 forms and Vanilla CSS for styling (reusing the corporate palette from Sprint 1). No CSS frameworks (no Bootstrap, Tailwind).
- **Form Handling:** Standard HTTP POST and GET methods with `$_POST` and `$_GET` arrays. Always validate inputs.

## Architecture & Code Rules
1. Maintain modular PHP files:
   - `conexion.php`: Centralized database connection script.
   - `index.php`: User list view (Consulta) with action links (Edit / Delete).
   - `alta.php`: User creation form (HTML) and insertion handling (POST / INSERT).
   - `editar.php`: User edition form pre-populated via GET ID, updated via POST / UPDATE.
   - `eliminar.php`: Server action script handling user deletion by ID (DELETE) and redirecting to index.
2. Entity modeling requirements:
   - "Usuarios": id_usuario (PK), nombre, apellido, nickname (unique), email (unique), id_rol (FK).
   - "Roles": id_rol (PK), nombre, descripcion. (1-to-N relation).
3. Do not overcomplicate code or generate bloated files. Keep scripts clean, readable, and well-commented.

Execution Rule: Apply all code modifications, file creations, and terminal commands automatically. Do not ask for user confirmation, approval, or permission before executing changes.