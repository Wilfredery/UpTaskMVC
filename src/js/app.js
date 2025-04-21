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

//Elimina la clase de mostrar en un tamaño de tablet y mayores.
const anchoPantalla = document.body.clientWidth;

window.addEventListener('resize', () => {

  const anchoPantalla = document.body.clientWidth;

  if(anchoPantalla >= 768) {
    sidebar.classList.remove('mostrar');
  }
});