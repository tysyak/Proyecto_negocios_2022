<div class="card-about">
    <div class="container">
        <form method="POST" action="/api/receta/nuevo"
      name='nueva_receta' id='nueva_receta_editar'>
    <input type="hidden" id="id_receta" name="id_receta" value=""><br><br>
    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="titulo" required><br><br>
    <label for="image">Imagen:</label><br>
    <input accept="image/png" type='file' id="prev_image" name="prev_image" onchange="preview_image(event)" />
    <br>
    <img class='img-recipe' alt="your image" id="image" src="/recetario/assets/img/food_default.png" />
    <br><br>
    <button class="btn" type="button" onclick="agregar_material()">Agregar Material</button>
    <button class="btn btn-danger" type="button" onclick="eliminar_material()">Eliminar Material</button>
    <br>
    <label for="materiales[]">Pasos:</label>
    <div id="materiales">
        <br>
        <input type="text" name="materiales[]" id="materiales[]" value="" required>
    </div>
    <br>
    <label for="pasos[]">Descripción</label><br>
    <textarea name="pasos[]" id="pasos[]" rows="4" cols="50"></textarea>
    <br>
    <button class="btn" type="submit" id="nueva_receta" >Crear Receta</button>
</form>
    </div>
</div>