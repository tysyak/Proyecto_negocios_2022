<style>
    .land-container {
        position: relative;
    }

    .text-block-left {
        position: absolute;
        font-size:3vw;
        bottom: 50%;
        background-color: rgba(255,223,185,0.8);
        color: black;
        padding-left: 20px;
        padding-right: 20px;
        border-radius:20px;
    }
    .text-block-right {
        position: absolute;
        text-align: right;
        font-size:3vw;
        left: 80%;
        bottom: 50%;
        background-color: rgba(255,223,185,0.8);
        color: black;
        padding-left: 40px;
        padding-right: 40px;
        border-radius:20px;
    }
</style>
<div class="land-container">
    <img src="/recetario/assets/img/land.jpg" alt="Nature" style=" max-width: 100%; height: auto; width: auto\9;" >
    <div class="text-block-left">
        <img src="/recetario/assets/img/logo.png" alt="mission_img">
        <h4>Tasty Recipes</h4>
        <i>Crea, comparte, busca y guarda <br>  tus recetas favoritas</i>
    </div>
    <div class="text-block-right">
        <a href="<?= val_path('/recipes') ?>" class="btn btn-success">
            Empieza a Cocinar
        </a>
    </div>
</div>
