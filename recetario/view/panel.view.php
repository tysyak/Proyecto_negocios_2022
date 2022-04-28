<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?= SITIO.'recetario/assets/css/app.css'?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar</title>
</head>
<body>

<header>
    <div class="logo">
        <i class="fas fa-feather-alt"></i>
    </div>
    <input type="checkbox" class="toggle" id="nav-toggle">
    <label for="nav-toggle" id="nav-toggle-label">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </label>
    <nav>
        <ul>
            <li>
                <a href="#"><i class="far fa-chart-bar"></i>Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="far fa-edit"></i>Projects</a>
            </li>
            <li>
                <a href="#"><i class="far fa-envelope-open"></i>Posts</a>
            </li>
        </ul>
    </nav>
</header>
<main>
    Make viewport smaller and see what happens to the navbar.
</main>

<!-- content will go here -->
</body>
</html>