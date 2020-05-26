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

                <div class="form-group" id="password_group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <span class="text-danger"></span>

                </div>
                <button class="btn btn-outline-primary btn-block" id="btn-login">
                    Iniciar sesión
                </button>


                <a href="#" class="text-center d-block col-12 mt-2">Solicitar mi cuenta</a>
            </div>
        </div>
    </div>
</div>
<?php
require 'views/layout/foot.php';
?>