<?php
require 'views/layout/head.php';
require 'views/layout/' . $_SESSION['rol'] . '_menu.php';
?>
<div class="container">
  <div class="row justify-content-center mt-2">
    <h1>Editar solicitud de servicio</h1>
  </div>
  <div class="row justify-content-center mb-3">
    <div class="card col-md-8 rounded">
      <div class="card-body form-row">
        <div class="form-group col-md-6 col-12" id="usuario_group">
          <label for="usuario">Cliene:</label>
          <select name="usuario" id="usuario" class="custom-select">
            <option value="">Selecciona un cliente</option>
            <?php
            if (isset($this->clientes)) {
              foreach ($this->clientes as $cliente) {
            ?>
                <option value="<?echo $cliente->id?>" <?php echo $this->solicitud['usuarioId'] == $cliente->id ? 'selected' : '' ?>><?php echo $cliente->nombres . ' - (' . $cliente->nit . ')' ?></option>
            <?php
              }
            }
            ?>
          </select>
          <span class="text-danger"></span>
        </div>
        <div class="form-group col-md-6 col-12" id="fecha_entrega_group">
          <label for="fecha_entrega">Fecha entrega:</label>
          <input type="date" name="fecha_entrega" id="fecha_entrega" placeholder="12/12/2020" class="form-control" value="<?php echo $this->solicitud['fecha_entrega'] ?>">
          <span class="text-danger"></span>
        </div>
        <div class="form-group col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="listo" <?php echo $this->solicitud['listo'] == 1 ? 'checked' : '' ?>>
            <label class="form-check-label" for="listo">
              Mostrar pdf al cliente
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="card col-md-8">
      <div class="card-body" id="card-body">
        <div class="form-group" id="descripcion_gruop">
          <label for="descripcion">Descripción</label>
          <textarea name="descipcion" id="descripcion" class="form-control"><?php echo $this->solicitud['descripcion'] ?></textarea>
          <span class="text-danger"></span>
        </div>
        <div class="row justify-content-end mb-3">
          <button class="btn btn-outline-primary btn-sm mr-3" id="btn-servicio">Agregar servicio</button>
        </div>
        <?php
        foreach ($this->solicitud['servicios'] as $servicio) {
        ?>
          <div class="form-group">
            <select name="servicios" class="custom-select col-11">
              <?php
              foreach ($this->servicios as $servicio_empresa) {
              ?>
                <option value="<?php echo $servicio_empresa->id ?>" <?php echo ($servicio['servicio_id'] == $servicio_empresa->id) ? 'selected' : '' ?>><?php echo $servicio_empresa->nombre ?></option>
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
        <button class="btn btn-primary mb-3 col-10" id="btn-guardar" data-solicitud="<?php echo $this->solicitud['solicitudId'] ?>">Actualizar</button>
      </div>
    </div>
  </div>
</div>



<?php
require 'views/layout/foot.php';
?>