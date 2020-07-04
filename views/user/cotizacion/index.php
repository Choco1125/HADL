<?php
    require 'views/layout/head.php';
    require 'views/layout/'.$_SESSION['rol'].'_menu.php';
?>

<div class="container">
    <div class="row justify-content-center mt-2">
        <h1>Cotizaciones</h1>
    </div>
    <div class="row mt-1 mb-3 justify-content-end">
        <a class="btn btn-outline-primary btn-sm" href="<? echo URL?>/cotizaciones/crear">Crear cotización</a>
    </div>
    <div class="mb-2">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Usuario</th>
                    <th scope="col">Fecha realización</th>
                    <th scope="col">Fecha vencimineto</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Estado</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if(isset($this->cotizaciones)){
                    foreach($this->cotizaciones as $cotizacion){
            ?>
                <tr id="<? echo $cotizacion->id?>">
                    <td><?php echo $cotizacion->nombres. " (". $cotizacion->nit.")"; ?></td>
                    <td><?php echo $cotizacion->fecha_realizacion; ?></td>
                    <td><?php echo $cotizacion->fecha_vencimiento; ?></td>
                    <td><?php echo $cotizacion->descripcion; ?></td>
                        <?php
                            $tipo = '';
                            switch ($cotizacion->estado) {
                                case 'En Solicitud':
                                    $tipo = 'info';
                                    break;
                                case 'En proceso':
                                    $tipo = 'primary';
                                    break;
                                case 'Aceptada':
                                    $tipo = 'success';
                                    break;
                                default:
                                    $tipo = 'danger';
                                    break;
                            }
                        ?>
                    <td class="text-<?echo $tipo ?>">
                            <?php echo $cotizacion->estado; ?>
                    </td>
                    <td id="botones-<?php echo $cotizacion->id?>">
                        <a class="btn btn-outline-primary btn-sm" href="<?php echo URL?>/cotizaciones/editar/<?php echo $cotizacion->id?>">
                            Editar
                        </a>
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