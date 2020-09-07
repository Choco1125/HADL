<?php
class Cuenta extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->view->set_title_page('Mi cuenta');
		$this->view->active = 'cuenta';
		if (!$this->is_login()) {
			header('location: ' . URL);
		}
	}

	public function render()
	{
		$this->load_model('Usuario');
		$usuario = new Usuario();
		$usuario->set_id($_SESSION['id']);
		$this->view->scripts = [
			'libs/spinner.js',
			'libs/alerta.js',
			'libs/erro.js',
			'libs/peticiones.js',
			$this->is_admin() ? 'cuenta/admin/main.js' : 'cuenta/usuario/main.js'
		];
		$usuario->seleccionar_mis_datos();
		$this->view->datos = $usuario;
		if ($this->is_admin()) {
			$this->view->render('admin/cuenta/index');
		} else {
			$this->view->render('user/cuenta/index');
		}
	}

	public function actualizar()
	{
		$id = $this->set_value($_POST['id']);
		$nombres = $this->set_value($_POST['nombres']);
		$email = $this->set_value($_POST['email']);
		if (!$this->is_admin()) {
			$nit = $this->set_value($_POST['nit']);
			$celular = $this->set_value($_POST['celular']);
			$direccion = $this->set_value($_POST['direccion']);
			$celular = $this->formatear_numero($celular);
		} else {
			$nit = null;
			$celular = null;
			$direccion = null;
		}

		$errores = [];

		if (empty($nombres)) {
			array_push($errores, [
				'input' => 'nombre',
				'mensaje' => 'Debes ingresar un nombre'
			]);
		}

		if (empty($email)) {
			array_push($errores, [
				'input' => 'email',
				'mensaje' => 'Debes ingresar un correo'
			]);
		} else if (!$this->is_valid_email($email)) {
			array_push($errores, [
				'input' => 'email',
				'mensaje' => 'Debes ingresar un correo válido'
			]);
		}

		if (count($errores) == 0) {
			$this->load_model('Usuario');
			$usuario = new Usuario($id, $email, ucwords($nombres), null, null, $nit, $celular, $direccion, null);

			$guardar = $usuario->actualizar_cuenta();

			if ($guardar == ['ok']) {
				echo json_encode([
					'status' => 200,
				]);
			} else {
				echo json_encode([
					'status' => 500,
					'error' => $guardar
				]);
			}
		} else {
			echo json_encode([
				'status' => 400,
				'errores' => $errores
			]);
		}
	}

	public function contrasena()
	{
		$this->view->scripts = [
			'libs/spinner.js',
			'libs/alerta.js',
			'libs/peticiones.js',
			'libs/erro.js',
			'cuenta/admin/contrasena.js'
		];
		$this->view->set_title_page('Cambiar contraseña');
		$this->view->render('user/cuenta/password');
	}

	public function actualizar_contraseña()
	{
		$new_password = $this->set_value($_POST['new_password']);
		$new_password_repeat = $this->set_value($_POST['new_password_repeat']);

		$this->load_model('Usuario');
		$usuario = new Usuario();
		$usuario->set_id($_SESSION['id']);

		$errores = [];

		if (empty($new_password)) {
			array_push($errores, [
				'input' => 'new_password',
				'mensaje' => 'Debes ingresar tu contraseña nueva'
			]);
		} else if (empty($new_password_repeat)) {
			array_push($errores, [
				'input' => 'new_password_repeat',
				'mensaje' => 'Debes conformar tu contraseña nueva'
			]);
		} else if ($new_password != $new_password_repeat) {
			array_push($errores, [
				'input' => 'new_password_repeat',
				'mensaje' => 'Las contaseñas no coinciden'
			]);
		}

		if (count($errores) == 0) {

			$usuario->set_password(password_hash($new_password, PASSWORD_DEFAULT));

			$guardar = $usuario->actualizar_contreasena();

			if ($guardar == ['ok']) {
				echo json_encode([
					'status' => 200,
				]);
			} else {
				echo json_encode([
					'status' => 500,
					'error' => $guardar
				]);
			}
		} else {
			echo json_encode([
				'status' => 400,
				'errores' => $errores
			]);
		}
	}
}
