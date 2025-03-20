<div class="contenedor login">
    <h1 class="uptask">UpTask</h1>

    <p class="tagline">Crea y administra tus proyectos</p>


    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar sesion</p>

        <form class="formulario" method="POST" action="/">
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

