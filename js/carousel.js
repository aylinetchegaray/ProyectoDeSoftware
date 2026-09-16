/**
 * NexusCore Presentation Hero Carousel
 * Supports automatic cycling, pause-on-hover, dot navigation,
 * arrow keys, touch gestures, and a synchronized progress bar.
 */
document.addEventListener('DOMContentLoaded', () => {
  const carousel = document.querySelector('.carousel-container');
  if (!carousel) return;

  const slides = carousel.querySelectorAll('.carousel-slide');
  const dots = carousel.querySelectorAll('.carousel-dot');
  const prevBtn = carousel.querySelector('.carousel-btn.prev');
  const nextBtn = carousel.querySelector('.carousel-btn.next');
  const progressBar = carousel.querySelector('.carousel-progress-bar');

  let currentSlide = 0;
  const totalSlides = slides.length;
  const slideDuration = 6000; // 6 seconds per slide
  let slideInterval = null;
  let progressInterval = null;
  let progressStart = 0;
  let isPaused = false;

  function showSlide(index) {
    if (index >= totalSlides) currentSlide = 0;
    else if (index < 0) currentSlide = totalSlides - 1;
    else currentSlide = index;

    slides.forEach((slide, idx) => {
      slide.classList.toggle('active', idx === currentSlide);
    });

    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === currentSlide);
    });

    resetProgressBar();
  }

  function nextSlide() {
    showSlide(currentSlide + 1);
  }

  function prevSlide() {
    showSlide(currentSlide - 1);
  }

  function startAutoplay() {
    stopAutoplay();
    progressStart = Date.now();

    slideInterval = setInterval(() => {
      if (!isPaused) {
        nextSlide();
      }
    }, slideDuration);

    progressInterval = setInterval(() => {
      if (!isPaused && progressBar) {
        const elapsed = (Date.now() - progressStart) % slideDuration;
        const percent = Math.min((elapsed / slideDuration) * 100, 100);
        progressBar.style.width = `${percent}%`;
      }
    }, 50);
  }

  function resetProgressBar() {
    progressStart = Date.now();
    if (progressBar) {
      progressBar.style.width = '0%';
    }
  }

  function stopAutoplay() {
    if (slideInterval) clearInterval(slideInterval);
    if (progressInterval) clearInterval(progressInterval);
  }

  // Button Listeners
  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      nextSlide();
      startAutoplay();
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      prevSlide();
      startAutoplay();
    });
  }

  // Dot Listeners
  dots.forEach((dot, idx) => {
    dot.addEventListener('click', () => {
      showSlide(idx);
      startAutoplay();
    });
  });

  // Pause on Hover
  carousel.addEventListener('mouseenter', () => {
    isPaused = true;
  });

  carousel.addEventListener('mouseleave', () => {
    isPaused = false;
    progressStart = Date.now();
  });

  // Keyboard navigation
  document.addEventListener('keydown', (e) => {
    const homeSection = document.getElementById('home');
    if (!homeSection) return;
    const rect = homeSection.getBoundingClientRect();
    if (rect.top <= window.innerHeight && rect.bottom >= 0) {
      if (e.key === 'ArrowRight') {
        nextSlide();
        startAutoplay();
      } else if (e.key === 'ArrowLeft') {
        prevSlide();
        startAutoplay();
      }
    }
  });

  // Touch Swipe Support
  let touchStartX = 0;
  let touchEndX = 0;

  carousel.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });

  carousel.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
  }, { passive: true });

  function handleSwipe() {
    const diff = touchStartX - touchEndX;
    if (Math.abs(diff) > 50) {
      if (diff > 0) {
        nextSlide();
      } else {
        prevSlide();
      }
      startAutoplay();
    }
  }

  // Initialize
  showSlide(0);
  startAutoplay();
});
