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
                <div class="form-group col-md-6 col-12"  id="usuario_group">
                    <label for="usuario">Cliene:</label>
                    <select name="usuario" id="usuario" class="custom-select">
                        <option value="">Selecciona un cliente</option>
                        <?php
                            if(isset($this->clientes)){
                                foreach($this->clientes as $cliente){
                        ?>
                                    <option value="<?echo $cliente->id?>"  <?php echo $this->cotizacion['usuarioId'] == $cliente->id ? 'selected' :'' ?> ><?php echo $cliente->nombres .' - (' .$cliente->nit. ')' ?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <span class="text-danger"></span>
                </div>
                <div class="form-group col-md-3 col-12"  id="estado_group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="custom-select">
                        <option value="En Solicitud" <?php echo $this->cotizacion['estado'] == 'En Solicitud' ? 'selected' :'' ?>>En solicitud</option>
                        <option value="En proceso" <?php echo $this->cotizacion['estado'] == 'En proceso' ? 'selected' :'' ?>>En proceso</option>
                        <option value="Aceptada" <?php echo $this->cotizacion['estado'] == 'Aceptada' ? 'selected' :'' ?>>Aceptada</option>
                        <option value="Rechazada" <?php echo $this->cotizacion['estado'] == 'Rechazada' ? 'selected' :'' ?>>Rechazada</option>
                    </select>
                    <span class="text-danger"></span>
                </div>
                <div class="form-group col-md-3 col-12"  id="fecha_vencimiento_group">
                    <label for="fecha_vencimiento">Fecha vencimiento</label>
                    <input type="date" class="form-control" id="fecha_vencimiento" value="<?php echo $this->cotizacion['fecha_vencimiento']?>">
                    <span class="text-danger"></span>
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
                <button class="btn btn-primary mb-3 col-10" id="btn-guardar">Actualizar</button>   
            </div>
        </div>
    </div>
</div>
<?php
    require 'views/layout/foot.php';
?>
