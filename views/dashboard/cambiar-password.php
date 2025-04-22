<?php include_once __DIR__. '/header.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__. '/../template/alertas.php'; ?>

    <a href="/perfil" class="enlace">Volver al perfil</a>

    <form action="/cambiar-password" class="formulario" method="POST">
        <div class="campo">
            <label for="nombre">Password actual</label>

            <input 
            type="password" 
            name="password_actual" 
            placeholder="Tu password actual">

        </div>

        <div class="campo">
            <label for="nombre">Nuevo password</label>

            <input 
            type="password"
            name="password_nuevo" 
            placeholder="Tu nuevo password">
            
        </div>

        <input type="submit" class="boton" value="Guardar">

    </form>
</div>


<?php include_once __DIR__. '/footer.php'; ?>