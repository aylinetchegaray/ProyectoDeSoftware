# Portal Web Corporativo - Sprint 1

Repositorio correspondiente al **Sprint 1** de la materia **Proyecto de Software** de la Licenciatura en Sistemas en UNRN.

## Objetivo del Proyecto
Desarrollo de un sitio web corporativo institucional estático, estructurado en **5 secciones principales** requeridas para la primera iteración del proyecto:
1. **Inicio (Home):** Presentación institucional con elemento multimedia (imagen/carrusel) y tres tiras de resumen (Servicios, Trabajos/Clientes y Quiénes Somos).
2. **El Equipo:** Descripción de la empresa e información de perfil de los integrantes (mínimo 3 miembros).
3. **Servicios:** Detalle completo de los servicios profesionales prestados (mínimo 3 servicios).
4. **Trabajos / Clientes:** Portfolio o listado de proyectos previos y clientes destacados (mínimo 5 elementos).
5. **Contacto:** Formulario funcional de contacto, ubicación física, redes sociales, correo electrónico y teléfonos de atención.

## Tecnologías y Estándares Utilizados
El proyecto se desarrolló bajo una arquitectura puramente nativa (*Vanilla*), cumpliendo estrictamente con los lineamientos de la cátedra:
* **Estructura:** HTML5 Semántico (`<header>`, `<nav>`, `<section>`, `<article>`, `<footer>`).
* **Presentación:** CSS3 nativo utilizando **Custom Properties (Variables)**, **Flexbox**, **Grid** y diseño adaptativo (*Responsive Design*) mediante **Media Queries** para enfoque *mobile-first*. 
* **Interactividad y Lógica:** Vanilla JavaScript (ES6+) para la gestión del DOM y validaciones del lado del cliente.
* **Restricciones Técnicas:** Sin librerías externas de CSS (como Bootstrap o Tailwind) ni frameworks de JavaScript (como React o Vue).

## Estructura del Proyecto
El código fuente respeta de manera estricta la distribución de carpetas obligatoria para las entregas de la asignatura:

corporate-software-website/
│
├── css/            # Hojas de estilo modulares en CSS3
├── font/           # Tipografías personalizadas utilizadas en el portal
├── img/            # Recursos gráficos, logotipos e imágenes institucionales
├── js/             # Archivos de lógica y manipulación del DOM en Vanilla JavaScript
└── index.html      # Archivo principal que nuclea la estructura del portal

## Instrucciones de Ejecución
Al tratarse de un sitio web estático basado en tecnologías web estándar, no requiere compilación ni servidores de backend complejos:

Clonar el repositorio en tu máquina local:

Bash
git clone [https://github.com/aylinetchegaray/NexusCore.git](https://github.com/aylinetchegaray/NexusCore.git)
Abrir la carpeta del proyecto en tu entorno de desarrollo o navegador de preferencia.

Hacer doble clic sobre el archivo index.html o abrirlo con un servidor local (como Live Server en VS Code / Antigravity) para visualizar el portal en funcionamiento.

Desarrollado por: Aylín Etchegaray