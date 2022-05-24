<?php
function val_path($path): string
{
    if ($_SERVER['REQUEST_URI'] == $path) {
        $home = '#';
    } else {
        $home = $path;
    }
    return $home;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="/recetario/assets/img/favicon.ico">

    <link rel="stylesheet" href="/recetario/assets/css/app.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasty Recipes</title>
</head>

<body>

    <header>
        <nav>
            <div class="links">

                <a href="<?= val_path('/') ?>"><img style="height: 1em;" src="/recetario/assets/img/logo.png"> Inicio</a>
                <a href="<?= val_path('/receta/editar') ?>">Editar Recetas</a>
                <a href="<?= val_path('/receta/nueva') ?>">Nueva Receta</a>
            </div>
        </nav>
    </header>


    <main>
        <div id="app">
            <?php if (isset($view)) : ?>
                <?php include_once $view; ?>
            <?php endif; ?>
        </div>
        <button class='btn' id="listar_recetas" type="button" onclick="listar_receta()">Listar Recetas</button>
    </main>


    <footer>
        <p>Author: Cristian Romero Andrade<br>
            <a href="mailto:mascrit@gmail.com">mascrit@gmail.com</a>
        </p>
    </footer>

</body>
<script src="/recetario/assets/js/app.js" type="application/javascript"></script>

</html>
