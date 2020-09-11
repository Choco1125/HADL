<?php
class Recuperacion extends Model
{

	private $email;
	private $password;

	public function __construct($email = null)
	{
		parent::__construct();
		$this->table = 'usuario';
		$this->email = $email;
		$this->password = null;
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

	public function is_registred()
	{
		try {
			$consulta = "SELECT password FROM usuario WHERE email = :email AND estado = 'activo'LIMIT 1";
			$sql = $this->db_connection->prepare($consulta);
			$sql->execute([
				'email' => $this->email
			]);

			while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
				$this->password = $row->password;
			}
			if (!is_null($this->get_password())) {
				return true;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			return false;
		}
	}

	public function update_password()
	{
		try {
			$consulta = "UPDATE usuario SET password = :password WHERE email = :email";
			$sql = $this->db_connection->prepare($consulta);
			$sql->execute([
				'email' => $this->email,
				'password' => $this->password
			]);

			return ['ok'];
		} catch (PDOException $ex) {
			return [
				'error' => $ex->errorInfo
			];
		}
	}
}
