<?php
/* @var array $data */
?>

<div class="card-about">
    <form name='perfil_editar' id='perfil_editar' method="POST" action="/api/perfil/editar" function="exec_perfil_editar">
        <label for="u">Nombre de Usuario:</label>
        <input type="text" id="u" name="u" value="<?= ucfirst(strtolower($data['username'])) ?>" disabled><br><br>

        <label for="n">Nombre:</label>
        <input type="text" id="n" name="n" value="<?= ucfirst(strtolower($data['nombre'])) ?>"><br><br>

        <label for="ap">Apellido Paterno</label>
        <input type="text" id="ap" name="ap" value="<?= ucfirst(strtolower($data['apellido_paterno'])) ?>"><br><br>

        <label for="am">Apellido Materno</label>
        <input type="text" id="am" name="am" value="<?= ucfirst(strtolower($data['apellido_materno'])) ?>"><br><br>

        <label for="nac">Nacimiento</label>
        <input type='date' id='nac' name='nac' value="<?= $data['fecha_nacimiento'] ?>"><br><br>


        <label for='estatura'>Estatura [cm]</label>
        <input type="number" id=estatura name=estatura step="1" max='300' min='0' value='<?= $data['estatura'] ?>'><br><br>

        <label for='peso'>Peso [Kg]</label>
        <input type="number" id=peso name=peso step="0.01" max='300.00' min='0.01' value='<?= $data['peso'] ?>'><br><br>

        <button type="submit" class="btn btn-success" style="width: 70%;">Actualizar Datos</button>

    </form>
</div>
