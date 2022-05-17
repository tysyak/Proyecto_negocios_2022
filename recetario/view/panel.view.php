
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
    <div class="logo">
        TR
    </div>
    <input type="checkbox" class="toggle" id="nav-toggle">
    <label for="nav-toggle" id="nav-toggle-label">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </label>
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="/">
                    Home
                </a>

                <a class="navbar-item" href="/contacto">Contacto</a>
        </div>
        <ul>
            <li>
                <a href="/">Inicio</a>
            </li>
            <li>
                <a href="#">Contacto</a>
            </li>
        </ul>
    </nav>
</header>


<main>
    <div id="app"><?= $view ?></div>
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


</body>
<script src="/recetario/assets/js/app.js" type="application/javascript" ></script>
</html>