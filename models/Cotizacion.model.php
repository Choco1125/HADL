<?php
class Cotizacion extends Model
{

    private $id;
    private $usuario;
    private $fecha_realizacion;
    private $fecha_vencimiento;
    private $descripcion;
    private $estado;
    private $listo;

    public function __construct($id = null, $usuario = null, $fecha_realizacion = null, $fecha_vencimiento = null, $descripcion = null, $estado = null, $listo = 0)
    {
        parent::__construct();
        $this->table = 'cotizacion';
        $this->id = $id;
        $this->usuario = $usuario;
        $this->fecha_realizacion = $fecha_realizacion;
        $this->fecha_vencimiento = $fecha_vencimiento;
        $this->descripcion = $descripcion;
        $this->listo = $listo;
        $this->estado = $estado;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_usuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function get_usuario()
    {
        return $this->usuario;
    }

    public function set_fecha_realizacion($fecha_realizacion)
    {
        $this->fecha_realizacion = $fecha_realizacion;
    }

    public function get_fecha_realizacion()
    {
        return $this->fecha_realizacion;
    }

    public function set_fecha_vencimiento($fecha_vencimiento)
    {
        $this->fecha_vencimiento = $fecha_vencimiento;
    }

    public function get_fecha_vencimiento()
    {
        return $this->fecha_vencimiento;
    }

    public function set_descripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function get_descripcion()
    {
        return $this->descripcion;
    }

    public function set_estado($estado)
    {
        $this->estado = $estado;
    }

    public function get_estado()
    {
        return $this->estado;
    }

    public function set_listo($listo)
    {
        $this->listo = $listo;
    }

    public function get_listo()
    {
        return $this->listo;
    }

    public function seleccionar_todos()
    {
        try {
            if (is_null($this->usuario)) {
                $consulta = "SELECT cotizacion.id, cotizacion.fecha_realizacion, cotizacion.fecha_vencimiento, cotizacion.descripcion, cotizacion.estado, usuario.nombres, usuario.nit FROM cotizacion INNER JOIN usuario ON cotizacion.usuario_id = usuario.id ORDER BY cotizacion.id DESC";
                $sql = $this->db_connection->query($consulta);
            } else {
                $consulta = "SELECT cotizacion.id, cotizacion.fecha_realizacion, cotizacion.fecha_vencimiento, cotizacion.descripcion, cotizacion.estado,cotizacion.listo, usuario.nombres, usuario.nit FROM cotizacion INNER JOIN usuario ON cotizacion.usuario_id = usuario.id WHERE cotizacion.usuario_id = :usuario ORDER BY cotizacion.id DESC";
                $sql = $this->db_connection->prepare($consulta);
                $sql->execute([
                    'usuario' => $this->get_usuario()
                ]);
            }

            $resulset = [];

            while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
                $resulset[] = $row;
            }
            return $resulset;
        } catch (PDOException $ex) {
            return null;
        }
    }

    public function crear()
    {
        try {
            $consulta = "INSERT INTO cotizacion (usuario_id, fecha_realizacion, fecha_vencimiento,descripcion,estado, listo) VALUES (:usuario_id,:fecha_realizacion,:fecha_vencimiento,:descripcion,:estado, :listo)";
            $sql = $this->db_connection->prepare($consulta);
            $sql->execute([
                ':usuario_id' => $this->usuario,
                ':fecha_realizacion' => $this->fecha_realizacion,
                ':fecha_vencimiento' => $this->fecha_vencimiento,
                ':descripcion' => $this->descripcion,
                ':estado' => $this->estado,
                'listo' => $this->listo
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
            $consulta = "INSERT INTO cotizacion_serivicio (servicio_id,cotizacion_id) VALUES (:servicio_id, :cotizacion_id)";
            $sql = $this->db_connection->prepare($consulta);

            $sql->execute([
                'servicio_id' => $id_servicio,
                'cotizacion_id' => $this->get_id()
            ]);
        } catch (PDOException $ex) {
            return [
                'error' => $ex->errorInfo
            ];
        }
    }

    public function eliminar_servicios()
    {
        try {
            $consulta = "DELETE FROM cotizacion_serivicio WHERE cotizacion_id = :cotizacion_id";
            $sql = $this->db_connection->prepare($consulta);
            $sql->execute([
                'cotizacion_id' => $this->id
            ]);
        } catch (PDOException $ex) {
            return [
                'error' => $ex->errorInfo
            ];
        }
    }

    public function actualizar()
    {
        try {
            if ($_SESSION['rol'] == 'user') {
                $consulta = "UPDATE cotizacion SET descripcion = :descripcion WHERE id = :id";
            } else {
                $consulta = "UPDATE cotizacion SET usuario_id = :usuario_id,fecha_vencimiento = :fecha_vencimiento,descripcion = :descripcion,estado = :estado, listo = :listo WHERE id = :id";
            }
            $sql = $this->db_connection->prepare($consulta);

            if ($_SESSION['rol'] == 'user') {
                $sql->execute([
                    'descripcion' => $this->get_descripcion(),
                    'id' => $this->get_id()
                ]);
            } else {
                $sql->execute([
                    'usuario_id' => $this->get_usuario(),
                    'fecha_vencimiento' => $this->get_fecha_vencimiento(),
                    'descripcion' => $this->get_descripcion(),
                    'estado' => $this->get_estado(),
										'listo' => $this->get_listo(),
                    'id' => $this->get_id()
                ]);
            }
            return ['ok'];
        } catch (PDOException $ex) {
            return [
                'error' => $ex->errorInfo
            ];
        }
    }
    public function mis_datos()
    {
        try {
            $consulta = "SELECT cotizacion.id AS cotizaciondId, cotizacion.fecha_realizacion, cotizacion.fecha_vencimiento, cotizacion.descripcion, cotizacion.estado, usuario.id AS usuarioId, usuario.nombres, usuario.nit, cotizacion.listo FROM cotizacion INNER JOIN usuario ON cotizacion.usuario_id = usuario.id WHERE cotizacion.id = :cotizacion_id ";
            $sql = $this->db_connection->prepare($consulta);
            $sql->execute([
                ':cotizacion_id' => $this->id
            ]);
            $servicios = null;

            while ($servicio = $sql->fetch(PDO::FETCH_ASSOC)) {
                $servicios[] = $servicio;
            }

            for ($i = 0; $i < count($servicios); $i++) {

                $consulta = "SELECT servicio.nombre, cotizacion_serivicio.servicio_id, servicio.precio FROM servicio INNER JOIN cotizacion_serivicio ON servicio.id = cotizacion_serivicio.servicio_id WHERE cotizacion_serivicio.cotizacion_id = :cotizacion_id";
                $sql = $this->db_connection->prepare($consulta);
                $sql->execute([
                    ':cotizacion_id' => $this->id
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


    public function delete()
    {
        try {
            $query = "DELETE FROM cotizacion WHERE id = :id";
            $sql = $this->db_connection->prepare($query);
            $sql->execute([
                ':id' => $this->id
            ]);

            return ['ok'];
        } catch (PDOException $ex) {
            return ['error' => $ex->errorInfo];
        }
    }

    public function contar_pendientes()
    {
        try {
            $consulta = "SELECT COUNT(id) AS cotizaciones_penidentes FROM cotizacion WHERE estado = 'En Solicitud' OR estado = 'En proceso'";
            $sql = $this->db_connection->query($consulta);

            $resulset = [];

            while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
                $resulset = $row;
            }
            return $resulset;
        } catch (PDOException $ex) {
            return null;
        }
    }

    public function seleccionar_todos_penidentes()
    {
        try {
            $consulta = "SELECT cotizacion.id, cotizacion.fecha_realizacion, cotizacion.fecha_vencimiento, cotizacion.descripcion, cotizacion.estado, usuario.nombres, usuario.nit FROM cotizacion INNER JOIN usuario ON cotizacion.usuario_id = usuario.id WHERE cotizacion.estado = 'En Solicitud' OR cotizacion.estado = 'En proceso' ORDER BY cotizacion.id DESC";
            $sql = $this->db_connection->query($consulta);

            $resulset = [];

            while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
                $resulset[] = $row;
            }
            return $resulset;
        } catch (PDOException $ex) {
            return null;
        }
    }
}
