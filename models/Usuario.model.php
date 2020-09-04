<?php
class Usuario extends Model
{

  private $id;
  private $email;
  private $nombres;
  private $password;
  private $rol;
  private $nit;
  private $celular;
  private $direccion;
  private $estado;

  public function __construct($id = null, $email = null, $nombres = null, $password = null, $rol = null, $nit = null, $celular = null, $direccion = null, $estado = null)
  {
    parent::__construct();
    $this->table = 'usuario';
    $this->id = $id;
    $this->email = $email;
    $this->nombres = $nombres;
    $this->password = $password;
    $this->rol = $rol;
    $this->nit = $nit;
    $this->celular = $celular;
    $this->direccion = $direccion;
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

  public function set_email($email)
  {
    $this->email = $email;
  }

  public function get_email()
  {
    return $this->email;
  }

  public function set_nombres($nombres)
  {
    $this->nombres = $nombres;
  }

  public function get_nombres()
  {
    return $this->nombres;
  }

  public function set_password($password)
  {
    $this->password = $password;
  }

  public function get_password()
  {
    return $this->password;
  }

  public function set_rol($rol)
  {
    $this->rol = $rol;
  }

  public function get_rol()
  {
    return $this->rol;
  }

  public function set_nit($nit)
  {
    $this->nit = $nit;
  }

  public function get_nit()
  {
    return $this->nit;
  }

  public function set_celular($celular)
  {
    $this->celular = $celular;
  }

  public function get_celular()
  {
    return $this->celular;
  }

  public function set_direccion($direccion)
  {
    $this->direccion = $direccion;
  }

  public function get_direccion()
  {
    return $this->direccion;
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
      $consulta = "INSERT INTO usuario (email,nombres,password,rol,nit,celular,direccion,estado) VALUES (:email,:nombres,:password,:rol,:nit,:celular,:direccion,:estado)";
      $sql = $this->db_connection->prepare($consulta);
      $sql->execute([
        'email' => $this->email,
        'nombres' => $this->nombres,
        'password' => $this->password,
        'rol' => $this->rol,
        'nit' => $this->nit,
        'celular' => $this->celular,
        'direccion' => $this->direccion,
        'estado' => $this->estado
      ]);

      return ['ok'];
    } catch (PDOException $ex) {
      return [
        'error' => $ex->errorInfo
      ];
    }
  }

  public function traer_todos()
  {
    try {
      $consulta = "SELECT * FROM usuario WHERE id != :id AND id != 1";
      $sql = $this->db_connection->prepare($consulta);
      $sql->execute([
        'id' => $this->id
      ]);

      $result_set = null;

      while ($row  = $sql->fetch(PDO::FETCH_OBJ)) {
        $result_set[] = $row;
      }
      return $result_set;
    } catch (PDOException $ex) {
      return [
        'error' => $ex->errorInfo
      ];
    }
  }

  public function actualizar_estado()
  {
    try {
      $consulta = "UPDATE usuario SET estado = :estado WHERE id = :id";
      $sql = $this->db_connection->prepare($consulta);
      $sql->execute([
        'id' => $this->id,
        'estado' => $this->estado
      ]);

      return ['ok'];
    } catch (PDOException $ex) {
      return [
        'error' => $ex->errorInfo
      ];
    }
  }

  public function seleccionar_mis_datos()
  {
    try {
      $consulta = "SELECT * FROM usuario WHERE id = :id AND id != 1";
      $sql = $this->db_connection->prepare($consulta);
      $sql->execute([
        'id' => $this->id
      ]);

      while ($row  = $sql->fetch(PDO::FETCH_OBJ)) {
        $this->email = $row->email;
        $this->nombres = $row->nombres;
        $this->rol = $row->rol;
        $this->nit = $row->nit;
        $this->celular = $row->celular;
        $this->direccion = $row->direccion;
        $this->estado = $row->estado;
      }
      return ['ok'];
    } catch (PDOException $ex) {
      return [
        'error' => $ex->errorInfo
      ];
    }
  }

  public function actualizar()
  {
    try {
      $consulta = "UPDATE usuario  SET email =:email ,nombres = :nombres,rol = :rol,nit = :nit,celular = :celular,direccion = :direccion,estado = :estado WHERE id = :id ";
      $sql = $this->db_connection->prepare($consulta);
      $sql->execute([
        'id' => $this->id,
        'email' => $this->email,
        'nombres' => $this->nombres,
        'rol' => $this->rol,
        'nit' => $this->nit,
        'celular' => $this->celular,
        'direccion' => $this->direccion,
        'estado' => $this->estado
      ]);

      return ['ok'];
    } catch (PDOException $ex) {
      return [
        'error' => $ex->errorInfo
      ];
    }
  }

  public function get_count_users_solcitud()
  {
    try {
      $consulta = "SELECT COUNT(id) AS cantidad FROM usuario WHERE estado = 'solicitando'";
      $sql = $this->db_connection->query($consulta);
      $result_set = null;

      while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
        $result_set = $row;
      }
      return [
        'datos' => $result_set
      ];
    } catch (PDOException $ex) {
      return [
        'error' => $ex->errorInfo
      ];
    }
  }

  public function traer_todos_por_solicitud()
  {
    try {
      $consulta = "SELECT * FROM usuario WHERE id != :id AND id != 1 AND estado = 'solicitando'";
      $sql = $this->db_connection->prepare($consulta);
      $sql->execute([
        'id' => $this->id
      ]);

      $result_set = null;

      while ($row  = $sql->fetch(PDO::FETCH_OBJ)) {
        $result_set[] = $row;
      }
      return $result_set;
    } catch (PDOException $ex) {
      return [
        'error' => $ex->errorInfo
      ];
    }
  }

  public function traer_todos_activos()
  {
    try {
      $consulta = "SELECT * FROM usuario WHERE id != :id AND id != 1 AND estado = 'activo'";
      $sql = $this->db_connection->prepare($consulta);
      $sql->execute([
        'id' => $this->id
      ]);

      $result_set = null;

      while ($row  = $sql->fetch(PDO::FETCH_OBJ)) {
        $result_set[] = $row;
      }
      return $result_set;
    } catch (PDOException $ex) {
      return [
        'error' => $ex->errorInfo
      ];
    }
  }
}
