<?php
require 'views/layout/head.php';
require 'views/layout/' . $_SESSION['rol'] . '_menu.php';
?>

<div class="container">
  <div class="row justify-content-center mt-2">
    <h1>Mi Cuenta</h1>
  </div>
  <div class="row justify-content-center mt-3 mb-2">
    <div class="card col-md-7">
      <div class="card-body">
        <div class="form-row">
          <input type="hidden" id="id" value="<?php echo $_SESSION['id']; ?>">
          <div class="form-group col-12" id="nombre_group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" placeholder="Jhon Due Alphabet" value="<?php echo $this->datos->get_nombres(); ?>">
            <span class="text-danger"></span>
          </div>
          <div class="form-group col-12" id="email_group">
            <label for="email">Correo</label>
            <input type="email" class="form-control" id="email" placeholder="JhonDue@email.com" value="<?php echo $this->datos->get_email(); ?>">
            <span class="text-danger"></span>
          </div>
          <button class="btn btn-primary btn-block" id="btn-crear">Guardar</button>
        </div>
      </div>
    </div>
  </div>
  <?php
  require 'views/layout/foot.php';
  ?>