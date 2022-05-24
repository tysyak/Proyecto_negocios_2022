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
                <a href="<?= val_path('/') ?>"><img style="height: 1em; " src="/recetario/assets/img/logo.png"> Inicio</a>
                <a href="<?= val_path('/receta/editar') ?>">Editar Recetas</a>
                <a href="<?= val_path('/receta/nueva') ?>">Nueva Receta</a>
                <a class="badge" href="<?= val_path('/login') ?>" style="float: right;">Acceder</a>
            </div>
        </nav>
    </header>


    <main>
        <div id="app">
            <?php if (isset($view)) : ?>
                <?php include_once $view; ?>
            <?php endif; ?>
        </div>
    </main>


    <footer>
        <a class="badge" href="<?= val_path('/subscripcion') ?>">Suscribete</a>
        <a href="<?= val_path('/about') ?>">Acerca de</a>
        <p>Autor: Cristian Romero Andrade<br>
            <a href="mailto:mascrit@gmail.com">mascrit@gmail.com</a>
        </p>
    </footer>

</body>
<script src="/recetario/assets/js/app.js" type="application/javascript"></script>
<?php if ($_SERVER['REQUEST_URI'] == '/'): ?>
    <script type="application/javascript">
        listar_receta();
    </script>
<?php endif; ?>
</html>
