(function() { //IIFE

    //boton para mostrar el Modal de agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    function mostrarFormulario() {
        
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
        
            <form class="formulario nueva-tarea">
                <legend>Agrega una nueva tarea</legend>

                <div class="campo">
                    <label for="tarea"> Tarea </label>

                    <input 
                    type="text"
                    name="tarea"
                    placeholder="Agregar tarea al proyecto actual"
                    id="tarea"
                    required
                    >
                </div>

                <div class="opciones">
                    <input class="submit-nueva-tarea" type="submit" value="Agregar tarea">

                    <button class="cerrar-modal" type="button">Cancelar</button>
                </div>
            </form>
        `;
        setTimeout(() => {
            const form = document.querySelector('.formulario');
            form.classList.add('animar');
        }, 100);

        modal.addEventListener('click', function(evento) {
            //Evita que si hay un boton de tipo submit en la zona este lo bloquea.
            evento.preventDefault(); 

            //Esto se aplica cuando se trabajo con el InnerHTML.
            if(evento.target.classList.contains('cerrar-modal')) {
                const form = document.querySelector('.formulario');
                form.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                }, 500);
                

            } 

            console.log(evento.target);
        });
        document.querySelector('body').appendChild(modal);
    }
})(); //END IIFE
