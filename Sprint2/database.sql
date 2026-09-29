-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS sistema_abmc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sistema_abmc;

-- Eliminación de tablas previas si existen (en orden por foreign key)
DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS rol;

-- 1. Tabla Rol (Entidad Fuerte / Catálogo)
CREATE TABLE rol (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion VARCHAR(255) NULL
) ENGINE=InnoDB;

-- 2. Tabla Usuario (Entidad Dependiente de Rol)
CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    nickname VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    id_rol INT NOT NULL,
    CONSTRAINT fk_usuario_rol FOREIGN KEY (id_rol) 
        REFERENCES rol(id_rol) 
        ON UPDATE CASCADE 
        ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 3. Carga inicial de Roles requeridos para las pruebas
INSERT INTO rol (nombre, descripcion) VALUES
('Administrador', 'Control total y gestión integral del sistema'),
('Editor', 'Permisos de modificación y publicación de contenidos'),
('Lector', 'Acceso básico de visualización y consulta');

-- 4. Datos de prueba iniciales para Usuarios

-- Usuarios Activos (Operativos en el panel principal)
INSERT INTO usuario (nombre, apellido, nickname, email, activo, id_rol) VALUES
('Aylín', 'Etchegaray', 'aetchegaray', 'aylin@unrn.edu.ar', 1, 1),
('Lucas', 'Martínez', 'lmartinez', 'lucas.m@nexuscore.com', 1, 2),
('Valentina', 'Silva', 'vsilva', 'valen.silva@nexuscore.com', 1, 2),
('Sofía', 'Gómez', 'sgomez', 'sofia.g@nexuscore.com', 1, 3),
('Mateo', 'Salazar', 'msalazar', 'mateo.salazar@codecraft.ar', 1, 3);

-- Usuarios Históricos / Dados de baja (Para testear baja lógica y bloqueo de acceso)
INSERT INTO usuario (nombre, apellido, nickname, email, activo, id_rol) VALUES
('Ramiro', 'Morales', 'rmorales', 'ramiro.morales@archive-user.net', 0, 2),
('Agustina', 'Paz', 'apaz', 'agustina.paz@legacy-box.io', 0, 3);