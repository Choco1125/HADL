<?php
class Home  extends Controller
{
  public function __construct()
  {
    parent::__construct();
    if (!$this->is_login()) {
      header('location: ' . URL . '');
    }
    $this->view->active = 'home';
    $this->view->set_title_page('Inicio');
  }

  public function render()
  {
    if ($this->is_admin()) {
      $this->load_model('Usuario');
      $usuario = new Usuario();
      $numero_usuarios = $usuario->get_count_users_solcitud();

      $this->load_model('Cotizacion');
      $cotizacion = new Cotizacion();
      $numero_cotizaciones_pendientes = $cotizacion->contar_pendientes();

			$this->load_model('Solicitud');
			$solicitud = new Solicitud();
			$numero_solicitudes_pendientes =  $solicitud->get_cantidad_pendientes();
      $this->view->datos = [
        'solicitudes_de_cuentas' => $numero_usuarios['datos']->cantidad,
        'cotizaciones_pendientes' => $numero_cotizaciones_pendientes->cotizaciones_penidentes,
				'solicitudes_pendientes' => $numero_solicitudes_pendientes->cantidad
      ];
      $this->view->render('admin/home/index');
    } else {
      $this->view->render('user/home/index');
    }
  }
}
