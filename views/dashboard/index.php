<?php include_once __DIR__. '/header.php'; ?>


    <?php if(count($proyectos) === 0) { ?> 
    
        <p class="no-proyectos">No hay proyectos aun. <a href="crearP">Crear un nuevo proyecto.</a></p>

    <?php }  
    else { ?>

        <ul class="listado-proyecto">

            <?php foreach($proyectos as $proyecto) { ?>

                <li class="proyecto">

                    <a href="/proyecto?id=<?php echo $proyecto->url; ?>">

                        <?php echo $proyecto->proyecto; ?>
                    </a>
                </li>


            <?php } ?>
        </ul>
    <?php } ?>

<?php include_once __DIR__. '/footer.php'; ?>