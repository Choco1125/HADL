<?php
    require 'views/layout/head.php';
    require 'views/layout/'.$_SESSION['rol'].'_menu.php';
?>
<div class="container">
    <div class="row justify-content-center mt-2">
        <h1>Solicitudes de servicio</h1>
    </div>
    <div class="row mt-1 mb-2 justify-content-end">
        <a href="<?echo URL?>/servicios/nueva_solicitud" class="btn btn-outline-primary btn-sm">Crear solicitud</a>
    </div>
    <div class="mb-2">
    <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Fecha creación</th>
                    <th scope="col">Fecha entrega</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Cliente</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if(isset($this->solicitudes)){
                    foreach($this->solicitudes as $solicitud){
            ?>
                <tr>
                    <td><?php echo $solicitud['fecha_creacion']; ?></td>
                    <td><?php echo $solicitud['fecha_entrega']; ?></td>
                    <td><?php echo $solicitud['descripcion']; ?></td>
                    <td><?php echo $solicitud['nombres'] . "( ".$solicitud['nit']." )"; ?></td>
                    <td id="botones-<?php echo $solicitud['id']?>">
                        <a class="btn btn-outline-success btn-sm" href="<?php echo URL?>/servicios/mostrar/<?php echo $dd['solicitudId']?>">
                            Ver
                        </a>
                        <a class="btn btn-outline-primary btn-sm" href="<?php echo URL?>/servicios/editar_solicitud/<?php echo $solicitud['solicitudId']?>">
                            Editar
                        </a>
                        <button class="btn btn-outline-danger btn-sm" data-id="<?php echo $solicitud['solicitudId']?>">
                            Eliminar
                        </button>
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