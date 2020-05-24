<?php
    require 'views/layout/head.php';
    require 'views/layout/'.$_SESSION['rol'].'_menu.php';
?>

<div class="container">
    <div class="row justify-content-center mt-2">
        <h1>Catalogo de servicios</h1>
    </div>
    <div class="row mt-1 mb-2 justify-content-end">
        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#crear">Crear servicio</a>
    </div>
</div>



<?php
    require 'views/admin/servicios/servicio/crear.php';
    require 'views/layout/foot.php';
?>