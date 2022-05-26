<?php
/* @var array $data */
?>
<div class="card" >
        <?php if (isset($data['image'])): ?>
        <img class='img-recipe' src="data:image/png;base64,<?=$data['image'] ?>" alt="receta" style="width: 100%">
        <?php else: ?>
        <?php endif; ?>
    <div class="container">
        <h4><?=$data['titulo'] ?></h4>
        <ul>
         <?php foreach ($data['materiales'] as $material): ?>
            <li><?= $material['descripcion'] ?></li>
         <?php endforeach; ?>
        </ul>
    </div>
    <input type="checkbox" class="read-more-state" id="<?= $data['id'] ?>">
    <p class="read-more-wrap" style="text-align: justify;"><br><span class="read-more-target"><?= $data['pasos'][0]['descripcion'] ?></span></p>


    <label for="<?= $data['id'] ?>" class="btn read-more-trigger"></label>
    <br>
    <?php if (isset($_SESSION['username'])): ?>
    <?php if ($data['favorito']): ?>
        <button id='btn-fav-<?= $data['id'] ?>' class="badge btn-danger" onclick="toggle_fav(<?= $data['id'] ?>)">Eliminar de favoritos</button>
    <?php else: ?>
        <button id='btn-fav-<?= $data['id'] ?>' class="badge btn-success" onclick="toggle_fav(<?= $data['id'] ?>)">Añadir a favoritos</button>
        <?php endif;?>
    <?php endif;?>
</div>
