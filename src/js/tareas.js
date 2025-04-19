(function() { //IIFE

    obtenerTareas();
    let tareas = [];
    let filtradas = [];

    //boton para mostrar el Modal de agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', function() {
        
        mostrarFormulario();
    });
    
    //Filtro de busqueda
    const filtros = document.querySelectorAll('#filtros input[type="radio');
    filtros.forEach(radio => {

        radio.addEventListener('input', filtrarTareas);
    });

    function filtrarTareas(evento) {
        const filtro = evento.target.value;

        if(filtro !== '') {

            filtradas = tareas.filter(tarea => tarea.estado === filtro);

        } else {

            filtradas = [];
        }

        mostrarTareas();
    }

    async function obtenerTareas() {

        try {
            const id = obtenerProyecto();
            const url = `/api/tareas?id=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            
            tareas = resultado.tareas;
            mostrarTareas();

        } catch (error) {

            console.log(error);
        }
    }

    function mostrarTareas() {
        
        limpiartareas();
        totalPendientes();
        totalCompletas();

        const arrayTareas = filtradas.length ? filtradas : tareas;

        if(arrayTareas.length === 0) {
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

        arrayTareas.forEach(tarea => {
            
            const contenedorTarea = document.createElement('LI');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;
            nombreTarea.ondblclick = function() {
                
                mostrarFormulario(editar = true, {...tarea});
            }


            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            //Botoenes
            const btnEstadoTarea = document.createElement('BUTTON');
            btnEstadoTarea.classList.add('estado-tarea');
            btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`);
            btnEstadoTarea.textContent = estados[tarea.estado];
            btnEstadoTarea.dataset.estadoTarea = tarea.estado;

            btnEstadoTarea.ondblclick = function() {

                cambiarEstadoTarea({...tarea});
            }

            const btnEliminarTarea = document.createElement('BUTTON');
            btnEliminarTarea.classList.add('eliminar-tarea');
            btnEliminarTarea.dataset.idtarea = tarea.id;
            btnEliminarTarea.textContent = 'Eliminar';

            btnEliminarTarea.ondblclick = function() {
                confirmarEliminarTarea({...tarea});
            }

            opcionesDiv.appendChild(btnEstadoTarea);
            opcionesDiv.appendChild(btnEliminarTarea);

            contenedorTarea.appendChild(nombreTarea);
            contenedorTarea.appendChild(opcionesDiv);

            const listadoTareas = document.querySelector('#listado-tareas');
            listadoTareas.appendChild(contenedorTarea);

        });
    }

    function totalPendientes() {
        const totalPendientes = tareas.filter(tarea => tarea.estado === "0"); 
        const pendientesRadio = document.querySelector('#pendientes');

        if(totalPendientes.length === 0) {

            pendientesRadio.disabled = true;

        } else {
            pendientesRadio.disabled = false;
        }
    }

    function totalCompletas() {
        const totalCompletas = tareas.filter(tarea => tarea.estado === "1"); 
        const completadasRadio = document.querySelector('#completadas');

        if(totalCompletas.length === 0) {

            completadasRadio.disabled = true;

        } else {
            completadasRadio.disabled = false;
        }
    }

    function mostrarFormulario(editar = false, tarea = {}) {
        

        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
        
            <form class="formulario nueva-tarea">
                <legend>${editar ? 'Editar Tarea' : 'Agregar una nueva tarea'}</legend>

                <div class="campo">
                    <label for="tarea"> Tarea </label>

                    <input 
                    type="text"
                    name="tarea"
                    placeholder="${tarea.nombre ? 'Editar la tarea' : 'Agregar tarea al proyecto'}"
                    id="tarea"
                    value="${tarea.nombre ? tarea.nombre : ''}"
                    >
                </div>

                <div class="opciones">
                    <input 
                    class="submit-nueva-tarea" 
                    type="submit" 
                    value="${tarea.nombre ? 'Guardar' : 'Agregar tarea'}"
                    id="tarea">

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
                //El value permite mostrar lo que se guarndo en esa variable que escribiste.
                //El trim elimina los espacios en blancos.
                const nombreTarea = document.querySelector('#tarea').value.trim();

                if(nombreTarea === '') {
                    //Mostrar una alerta de error.
                    
                    mostrarAlert('El nombre de la tarea es obligatorio', 'error', document.querySelector('.formulario legend'));
                    
                    return;
                } 

                if(editar) {
                    tarea.nombre = nombreTarea;
                    actualizarTarea(tarea);
                } else {
                    agregarTarea(nombreTarea);
                }
                
            }
        });
        document.querySelector('.dashboard').appendChild(modal);
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

        // const proyecto = Object.fromEntries(ProyectoParams.entries());
        // console.log(proyecto.id);

        try {

            const url = 'http://localhost:3000/api/tarea';

            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();
           

            mostrarAlert(resultado.mensaje, 
                resultado.tipo, 
                document.querySelector('.formulario legend'));

            if(resultado.tipo === 'exito') {
                const modal = document.querySelector('.modal');
                setTimeout(() => {
                    modal.remove();

                    window.location.reload();
                }, 3000);

                //Agregar el objeto de tarea al global de tareas.
                const tareaObj = {
                    id: String(resultado.id),
                    nombre: tarea,
                    estado: "0",
                    proyectoid: resultado.proyectoid

                }

                //Este es el global que esta arribita.
                tareas = [...tareas, tareaObj];
                mostrarTareas();

                console.log(tareaObj);
            }
            
        } catch (error) {
            console.log(error);
        }
    }

    function cambiarEstadoTarea(tarea) {

        const nuevoEstado = tarea.estado === '1' ? "0" : "1";
        tarea.estado = nuevoEstado;
        actualizarTarea(tarea);

    }

    async function actualizarTarea(tarea) {

        const {estado, id, nombre, proyectoid} = tarea;

        const datos = new FormData();
        datos.append('id', id);
        datos.append('estado', estado);
        datos.append('nombre', nombre);

        datos.append('proyectoid', obtenerProyecto());

        // for(let valor of datos.values()) {

        //     console.log(valor);
        // }

        try {
            const url = 'http://localhost:3000/api/tarea/actualizar';

            const respuesta = await fetch(url, {

                method:'POST',
                body: datos
            });

            const resultado = await respuesta.json();

            if(resultado.respuesta.tipo === 'exito') {
                
                Swal.fire(
                    resultado.respuesta.mensaje,
                    resultado.respuesta.mensaje,
                    'success'
                );

                const modal = document.querySelector('.modal');
                
                if(modal) {
                    modal.remove();
                }
                //Mantener sincronizando el backend con el cliente

                tareas = tareas.map(tareaMemoria => {
                    
                    if(tareaMemoria.id === id) {
                        tareaMemoria.estado = estado;
                        tareaMemoria.nombre = nombre;
                    } 

                    return tareaMemoria;
                });
                
                mostrarTareas();
            }

        } catch (error) {
            console.log(error);

        }

    }

    function confirmarEliminarTarea(tarea) {

        Swal.fire({

            title: "Estas seguro?",
            showCancelButton: true,
            confirmButtonText: "Si",
            cancelButtonText: "No"

        }).then((result) => {

            //Si se responde con si.
            if (result.isConfirmed) {
              eliminarTarea(tarea);
            }

        });
    }

    async function eliminarTarea(tarea) {

        const {estado, id, nombre, proyectoid} = tarea;

        const datos = new FormData();
        datos.append('id', id);
        datos.append('estado', estado);
        datos.append('nombre', nombre);

        datos.append('proyectoid', obtenerProyecto());
        
        try {
            
            const url = 'http://localhost:3000/api/tarea/eliminar';

            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            console.log(respuesta);

            const resultado = await respuesta.json();
            
            if (resultado.resultado) {
                // mostrarAlert(resultado.mensaje, resultado.tipo, document.querySelector('.contenedor-nueva-tarea'));

                Swal.fire('Eliminado!', resultado.mensaje, 'success')
                //Sacar del VirtualDOM
    
                //El filter deja dicho en esta codicion,traete todas excepto a la que yo elimine
                tareas = tareas.filter( tareaMemoria => tareaMemoria.id != tarea.id);
                mostrarTareas();
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

    function limpiartareas() {
        const listadoTareas= document.querySelector('#listado-tareas');
        
        //busca el elemento del id listado-tareas, evalua si hay contenido y si hay ira eliminando 1 por 1.
        while(listadoTareas.firstChild) {
            listadoTareas.removeChild(listadoTareas.firstChild);
        }
    }

})(); //END IIFE
