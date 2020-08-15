<?php
require 'views/layout/head.php';
?>
<div class="container">
  <div class="row justify-content-center align-items-center">
    <div class="card col-11 col-md-6 col-lg-4 shadow-lg rounded">
      <div class="card-body">
        <h1 class="card-title text-center h2"><?php echo constant('APPNAME'); ?></h1>


        <div class="form-group" id="email_group">
          <label for="email">Correo</label>
          <input type="email" name="email" id="email" autofocus class="form-control">
          <span class="text-danger"></span>
        </div>

        <div class="form-group" id="nombre_group">
          <label for="nombre">Nombres</label>
          <input type="text" name="nombre" id="nombre" class="form-control">
          <span class="text-danger"></span>
        </div>

        <div class="form-group" id="celular_group">
          <label for="celular">Celular</label>
          <input type="text" name="celular" id="celular" class="form-control">
          <span class="text-danger"></span>
        </div>

        <button class="btn btn-outline-primary btn-block" id="btn-registrarse">
          Registrarme
        </button>

        <a href="<?php echo URL ?>" class="text-center d-block col-12 mt-2">Iniciar sesión</a>
      </div>
    </div>
  </div>
</div>
<?php
require 'views/layout/foot.php';
?>