<?php /* @var $data */ ?>
<div class="card-about">
    <div class="container">
        <form>
            <label for="sub">Plan:</label>
            <select name="sub" id="sub" >
                <option value="1">Mes completo</option>
            </select>
            <br><br>

            <label for="tarjeta" >Número de Tarjeta:</label>
            <input type="text" pattern="[0-9]{19}" maxlength="19"
                   autocomplete="cc-number"
                   id="tarjeta"
                   tabindex="2"
                   placeholder="0000000000000000" name="tarjeta"
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
            ><br><br>

            <label for="caducidad" >Fecha de caducidad</label>
            <input style="width: 20%;" type="text" pattern="[0-9]{4}" maxlength="4"
                   autocomplete="cc-number"
                   id="caducidad"
                   tabindex="2"
                   placeholder="MMAA" name="caducidad"
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
            >

            <label for="cvv" >CVV</label>
            <input style="width: 20%;" type="text" pattern="[0-9]{3}" maxlength="3"
                   autocomplete="cc-number"
                   id="cvv"
                   tabindex="2"
                   placeholder="***" name="cvv"
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
            <br><br>
            <button class="btn btn-success" type="submit" id="btn-subscripcion" >Suscribirse</button>
        </form>
    </div>
</div>