(function() { //IIFE

    obtenerTareas();

    //boton para mostrar el Modal de agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    async function obtenerTareas() {

        try {
            const id = obtenerProyecto();
            const url = `/api/tareas?id=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            
            const {tareas} = resultado;
            mostrarTareas(tareas);

        } catch (error) {

            console.log(error);
        }
    }

    function mostrarTareas(tareas) {
        if(tareas.length === 0) {
            const contenedorTareas = document.querySelector('#listado-tareas');

            const textoNoTareas = document.createElement('LI');
            textoNoTareas.textContent = 'No hay tareas.';
            textoNoTareas.classList.add('no-tareas');

            contenedorTareas.appendChild(textoNoTareas);

            return;
        }

        const estados = {
            0: 'Pendiente',
            1: 'Completa'
        }

        tareas.forEach(tarea => {
            
            const contenedorTarea = document.createElement('LI');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;


            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            //Botoenes
            const btnEstadoTarea = document.createElement('BUTTON');
            btnEstadoTarea.classList.add('estado-tarea');
            btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`);
            btnEstadoTarea.textContent = estados[tarea.estado];
            btnEstadoTarea.dataset.estadoTarea = tarea.estado;

            const btnEliminarTarea = document.createElement('BUTTON');
            btnEliminarTarea.classList.add('eliminar-tarea');
            btnEliminarTarea.dataset.idtarea = tarea.id;
            btnEliminarTarea.textContent = 'Eliminar';

            opcionesDiv.appendChild(btnEstadoTarea);
            opcionesDiv.appendChild(btnEliminarTarea);

            contenedorTarea.appendChild(nombreTarea);
            contenedorTarea.appendChild(opcionesDiv);

            const listadoTareas = document.querySelector('#listado-tareas');
            listadoTareas.appendChild(contenedorTarea);


            console.log(contenedorTarea);
        })
    }


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

            if(evento.target.classList.contains('submit-nueva-tarea')) {
                
                submitFormNewTarea();
            }
        });
        document.querySelector('.dashboard').appendChild(modal);
    }

    function submitFormNewTarea() {

        //El value permite mostrar lo que se guarndo en esa variable que escribiste.
        //El trim elimina los espacios en blancos.
        const tarea = document.querySelector('#tarea').value.trim();

        if(tarea === '') {
            //Mostrar una alerta de error.
            
            mostrarAlert('El nombre de la tarea es obligatorio', 'error', document.querySelector('.formulario legend'));
            
            return;
        } 

        agregarTarea(tarea);
    }

    function mostrarAlert(mensaje, tipo, referencia) {
        //Prevenir la creacion de multiples alertas.
        const alertPrev = document.querySelector('.alerta');

        if(alertPrev) {
            alertPrev.remove();
        }

        const alerta = document.createElement('DIV');

        //Con tipo se deja dicho qye puede ser un alerta de eror o un alerta de exito.
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;

        //Este codigo inserta antes del legend y no adentro.
        //El nextElementSiblings toma la referencia de colocarlo despues del elemento padre y antes delsegundo elemento del HTML.
        referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);
        // console.log(referencia);
        // console.log(referencia.parentElement);
        // console.log(referencia.nextElementSibling);

        //Eliminar la alerta despues de cierto tiempo
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
    
    //Consultar al sv para agregar una nueva tarea al proyecto actual.
    async function agregarTarea(tarea) {

        //Construir la peticion
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('proyectoid', obtenerProyecto());

        const ProyectoParams = new URLSearchParams(window.location.search)

        const proyecto = Object.fromEntries(ProyectoParams.entries());
        console.log(proyecto.id);

        try {

            const url = 'http://localhost:3000/api/tarea';

            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();
            console.log(resultado);

            mostrarAlert(resultado.mensaje, resultado.tipo, document.querySelector('.formulario legend'));

            if(resultado.tipo === 'exito') {
                const modal = document.querySelector('.modal');
                setTimeout(() => {
                    modal.remove();
                }, 3000);
            }
            
        } catch (error) {
            console.log(error);
        }
    }

    function obtenerProyecto() {
        const proyectoParams = new URLSearchParams(window.location.search);

        const proyecto = Object.fromEntries(proyectoParams.entries());
        return proyecto.id;
    }

})(); //END IIFE
