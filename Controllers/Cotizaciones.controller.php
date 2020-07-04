<?php
class Cotizaciones extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->set_title_page('Cotizaciones');
        $this->view->active = 'cotizacion';
    }

    public function render()
    {
        $this->load_model('Cotizacion');
        $cotizacion = new Cotizacion();
        if ($this->is_admin()) {
            $this->view->scripts = [
                'libs/peticiones.js',
                'libs/erro.js',
                'libs/alerta.js',
                'libs/spinner.js',
                'cotizacion/main.js'
            ];
            $this->view->cotizaciones = $cotizacion->seleccionar_todos();
            $this->view->render('admin/cotizacion/index');
        } else {
            $cotizacion->set_usuario($_SESSION['id']);
            $this->view->cotizaciones = $cotizacion->seleccionar_todos();
            $this->view->render('user/cotizacion/index');
        }
    }

    public function crear()
    {
        if ($this->is_admin()) {
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
        } else {
            $this->view->scripts = [
                'libs/peticiones.js',
                'libs/erro.js',
                'libs/alerta.js',
                'libs/spinner.js',
                'cotizacion/crear.js'
            ];
            $this->view->render('user/cotizacion/crear');
        }
    }

    public function storage()
    {
        if ($this->is_admin()) {
            $cliente = $this->set_value($_POST['cliente']);
            $estado = $this->set_value($_POST['estado']);
            $fecha_vencimiento = $this->set_value($_POST['fecha_vencimiento']);
        } else {
            $cliente = $_SESSION['id'];
            $estado = "";
            $fecha_vencimiento = $this->set_value($_POST['fecha_vencimiento']);
        }

        $descripcion = $this->set_value($_POST['descripcion']);
        $servicos = $this->set_value($_POST['servicios']);

        $servicios = explode(',', $servicos);
        $this->load_model('Cotizacion');
        $cotizacion = new Cotizacion(null, $cliente, date('Y-m-d'), $fecha_vencimiento, $descripcion, $estado);
        $guardar = $cotizacion->crear();

        if ($guardar == ['ok']) {
            $test = [];
            foreach ($servicios as $servicio) {
                $lol = $cotizacion->agregar_servicio($servicio);
                array_push($test, $lol);
            }
            echo json_encode([
                'status' => 201
            ]);
        } else {
            echo json_encode([
                'status' => 400,
                'error' => $guardar
            ]);
        }
    }

    public function editar($params)
    {
        $id = isset($params) ? $params[0] : null;
        if (isset($id)) {

            $this->load_model('Cotizacion');
            $cotizacion = new Cotizacion();
            $cotizacion->set_id($id);

            $buscar = $cotizacion->mis_datos();


            if (!is_null($buscar)) {

                $this->load_model('Usuario');
                $usuarios = new Usuario();
                $usuarios->set_id($_SESSION['id']);

                $this->view->clientes = $usuarios->traer_todos();
                $this->view->cotizacion = $buscar[0];

                $this->load_model('Servicio');
                $servicios = new Servicio();

                $this->view->servicios = $servicios->seleccionar_todos();

                $this->view->scripts = [
                    'libs/erro.js',
                    'libs/peticiones.js',
                    'libs/alerta.js',
                    'libs/spinner.js',
                    'cotizacion/editar.js'
                ];
                $this->view->render('admin/cotizacion/editar');
            } else {
                header('location:' . URL . '/cotizaciones');
            }
        } else {
            header('location:' . URL . '/cotizaciones');
        }
    }

    public function update()
    {
        $id = $this->set_value($_POST['cotizacionId']);
        $cliente = $this->set_value($_POST['cliente']);
        $descripcion = $this->set_value($_POST['descripcion']);
        $estado = $this->set_value($_POST['estado']);
        $servicos = $this->set_value($_POST['servicios']);
        $fecha_vencimiento = $this->set_value($_POST['fecha_vencimiento']);

        $servicios = explode(',', $servicos);
        $this->load_model('Cotizacion');
        $cotizacion = new Cotizacion($id, $cliente, null, $fecha_vencimiento, $descripcion, $estado);
        $guardar = $cotizacion->actualizar();

        if ($guardar == ['ok']) {
            $cotizacion->eliminar_servicios();
            foreach ($servicios as $servicio) {
                $cotizacion->agregar_servicio($servicio);
            }
            echo json_encode([
                'status' => 200
            ]);
        } else {
            echo json_encode([
                'status' => 400,
                'error' => $guardar
            ]);
        }
    }

    public function delete(){
	$id = $_POST['id'];
	$this->load_model('Cotizacion');
	$cotizacion = new Cotizacion();
	$cotizacion->set_id($id);

	$delete = $cotizacion->delete();
	
	if($delete == ['ok']){
	  echo json_encode([
	  	'status' => 200
	  ]);
	}else{
	  echo json_encode([
	  	'status' => 500,
		'error' => $delete['error']
	  ]);
	}
    }
}
