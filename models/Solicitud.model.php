<?php
class Solicitud extends Model
{

  private $id;
  private $usuario_id;
  private $fecha_creacion;
  private $fecha_entrega;
  private $descripcion;

  public function __construct($id = null, $usuario_id = null, $fecha_creacion = null, $fecha_entrega = null, $descripcion = null)
  {
    $this->id =  $id;
    $this->usuario_id =  $usuario_id;
    $this->fecha_creacion =  $fecha_creacion;
    $this->fecha_entrega =  $fecha_entrega;
    $this->descripcion =  $descripcion;
    $this->table = 'solicitud';
    parent::__construct();
  }

  public function set_id($id)
  {
    $this->id = $id;
  }

  public function get_id()
  {
    return $this->id;
  }

  public function set_usuario_id($usuario_id)
  {
    $this->usuario_id = $usuario_id;
  }

  public function get_usuario_id()
  {
    return $this->usuario_id;
  }

  public function set_fecha_creacion($fecha_creacion)
  {
    $this->fecha_creacion = $fecha_creacion;
  }

  public function get_fecha_creacion()
  {
    return $this->fecha_creacion;
  }

  public function set_fecha_entrega($fecha_entrega)
  {
    $this->fecha_entrega = $fecha_entrega;
  }

  public function get_fecha_entrega()
  {
    return $this->fecha_entrega;
  }

  public function set_descripcion($descripcion)
  {
    $this->descripcion = $descripcion;
  }

  public function get_descripcion()
  {
    return $this->descripcion;
  }

  public function crear()
  {
    try {
      $consulta = "INSERT INTO solicitud (usuario_id,fecha_creacion, fecha_entrega,descripcion) VALUES (:usuario_id,:fecha_creacion,:fecha_entrega,:descripcion)";
      $sql = $this->db_connection->prepare($consulta);

      $sql->execute([
        'usuario_id' => $this->usuario_id,
        'fecha_creacion' => $this->fecha_creacion,
        'fecha_entrega' => $this->fecha_entrega,
        'descripcion' => $this->descripcion
      ]);

      $this->id = $this->db_connection->lastInsertId();

      return ['ok'];
    } catch (PDOException $ex) {
      return [
        'error' => $ex->errorInfo
      ];
    }
  }

  public function agregar_servicio($id_servicio)
  {
    try {
      $consulta = "INSERT INTO solicitud_servico (servicio_id, solicitud_id) VALUES (:servicio_id, :solicitud_id)";
      $sql = $this->db_connection->prepare($consulta);

      $sql->execute([
        'servicio_id' => $id_servicio,
        'solicitud_id' => $this->id
      ]);
    } catch (PDOException $ex) {
      return [
        'error' => $ex->errorInfo
      ];
    }
  }

  public function tarer_todos()
  {
    try {
      $consulta = "SELECT solicitud.id AS solicitudId, solicitud.fecha_creacion, solicitud.fecha_entrega, solicitud.descripcion, usuario.nombres, usuario.nit FROM solicitud INNER JOIN usuario ON solicitud.usuario_id = usuario.id ORDER BY solicitud.id DESC";
      $sql = $this->db_connection->query($consulta);
      $servicios = null;

      while ($servicio = $sql->fetch(PDO::FETCH_ASSOC)) {
        $servicios[] = $servicio;
      }
      return $servicios;
    } catch (PDOException $ex) {
      return ['error' => $ex->errorInfo];
    }
  }

  public function mis_dato()
  {
    try {
      $consulta = "SELECT solicitud.id AS solicitudId, solicitud.fecha_creacion, solicitud.fecha_entrega, solicitud.descripcion, usuario.id AS usuarioId FROM solicitud INNER JOIN usuario ON solicitud.usuario_id = usuario.id WHERE solicitud.id = :solicitud_id";
      $sql = $this->db_connection->prepare($consulta);
      $sql->execute([
        ':solicitud_id' => $this->id
      ]);
      $servicios = null;

      while ($servicio = $sql->fetch(PDO::FETCH_ASSOC)) {
        $servicios[] = $servicio;
      }

      for ($i = 0; $i < count($servicios); $i++) {

        $consulta = "SELECT servicio.nombre,solicitud_servico.servicio_id FROM servicio INNER JOIN solicitud_servico ON servicio.id = solicitud_servico.servicio_id WHERE solicitud_servico.solicitud_id = :solicitud_id";
        $sql = $this->db_connection->prepare($consulta);
        $sql->execute([
          ':solicitud_id' => $this->id
        ]);

        while ($servicio_de_solicitud = $sql->fetch(PDO::FETCH_ASSOC)) {
          $servicios[$i]['servicios'][] = $servicio_de_solicitud;
        }
      }
      return $servicios;
    } catch (PDOException $ex) {
      return ['error' => $ex->errorInfo];
    }
  }

  public function actualizar()
  {
    try {
      $consulta = "UPDATE solicitud SET usuario_id = :usuario_id, fecha_entrega = :fecha_entrega, descripcion = :descripcion WHERE id = :id";
      $sql = $this->db_connection->prepare($consulta);
      $sql->execute([
        'usuario_id' => $this->usuario_id,
        'fecha_entrega' => $this->fecha_entrega,
        'descripcion' => $this->descripcion,
        'id' => $this->id
      ]);

      return ['ok'];
    } catch (PDOException $ex) {
      return [
        'error' => $ex->errorInfo
      ];
    }
  }

  public function eliminar_servicios()
  {
    try {
      $consulta = "DELETE FROM solicitud_servico WHERE solicitud_id = :solicitud_id";
      $sql = $this->db_connection->prepare($consulta);

      $sql->execute([
        'solicitud_id' => $this->id
      ]);

      return ['ok'];
    } catch (PDOException $ex) {
      return [
        'error' => $ex->errorInfo
      ];
    }
  }

  public function eliminar()
  {
    try {
      $sql = $this->db_connection->prepare('DELETE FROM solicitud WHERE id = :id');
      $sql->execute([
        'id' => $this->id
      ]);
      return ['ok'];
    } catch (PDOException $ex) {
      return [
        'error' => $ex->errorInfo
      ];
    }
  }
}
