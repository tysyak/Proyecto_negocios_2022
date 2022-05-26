<?php
/* @var array $data */
?>

<div class="card-about">
    <div class="container">
<form name='cargar_receta_editar' id='cargar_receta_editar' method="GET" action="/api/receta"
      function="edit_form_recipe">
    <h3><label for="id_receta_to_edit">Seleccione una receta:</label></h3><br>
    <select name="id_receta_to_edit" id="id_receta_to_edit" >
        <?php foreach ($data as $recetas ): ?>
        <option value="<?= $recetas['id'] ?>"><?= $recetas['titulo'] ?></option>
        <?php endforeach;?>
    </select>
    <button class="btn" type="submit">Obtener receta</button>
</form>
</div>
</div>

<hr>

<div class="card-about">
    <div class="container">
<form name='receta_editar' id='receta_editar' method="post" action="/api/receta/editar"
      function="edit_recipe">
    <input type="hidden" id="id_receta" name="id_receta" value=""><br><br>

    <label for="titulo" >Titulo:</label>
    <input type="text" id="titulo" name="titulo" autocomplete="off"><br><br>
    <br><br>


    <label for="borrar_imagen">Borrar imagen: </label>
    <input accept="image/png" type="checkbox" name="borrar_imagen" id="borrar_imagen">
    <br><br>

    <label for="image">Imagen:</label><br>
    <br>
    <img class="img-recipe" alt="your image" id="image" src="/recetario/assets/img/food_default.png" />
    <br>
    <input accept="image/*" type='file' name="prev_image" id="prev_image" onchange="preview_image(event)" />
    <br><br>

    <button class='btn' type="button" onclick="agregar_material()">Agregar Material</button>
    <button class='btn btn-danger' type="button" onclick="eliminar_material()">Eliminar Material</button><br>
    <div id="materiales"></div>
    <br>

    <label for="pasos[]">Descripción</label><br>
    <textarea name="pasos[]" id="pasos[]" rows="4" cols="50" autocomplete="off"></textarea>
    <br>
    <button class="btn btn-success" type="submit" id="new_receta" disabled>Cambiar</button>
</form>
    </div>
</div>