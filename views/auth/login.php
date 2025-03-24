<div class="contenedor login">

    <?php include_once __DIR__ . '/../template/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar sesion</p>

        <?php include_once __DIR__ . '/../template/alertas.php'; ?>

        <form class="formulario" method="POST" >
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Tu correo electronico">
            </div>

            <div class="campo">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Tu Contraseña">
            </div>

            <input type="submit" value="Acceder" class="boton">
        </form>

        <div class="acciones">
            <a href="/crear">Crear cuenta</a>
            <a href="/olvidar">Olvide el password</a>
        </div>        
    </div> <!-- Fin contenedor-sm -->
</div>

