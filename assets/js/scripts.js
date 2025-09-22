// (Legacy .nav-links mobile toggle removed; replaced by popup-menu off-canvas system below)

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ----------------- Primary Navigation / Off-canvas -----------------
(function(){
    // Defer until DOM ready to guarantee elements exist
    if(document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', initNav); }
    else initNav();

    function initNav(){
        const menu = document.getElementById('popup-menu');
        const overlay = document.getElementById('popup-menu-overlay');
        const hamburger = document.getElementById('hamburger-menu');
        const closeBtn = document.getElementById('close-menu');
    if(!menu || !overlay || !hamburger) return;

    // Dynamic hamburger midpoint positioning on mobile: place button halfway between
    // viewport left (0) and the left edge of the centered logo, within min/max clamps.
    function positionHamburger(){
        // Only active on small screens
        if(window.innerWidth > 640){ hamburger.style.left=''; return; }
        const logo = document.querySelector('.logo'); if(!logo) return;
        const rect = logo.getBoundingClientRect();
        const logoLeft = rect.left; // distance from viewport left to logo start
        if(logoLeft <= 0){ requestAnimationFrame(positionHamburger); return; }

    const buttonWidth = hamburger.offsetWidth || 40;
    const vw = window.innerWidth;
    // Adaptive proportional gap model (boost gap below 425px without moving logo)
    let gapFactor = 0.11; // baseline
    // Boost gap factor more aggressively so hamburger anchors further left relative to logo on very small widths
    if(vw <= 425) gapFactor = 0.14;
    if(vw <= 390) gapFactor = 0.155;
    if(vw <= 360) gapFactor = 0.17;
    if(vw <= 340) gapFactor = 0.182;
    const minGap = vw <= 360 ? 30 : vw <= 425 ? 28 : 26; // maintain a solid minimum
    const maxGap = vw <= 340 ? 50 : vw <= 360 ? 48 : vw <= 390 ? 46 : 44; // allow slightly larger visual separation
    const BASE_INSET = 10;        // minimum left inset from viewport edge
    const MAX_INSET = Math.min(110, Math.round(vw * 0.36)); // slightly higher ceiling so increased gap doesn't clamp early

    const rawGap = vw * gapFactor;
    const desiredGap = Math.min(maxGap, Math.max(minGap, rawGap));
    // Place hamburger so its right edge sits desiredGap left of logoLeft
    let candidate = logoLeft - desiredGap - buttonWidth;
    // Clamp candidate inside bounds
    if(candidate < BASE_INSET) candidate = BASE_INSET; else if(candidate > MAX_INSET) candidate = MAX_INSET;
    hamburger.style.left = candidate + 'px';

    // Lightweight runtime diagnostics (only on very narrow widths). Remove once tuned.
    if(vw <= 425){
        window.__navDebug = {
            vw,
            logoLeft: Math.round(logoLeft),
            desiredGap: Math.round(desiredGap),
            buttonWidth,
            candidate,
            BASE_INSET,
            MAX_INSET,
            gapFactor,
            minGap,
            maxGap
        };
    }
    }
    // Re-run after font load (fonts can shift logo width)
    if(document.fonts && document.fonts.ready){ document.fonts.ready.then(()=> positionHamburger()); }
    positionHamburger();
    window.addEventListener('resize', positionHamburger);
    window.addEventListener('orientationchange', positionHamburger);
    window.addEventListener('resize', ()=>{ if(overlay.classList.contains('show')) positionDesktopPopup(); });


    // Determine if we should use side-left variant (mobile) so menu sits to left of centered logo.
    // Use simpler class name for left panel variant
    // Remove menu-left variant logic (reverting to simple centered popup override CSS handles mobile positioning)

    // ARIA wiring
    const menuId = menu.id || 'main-nav-panel';
    hamburger.setAttribute('aria-controls', menuId);
    hamburger.setAttribute('aria-expanded','false');
    hamburger.setAttribute('aria-label','Open menu');
    menu.setAttribute('role','navigation');
    menu.setAttribute('aria-label','Primary');

    let lastFocus = null;
    const focusableSel = 'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])';

    function openMenu(){
        lastFocus = document.activeElement;
        menu.classList.add('show');
        overlay.classList.add('show');
        closeBtn && (closeBtn.style.display='block');
        document.body.classList.add('nav-open');
        hamburger.setAttribute('aria-expanded','true');
        hamburger.setAttribute('aria-label','Close menu');
        // focus first link
        const first = menu.querySelector(focusableSel);
    setTimeout(()=>{ first && first.focus(); },30);
    requestAnimationFrame(positionDesktopPopup);
    }
    function closeMenu(){
        menu.classList.remove('show');
        overlay.classList.remove('show');
        closeBtn && (closeBtn.style.display='none');
        document.body.classList.remove('nav-open');
        hamburger.setAttribute('aria-expanded','false');
        hamburger.setAttribute('aria-label','Open menu');
        menu.classList.remove('popup-tall');
        menu.style.top='';
        menu.style.transform='';
        menu.style.maxHeight='';
        if(lastFocus && lastFocus.focus) setTimeout(()=>lastFocus.focus(),50);
    }

    function positionDesktopPopup(){
        if(!menu.classList.contains('show')) return;
        if(window.innerWidth <= 640){ // mobile layout
            menu.classList.remove('popup-tall');
            menu.style.top='';
            menu.style.transform='';
            menu.style.maxHeight='';
            return;
        }
        const header = document.querySelector('header.site-header');
        const headerH = header ? header.offsetHeight : 80;
        const gap = 30; // distance below header
        menu.classList.add('popup-tall');
        menu.style.top = (headerH + gap) + 'px';
        menu.style.transform = 'translateX(-50%)';
        menu.style.maxHeight = `calc(100vh - ${headerH + gap + 40}px)`; // 40 bottom padding
    }

        hamburger.addEventListener('click', () => {
        const expanded = hamburger.getAttribute('aria-expanded')==='true';
        expanded ? closeMenu() : openMenu();
    });
        closeBtn && closeBtn.addEventListener('click', closeMenu);
        overlay.addEventListener('click', closeMenu);

    // Focus trap
    document.addEventListener('keydown', e => {
        if(e.key === 'Escape' && overlay.classList.contains('show')){ closeMenu(); }
        if(e.key === 'Tab' && overlay.classList.contains('show')){
            const nodes = Array.from(menu.querySelectorAll(focusableSel)).filter(el=>el.offsetParent!==null);
            if(nodes.length===0) return;
            const first = nodes[0];
            const last = nodes[nodes.length-1];
            if(e.shiftKey && document.activeElement === first){ e.preventDefault(); last.focus(); }
            else if(!e.shiftKey && document.activeElement === last){ e.preventDefault(); first.focus(); }
        }
    });

    // Submenu accordion behavior
    function setupSubmenus(){
        const parents = menu.querySelectorAll('.has-sub > a.nav-parent');
        function closeAll(except){
            parents.forEach(plink => {
                const li = plink.parentElement;
                if(li === except) return;
                li.classList.remove('open');
                const wrap = li.querySelector('.sub-menu-wrapper');
                if(wrap){ wrap.style.maxHeight=null; wrap.setAttribute('aria-hidden','true'); }
                plink.setAttribute('aria-expanded','false');
            });
        }
        parents.forEach(plink => {
            plink.setAttribute('aria-expanded','false');
                // Ensure wrappers start collapsed (CSS sets max-height:0, but inline style guarantees if previously opened)
                const wrap = plink.parentElement.querySelector('.sub-menu-wrapper');
                if(wrap){ wrap.style.maxHeight = 0; wrap.setAttribute('aria-hidden','true'); }
            plink.addEventListener('click', e => {
                const li = plink.parentElement;
                const open = li.classList.contains('open');
                    if(!open){
                        // First click: open (prevent navigation)
                        e.preventDefault();
                        closeAll(li);
                        li.classList.add('open');
                        const wrapEl = li.querySelector('.sub-menu-wrapper');
                        if(wrapEl){
                            wrapEl.style.maxHeight = wrapEl.scrollHeight + 'px';
                            wrapEl.setAttribute('aria-hidden','false');
                        }
                        plink.setAttribute('aria-expanded','true');
                    } else {
                        // Second click: navigate to href (do not preventDefault)
                        // Collapse will happen naturally when page loads
                    }
            });
        });
    }
        setupSubmenus();
        }
    })();

// Form validation and feedback
// Enhanced Booking Form Validation (progressive enhancement)
(function(){
    const bookingForm = document.querySelector('form.booking-form');
    if(!bookingForm) return; // only run on booking page

    const allowedTimes = [
        '12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30',
        '16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30',
        '20:00','20:30','21:00','21:30'
    ];

    const fields = {
        venue: bookingForm.querySelector('#venue'),
        guests: bookingForm.querySelector('#guests'),
        date: bookingForm.querySelector('#date'),
        time: bookingForm.querySelector('#time'),
        name: bookingForm.querySelector('#name'),
        phone: bookingForm.querySelector('#phone'),
        email: bookingForm.querySelector('#email'),
        policy: bookingForm.querySelector('input[name="policy"]')
    };

    function ensureErrorSpan(el){
        let wrap = el.closest('.form-row');
        if(!wrap) return null;
        let span = wrap.querySelector('.err-msg.js');
        if(!span){
            span = document.createElement('span');
            span.className = 'err-msg js';
            span.setAttribute('aria-live','polite');
            wrap.appendChild(span);
        }
        return span;
    }

    function setError(el, msg){
        if(!el) return;
        el.setAttribute('aria-invalid','true');
        const span = ensureErrorSpan(el);
        if(span){ span.textContent = msg; span.style.display=''; }
        el.classList.add('field-error');
    }
    function clearError(el){
        if(!el) return;
        el.removeAttribute('aria-invalid');
        const wrap = el.closest('.form-row');
        if(wrap){
            const span = wrap.querySelector('.err-msg.js');
            if(span){ span.textContent=''; span.style.display='none'; }
        }
        el.classList.remove('field-error');
    }

    function basicEmail(v){
        return /.+@.+\..+/.test(v);
    }

    function validate(){
        let errors = [];
        // Venue
        if(!fields.venue.value){ setError(fields.venue,'Choose a venue'); errors.push(fields.venue); } else clearError(fields.venue);
        // Guests
        if(!fields.guests.value){ setError(fields.guests,'Select guests'); errors.push(fields.guests); }
        else if(Number(fields.guests.value) < 1 || Number(fields.guests.value) > 20){ setError(fields.guests,'1–20 only'); errors.push(fields.guests); }
        else { clearError(fields.guests); }
        // Large party redirect (client side) - consistent with server
        if(fields.guests.value && Number(fields.guests.value) > 10){
            const params = new URLSearchParams();
            params.set('guests', fields.guests.value);
            if(fields.date.value) params.set('date', fields.date.value);
            if(fields.time.value) params.set('time', fields.time.value);
            window.location.href = 'group-bookings.php?' + params.toString();
            return {ok:false, redirected:true};
        }
        // Date
        if(!fields.date.value){ setError(fields.date,'Select a date'); errors.push(fields.date); } else clearError(fields.date);
        // Time
        if(!fields.time.value){ setError(fields.time,'Select a time'); errors.push(fields.time); }
        else if(!allowedTimes.includes(fields.time.value)){ setError(fields.time,'Invalid slot'); errors.push(fields.time); }
        else { clearError(fields.time); }
        // Name
        if(!fields.name.value.trim()){ setError(fields.name,'Enter name'); errors.push(fields.name); } else clearError(fields.name);
        // Phone (minimal presence check – deeper pattern can be server side)
        if(!fields.phone.value.trim()){ setError(fields.phone,'Enter phone'); errors.push(fields.phone); } else clearError(fields.phone);
        // Email
        if(!fields.email.value.trim()){ setError(fields.email,'Enter email'); errors.push(fields.email); }
        else if(!basicEmail(fields.email.value.trim())){ setError(fields.email,'Invalid email'); errors.push(fields.email); }
        else { clearError(fields.email); }
        // Policy
        if(!fields.policy.checked){ setError(fields.policy,'Required'); errors.push(fields.policy); } else clearError(fields.policy);

        return { ok: errors.length===0, first: errors[0] };    
    }

    // Real-time blur validation (lightweight)
    bookingForm.addEventListener('blur', e => {
        if(!(e.target instanceof HTMLElement)) return;
        if(e.target.matches('input, select, textarea')){
            // validate only that field
            const tempRes = validate();
            // don't shift focus here
        }
    }, true);

    bookingForm.addEventListener('submit', e => {
        const result = validate();
        if(!result.ok){
            e.preventDefault();
            if(result.first){
                // focus after small delay for reliability
                setTimeout(()=>{ result.first.focus(); }, 10);
            }
        }
    });
})();

// ----------------- Shop cart enhancements (progressive) -----------------
(function(){
    const cartForm = document.querySelector('.cart-form');
    const cartPanel = document.getElementById('cart');
    const focusCart = () => {
        if(!cartPanel) return;
        const alert = cartPanel.querySelector('.cart-alert');
        // prefer alert if exists
        if(alert){ alert.setAttribute('tabindex','-1'); alert.focus(); setTimeout(()=>{ alert.removeAttribute('tabindex'); }, 1000); return; }
        cartPanel.focus();
    };
    if(window.location.hash === '#cart') {
        setTimeout(focusCart, 60);
    }
    // If a cart alert exists (session message) focus it regardless of hash
    if(cartPanel && cartPanel.querySelector('.cart-alert')) {
        setTimeout(focusCart, 60);
    }
    if(!cartForm) return;
    cartForm.addEventListener('change', function(e){
        const t = e.target;
        if(t.matches('input[type=number]')) {
            // debounce small delay before auto-submit update
            clearTimeout(cartForm._debounce);
            cartForm._debounce = setTimeout(()=>{
                if(!cartForm.querySelector('input[name=action]')) return;
                cartForm.querySelector('input[name=action]').value = 'update';
                cartForm.submit();
            }, 600);
        }
    });
})();

// ----------------- Collapsible category groups -----------------
(function(){
    const sidebar = document.querySelector('.shop-sidebar');
    if(!sidebar) return;
    const toggles = sidebar.querySelectorAll('.cat-toggle');
    // Versioned key so structural behavior changes (default-collapsed) take effect fresh
    const storeKey = 'shopCatGroups_v2';
    // Clean up legacy key once (non-blocking)
    try { localStorage.removeItem('shopCatGroups'); } catch(e){}
    let state = {};
    try { state = JSON.parse(localStorage.getItem(storeKey) || '{}'); } catch(e){ state = {}; }
    toggles.forEach(btn => {
        const controls = btn.getAttribute('aria-controls');
        const list = document.getElementById(controls);
        if(!list) return;
        // Apply persisted state if exists
        if(typeof state[controls] !== 'undefined') {
            const expanded = !!state[controls];
            btn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
            if(!expanded) list.setAttribute('hidden',''); else list.removeAttribute('hidden');
        }
        btn.addEventListener('click', () => {
            const isExpanded = btn.getAttribute('aria-expanded') === 'true';
            const next = !isExpanded;
            btn.setAttribute('aria-expanded', next ? 'true':'false');
            if(next) { list.removeAttribute('hidden'); }
            else { list.setAttribute('hidden',''); }
            state[controls] = next;
            try { localStorage.setItem(storeKey, JSON.stringify(state)); } catch(e){}
        });
    });
})();

// ----------------- AJAX Add to Cart (prevent page jump) -----------------
(function(){
  const panel = document.getElementById('cart');
  if(!panel) return;
  // Quantity steppers (delegated for both product cards and cart)
  function attachQtySteppers(root){
      (root || document).querySelectorAll('[data-qty-wrapper]').forEach(wrap => {
          if(wrap._enhanced) return; wrap._enhanced = true;
          const input = wrap.querySelector('input[type=number]');
          if(!input) return;
          wrap.addEventListener('click', e => {
              const btn = e.target.closest('.qty-btn');
              if(!btn) return;
              e.preventDefault();
              const step = parseInt(btn.getAttribute('data-step'),10)||0;
              let current = parseInt(input.value,10); if(isNaN(current)) current = 0;
              const min = parseInt(input.getAttribute('min')||'0',10);
              const next = Math.max(min, current + step);
              input.value = next;
              input.dispatchEvent(new Event('change', {bubbles:true}));
          });
      });
  }
  attachQtySteppers();
  function updateCartDOM(html, message){
      panel.innerHTML = '<h2 class="cart-heading">Your Cart</h2>' + (message?('<div class="cart-alert" role="status" aria-live="polite">'+message+'</div>'):'') + html;
        attachQtySteppers(panel);
  }
  async function postCart(formData){
      const resp = await fetch('cart_api.php', {method:'POST', body: formData});
      if(!resp.ok) return;
      const data = await resp.json();
      if(data.cart_html){ updateCartDOM(data.cart_html, data.message); attachDynamicHandlers(); focusAfterUpdate(); }
  }
  function focusAfterUpdate(){
      const alert = panel.querySelector('.cart-alert');
      if(alert){ alert.setAttribute('tabindex','-1'); alert.focus(); setTimeout(()=>alert.removeAttribute('tabindex'),800); }
  }
  function attachDynamicHandlers(){
      const form = panel.querySelector('form.cart-form[data-ajax]') || panel.querySelector('form.cart-form');
      if(form){
          form.addEventListener('submit', e => {
              e.preventDefault();
              const fd = new FormData(form);
              fd.set('action','update');
              postCart(fd);
          });
          form.querySelectorAll('input[type=number]').forEach(inp => {
                inp.addEventListener('change', ()=>{
                    clearTimeout(inp._deb); inp._deb=setTimeout(()=>{
                         const fd = new FormData(form);
                         fd.set('action','update');
                         postCart(fd);
                    },500);
                });
          });
          form.querySelectorAll('[data-remove]').forEach(btn => {
                btn.addEventListener('click', () => {
                     const fd = new FormData();
                     fd.set('action','remove'); fd.set('product_id', btn.getAttribute('data-remove'));
                     postCart(fd);
                });
          });
          const clearBtn = form.querySelector('[data-clear]');
          if(clearBtn){
                clearBtn.addEventListener('click', () => {
                     if(!confirm('Clear all items from cart?')) return;
                     const fd = new FormData(); fd.set('action','clear_cart'); postCart(fd);
                });
          }
      }
  }
  // Intercept add forms
  document.querySelectorAll('form.add-form').forEach(f => {
      f.addEventListener('submit', e => {
          e.preventDefault();
          const fd = new FormData(f);
          postCart(fd);
      });
  });
  attachDynamicHandlers();
})();