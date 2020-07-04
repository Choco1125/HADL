<?php
class Main extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->view->set_title_page('HADL');

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
            'login/main.js'
        ];
        $this->load_model('Login');
    }

    function is_email($email)
    {
        return preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $email);
    }

    public function render()
    {
        $this->view->render('main/index');
        if (isset($_SESSION['rol'])) {
            header('location: ' . URL . '/home');
        }
    }

    public function login()
    {

        $correo = $this->set_value($_POST['email']);
        $password = $this->set_value($_POST['password']);

        $errores = [];

        if (empty($correo)) {
            array_push($errores, [
                'input' => 'email',
                'mensaje' => 'Debes ingresar un valor'
            ]);
        } else if (!$this->is_email($correo)) {
            array_push($errores, [
                'input' => 'email',
                'mensaje' => 'Debes ingresar un valor'
            ]);
        }

        if (empty($password)) {
            array_push($errores, [
                'input' => 'password',
                'mensaje' => 'Debes ingresar un valor'
            ]);
        }

        if (count($errores) == 0) {
            $login = new Login($correo);
            $iniciar_sesion = $login->iniciar_sesion();
            if ($iniciar_sesion == ['ok']) {

                if (!is_null($login->get_password())) {

                    if ($login->is_valid_password($password)) {
                        $_SESSION['rol'] = $login->get_rol();
                        $_SESSION['id'] = $login->get_id();
                        echo json_encode(['status' => 200, 'rol' => $_SESSION['rol']]);
                    } else {
                        echo json_encode(['status' => 400, 'error' => [[
                            'input' => 'password',
                            'mensaje' => 'Contraseña errónea'
                        ]]]);
                    }
                } else {
                    echo json_encode(['status' => 404, 'error' => [[
                        'input' => 'email',
                        'mensaje' => 'Usuario no encontrado o se encuentra desactivado'
                    ]]]);
                }
            } else {
                echo json_encode(['status' => 500, 'error' => $iniciar_sesion]);
            }
        } else {
            echo json_encode(['status' => 400, 'error' => $errores]);
        }
    }

    public function salir()
    {
        unset($_SESSION['rol'], $_SESSION['id']);
        header('location: ' . URL . '/');
    }
}
