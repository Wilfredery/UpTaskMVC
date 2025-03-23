<div class="contenedor olvidar">

    <?php include_once __DIR__ . '/../template/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recuperar tu acceso de cuenta</p>

        <?php include_once __DIR__ . '/../template/alertas.php'; ?>

        <form class="formulario" method="POST" action="/olvidar" >

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Tu correo electronico">
            </div>

            <input type="submit" value="Enviar" class="boton">
        </form>

        <div class="acciones">
            <a href="/">Iniciar sesion</a>
            <a href="/crear">Crear cuenta</a>
        </div>        
    </div> <!-- Fin contenedor-sm -->
</div>

