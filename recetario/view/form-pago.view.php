<?php /* @var $data */ ?>

<div class="card-about">
    <div class="container">
        <form action="/api/subscripcion/usuario/registrar" method="post"
              name="form-suscribirse" id="form-suscribirse">
            <label for="sub">Plan:</label>
            <select name="sub" id="sub" onchange="sel_plan(this)" required>
                <option id='sel-default' value="nope" >Selecciona un Plan</option>
                <?php foreach ($data as $sub): ?>
                    <option value="<?= $sub['id'] ?>" precio="<?=$sub['precio']?>">
                        <?= $sub['precio'].' MXN$'.' - '.$sub['titulo'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <p id="sub-desc"></p>
            <br><br>

            <label for="tarjeta" >Número de Tarjeta:</label>
            <input type="text" pattern="[0-9]{19}" maxlength="19"
                   autocomplete="cc-number"
                   id="tarjeta"
                   tabindex="2"
                   placeholder="0000000000000000" name="tarjeta"
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                   required ><br><br>

            <label for="caducidad" >Fecha de caducidad</label>
            <input style="width: 20%;" type="text" pattern="[0-9]{4}" maxlength="4"
                   autocomplete="cc-number"
                   id="caducidad"
                   tabindex="2"
                   placeholder="MMAA" name="caducidad"
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                   required >

            <label for="cvv" >CVV</label>
            <input style="width: 20%;" type="text" pattern="[0-9]{3}" maxlength="3"
                   autocomplete="cc-number"
                   id="cvv"
                   tabindex="2"
                   placeholder="***" name="cvv"
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
            <br><br>
            <button id='sub-submit' class="btn btn-success" type="submit" id="btn-subscripcion" disabled>Suscribirse</button>
        </form>
    </div>
</div>
<script type="application/javascript">
const data = <?= json_encode($data) ?>;

function sel_plan(sel) {
    data.forEach(elem => {
        if (elem.id == sel.value){
            document.getElementById('sub-desc').innerText = elem.descripcion
            document.getElementById('sub-submit').disabled = false;
        }
        if (sel.value === 'nope'){
            document.getElementById('sub-desc').innerText = '';
            document.getElementById('sub-submit').disabled = true;
        }
    });
}


const uri = '/api/suscripcion/usuario/info';

 fetch(uri,{method: 'post'}).then( async response => {
     const json = await response.json();
     if (json.activo) {
         let fecha = new Date(
             json.fecha_termino.year,
             json.fecha_termino.month - 1,
             json.fecha_termino.day
         );
         fecha.toLocaleString('es-ES', { month: 'long' })
          document.getElementById('sub-desc').innerHTML = 'Ya tienes una subscripcion activa:' +
              '<h4>' + json.detalle.titulo + '</h4>' +
              `<p>${fecha.getDate()}-${fecha.toLocaleString('default', { month: 'long' })}-${fecha.getUTCFullYear()}</p>`;
            document.getElementById('sub').disabled = true
            document.getElementById('sel-default').innerText = 'Ya Cuentas con una suscripción'
            document.getElementById('tarjeta').disabled = true
            document.getElementById('caducidad').disabled = true
            document.getElementById('cvv').disabled = true
        }});

</script>