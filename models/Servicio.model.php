<?php
    class Servicio extends Model{

        private $id;
        private $nombre;
        private $descripcion;
        private $precio;

        public function __construct($id = null,$nombre=null,$descripcion=null,$precio = null){
            parent::__construct();
            $this->table = 'servicio';
            $this->id = $id;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->precio = $precio;
        }

        public function get_id(){
            return $this->id;
        }
        public function set_id($id){
            $this->id = $id;
        }

        public function get_nombre(){
            return $this->nombre;
        }
        public function set_nombre($nombre){
            $this->nombre = $nombre;
        }

        public function get_descripcion(){
            return $this->descripcion;
        }
        public function set_descripcion($descripcion){
            $this->descripcion = $descripcion;
        }

        public function get_precio(){
            return $this->precio;
        }
        public function set_precio($precio){
            $this->precio = $precio;
        }

        public function guardar(){
            try {
                $consulta = "INSERT INTO servicio (nombre,descripcion,precio) VALUES (:nombre,:descripcion,:precio)";

                $sql = $this->db_connection->prepare($consulta);
                
                $sql->execute([
                    'nombre' => $this->nombre,
                    'descripcion' => $this->descripcion,
                    'precio' => $this->precio
                ]);

                $this->set_id($this->db_connection->lastInsertId());
                
                return ['ok'];

            } catch (PDOException $ex) {
                return [
                    'error'=> $ex->errorInfo
                ];
            }
        }

        public function eliminar(){
            try {
                $consulta = "DELETE FROM servicio WHERE id = :id";

                $sql = $this->db_connection->prepare($consulta);
                
                $sql->execute([
                    'id' => $this->id
                ]);

                return ['ok'];

            } catch (PDOException $ex) {
                return [
                    'error'=> $ex->errorInfo
                ];
            }
        }

        public function buscar_informacion(){
            try {
                $consulta = 'SELECT nombre,descripcion,precio FROM servicio WHERE id = :id';
                $sql = $this->db_connection->prepare($consulta);
                $sql->execute([
                    'id' => $this->id
                ]);


                while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
                    $this->nombre = $row->nombre;
                    $this->descripcion = $row->descripcion;
                    $this->precio = $row->precio;
                }

                return ['ok'];

            } catch (PDOException $ex) {
                return[
                    'error'=>$ex
                ];
            }
        }

        public function actualizar(){
            try {
                $consulta = "UPDATE servicio SET nombre = :nombre,descripcion = :descripcion, precio = :precio WHERE id = :id";

                $sql = $this->db_connection->prepare($consulta);
                
                $sql->execute([
                    'nombre' => $this->nombre,
                    'descripcion' => $this->descripcion,
                    'precio' => $this->precio,
                    'id'=>$this->id
                ]);

                
                return ['ok'];

            } catch (PDOException $ex) {
                return [
                    'error'=> $ex->errorInfo
                ];
            }
        }
    }