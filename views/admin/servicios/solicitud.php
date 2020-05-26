<?php
    require 'views/layout/head.php';
    require 'views/layout/'.$_SESSION['rol'].'_menu.php';
?>
<div class="container">
    <div class="row justify-content-center mt-2">
        <h1>Solicitudes de servicio</h1>
    </div>
    <div class="row mt-1 mb-2 justify-content-end">
        <a href="<?echo URL?>/servicios/nueva_solicitud" class="btn btn-outline-primary btn-sm">Crear solicitud</a>
    </div>
</div>



<?php
    require 'views/layout/foot.php';
?>