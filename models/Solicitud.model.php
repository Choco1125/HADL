<?php
    class Solicitud extends Model{

        private $id;
        private $usuario_id;
        private $fecha_creacion;
        private $fecha_entrega;
        private $descripcion;

        public function __construct($id = null,$usuario_id = null,$fecha_creacion = null,$fecha_entrega = null,$descripcion = null){
            $this->id =  $id;
            $this->usuario_id =  $usuario_id;
            $this->fecha_creacion =  $fecha_creacion;
            $this->fecha_entrega =  $fecha_entrega;
            $this->descripcion =  $descripcion;
            $this->table = 'solicitud';
            parent::__construct();
        }

        public function set_id($id){
            $this->id = $id;
        }

        public function get_id(){
            return $this->id;
        }

        public function set_usuario_id($usuario_id){
            $this->usuario_id = $usuario_id;
        }

        public function get_usuario_id(){
            return $this->usuario_id;
        }

        public function set_fecha_creacion($fecha_creacion){
            $this->fecha_creacion = $fecha_creacion;
        }

        public function get_fecha_creacion(){
            return $this->fecha_creacion;
        }

        public function set_fecha_entrega($fecha_entrega){
            $this->fecha_entrega = $fecha_entrega;
        }

        public function get_fecha_entrega(){
            return $this->fecha_entrega;
        }

        public function set_descripcion($descripcion){
            $this->descripcion = $descripcion;
        }

        public function get_descripcion(){
            return $this->descripcion;
        }

        public function crear(){
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

        public function agregar_servicio($id_servicio){
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
    }