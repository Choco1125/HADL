<?php
    require 'views/layout/head.php';
    require 'views/layout/'.$_SESSION['rol'].'_menu.php';
?>

<div class="container">
    <div class="row justify-content-center mt-2">
        <h1>Usuarios</h1>
    </div>
    <div class="row mt-1 mb-3 justify-content-end">
        <a class="btn btn-outline-primary btn-sm" href="<? echo URL?>/usuarios/crear">Crear usuario</a>
    </div>
    <div class="mb-2">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Correo</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Rol</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if(isset($this->usuarios)){
                    foreach($this->usuarios as $usuario){
            ?>
                <tr>
                    <td><?php echo $usuario->email; ?></td>
                    <td><?php echo $usuario->nombres; ?></td>
                    <td>
                        <?php if($usuario->rol == 'admin'){ ?>
                            <i class="fas fa-user-tie" title="Administrador"></i>
                        <?php }else{ ?>
                            <i class="fas fa-user" title="Usuario"></i>
                        <?php } ?>
                    </td>
                    <!-- <td class="text-<?php echo $usuario->estado == 'activo'?'danger':'success' ?>">
                        <?php echo ucfirst($usuario->estado); ?>
                    </td> -->
                    <td>
                        <a class="btn btn-outline-primary btn-sm" href="<?php echo URL?>/usuarios/editar/<?php echo $usuario->id?>">
                            <!-- <i class="fas fa-user-edit"></i> -->
                            Editar
                        </a>
                        <?php
                            if($usuario->estado == 'activo'){
                        ?>
                            <button class="btn btn-outline-danger btn-sm" data-id="<?php echo $usuario->id?>" data-toggle="modal" data-target="#actualizar">
                                <!-- <i class="fas fa-user-slash"></i> -->
                                Desactivar
                            </button>
                        <?php 
                            }else{
                        ?>
                            <button class="btn btn-outline-success btn-sm" data-id="<?php echo $usuario->id?>" data-toggle="modal" data-target="#actualizar">
                                <!-- <i class="fas fa-user"></i> -->
                                Activar
                            </button>
                        <?php
                            }
                        ?>
                    </td>
                </tr>
            <?php
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php
    require 'views/layout/foot.php';
?>