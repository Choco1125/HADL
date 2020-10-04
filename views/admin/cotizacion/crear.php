<?php
require 'views/layout/head.php';
require 'views/layout/' . $_SESSION['rol'] . '_menu.php';
?>
<div class="container">
  <div class="row justify-content-center mt-2">
    <h1>Nueva cotización</h1>
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
                <option value="<?echo $cliente->id?>"><?php echo $cliente->nombres . ' - (' . $cliente->nit . ')' ?></option>
            <?php
              }
            }
            ?>
          </select>
          <span class="text-danger"></span>
        </div>
        <div class="form-group col-md-3 col-12" id="estado_group">
          <label for="estado">Estado</label>
          <select name="estado" id="estado" class="custom-select">
            <option value="En Solicitud">En solicitud</option>
            <option value="En proceso">En proceso</option>
            <option value="Aceptada">Aceptada</option>
            <option value="Rechazada">Rechazada</option>
          </select>
          <span class="text-danger"></span>
        </div>
        <div class="form-group col-md-3 col-12" id="fecha_vencimiento_group">
          <label for="fecha_vencimiento">Fecha vencimiento</label>
          <input type="date" class="form-control" id="fecha_vencimiento">
          <span class="text-danger"></span>
        </div>
        <div class="form-group col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="listo">
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