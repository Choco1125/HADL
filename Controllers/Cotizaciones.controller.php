<?php
    class Cotizaciones extends Controller{
        public function __construct()
        {
            parent::__construct();
            $this->view->set_title_page('Cotizaciones');
            $this->view->active = 'cotizacion';    
        }

        public function render()
        {
            $this->view->render('admin/cotizacion/index');
        }

        public function crear()
        {
            $this->load_model('Usuario');
            $usuarios =  new Usuario();
            $usuarios->set_id($_SESSION['id']);
            $this->view->scripts = [
                'libs/peticiones.js',
                'libs/erro.js',
                'libs/alerta.js',
                'libs/spinner.js',
                'cotizacion/crear.js'
            ];
            $this->view->clientes = $usuarios->traer_todos();
            $this->view->render('admin/cotizacion/crear');
        }

        public function storage()
        {
            $cliente = $this->set_value($_POST['cliente']);
            $descripcion = $this->set_value($_POST['descripcion']); 
            $estado = $this->set_value($_POST['estado']);
            $servicos = $this->set_value($_POST['servicios']);
            $fecha_vencimiento = $this->set_value($_POST['fecha_vencimiento']);
            
            $servicios = explode(',',$servicos);
            $this->load_model('Cotizacion');
            $cotizacion = new Cotizacion(null,$cliente,date('Y-m-d'),$fecha_vencimiento,$descripcion,$estado);
            $guardar = $cotizacion->crear();

            if($guardar == ['ok']){
                $test = [];
                foreach($servicios as $servicio){
                    $lol = $cotizacion->agregar_servicio($servicio);       
                    array_push($test,$lol);
                }
                echo json_encode([
                    'status'=>200,
                    'id' => $cotizacion->get_id(),
                    'test' => $test
                ]);
            }else{
                echo json_encode([
                    'status' => 400,
                    'error' => $guardar
                ]);
            }
        }
    }