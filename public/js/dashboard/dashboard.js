/**
 * ============================================
 * DASHBOARD JAVASCRIPT - CLINICAL PATHWAY APP
 * ============================================
 */

/**
 * Open modal untuk memilih pathway
 */
function openModal() {
    const modal = document.getElementById('pathwayModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

/**
 * Close modal
 */
function closeModal() {
    const modal = document.getElementById('pathwayModal');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

/**
 * Close modal ketika click di luar modal content
 */
function closeModalOnOutsideClick(event) {
    if (event.target.id === 'pathwayModal') {
        closeModal();
    }
}

/**
 * Event listener untuk ESC key
 */
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});

/**
 * Smooth scroll untuk anchor links
 */
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