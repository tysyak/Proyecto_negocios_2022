<?php
/* @var array $data */
?>
<form name='cargar_receta_editar' id='cargar_receta_editar' method="GET" action="/api/receta"
      function="edit_form_recipe" xmlns="http://www.w3.org/1999/html">
    <label for="id_receta_to_edit">Selecciones una receta:</label>
    <select name="id_receta_to_edit" id="id_receta_to_edit" >
        <?php foreach ($data as $recetas ): ?>
        <option value="<?= $recetas->id ?>"><?= $recetas->titulo ?></option>
        <?php endforeach;?>
    </select>
    <input type="submit">Obtener receta</input>
</form>

<hr>
<form >
    <input type="hidden" id="ed_id_receta" name="ed_id_receta" value=""><br><br>
    <label for="ed_titulo">Titulo:</label>
    <input type="text" id="ed_titulo" name="ed_titulo"><br><br>
    <div id="ed_materiales"></div>
    <input type="submit" id="ed_receta" disabled>Cambiar</input>
</form>
