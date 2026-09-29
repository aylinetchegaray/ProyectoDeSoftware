/**
 * NexusCore Software Technologies - Main Application Script
 * Orchestrates navigation, scrollspy, project filters,
 * detailed case study modals, and animated metric counters.
 */

document.addEventListener('DOMContentLoaded', () => {
  /* ==========================================================================
     1. Sticky Navigation & Scrollspy
     ========================================================================== */
  const header = document.querySelector('.site-header');
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-link');
  const mobileToggle = document.querySelector('.mobile-toggle');
  const navMenu = document.querySelector('.nav-menu');
  const backToTopBtn = document.querySelector('.back-to-top');

  window.addEventListener('scroll', () => {
    const scrollY = window.pageYOffset;

    // Header styling on scroll
    if (header) {
      if (scrollY > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    }

    // Back to top visibility
    if (backToTopBtn) {
      if (scrollY > 400) {
        backToTopBtn.classList.add('visible');
      } else {
        backToTopBtn.classList.remove('visible');
      }
    }

    // Scrollspy for active link has been removed due to multi-page refactoring.
  });

  // Dynamic active link highlighting based on current URL path
  const currentPath = window.location.pathname.split('/').pop() || 'index.html';
  navLinks.forEach((link) => {
    link.classList.remove('active');
    const href = link.getAttribute('href');
    if (href === currentPath) {
      link.classList.add('active');
    }
  });

  // Mobile menu toggle
  if (mobileToggle && navMenu) {
    mobileToggle.addEventListener('click', () => {
      navMenu.classList.toggle('open');
      const isOpen = navMenu.classList.contains('open');
      mobileToggle.setAttribute('aria-expanded', isOpen);
    });

    // Close menu when clicking nav links
    navLinks.forEach((link) => {
      link.addEventListener('click', () => {
        navMenu.classList.remove('open');
      });
    });
  }

  // Back to top action
  if (backToTopBtn) {
    backToTopBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  /* ==========================================================================
     2. Works / Projects Filter System
     ========================================================================== */
  const filterBtns = document.querySelectorAll('.filter-btn');
  const workCards = document.querySelectorAll('.work-card');

  filterBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      filterBtns.forEach((b) => b.classList.remove('active'));
      btn.classList.add('active');

      const filterValue = btn.getAttribute('data-filter');

      workCards.forEach((card) => {
        const category = card.getAttribute('data-category');
        if (filterValue === 'all' || category.includes(filterValue)) {
          card.style.display = 'flex';
          setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, 50);
        } else {
          card.style.opacity = '0';
          card.style.transform = 'translateY(20px)';
          setTimeout(() => {
            card.style.display = 'none';
          }, 250);
        }
      });
    });
  });

  /* ==========================================================================
     3. Case Study Details Modal
     ========================================================================== */
  const modalOverlay = document.getElementById('caseStudyModal');
  const modalCloseBtn = document.getElementById('modalCloseBtn');
  const openModalBtns = document.querySelectorAll('.work-open-modal-btn');

  const caseStudiesData = {
    'fintech': {
      title: 'Apex Global Banking: Sistema Bancario en Tiempo Real y Detección de Fraude',
      client: 'Apex International Finance Corp',
      industry: 'Banca y Servicios Financieros',
      timeline: '10 Meses',
      metric: '+350% Procesamiento de Transacciones',
      image: 'img/project-1.jpg',
      badge: 'Enterprise FinTech',
      description: 'Apex requería modernizar su infraestructura transaccional de pagos heredada para procesar más de 25 millones de microtransacciones diarias con latencia inferior a 45 milisegundos y conformidad bancaria global.',
      challenge: 'Latencia elevada en picos de demanda, fragmentación de datos heredados y requerimientos estrictos de seguridad PCI-DSS Nivel 1 con auditoría en tiempo real.',
      solution: 'Diseñamos e implementamos una arquitectura orientada a eventos basada en Apache Kafka y microservicios en Go/Kubernetes, con un motor de inferencia de IA capaz de clasificar patrones de fraude con 99.8% de precisión antes de la liquidación bancaria.',
      stack: ['Go (Golang)', 'Kubernetes', 'Apache Kafka', 'PostgreSQL', 'Redis Cluster', 'React Enterprise'],
      deliverables: ['Plataforma web bancaria de alta concurrencia', 'API Gateway con rate limiting dinámico', 'Panel de telemetría y auditoría en vivo']
    },
    'healthtech': {
      title: 'MediSphere Health: Ecosistema de Telemedicina y Telemetría Clínica',
      client: 'MediSphere Hospital Network',
      industry: 'Salud Digital y MedTech',
      timeline: '8 Meses',
      metric: '99.999% Disponibilidad en Consultas Críticas',
      image: 'img/project-2.jpg',
      badge: 'HealthTech SaaS',
      description: 'Plataforma integral de telemedicina con transmisión segura de video en tiempo real (WebRTC cifrado E2E), integración de historia clínica electrónica (EHR) y sincronización con dispositivos biométricos de monitoreo ambulatorio.',
      challenge: 'Garantizar el cumplimiento riguroso de normativas HIPAA/GDPR y la estabilidad de video de baja latencia incluso en redes móviles rurales con baja conectividad.',
      solution: 'Desarrollo de una Progressive Web App (PWA) resiliente con WebRTC optimizado mediante códec AV1, backend serverless en Node.js/TypeScript y cifrado asimétrico a nivel de registro médico.',
      stack: ['TypeScript', 'Next.js / React', 'WebRTC E2E', 'Node.js', 'FHIR / HL7 APIs', 'AWS Medialive'],
      deliverables: ['Portal web de pacientes y médicos', 'Módulo de videoconferencia médica HD', 'Integración de telemetría IoT de signos vitales']
    },
    'iot': {
      title: 'OmniLogistics Fleet: Telemetría IoT y Control Autónomo de Flota Global',
      client: 'OmniLogistics Supply Chain',
      industry: 'Logística y Transporte Global',
      timeline: '12 Meses',
      metric: '-32% Costos Operativos de Combustible',
      image: 'img/project-3.jpg',
      badge: 'IoT & Edge Computing',
      description: 'Centro de control operativo global que procesa telemetría continua de más de 8,500 vehículos comerciales en 14 países, optimizando rutas en tiempo real mediante algoritmos de grafos y aprendizaje automático.',
      challenge: 'Ingesta masiva y continua de 120,000 eventos de sensores por segundo (GPS, temperatura de carga fría, vibración, estado del motor) sin pérdidas de paquetes.',
      solution: 'Implementación de una infraestructura en AWS IoT Core y Apache Spark con bases de datos Time-Series (TimescaleDB) y una interfaz interactiva WebGL con mapas geoespaciales vectorizados.',
      stack: ['Python', 'AWS IoT Core', 'TimescaleDB', 'Apache Spark', 'WebGL / Mapbox GL', 'Vue.js'],
      deliverables: ['Dashboard de control en tiempo real', 'Sistema de alertas tempranas de cadena de frío', 'App móvil de conductor con navegación offline']
    },
    'ecommerce': {
      title: 'Aura Luxe E-Commerce: Plataforma Headless de Comercio Digital de Lujo',
      client: 'Aura Luxury Global Group',
      industry: 'Comercio Electrónico y Retail de Lujo',
      timeline: '6 Meses',
      metric: '+180% Conversión de Checkout Móvil',
      image: 'img/project-4.jpg',
      badge: 'Headless Commerce',
      description: 'Experiencia de compra digital inmersiva para catálogo de alta gama con visualizador de productos 3D interactivo, internacionalización en 18 monedas y checkout ultrarrápido sin fricciones.',
      challenge: 'Tiempos de carga lentos de la plataforma anterior que penalizaban la tasa de conversión en dispositivos móviles y una experiencia visual plana que no transmitía el prestigio de la marca.',
      solution: 'Reconstrucción arquitectónica utilizando arquitectura Jamstack / Headless Commerce, renderizado híbrido SSR/SSG en Next.js, pasarelas de pago globales integradas (Stripe & Adyen) y optimización Core Web Vitals perfecta (100/100).',
      stack: ['Next.js / React', 'Shopify Plus GraphQL', 'Three.js (3D Viewer)', 'Tailored CSS', 'Stripe Payments', 'Cloudflare Workers'],
      deliverables: ['Tienda online ultra-rápida (Score 99)', 'Visor 3D de modelos de joyería', 'Checkout localizado con impuestos automatizados']
    },
    'edtech': {
      title: 'Veritas EdTech: Plataforma SaaS de Aprendizaje Adaptativo con IA',
      client: 'Veritas Education Institute',
      industry: 'Educación Superior y EdTech',
      timeline: '9 Meses',
      metric: '500k+ Estudiantes Activos en Simultáneo',
      image: 'img/project-5.jpg',
      badge: 'AI & Cloud SaaS',
      description: 'Plataforma educativa interactiva que personaliza la ruta de aprendizaje de cada estudiante a través de tutores inteligentes basados en modelos LLM y ejercicios de código evaluados en tiempo real dentro de sandboxes aislados.',
      challenge: 'Ejecutar de forma segura miles de fragmentos de código de estudiantes por minuto en entornos sandbox aislados sin comprometer el servidor, y escalar ante picos de exámenes masivos.',
      solution: 'Arquitectura de micro-contenedores ligeros en Firecracker MicroVMs orquestados dinámicamente, con interfaz de usuario reactiva en React y analítica de retención predictiva.',
      stack: ['Python / FastAPI', 'Firecracker MicroVMs', 'React', 'Docker', 'OpenAI APIs', 'PostgreSQL'],
      deliverables: ['Editor de código en navegador con autoevaluación', 'Tutor IA explicativo paso a paso', 'Panel analítico para profesores y directores']
    }
  };

  function openCaseStudyModal(studyId) {
    const data = caseStudiesData[studyId];
    if (!data || !modalOverlay) return;

    document.getElementById('modalImage').src = data.image;
    document.getElementById('modalBadge').textContent = data.badge;
    document.getElementById('modalTitle').textContent = data.title;
    document.getElementById('modalClient').textContent = data.client;
    document.getElementById('modalIndustry').textContent = data.industry;
    document.getElementById('modalTimeline').textContent = data.timeline;
    document.getElementById('modalMetric').textContent = data.metric;
    document.getElementById('modalDesc').textContent = data.description;
    document.getElementById('modalChallenge').textContent = data.challenge;
    document.getElementById('modalSolution').textContent = data.solution;

    // Render stack
    const stackContainer = document.getElementById('modalStack');
    if (stackContainer) {
      stackContainer.innerHTML = '';
      data.stack.forEach((tech) => {
        const pill = document.createElement('span');
        pill.className = 'tech-pill';
        pill.textContent = tech;
        stackContainer.appendChild(pill);
      });
    }

    // Render deliverables
    const deliverablesList = document.getElementById('modalDeliverables');
    if (deliverablesList) {
      deliverablesList.innerHTML = '';
      data.deliverables.forEach((item) => {
        const li = document.createElement('li');
        li.textContent = `✓ ${item}`;
        deliverablesList.appendChild(li);
      });
    }

    modalOverlay.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeCaseStudyModal() {
    if (!modalOverlay) return;
    modalOverlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  openModalBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      const studyId = btn.getAttribute('data-study');
      openCaseStudyModal(studyId);
    });
  });

  if (modalCloseBtn) {
    modalCloseBtn.addEventListener('click', closeCaseStudyModal);
  }

  if (modalOverlay) {
    modalOverlay.addEventListener('click', (e) => {
      if (e.target === modalOverlay) {
        closeCaseStudyModal();
      }
    });
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeCaseStudyModal();
    }
  });

  /* ==========================================================================
     4. Animated Counter for Strip Metrics
     ========================================================================== */
  const metricNumbers = document.querySelectorAll('.metric-number');
  let animated = false;

  function runCounterAnimation() {
    metricNumbers.forEach((el) => {
      const target = parseInt(el.getAttribute('data-target'), 10);
      const suffix = el.getAttribute('data-suffix') || '';
      const prefix = el.getAttribute('data-prefix') || '';
      let current = 0;
      const step = Math.max(1, Math.floor(target / 40));

      const timer = setInterval(() => {
        current += step;
        if (current >= target) {
          el.textContent = `${prefix}${target}${suffix}`;
          clearInterval(timer);
        } else {
          el.textContent = `${prefix}${current}${suffix}`;
        }
      }, 35);
    });
  }

  const stripWorks = document.querySelector('.strip-works');
  if (stripWorks) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && !animated) {
          animated = true;
          runCounterAnimation();
        }
      });
    }, { threshold: 0.3 });

    observer.observe(stripWorks);
  }
});
