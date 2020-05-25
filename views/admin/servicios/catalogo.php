<?php
    require 'views/layout/head.php';
    require 'views/layout/'.$_SESSION['rol'].'_menu.php';
?>

<div class="container">
    <div class="row justify-content-center mt-2">
        <h1>Catalogo de servicios</h1>
    </div>
    <div class="row mt-1 mb-2 justify-content-end">
        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#crear">Crear servicio</a>
    </div>
    <div class="row mt-2 mb-3">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Precio</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="tbl">
        <?php
            if(!is_null($this->catalogo)){
                foreach ($this->catalogo as $servicio) {
        ?>
                <tr id="<?php echo $servicio->id?>">
                    <td><?php echo $servicio->nombre; ?></td>
                    <td><?php echo $servicio->descripcion; ?></td>
                    <td><?php echo $servicio->precio; ?></td>
                    <td>
                        <button class="btn btn-outline-danger btn-sm" data-id="<?php echo $servicio->id?>" data-toggle="modal" data-target="#eliminar">
                            <i class="fa fa-trash"></i>
                        </button>
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit"></i>
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
    require 'views/admin/servicios/servicio/crear.php';
    require 'views/admin/servicios/servicio/eliminar.php';
    require 'views/layout/foot.php';
?>