<?php
class Usuarios extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->is_login() || !$this->is_admin()) {
            header('location: ' . URL);
        }
        $this->view->set_title_page('Usuario');
        $this->view->active = 'usuario';
    }

    public function render()
    {
        $this->load_model('Usuario');

        $usuarios = new Usuario();
        $usuarios->set_id($_SESSION['id']);
        $this->view->scripts = [
            'libs/spinner.js',
            'libs/alerta.js',
            'libs/peticiones.js',
            'usuario/main.js'
        ];
        $this->view->usuarios = $usuarios->traer_todos();
        $this->view->render('admin/usuario/index');
    }

    public function crear()
    {
        $this->view->scripts = [
            'libs/peticiones.js',
            'libs/erro.js',
            'libs/spinner.js',
            'usuario/crear.js'
        ];
        $this->view->set_title_page('Crear Usuario');
        $this->view->render('admin/usuario/crear');
    }

    public function nuevo()
    {
        $nombres = $this->set_value($_POST['nombres']);
        $email = $this->set_value($_POST['email']);
        $rol = $this->set_value($_POST['rol']);
        $estado = $this->set_value($_POST['estado']);
        $nit = $this->set_value($_POST['nit']);
        $celular = $this->set_value($_POST['celular']);
        $direccion = $this->set_value($_POST['direccion']);

        $celular = $this->formatear_numero($celular);
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

        if ($rol == 'user' && !empty($celular)) {
            if (!$this->is_valid_number($celular)) {
                array_push($errores, [
                    'input' => 'celular',
                    'mensaje' => 'Debes ingresar un número celular válido'
                ]);
            }
        }

        if (count($errores) == 0) {
            $this->load_model('Usuario');
            $usuario = new Usuario();
            $usuario->set_nombres(ucwords($nombres));
            $usuario->set_email($email);
            $usuario->set_rol($rol);
            $usuario->set_estado($estado);
            $usuario->set_nit($nit);
            $usuario->set_direccion($direccion);
            $usuario->set_celular($celular);
            // $usuario->set_password(password_hash(uniqid(),PASSWORD_DEFAULT));
            $usuario->set_password(uniqid());

            $guardar = $usuario->crear();

            if ($guardar == ['ok']) {
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
            echo json_encode([
                'status' => 400,
                'errores' => $errores
            ]);
        }
    }

    public function cambiar_estado()
    {
        $id = $this->set_value($_POST['id']);
        $estado = $this->set_value($_POST['estado']);

				switch ($estado){
					case 'activo':
						$estados = 'inactivo';
						break;
					case 'solicitando':
					case 'inactivo':
						$estados = 'activo';
						break;
					default:
						$estados = 'inactivo';
						break;
				}

        $this->load_model('Usuario');

        $usuario = new Usuario();

        $usuario->set_id($id);
        $usuario->set_estado($estados);
        $actualizar = $usuario->actualizar_estado();

        if ($actualizar == ['ok']) {
            echo json_encode([
                'status' => 200,
                'datos' => [
                    'id' => $usuario->get_id(),
                    'estado' => $usuario->get_estado(),
                    'estado_ingresado' => $estado
                ]
            ]);
        } else {
            echo json_encode([
                'status' => 500,
                'error' => $actualizar
            ]);
        }
    }

    public function editar($parametros)
    {
        $id = $this->set_value($parametros[0]);

        if (!empty($id)) {
            $this->load_model('Usuario');

            $usuario = new Usuario();
            $usuario->set_id($id);
            $mis_datos = $usuario->seleccionar_mis_datos();

            if ($mis_datos == ['ok'] && !is_null($usuario->get_email())) {
                $this->view->scripts = [
                    'libs/spinner.js',
                    'libs/alerta.js',
                    'libs/peticiones.js',
                    'libs/erro.js',
                    'usuario/editar.js'
                ];
                $this->view->usuario = $usuario;
                $this->view->render('admin/usuario/editar');
            } else {
                header('location: ' . URL . '/usuarios');
            }
        } else {
            header('location: ' . URL . '/usuarios');
        }
    }

    public function actualizar()
    {
        $id = $this->set_value($_POST['id']);
        $nombres = $this->set_value($_POST['nombres']);
        $email = $this->set_value($_POST['email']);
        $rol = $this->set_value($_POST['rol']);
        $estado = $this->set_value($_POST['estado']);
        $nit = $this->set_value($_POST['nit']);
        $celular = $this->set_value($_POST['celular']);
        $direccion = $this->set_value($_POST['direccion']);

        $celular = $this->formatear_numero($celular);
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

        if ($rol == 'user' && !empty($celular)) {
            if (!$this->is_valid_number($celular)) {
                array_push($errores, [
                    'input' => 'celular',
                    'mensaje' => 'Debes ingresar un número celular válido'
                ]);
            }
        }

        if (count($errores) == 0) {
            $this->load_model('Usuario');
            $usuario = new Usuario($id, $email, ucwords($nombres), null, $rol, $nit, $celular, $direccion, $estado);

            $guardar = $usuario->actualizar();

            if ($guardar == ['ok']) {
                echo json_encode([
                    'status' => 200
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
