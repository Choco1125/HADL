<?php
class Registrarse extends Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->view->set_title_page('Solicitar mi cuenta');
    if ($this->is_login()) {
      header('location: ' . URL . '/home');
    }
    $this->view->styles = [
      'login/main.css'
    ];

    $this->view->scripts = [
      'libs/peticiones.js',
      'libs/spinner.js',
      'libs/erro.js',
			'libs/alerta.js',
      'registro/main.js'
    ];

    $this->load_model('Usuario');
  }

  public function render()
  {
    $this->view->render('registro/index');
  }

  public function registrarse()
  {
    $correo = $this->set_value($_POST['email']);
    $nombre = $this->set_value($_POST['nombre']);
    $celular = $this->set_value($_POST['celular']);

    $celular = $this->formatear_numero($celular);

    $errores = [];

    if (empty($correo)) {
      array_push($errores, [
        'input' => 'email',
        'mensaje' => 'Debes ingresar un correo elecrónico'
      ]);
    } else if (!$this->is_valid_email($correo)) {
      array_push($errores, [
        'input' => 'email',
        'mensaje' => 'Debes ingresar un correo válido'
      ]);
    }

    if (empty($nombre)) {
      array_push($errores, [
        'input' => 'nombre',
        'mensaje' => 'Debes ingresar un nombre'
      ]);
    }

    if (empty($celular)) {
      array_push($errores, [
        'input' => 'celular',
        'mensaje' => 'Debes ingresar un número'
      ]);
		} else if(!$this->is_valid_number($celular)){
			array_push($errores, [
        'input' => 'celular',
        'mensaje' => 'Debes ingresar un número válido'
      ]);
		}

    if(count($errores) == 0) {
      $usuario = new Usuario();
      $usuario->set_nombres(ucfirst($nombre));
      $usuario->set_email($correo);
      $usuario->set_celular($celular);
      $usuario->set_estado('solicitando');
      $usuario->set_rol('user');
			$usuario->set_password($celular);
			$guardar = $usuario->crear();

			if($guardar == ['ok']){
				echo json_encode([
					'status' => 201
				]);
			} else {
				echo json_encode([
					'status' => 500,
					'error' => $guardar
				]);
			}
    } else {
      echo json_encode(['status' => 400, 'error' => $errores]);
    }
  }
}
