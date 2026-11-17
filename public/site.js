
    const themeButton = document.querySelector('.theme-toggle');
    const themeColor = document.querySelector('meta[name="theme-color"]');
    const menuButton = document.querySelector('.menu-toggle');
    const mobilePanel = document.querySelector('#mobile-menu');
    const closeButton = document.querySelector('.close-menu');
    const desktopDropdowns = [...document.querySelectorAll('.nav-menu > .nav-dropdown')];
    let returnFocusTo = null;

    desktopDropdowns.forEach(dropdown => {
      dropdown.addEventListener('toggle', () => {
        if (!dropdown.open) return;
        desktopDropdowns.forEach(otherDropdown => {
          if (otherDropdown !== dropdown) otherDropdown.open = false;
        });
      });
    });

    document.addEventListener('click', event => {
      if (event.target instanceof Element && !event.target.closest('.nav-menu')) {
        desktopDropdowns.forEach(dropdown => { dropdown.open = false; });
      }
    });

    document.addEventListener('keydown', event => {
      if (event.key === 'Escape') {
        desktopDropdowns.forEach(dropdown => { dropdown.open = false; });
      }
    });

    function setTheme(theme) {
      document.documentElement.dataset.theme = theme;
      const dark = theme === 'dark';
      themeButton.setAttribute('aria-pressed', String(dark));
      themeButton.setAttribute('aria-label', dark ? 'Ganti ke mode terang' : 'Ganti ke mode gelap');
      themeColor.setAttribute('content', dark ? '#0a111e' : '#edf3f7');
      try { localStorage.setItem('dedehusen-theme', theme); } catch (_) { /* Tema tetap bekerja tanpa penyimpanan lokal. */ }
    }

    themeButton.addEventListener('click', () => {
      setTheme(document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark');
    });
    setTheme(document.documentElement.dataset.theme || 'light');

    function openMenu() {
      returnFocusTo = document.activeElement;
      mobilePanel.dataset.open = 'true';
      mobilePanel.removeAttribute('inert');
      mobilePanel.setAttribute('aria-hidden', 'false');
      menuButton.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';
      closeButton.focus();
    }
    function closeMenu() {
      mobilePanel.dataset.open = 'false';
      mobilePanel.setAttribute('aria-hidden', 'true');
      mobilePanel.setAttribute('inert', '');
      menuButton.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
      if (returnFocusTo) returnFocusTo.focus();
    }
    menuButton.addEventListener('click', openMenu);
    closeButton.addEventListener('click', closeMenu);
    mobilePanel.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));
    document.addEventListener('keydown', event => {
      if (mobilePanel.dataset.open !== 'true') return;
      if (event.key === 'Escape') {
        closeMenu();
        return;
      }
      if (event.key !== 'Tab') return;

      const focusableItems = [...mobilePanel.querySelectorAll('a[href], button:not([disabled]), summary')]
        .filter(item => item.offsetParent !== null);
      if (!focusableItems.length) return;

      const firstItem = focusableItems[0];
      const lastItem = focusableItems[focusableItems.length - 1];
      if (!mobilePanel.contains(document.activeElement)) {
        event.preventDefault();
        firstItem.focus();
      } else if (event.shiftKey && document.activeElement === firstItem) {
        event.preventDefault();
        lastItem.focus();
      } else if (!event.shiftKey && document.activeElement === lastItem) {
        event.preventDefault();
        firstItem.focus();
      }
    });
    document.querySelector('#current-year').textContent = new Date().getFullYear();

    const blogFilters = [...document.querySelectorAll('[data-blog-filter]')];
    const blogCards = [...document.querySelectorAll('[data-blog-card]')];
    const blogEmptyCard = document.querySelector('.blog-empty-card');
    const blogEmptyTitle = document.querySelector('[data-blog-empty-title]');
    const blogEmptyMessage = document.querySelector('[data-blog-empty-message]');
    const blogCategories = {
      pendidikan: 'Pendidikan',
      penelitian: 'Penelitian',
      pengabdian: 'Pengabdian',
      teknologi: 'Teknologi'
    };

    function applyBlogFilter(filter) {
      const category = filter.dataset.blogFilter;
      const matchingCards = blogCards.filter(card => category === 'all' || card.dataset.category === category);

      blogFilters.forEach(button => {
        const active = button === filter;
        button.classList.toggle('is-active', active);
        button.setAttribute('aria-pressed', String(active));
      });
      blogCards.forEach(card => {
        card.hidden = !matchingCards.includes(card);
      });

      if (!blogEmptyCard) return;
      blogEmptyCard.hidden = matchingCards.length > 0;
      if (matchingCards.length > 0) return;

      if (category === 'all' && blogCards.length === 0) {
        blogEmptyTitle.textContent = 'Artikel pertama sedang disiapkan';
        blogEmptyMessage.textContent = 'Setelah terbit, artikel terbaru akan tampil sebagai kartu di bagian ini.';
      } else {
        const categoryName = blogCategories[category];
        blogEmptyTitle.textContent = category === 'all' ? 'Belum ada artikel' : `Belum ada tulisan tentang ${categoryName}`;
        blogEmptyMessage.textContent = category === 'all'
          ? 'Tulisan terbaru akan muncul di sini setelah diterbitkan.'
          : 'Pilih kategori lain atau lihat semua tulisan yang tersedia.';
      }
    }

    blogFilters.forEach(filter => {
      filter.addEventListener('click', () => applyBlogFilter(filter));
    });

    const activeBlogFilter = blogFilters.find(filter => filter.classList.contains('is-active'));
    if (activeBlogFilter) applyBlogFilter(activeBlogFilter);

    const contactForm = document.querySelector('[data-contact-form]');
    if (contactForm) {
      const contactStatus = contactForm.querySelector('[data-contact-status]');
      const contactSubmit = contactForm.querySelector('[type="submit"]');
      const contactDialog = document.querySelector('[data-contact-dialog]');
      const contactDialogTitle = contactDialog?.querySelector('[data-contact-dialog-title]');
      const contactDialogMessage = contactDialog?.querySelector('[data-contact-dialog-message]');
      const contactDialogClose = contactDialog?.querySelector('[data-contact-dialog-close]');

      contactDialogClose?.addEventListener('click', () => contactDialog.close());

      contactForm.addEventListener('submit', async event => {
        event.preventDefault();
        contactSubmit.disabled = true;
        contactSubmit.textContent = 'Mengirim pesan…';
        contactStatus.textContent = 'Pesan sedang dikirim.';

        try {
          const response = await fetch(contactForm.action, {
            method: 'POST',
            body: new FormData(contactForm),
            headers: { Accept: 'application/json' }
          });
          const result = await response.json().catch(() => ({}));
          if (!response.ok) throw new Error(result.message || 'Pesan belum tersimpan.');

          contactForm.reset();
          contactStatus.textContent = result.message;
          if (contactDialog?.showModal) {
            contactDialogTitle.textContent = result.email_sent === true
              ? 'Pesan berhasil dikirim'
              : response.status === 202 ? 'Pesan diterima' : 'Pesan tersimpan';
            contactDialogMessage.textContent = result.message;
            contactDialog.showModal();
          } else {
            window.alert(result.message);
          }
        } catch (error) {
          contactStatus.textContent = error.message || 'Koneksi bermasalah. Coba kirim kembali.';
        } finally {
          contactSubmit.disabled = false;
          contactSubmit.textContent = 'Kirim pesan';
        }
      });
    }
  
