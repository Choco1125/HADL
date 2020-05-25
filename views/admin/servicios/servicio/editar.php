<?php
    require 'views/layout/head.php';
    require 'views/layout/'.$_SESSION['rol'].'_menu.php';
?>

<div class="container">
    <div class="row justify-content-center mt-2">
        <h1>Editar servicios</h1>
    </div>
    <div class="row mt-2 mb-3 justify-content-center">
        <div class="card col-md-6">
            <div class="card-body">
                <input type="hidden" id="id" value="<?echo $this->servicio->get_id()?>">

                <div class="form-group" id="nombre_group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" value="<?echo $this->servicio->get_nombre()?>">
                    <span class="text-danger"></span>
                </div>
                <div class="form-group" id="descripcion_group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" class="form-control" id="descripcion" value="<?echo $this->servicio->get_descripcion()?>">
                    <span class="text-danger"></span>
                </div>
                <div class="form-group" id="precio_group">
                    <label for="precio">Precio</label>
                    <input type="text" class="form-control" id="precio" value="<?echo $this->servicio->get_precio()?>">
                    <span class="text-danger"></span>
                </div>
                <button class="btn btn-primary btn-block" id="btn-crear">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<?php
    require 'views/layout/foot.php';
?>