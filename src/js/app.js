const mobileMenubtn = document.querySelector('#mobile-menu');
const cerrarMenubtn = document.querySelector('#cerrar-menu');
const sidebar = document.querySelector('.sidebar');

if(mobileMenubtn) {
  mobileMenubtn.addEventListener('click', () => {
    sidebar.classList.add('mostrar');

  });
}

if(cerrarMenubtn) {
  cerrarMenubtn.addEventListener('click', () => {
    sidebar.classList.add('ocultar');

    setTimeout(() => {
        sidebar.classList.remove('mostrar');
        sidebar.classList.remove('ocultar');
    }, 300);
  });
}