/**
 * NexusCore Contact Form Validation & Submission Handler
 * Features real-time field validation, error indicators,
 * loading animations, and user feedback toasts.
 */
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('contactForm');
  const toast = document.getElementById('toastNotification');
  if (!form) return;

  const fields = {
    name: {
      el: document.getElementById('contactName'),
      group: document.getElementById('groupName'),
      validate: (val) => val.trim().length >= 2,
      msg: 'Por favor ingrese un nombre válido (mínimo 2 caracteres).'
    },
    email: {
      el: document.getElementById('contactEmail'),
      group: document.getElementById('groupEmail'),
      validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()),
      msg: 'Ingrese una dirección de correo electrónico válida (ej: nombre@empresa.com).'
    },
    phone: {
      el: document.getElementById('contactPhone'),
      group: document.getElementById('groupPhone'),
      validate: (val) => /^[\d\s+\-().]{7,20}$/.test(val.trim()),
      msg: 'Ingrese un número telefónico válido (mínimo 7 dígitos).'
    },
    service: {
      el: document.getElementById('contactService'),
      group: document.getElementById('groupService'),
      validate: (val) => val !== '' && val !== 'placeholder',
      msg: 'Seleccione un servicio de desarrollo de software.'
    },
    message: {
      el: document.getElementById('contactMessage'),
      group: document.getElementById('groupMessage'),
      validate: (val) => val.trim().length >= 10,
      msg: 'Por favor detalle los requerimientos de su proyecto (mínimo 10 caracteres).'
    },
    consent: {
      el: document.getElementById('contactConsent'),
      group: document.getElementById('groupConsent'),
      validate: (val, el) => el && el.checked,
      msg: 'Debe aceptar los términos para continuar.'
    }
  };

  // Helper to validate a single field
  function validateField(key) {
    const field = fields[key];
    if (!field || !field.el) return true;

    const isValid = field.validate(field.el.value, field.el);
    const errorSpan = field.group ? field.group.querySelector('.form-error-msg') : null;

    if (!isValid) {
      field.el.classList.add('is-invalid');
      field.el.classList.remove('is-valid');
      if (field.group) field.group.classList.add('has-error');
      if (errorSpan) errorSpan.textContent = field.msg;
      return false;
    } else {
      field.el.classList.remove('is-invalid');
      field.el.classList.add('is-valid');
      if (field.group) field.group.classList.remove('has-error');
      return true;
    }
  }

  // Attach live validation events (blur & input)
  Object.keys(fields).forEach((key) => {
    const field = fields[key];
    if (field && field.el) {
      field.el.addEventListener('blur', () => {
        if (field.el.value.trim().length > 0 || field.el.type === 'checkbox') {
          validateField(key);
        }
      });

      const eventType = (field.el.type === 'checkbox' || field.el.tagName === 'SELECT') ? 'change' : 'input';
      field.el.addEventListener(eventType, () => {
        if (field.el.classList.contains('is-invalid')) {
          validateField(key);
        }
      });
    }
  });

  // Handle Form Submission
  form.addEventListener('submit', (e) => {
    e.preventDefault();

    // Honeypot spam defense check
    const honeypot = document.getElementById('websiteWebsite');
    if (honeypot && honeypot.value) {
      console.warn('Spam detected via honeypot.');
      return;
    }

    let isFormValid = true;
    let firstInvalidField = null;

    Object.keys(fields).forEach((key) => {
      const valid = validateField(key);
      if (!valid) {
        isFormValid = false;
        if (!firstInvalidField && fields[key].el) {
          firstInvalidField = fields[key].el;
        }
      }
    });

    if (!isFormValid) {
      if (firstInvalidField) {
        firstInvalidField.focus();
      }
      return;
    }

    // Show loading state
    const submitBtn = form.querySelector('.submit-btn');
    if (submitBtn) {
      submitBtn.classList.add('loading');
      submitBtn.disabled = true;
    }

    // Simulate async submission
    setTimeout(() => {
      if (submitBtn) {
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
      }

      // Show Toast Notification
      showToast('¡Mensaje Enviado con Éxito!', 'Nuestro equipo de ingeniería se pondrá en contacto dentro de las próximas 24 horas.');

      // Reset form
      form.reset();
      Object.keys(fields).forEach((key) => {
        if (fields[key].el) {
          fields[key].el.classList.remove('is-valid', 'is-invalid');
        }
        if (fields[key].group) {
          fields[key].group.classList.remove('has-error');
        }
      });
    }, 1200);
  });

  // Toast Functionality
  function showToast(title, desc) {
    if (!toast) return;

    const titleEl = toast.querySelector('.toast-title');
    const descEl = toast.querySelector('.toast-desc');

    if (titleEl) titleEl.textContent = title;
    if (descEl) descEl.textContent = desc;

    toast.classList.add('show');

    setTimeout(() => {
      toast.classList.remove('show');
    }, 5000);
  }
});
