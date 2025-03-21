<div class="contenedor restablecer">

    <?php include_once __DIR__ . '/../template/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Nueva contraseña</p>

        <form class="formulario" method="POST" action="/">

            <div class="campo">
                <label for="password">password</label>
                <input type="password" name="password" id="password" placeholder="coloca la nueva contraseña">
            </div>

            <input type="submit" value="Guardar password" class="boton">
        </form>

        <div class="acciones">
            <a href="/">Iniciar sesion</a>
            <a href="/crear">Crear cuenta</a>
        </div>        
    </div> <!-- Fin contenedor-sm -->
</div>

