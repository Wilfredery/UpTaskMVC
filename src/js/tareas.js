(function() { //IIFE

    //boton para mostrar el Modal de agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    function mostrarFormulario() {
        
        const modal =document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
        
            <form class="formulario nueva-tarea">
                <legend>Tarea</legend>

                <div class="campo">
                    <label>Agrega una nueva tarea </label>

                    <input 
                    type="text"
                    name="tarea"
                    placeholder="Agregar tarea al proyecto actual"
                    id="tarea"
                    >
                </div>

                <div class="opciones">
                    <input type="submit" class="submit-nueva-tarea" value="Agregar tarea">

                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
            </form>
        `;
        setTimeout(() => {
            const form = document.querySelector('.formulario');
            form.classList.add('animar');
        }, 1000);
        console.log(modal);
        document.querySelector('body').appendChild(modal);
    }
})();

