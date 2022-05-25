<div class="card-about">
    <form method="post" action="/api/session/login">

        <label for="username">Usuario</label><br>
        <input type="text" id="username" name="username" placeholder="Usuario">
        <br>
        <label for="password" >Contraseña</label><br>
        <input type="password" id="password" name="password" placeholder="Contraseña" autocomplete="off">
        <br>
        <input type="checkbox" id="show_password"><label for="show_password">&nbsp;Mostrar Contraseña</label>
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>
</div>

<script type="text/javascript">
    const target_pass = document.getElementById('show_password');
    const password = document.getElementById('password');

    let mostrar_contrasenia = false;

    target_pass.addEventListener('change',presionar_boton);

    function presionar_boton(){
        mostrar_contrasenia = !mostrar_contrasenia;
        if (mostrar_contrasenia) {
            password.type = 'text';
        } else {
            password.type = 'password';
        }
    }
</script>