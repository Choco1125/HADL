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
        <table class="table table-hover">
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
                <tr>
                    <td><?php echo $servicio->nombre; ?></td>
                    <td><?php echo $servicio->descripcion; ?></td>
                    <td><?php echo $servicio->precio; ?></td>
                    <td><?php echo $servicio->id; ?></td>
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
    require 'views/layout/foot.php';
?>