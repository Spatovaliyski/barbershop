const menuToggle = document.querySelector('.menu-toggle');
const siteHeader = document.querySelector('.site-header');

menuToggle.addEventListener('click', () => {
	siteHeader.classList.toggle('is-menu-opened');
});
