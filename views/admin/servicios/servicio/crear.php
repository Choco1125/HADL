<div class="modal fade" id="crear" tabindex="-1" role="dialog" aria-labelledby="crearLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="crearLabel">Crear servicio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group" id="nombre_group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre">
            <span class="text-danger"></span>
        </div>
        <div class="form-group" id="descripcion_group">
            <label for="descripcion">Descripción</label>
            <input type="text" class="form-control" id="descripcion">
            <span class="text-danger"></span>
        </div>
        <div class="form-group" id="precio_group">
            <label for="precio">Precio</label>
            <input type="text" class="form-control" id="precio">
            <span class="text-danger"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>