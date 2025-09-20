// Mobile Navigation Toggle
const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');

if (hamburger) {
    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        hamburger.classList.toggle('active');
    });
}

// Close mobile menu when clicking on a link
document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => {
        navLinks.classList.remove('active');
        hamburger.classList.remove('active');
    });
});

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