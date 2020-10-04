<?php
require 'views/layout/head.php';
require 'views/layout/' . $_SESSION['rol'] . '_menu.php';
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
          <th>Fecha creación</th>
          <th>Fecha entrega</th>
          <th>Descripción</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="tbl">
        <?php
        if (isset($this->solicitudes)) {
          foreach ($this->solicitudes as $solicitud) {
        ?>
            <tr id="<?php echo $solicitud['solicitudId'] ?>">
              <td><?php echo $solicitud['fecha_creacion']; ?></td>
              <td><?php echo $solicitud['fecha_entrega']; ?></td>
              <td><?php echo substr($solicitud['descripcion'], 0, 70); ?><?php echo strlen($solicitud['descripcion']) >= 70 ? '...' : ''; ?></td>
              <td id="botones-<?php echo $solicitud['id'] ?>">
                <?php if ($solicitud['listo'] == 1) { ?>
                  <a class="btn btn-outline-success btn-sm mt-2" href="<?php echo URL ?>/servicios/ver_servicios/<?php echo $solicitud['solicitudId'] ?>" target="_blank">
                    <i class="fas fa-eye"></i>
                  </a>
                <?php } ?>
                <a class="btn btn-outline-primary btn-sm mt-2" href="<?php echo URL ?>/servicios/editar_solicitud/<?php echo $solicitud['solicitudId'] ?>">
                  <i class="fas fa-edit"></i>
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