
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?= '/recetario/assets/css/app.css'?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasty Recipes</title>
</head>
<body>

<header>
    <nav>
        <div class="links">
            <?php if ($_SERVER['REQUEST_URI']=='/'):?>
                <?php $home = '#';?>
            <?php else: ?>
                <?php $home = '/';?>
            <?php endif;?>
            <a href="<?= $home ?>">Inicio</a>
            <a href="/receta/editar">Editar Recetas</a>
            <a href="/receta/nueva">Nueva Receta</a>
        </div>
    </nav>
</header>


<main>
    <div id="app">
        <?php if (isset($view)): ?>
            <?php include_once $view; ?>
        <?php endif; ?>
    </div>
    <button id="listar_recetas" type="button" onclick="listar_receta()">Listar Recetas</button>
</main>
<div class="card">
    <header class="card-header">
        <p class="card-header-title">
            Component
        </p>
        <button class="card-header-icon" aria-label="more options">
      <span class="icon">
        <i class="fas fa-angle-down" aria-hidden="true"></i>
      </span>
        </button>
    </header>
    <div class="card-content">
        <div class="content">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.
            <a href="#">@bulmaio</a>. <a href="#">#css</a> <a href="#">#responsive</a>
            <br>
            <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
        </div>
    </div>
    <footer class="card-footer">
        <a href="#" class="card-footer-item">Save</a>
        <a href="#" class="card-footer-item">Edit</a>
        <a href="#" class="card-footer-item">Delete</a>
    </footer>
</div>

<footer>
    <p>Author: Hege Refsnes<br>
        <a href="mailto:hege@example.com">hege@example.com</a></p>
</footer>

</body>
<script src="/recetario/assets/js/app.js" type="application/javascript" ></script>
</html>
