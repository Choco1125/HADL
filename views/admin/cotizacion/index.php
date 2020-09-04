<?php
require 'views/layout/head.php';
require 'views/layout/' . $_SESSION['rol'] . '_menu.php';
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
                    <th scope="col-lg-5">Descripción</th>
                    <th scope="col">Estado</th>
                    <th scope="col-lg-1"></th>
                </tr>
            </thead>
            <tbody id="tbl">
                <?php
                if (isset($this->cotizaciones)) {
                    foreach ($this->cotizaciones as $cotizacion) {
                ?>
                        <tr id="<? echo $cotizacion->id?>">
                            <td><?php echo $cotizacion->nombres . " (" . $cotizacion->nit . ")"; ?></td>
                            <td><?php echo $cotizacion->fecha_realizacion; ?></td>
                            <td><?php echo $cotizacion->fecha_vencimiento; ?></td>
														<td><?php echo substr($cotizacion->descripcion,0,30); ?> <?php echo strlen($cotizacion->descripcion) >=30 ? "..." : '' ?></td>
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
                            <td id="botones-<?php echo $cotizacion->id ?>">
                                <a class="btn btn-outline-success btn-sm  mt-2" href="<?php echo URL ?>/cotizaciones/ver/<?php echo $cotizacion->id ?>" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-outline-primary btn-sm  mt-2" href="<?php echo URL ?>/cotizaciones/editar/<?php echo $cotizacion->id ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-outline-danger btn-sm  mt-2" data-toggle="modal" data-target="#eliminar" data-cotizacion="<?php echo $cotizacion->id ?>">
                                    <i class="fa fa-trash"></i>

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

    <div class="modal fade" id="eliminar" tabindex="-1" role="dialog" aria-labelledby="eliminarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarLabel">¿Deseas eliminar esta cotización?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="btn-eliminar">Sí, eliminar </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require 'views/layout/foot.php';
?>
