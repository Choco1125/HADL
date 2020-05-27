<?php
    require 'views/layout/head.php';
    require 'views/layout/'.$_SESSION['rol'].'_menu.php';
?>

<div class="container">
    <div class="row justify-content-center mt-2">
        <h1>Editar Usuario</h1>
    </div>
    <div class="row justify-content-center mt-3 mb-2">
        <div class="card col-md-9">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-lg-6" id="nombre_group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Jhon Due Alphabet" value="<?php echo $this->usuario->get_nombres(); ?>">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group col-lg-6" id="email_group">
                        <label for="email">Correo</label>
                        <input type="email" class="form-control" id="email" placeholder="JhonDue@email.com" value="<?php echo $this->usuario->get_email(); ?>">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group col-lg-6" id="rol_group">
                        <label for="rol">Rol</label>
                        <select id="rol" class="custom-select">
                            <option value="user" <?php echo $this->usuario->get_rol() == 'user' ? 'selected' : ''; ?>>Cliente</option>
                            <option value="admin" <?php echo $this->usuario->get_rol() == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group col-lg-6" id="estado_group">
                        <label for="estado">Estado</label>
                        <select id="estado" class="custom-select">
                            <option value="activo" <?php echo $this->usuario->get_estado() == 'activo' ? 'selected' : ''?>>Activo</option>
                            <option value="inactivo" <?php echo $this->usuario->get_estado() == 'inactivo' ? 'selected' : ''?>>Inactivo</option>
                        </select>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="form-row" id="contenido-usuario">
                    <div class="form-group col-lg-6" id="nit_group">
                        <label for="nit">NIT</label>
                        <input type="text" class="form-control" id="nit" placeholder="900467409-8" value="<?php echo $this->usuario->get_nit(); ?>">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group col-lg-6" id="celular_group">
                        <label for="celular">Celular</label>
                        <input type="phone" class="form-control" id="celular" placeholder="311 445 6677" value="<?php echo $this->usuario->get_celular(); ?>">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group col-lg-12" id="direccion_group">
                        <label for="direccion">Dirección</label>
                        <input type="phone" class="form-control" id="direccion" placeholder="Cl 12 A 20 G-190 Yumbo - Valle Del Cauca" value="<?php echo $this->usuario->get_direccion(); ?>">
                        <span class="text-danger"></span>
                    </div>
                </div>
                <button class="btn btn-primary btn-block" id="btn-actualizar" data-usuario="<?php echo $this->usuario->get_id(); ?>" >Actualizar</button>
            </div>
        </div>
    </div>
</div>

<?php
    require 'views/layout/foot.php';
?>