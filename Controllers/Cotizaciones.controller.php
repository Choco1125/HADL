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
      $this->view->clientes = $usuarios->traer_todos_activos();
      $this->view->render('admin/cotizacion/crear');
    } else {
      $this->view->scripts = [
        'libs/peticiones.js',
        'libs/erro.js',
        'libs/alerta.js',
        'libs/spinner.js',
        'cotizacion/user/crear.js'
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
      $estado = "En Solicitud";
      $fecha_vencimiento = isset($_POST['fecha_vencimiento']) ? $_POST['fecha_vencimiento'] : '';
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

      if ($_SESSION['rol'] == 'user' && $_SESSION['id'] != $buscar[0]['usuarioId']) {
        header('location: ' . URL . '/cotizaciones');
      }

      if (!is_null($buscar)) {

        $this->load_model('Usuario');
        $usuarios = new Usuario();
        $usuarios->set_id($_SESSION['id']);

        $this->view->clientes = $usuarios->traer_todos();
        $this->view->cotizacion = $buscar[0];

        $this->load_model('Servicio');
        $servicios = new Servicio();

        $this->view->servicios = $servicios->seleccionar_todos();

        if ($_SESSION['rol'] == 'user') {
          $this->view->scripts = [
            'libs/erro.js',
            'libs/peticiones.js',
            'libs/alerta.js',
            'libs/spinner.js',
            'cotizacion/user/editar.js'
          ];
        } else {
          $this->view->scripts = [
            'libs/erro.js',
            'libs/peticiones.js',
            'libs/alerta.js',
            'libs/spinner.js',
            'cotizacion/editar.js'
          ];
        }

        $this->view->render($_SESSION['rol'] == 'admin' ? 'admin/cotizacion/editar' : 'user/cotizacion/editar');
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
    $cliente = isset($_POST['cliente']) ? $this->set_value($_POST['cliente']) : '';
    $descripcion = $this->set_value($_POST['descripcion']);
    $estado = isset($_POST['estado']) ? $this->set_value($_POST['estado']) : '';
    $servicos = $this->set_value($_POST['servicios']);
    $fecha_vencimiento = isset($_POST['fecha_vencimiento']) ? $this->set_value($_POST['fecha_vencimiento']) : '';

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

  public function delete()
  {
    $id = $_POST['id'];
    $this->load_model('Cotizacion');
    $cotizacion = new Cotizacion();
    $cotizacion->set_id($id);

    $delete = $cotizacion->delete();

    if ($delete == ['ok']) {
      echo json_encode([
        'status' => 200
      ]);
    } else {
      echo json_encode([
        'status' => 500,
        'error' => $delete['error']
      ]);
    }
  }

  public function ver($params = null)
  {
    $idCotizacion = $params[0];
    $this->load_model('Cotizacion');
    $cotizacion = new Cotizacion();
    $cotizacion->set_id($idCotizacion);
    $datos = $cotizacion->mis_datos();

    // echo '<pre>';
    // var_dump($datos);
    // echo '</prev>';

    $this->crear_pdf($datos);
  }

  public function crear_pdf($datos)
  {
    require 'libs/pdf/pdf.php';
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetFont('Helvetica', 'B', 14);
    $pdf->Cell(0, 10, utf8_decode('Cotización de servicios'), 0, 1, 'C');
    //METADATA
    $pdf->Ln(10);
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(45, 5, utf8_decode('Cotización Nro:'));
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell(0, 5, $datos[0]['cotizaciondId'], 0, 1);
    $pdf->Ln(5);
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(45, 5, utf8_decode('Fecha realización:'));
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell(0, 5, $datos[0]['fecha_realizacion'], 0, 1);
    $pdf->Ln(2);
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(45, 5, utf8_decode('Fecha vencimiento:'));
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell(0, 5, $datos[0]['fecha_vencimiento'], 0, 1);
    //Usuario
    $pdf->Ln(2);
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(45, 5, utf8_decode('Usuario:'));
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell(0, 5, $datos[0]['nombres'], 0, 1);
    //NIT
    $pdf->Ln(2);
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(45, 5, utf8_decode('NIT:'));
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell(0, 5, $datos[0]['nit'], 0, 1);
    //Estado
    $pdf->Ln(2);
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(45, 5, utf8_decode('Estado:'));
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(0, 5, $datos[0]['estado'], 0, 1);
    //Descripción
    $pdf->Ln(5);
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(0, 5, utf8_decode('Descripción: '), 0, 1);
    $pdf->Ln(2);
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->MultiCell(0, 5, utf8_decode($datos[0]['descripcion']));

    //Servicios
    $pdf->Ln(5);
    $pdf->SetFont('Helvetica', 'B', 15);
    $pdf->Cell(0, 10, 'Lista de servicios', 0, 1, 'C');
    $pdf->Ln(2);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(95, 7, 'Servicio', 1, 0, 'C');
    $pdf->Cell(0, 7, 'Precio', 1, 1, 'C');

    $pdf->SetFont('Helvetica', '', 12);
    $total = 0;
    for ($i = 0; $i < count($datos[0]['servicios']); $i++) {
      $total += $datos[0]['servicios'][$i]['precio'];
      $pdf->Cell(95, 7, utf8_decode($datos[0]['servicios'][$i]['nombre']), 1, 0, 'C');
      $pdf->Cell(0, 7, utf8_decode($datos[0]['servicios'][$i]['precio']), 1, 1, 'C');
    }
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(95, 7, 'Total', 1, 0, 'C');
    $pdf->Cell(0, 7, $total, 1, 1, 'C');

    $pdf->Output();
  }

  public function pendientes()
  {
    $this->load_model('Cotizacion');
    $cotizacion = new Cotizacion();
    $this->view->scripts = [
      'libs/peticiones.js',
      'libs/erro.js',
      'libs/alerta.js',
      'libs/spinner.js',
      'cotizacion/main.js'
    ];
    $this->view->cotizaciones = $cotizacion->seleccionar_todos_penidentes();
    $this->view->render('admin/cotizacion/index');
  }
}
