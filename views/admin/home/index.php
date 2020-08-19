<?php
require 'views/layout/head.php';
require 'views/layout/' . $_SESSION['rol'] . '_menu.php';
?>

<div class="container">
    <div class="row">
        <div class="card card-body col-md-2 mt-3">
            <h5 class="card-title">
                Solicitudes de cuenta
            </h5>
            <p class="card-text">
                <?php echo  $this->datos['solicitudes_de_cuentas'] ?>
            </p>
            <a href="<?php echo URL ?>/usuarios/solicitudes" class="btn btn-outline-primary">Ver</a>
        </div>
    </div>
</div>
<?php
require 'views/layout/foot.php';
?>