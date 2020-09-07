<?php
class Login extends Model
{

    private $email;
    private $password;
    private $id;
    private $rol;

    public function __construct($email = null, $password = null, $rol = null)
    {
        $this->table = 'usuario';
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
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

    public function set_email($email)
    {
        $this->email = $email;
    }

    public function get_email()
    {
        return $this->email;
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

    public function iniciar_sesion()
    {
        try {
            $consulta = "SELECT rol,id,password,estado FROM usuario WHERE email = :email AND estado = 'activo' LIMIT 1";

            $sql = $this->db_connection->prepare($consulta);
            $sql->execute([
                'email' => $this->email
            ]);

            while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
                $this->password = $row->password;
                $this->rol = $row->rol;
                $this->id = $row->id;
            }

            return ['ok'];
        } catch (PDOException $ex) {
            return [
                'error' => $ex->errorInfo
            ];
        }
    }

    public function is_valid_password($password)
    {
        return password_verify($password, $this->password);
        //return ($this->password == $password);
    }
}
