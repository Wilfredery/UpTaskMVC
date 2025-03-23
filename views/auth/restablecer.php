<div class="contenedor restablecer">

    <?php include_once __DIR__ . '/../template/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Nueva contraseña</p>

        <?php include_once __DIR__ . '/../template/alertas.php'; ?>

        <?php if($mostrar) { ?>

        <form class="formulario" method="POST">

            <div class="campo">
                <label for="password">password</label>
                <input type="password" name="password" id="password" placeholder="coloca la nueva contraseña" required>
            </div>

            <input type="submit" value="Guardar password" class="boton">
        </form>

        <?php } ?>
        <div class="acciones">
            <a href="/">Iniciar sesion</a>
            <a href="/crear">Crear cuenta</a>
        </div>        
    </div> <!-- Fin contenedor-sm -->
</div>

