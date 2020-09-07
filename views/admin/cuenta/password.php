<?php
require 'views/layout/head.php';
require 'views/layout/' . $_SESSION['rol'] . '_menu.php';
?>

<div class="container">
  <div class="row justify-content-center mt-2">
    <h1>Cambiar mi contraseña</h1>
  </div>
  <div class="row justify-content-center mt-3 mb-2">
    <div class="card col-md-7">
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-lg-12" id="old_password_group">
            <label for="old_password">Contraseña</label>
            <input type="password" class="form-control" id="old_password" placeholder="Contraseña">
            <span class="text-danger"></span>
          </div>
          <div class="form-group col-lg-12" id="new_password_group">
            <label for="new_password">Contraseña nueva</label>
            <input type="password" class="form-control" id="new_password" placeholder="Contraseña nueva">
            <span class="text-danger"></span>
          </div>
          <div class="form-group col-lg-12" id="new_password_repeat_group">
            <label for="new_password_repeat">Confirmar contraseña nueva</label>
            <input type="text" class="form-control" id="new_password_repeat" placeholder="Confirmar la constraseña nueva">
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