<?php /* @var $data */ ?>

<div class="card-about">
    <div class="container">
        <form action="/subscripcion/registrar" method="post" name="form-suscribirse" id="form-suscribirse">
            <label for="sub">Plan:</label>
            <select name="sub" id="sub" onchange="sel_plan(this)" required>
                <option value="nope" >Selecciona un Plan</option>
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
</script>