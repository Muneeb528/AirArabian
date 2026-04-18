/* ===========================================
   AirArabian — app.js (Public + Admin JS)
   =========================================== */

document.addEventListener('DOMContentLoaded', function () {

  // ---- Navbar scroll effect ----
  const nav = document.getElementById('mainNav');
  if (nav) {
    window.addEventListener('scroll', () => {
      nav.classList.toggle('scrolled', window.scrollY > 60);
    });
  }

  // ---- Mobile sidebar toggle ----
  const sidebarToggle = document.getElementById('mobileSidebarToggle');
  const sidebar       = document.getElementById('adminSidebar');
  const overlay       = document.getElementById('sidebarOverlay');

  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('open');
      overlay.classList.toggle('open');
    });
  }
  if (overlay) {
    overlay.addEventListener('click', () => {
      sidebar.classList.remove('open');
      overlay.classList.remove('open');
    });
  }

  // ---- Auto-dismiss floating alerts ----
  document.querySelectorAll('.alert-floating, .alert').forEach(alert => {
    setTimeout(() => {
      const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
      if (bsAlert) bsAlert.close();
    }, 5000);
  });

  // ---- Confirm delete forms ----
  document.querySelectorAll('form[data-confirm]').forEach(form => {
    form.addEventListener('submit', e => {
      if (!confirm(form.dataset.confirm)) e.preventDefault();
    });
  });

  // ---- Ticket search live filter (landing page) ----
  const searchInputs = document.querySelectorAll('.search-input');
  searchInputs.forEach(input => {
    input.addEventListener('keydown', e => {
      if (e.key === 'Enter') {
        e.target.closest('form')?.submit();
      }
    });
  });

  // ---- Table row hover highlight for action rows ----
  document.querySelectorAll('.admin-table tbody tr').forEach(row => {
    row.style.cursor = 'default';
  });

  // ---- Scroll reveal animation ----
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.feature-card, .ticket-card, .route-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity .5s ease, transform .5s ease';
    observer.observe(el);
  });

  // CSS class to make visible
  const style = document.createElement('style');
  style.textContent = '.visible { opacity: 1 !important; transform: translateY(0) !important; }';
  document.head.appendChild(style);

  // ---- Ticket price calculator (booking form) ----
  const passengerInput = document.getElementById('passengerCount');
  if (passengerInput) {
    passengerInput.addEventListener('input', function() {
      if (typeof updateTotal === 'function') updateTotal();
    });
  }

  // ---- Payment method card selection ----
  document.querySelectorAll('.payment-method-option input[type=radio]').forEach(radio => {
    radio.addEventListener('change', function() {
      document.querySelectorAll('.payment-method-card').forEach(c => c.classList.remove('selected'));
      this.nextElementSibling?.classList.add('selected');
    });
  });

  // ---- Tooltip init (Bootstrap) ----
  document.querySelectorAll('[title]').forEach(el => {
    new bootstrap.Tooltip(el, { trigger: 'hover', placement: 'top' });
  });

});
