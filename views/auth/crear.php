<div class="contenedor crear">

    <?php include_once __DIR__ . '/../template/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en uptask</p>

        <?php include_once __DIR__ . '/../template/alertas.php'; ?>

        <form class="formulario" method="POST" action="/crear">

            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" value="<?php echo $usuario->nombre; ?>">
            </div>

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Tu correo electronico" 
                <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" value="<?php echo $usuario->email; ?>">
            </div>

            <div class="campo">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Tu Contraseña">
            </div>

            <div class="campo">
                <label for="password2">Confirmar la contraseña</label>
                <input type="password" name="password2" id="password2" placeholder="Repetir tu contraseña">
            </div>

            <input type="submit" value="Crear cuenta" class="boton">
        </form>

        <div class="acciones">
            <a href="/">Iniciar sesion</a>
            <a href="/olvidar">Olvide el password</a>
        </div>        
    </div> <!-- Fin contenedor-sm -->
</div>

