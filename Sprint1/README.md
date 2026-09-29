# Portal Web Corporativo - Sprint 1

Correspondiente al **Sprint 1** de la materia **Proyecto de Software** de la Licenciatura en Sistemas en la UNRN.

## Objetivo del Proyecto
Desarrollo de un sitio web institucional estático, modularizado en páginas independientes para cubrir las **5 secciones principales** requeridas en la primera iteración:
1. **Inicio (`index.html`):** Presentación institucional con carrusel multimedia y tres tiras de resumen: Servicios, Trabajos/Clientes y Quiénes Somos.
2. **El Equipo (`equipo.html`):** Descripción de la empresa y perfiles profesionales de los integrantes (mínimo 3 miembros).
3. **Servicios (`servicios.html`):** Detalle exhaustivo de las soluciones y prestaciones ofrecidas (mínimo 3 servicios).
4. **Trabajos / Clientes (`trabajos.html`):** Portfolio de casos de éxito y clientes corporativos (mínimo 5 elementos).
5. **Contacto (`contacto.html`):** Formulario validado del lado del cliente, ubicación física, redes sociales, correo y canales telefónicos.

## Tecnologías y Estándares Utilizados
Arquitectura web estándar basada íntegramente en tecnologías nativas (*Vanilla*), alineada con los lineamientos de la cátedra:
* **Estructura:** HTML5 semántico (`<header>`, `<nav>`, `<section>`, `<article>`, `<footer>`) con codificación UTF-8.
* **Presentación:** CSS3 nativo mediante **Custom Properties (Variables)**, **Flexbox**, **Grid** y diseño responsivo (*mobile-first*) con **Media Queries**.
* **Interactividad y Lógica:** JavaScript moderno (ES6+) modular (`main.js`, `carousel.js`, `validation.js`) para manipulación del DOM y captura semántica de eventos sin dependencias externas.
* **Restricciones Técnicas:** Sin frameworks ni librerías de CSS (sin Bootstrap ni Tailwind) ni de JS (sin jQuery, React ni Vue).

## Estructura del Proyecto
El árbol de directorios respeta el esquema de carpetas obligatorio y la modularización multipágina:

```text
corporate-software-website/
│
├── css/              # Hojas de estilo modulares en CSS3
├── font/             # Tipografías y fuentes locales utilizadas
├── img/              # Recursos gráficos, logotipos e imágenes institucionales
├── js/               # Scripts modulares en Vanilla JavaScript
│   ├── carousel.js   # Lógica interactiva del carrusel multimedia
│   ├── main.js       # Navegación dinámica y gestión de enlaces activos
│   └── validation.js # Validaciones de formulario mediante el DOM
│
├── contacto.html     # Sección de contacto y formulario
├── equipo.html       # Sección de presentación del equipo
├── index.html        # Página principal de bienvenida y tiras de resumen
├── servicios.html    # Sección con el catálogo de servicios
└── trabajos.html     # Sección de portfolio y casos de estudio
```

## Instrucciones de Ejecución
Al ser una aplicación web puramente estática, no requiere entornos de compilación ni servidores backend:

Clonar el repositorio en tu máquina local:

```bash
git clone https://github.com/aylinetchegaray/NexusCore.git
```
Acceder al directorio clonado:

```bash
cd corporate-software-website
```
Abrir el archivo `index.html` en cualquier navegador web moderno (Chrome, Firefox, Edge) o levantarlo mediante una extensión de servidor local (ej. Live Server).

Desarrollado por: Aylín Etchegaray
Desarrollo Aumentado mediante Antigravity AI Agent
