<?php
    require 'views/layout/head.php';
    require 'views/layout/'.$_SESSION['rol'].'_menu.php';
?>

<div class="container">
    <div class="row justify-content-center mt-2">
        <h1>Usuarios</h1>
    </div>
    <div class="row mt-1 mb-2 justify-content-end">
        <a class="btn btn-outline-primary btn-sm" href="<? echo URL?>/usuarios/crear">Crear usuario</a>
    </div>
</div>

<?php
    require 'views/layout/foot.php';
?>