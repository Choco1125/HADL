<?php
    class Usuarios extends Controller{
        public function __construct(){
            parent::__construct();
            $this->view->set_title_page('Usuario');
            $this->view->active = 'usuario';
        }

        public function render(){
            $this->view->render('admin/usuario/index');
        }

        public function crear(){
            $this->view->scripts = [
                'libs/peticiones.js',
                'libs/erro.js',
                'libs/spinner.js',
                'usuario/crear.js'
            ];
            $this->view->set_title_page('Crear Usuario');
            $this->view->render('admin/usuario/crear');
        }

        public function nuevo(){
            $nombres = $this->set_value($_POST['nombres']);
            $email = $this->set_value($_POST['email']);
            $rol = $this->set_value($_POST['rol']);
            $estado = $this->set_value($_POST['estado']);
            $nit = $this->set_value($_POST['nit']);
            $celular = $this->set_value($_POST['celular']);
            $direccion = $this->set_value($_POST['direccion']);

            $celular = $this->formatear_numero($celular);
            $errores = [];

            if(empty($nombres)){
                array_push($errores,[
                    'input' => 'nombre',
                    'mensaje' => 'Debes ingresar un nombre'
                ]);
            }

            if(empty($email)){
                array_push($errores,[
                    'input' => 'email',
                    'mensaje' => 'Debes ingresar un correo'
                ]);
            }else if(!$this->is_valid_email($email)){
                array_push($errores,[
                    'input' => 'email',
                    'mensaje' => 'Debes ingresar un correo válido'
                ]);
            }

            if($rol == 'user' && !empty($celular)){
                if(!$this->is_valid_number($celular)){
                    array_push($errores,[
                        'input' => 'celular',
                        'mensaje' => 'Debes ingresar un número celular válido'
                    ]);
                }
            }

            if(count($errores) == 0){
                $this->load_model('Usuario');
                $usuario = new Usuario();
                $usuario->set_nombres(ucwords($nombres));
                $usuario->set_email($email);
                $usuario->set_rol($rol);
                $usuario->set_estado($estado);
                $usuario->set_nit($nit);
                $usuario->set_direccion($direccion);
                $usuario->set_celular($celular);
                $usuario->set_password(password_hash(uniqid(),PASSWORD_DEFAULT));

                $guardar = $usuario->crear();

                if($guardar == ['ok']){
                    echo json_encode([
                        'status' => 201
                    ]);
                }else{
                    echo json_encode([
                        'status' => 500,
                        'error' => $guardar
                    ]);
                }
            }else{
                echo json_encode([
                    'status' => 400,
                    'errores' => $errores
                ]);
            }
        }
    }