<?php
    require 'views/layout/head.php';
    require 'views/layout/'.$_SESSION['rol'].'_menu.php';
?>
<div class="container">
    <div class="row justify-content-center mt-2">
        <h1>Editar cotización</h1>
    </div>
    <div class="row justify-content-center mb-3">
        <div class="card col-md-8 rounded">
            <div class="card-body form-row">
                <div class="form-group col-md-6 col-12">
                    <label for="estado">Estado</label>
                    <p><?php echo $this->cotizacion['estado'] ?></p> 
                </div>
                <div class="form-group col-md-6 col-12"  id="fecha_vencimiento_group">
                    <label for="fecha_vencimiento">Fecha vencimiento</label>
                    <p><?php echo $this->cotizacion['fecha_vencimiento'] ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="card col-md-8">
            <div class="card-body" id="card-body">
                <div class="form-group" id="descripcion_gruop">
                    <label for="descripcion">Descripción</label>
                    <input type="text" name="descipcion" id="descripcion" class="form-control" value="<?php echo $this->cotizacion['descripcion']?>">
                    <span class="text-danger"></span>
                </div>
                <div class="row justify-content-end mb-3">
                    <button class="btn btn-outline-primary btn-sm mr-3" id="btn-servicio">Agregar servicio</button>
                </div>
                <?php
                    foreach($this->cotizacion['servicios'] as $servicio){
                ?>
                        <div class="form-group">
                            <select name="servicios" class="custom-select col-11">
                <?php
                                foreach($this->servicios as $servicio_empresa){
                ?>
                                    <option value="<?php echo $servicio_empresa->id ?>" <?php echo ($servicio['servicio_id'] == $servicio_empresa->id)? 'selected' : '' ?>><?php echo $servicio_empresa->nombre ?></option>
                <?php
                                }  
                ?>
                            </select>
                            <button class="btn btn-link btn-sm text-center col-1" style="margin-left: -5px;"><i class="fas fa-times text-danger"></i></button>
                        </div>
                <?php    
                    }
                ?>
            </div>
            <div class="row justify-content-center">
                <button 
                    class="btn btn-primary mb-3 col-10" 
                    id="btn-guardar" 
                    data-cotizacion="<?php echo $this->cotizacion['cotizaciondId'] ?>"
                    data-usuario="<?php echo $this->cotizacion['usuarioId']?>"
                    data-estado="<?php echo $this->cotizacion['estado']?>"
                    data-fecha_vencimiento="<?php echo $this->cotizacion['fecha_vencimiento']?>"
                >
                    Actualizar
                </button>   
            </div>
        </div>
    </div>
</div>
<?php
    require 'views/layout/foot.php';
?>
