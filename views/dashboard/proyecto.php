<?php include_once __DIR__. '/header.php'; ?>

    <div class="contenedor-sm">
        <div class="contenedor-nueva-tarea">
            <button class="agregar-tarea" type="button" id="agregar-tarea">&#43; Nueva tarea</button>
        </div>

        <ul id="listado-tareas" class="listado-tareas">
            <!-- Aqui se inyectara el contenido desde tareas.js -->

        </ul>

    </div>


<?php include_once __DIR__. '/footer.php'; ?>

<?php

    $script = '<script src="build/js/tareas.js"></script>';

?>
