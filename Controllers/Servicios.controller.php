<?php
    class Servicios extends Controller{
        public function __construct(){
            parent::__construct();
            $this->view->active = 'servicios';
            $this->view->set_title_page('Servicios');
        }

        public function render(){
            $this->view->render('admin/servicios/solicitud');
        }

        //Solicitudes----------------------------------------
      

        public function solicitud(){
            $this->view->render('admin/servicios/solicitud');
        }

        public function nueva_solicitud(){
            
            $this->view->scripts = [
                'libs/peticiones.js',
                'libs/alerta.js',
                'servicios/solicitud/crear.js'
            ];
            $this->view->render('admin/servicios/solicitud/crear');
        }

        //----------------------------------------------------------

        //Servicios--------------------------------------------------

        public function catalogo(){
            $this->load_model('Servicio');

            $servicio = new Servicio();

            $this->view->catalogo = $servicio->seleccionar_todos();
            $this->view->scripts = [
                'libs/erro.js',
                'libs/peticiones.js',
                'libs/spinner.js',
                'libs/alerta.js',
                'servicios/admin/main.js',
                'servicios/admin/crear.js',
            ];
            $this->view->render('admin/servicios/catalogo');
        }

        public function todos_servicios(){
            $this->load_model('Servicio');
            $servicio = new Servicio();
            $datos = $servicio->seleccionar_todos();


            if(isset($datos)){
                echo json_encode([
                    'status' => 200,
                    'datos' => $datos
                ]);
            }else{
                echo json_encode([
                    'status' => 400
                ]);
            }
        }

        public function crear_servicio(){
            $nombre = $this->set_value($_POST['nombre']);
            $descripcion = $this->set_value($_POST['descripcion']);
            $precio = $this->set_value($_POST['precio']);

            $errores = [];

            if(empty($nombre)){
                array_push($errores,[
                    'input'=>'nombre',
                    'mensaje'=>'Debes llenar este campo'
                ]);
            }
            if(empty($descripcion)){
                array_push($errores,[
                    'input'=>'descripcion',
                    'mensaje'=>'Debes llenar este campo'
                ]);
            }

            $precio = str_replace('.','',$precio);
            $precio = str_replace(',','',$precio);

            if(empty($precio)){
                array_push($errores,[
                    'input'=>'precio',
                    'mensaje'=>'Debes llenar este campo'
                ]);
            }else if(!is_numeric($precio)){
                array_push($errores,[
                    'input'=>'precio',
                    'mensaje'=>'Debes ingresar un precio válido'
                ]);
            }

            if(count($errores) == 0){

                $this->load_model('Servicio');

                $servicio = new Servicio();
                $servicio->set_nombre(ucfirst($nombre));
                $servicio->set_descripcion(ucfirst($descripcion));
                $servicio->set_precio($precio);
                $guardar = $servicio->guardar();


                if($guardar == ['ok']){
                    echo json_encode([
                        'status'=>201,
                        'datos'=>[
                            'id' => $servicio->get_id(),
                            'nombre' => $servicio->get_nombre(),
                            'descripcion' => $servicio->get_descripcion(),
                            'precio' => $servicio->get_precio()
                        ]
                    ]);
                }else{
                    echo json_encode([
                        'status' => 400,
                        'error' => $guardar
                    ]);
                }

            }else{
                echo json_encode([
                    'status' => 400,
                    'error'=> $errores
                ]);
            }
        }

        public function eliminar_servicio(){
            $id = $_POST['id'];

            $this->load_model('Servicio');
            $servicio = new Servicio();
            $servicio->set_id($id);

            $eliminar = $servicio->eliminar();
            if($eliminar == ['ok']){
                echo json_encode([
                    'status' => 200
                ]);
            }else{
                echo json_encode([
                    'status' => 400,
                    'error'=>$eliminar['error']
                ]);
            }
        }

        public function editar_servicio($params= null){
            $id = isset($params)? $params[0]: null;
            if(isset($id)){
                $this->load_model('Servicio');
                $servicio = new Servicio();
                $servicio->set_id($id);
                $buscar = $servicio->buscar_informacion();

                if($buscar == ['ok'] && $servicio->get_nombre() != null){
                    $this->view->servicio = $servicio;
                    $this->view->scripts = [
                        'libs/erro.js',
                        'libs/peticiones.js',
                        'libs/spinner.js',
                        'servicios/admin/editar.js'
                    ];
                    $this->view->render('admin/servicios/servicio/editar');
                }else{
                    header('location:'.URL.'/servicios/catalogo');
                }
            }else{
                header('location:'.URL.'/servicios/catalogo');
            }
        }

        public function actualzar_servicio(){
            $id = $this->set_value($_POST['id']);
            $nombre = $this->set_value($_POST['nombre']);
            $descripcion = $this->set_value($_POST['descripcion']);
            $precio = $this->set_value($_POST['precio']);

            $errores = [];

            if(empty($nombre)){
                array_push($errores,[
                    'input'=>'nombre',
                    'mensaje'=>'Debes llenar este campo'
                ]);
            }
            if(empty($descripcion)){
                array_push($errores,[
                    'input'=>'descripcion',
                    'mensaje'=>'Debes llenar este campo'
                ]);
            }

            $precio = str_replace('.','',$precio);
            $precio = str_replace(',','',$precio);

            if(empty($precio)){
                array_push($errores,[
                    'input'=>'precio',
                    'mensaje'=>'Debes llenar este campo'
                ]);
            }else if(!is_numeric($precio)){
                array_push($errores,[
                    'input'=>'precio',
                    'mensaje'=>'Debes ingresar un precio válido'
                ]);
            }

            if(count($errores) == 0){

                $this->load_model('Servicio');

                $servicio = new Servicio($id,ucfirst($nombre),ucfirst($descripcion),$precio);
                $guardar = $servicio->actualizar();


                if($guardar == ['ok']){
                    echo json_encode([
                        'status'=>200
                    ]);
                }else{
                    echo json_encode([
                        'status' => 400,
                        'error' => $guardar
                    ]);
                }

            }else{
                echo json_encode([
                    'status' => 400,
                    'error'=> $errores
                ]);
            }
        }
        //---------------------------------------------------------------------
    }