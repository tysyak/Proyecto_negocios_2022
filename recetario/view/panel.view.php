<?php
/* @var array $data */
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

    <!--   El Modal   -->
    <div id="gen-modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header" id="modal-header">
                <span class="close-modal" onclick="ocultar_modal()">&times;</span>
                <h2>Modal Header</h2>
            </div>
            <div class="modal-body" id="modal-body">
                <p>Some text in the Modal Body</p>
                <p>Some other text...</p>
            </div>
            <div class="modal-footer" id="modal-footer">
                <h3>Modal Footer</h3>
            </div>
        </div>

    </div>

    <header>
        <nav class="navbar">
            <div class="title"><a class="nav-link" href="<?= val_path('/') ?>"><img style="height: 1em; " src="/recetario/assets/img/logo.png" alt="logo"> Inicio</a></div>

            <div class="ham">
                <span class="bar1"></span>
                <span class="bar2"></span>
                <span class="bar3"></span>
            </div>
            <ul class="nav-sub">
                <?php if (isset($_SESSION['username'])) : ?>
                    <script type="application/javascript">
                        const username = '<?= $_SESSION['username'] ?>';
                        const id_usuario = '<?= $_SESSION['id_usuario'] ?>';
                    </script>
                    <li class="list-item">
                        <a class="badge links " href="<?= val_path('/perfil') ?>" style="float: right;"><?= ucfirst(strtolower($_SESSION['username'])) ?></a>
                    </li>
                    <li class="list-item"><a class="links" href="<?= val_path('/recetas') ?>">Ver Recetas</a></li>
                    <li class="list-item"><a class="links" href="<?= val_path('/recetas?f=true') ?>">Mis Recetas Favoritas</a></li>
                    <li class="list-item"><a class="links" href="<?= val_path('/receta/editar') ?>">Editar Mis Recetas</a></li>
                    <li class="list-item"><a class="links" href="<?= val_path('/receta/nueva') ?>">Nueva Receta</a></li>
                    <li class="list-item"><a class="badge links btn-danger" href="<?= val_path('/logout') ?>" style="float: right;">Cerrar Sesión</a></li>
                <?php else : ?>
                    <li class="list-item"><a class="links" href="<?= val_path('/recetas') ?>">Ver Recetas</a></li>
                    <li class="list-item"><a class="badge links" href="<?= val_path('/login') ?>" style="float: right;">Acceder</a></li>
                <?php endif; ?>
            </ul>

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
        <p>Autores:</p>

        <a href="mailto:mascrit@gmail.com">Cristian Romero Andrade<br></a>

        <a href="#">Victor Anizar Morales</a>




    </footer>

</body>
<script src="/recetario/assets/js/app.js" type="application/javascript"></script>
<?php if ($_SERVER['REQUEST_URI'] == '/recetas' || $_SERVER['REQUEST_URI'] == '/recetas?f=true') : ?>
    <script type="application/javascript">
        window.onload = () => {
            mostrar_modal('Esperando las recetas',
                'Cargando', '');
            listar_receta(<?php
                            if (!empty($data)) {
                                echo json_encode($data);
                            }
                            ?>);
            ocultar_modal();
        }
    </script>
<?php endif; ?>

</html>
