<?php
    require 'views/layout/head.php';
    require 'views/layout/'.$_SESSION['rol'].'_menu.php';
?>
<div class="container">
    <div class="row justify-content-center mt-2">
        <h1>Nueva cotización</h1>
    </div>
    <div class="row justify-content-center">
        <div class="card col-md-8">
            <div class="card-body" id="card-body">
                <div class="form-group" id="descripcion_gruop">
                    <label for="descripcion">Descripción</label>
                    <input type="text" name="descipcion" id="descripcion" class="form-control">
                    <span class="text-danger"></span>
                </div>
                <div class="row justify-content-end mb-3">
                    <button class="btn btn-outline-primary btn-sm mr-3" id="btn-servicio">Agregar servicio</button>
                </div>
                
            </div>
            <div class="row justify-content-center">
                <button class="btn btn-primary mb-3 col-10" id="btn-guardar">Crear</button>   
            </div>
        </div>
    </div>
</div>
<?php
    require 'views/layout/foot.php';
?>