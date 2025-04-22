<?php include_once __DIR__. '/header.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__. '/../template/alertas.php'; ?>

    <a href="/cambiar-password" class="enlace">Cambiar password</a>

    <form action="/perfil" class="formulario" method="POST">
        <div class="campo">
            <label for="nombre">Nombre</label>

            <input 
            type="text" 
            value="<?php echo $usuario->nombre; ?>" 
            name="nombre" 
            placeholder="Tu nombre">

        </div>

        <div class="campo">
            <label for="nombre">Email</label>

            <input 
            type="email" 
            value="<?php echo $usuario->email; ?>" 
            name="email" 
            placeholder="Tu E-mail">
            
        </div>

        <input type="submit" class="boton" value="Guardar">

    </form>
</div>


<?php include_once __DIR__. '/footer.php'; ?>