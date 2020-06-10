<?php
    class Cotizacion extends Model{
        
        private $id;
        private $usuario;
        private $fecha_realizacion;
        private $fecha_vencimiento;
        private $descripcion;
        private $estado;

        public function __construct($id = null, $usuario = null, $fecha_realizacion = null, $fecha_vencimiento = null, $descripcion = null, $estado = null)
        {
            parent::__construct();
            $this->table = 'cotizacion';
            $this->id = $id;
            $this->usuario = $usuario;
            $this->fecha_realizacion = $fecha_realizacion;
            $this->fecha_vencimiento = $fecha_vencimiento;
            $this->descripcion = $descripcion;
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

        public function crear()
        {
            try {
                $consulta = "INSERT INTO cotizacion (usuario_id, fecha_realizacion, fecha_vencimiento,descripcion,estado) VALUES (:usuario_id,:fecha_realizacion,:fecha_vencimiento,:descripcion,:estado)";
                $sql = $this->db_connection->prepare($consulta);
                $sql->execute([
                    ':usuario_id' => $this->usuario, 
                    ':fecha_realizacion' => $this->fecha_realizacion, 
                    ':fecha_vencimiento' => $this->fecha_vencimiento,
                    ':descripcion' => $this->descripcion,
                    ':estado' => $this->estado
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
    }