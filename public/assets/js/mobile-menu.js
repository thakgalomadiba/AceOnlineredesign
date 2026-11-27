const menuToggle = document.getElementById('mobileMenuToggle');
const menuClose = document.getElementById('mobileMenuClose');
const mobileNav = document.getElementById('mobileNav');
const overlay = document.getElementById('mobileMenuOverlay');



function openMenu() {
    mobileNav.classList.add('active');
    overlay.classList.add('active');
    menuToggle.setAttribute('aria-expanded', 'true');
}

function closeMenu() {
    mobileNav.classList.remove('active');
    overlay.classList.remove('active');
    menuToggle.setAttribute('aria-expanded', 'false');
}

menuToggle?.addEventListener('click', openMenu);
menuClose?.addEventListener('click', closeMenu);
overlay?.addEventListener('click', closeMenu);

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeMenu();
});