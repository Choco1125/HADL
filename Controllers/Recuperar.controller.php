<?php

require 'libs/PHPMailer/src/PHPMailer.php';
require 'libs/PHPMailer/src/SMTP.php';
require 'libs/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Recuperar extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->view->set_title_page('Recuperar contraseña');
		if ($this->is_login()) {
			header('location: ' . URL . '/home');
		}
	}

	public function render()
	{
		$this->view->styles = [
			'login/main.css'
		];
		$this->view->scripts = [
			'libs/peticiones.js',
			'libs/spinner.js',
			'libs/erro.js',
			'recuperacion/main.js'
		];
		$this->view->render('recuperacion/index');
	}

	public function recuperar_contrasena()
	{

		$email = $this->set_value($_POST['email']);

		$errores = [];

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

		$this->load_model('Recuperacion');
		$recuperacion = new Recuperacion($email);

		if (!$recuperacion->is_registred()) {
			array_push($errores, [
				'input' => 'email',
				'mensaje' => 'El correo no se encuentra registarado o el usuario no está activo'
			]);
		}

		if (count($errores) == 0) {
			$password = uniqid();
			$recuperacion->set_password(password_hash($password, PASSWORD_DEFAULT));
			$guardar = $recuperacion->update_password();
			if ($guardar == ['ok']) {
				echo json_encode([
					'status' => 200,
				]);
				$this->sendMailCreate($email, $password);
			} else {
				echo json_encode([
					'status' => 500,
					'error' => $guardar
				]);
			}
		} else {
			echo json_encode([
				'status' => 400,
				'errores' => $errores,
			]);
		}
	}

	public function sendMailCreate($email, $password)
	{
		try {
			$mail =  new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPDebug = 0;
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';
			$mail->SMTPAuth = true;
			$mail->Username = constant('CORREO');
			$mail->Password = constant('EMAIL_CONTRASENA');
			$mail->SetFrom(constant('CORREO'), constant('APPNAME'));
			$mail->addAddress($email, $email);
			$mail->Subject = "Esta es tu nueva contraseña";
			$mail->isHTML(true);
			$cuerpo = '
				<html>
					<head>
						<style>
							body {
								font-family: tahoma;
								width: 50%;
								margin: 0 auto;
								background-color: rgb(245, 245, 245);
							}
							.head {
								text-align: center;
								font-size: 18px;
							}
							.body,
							.foot {
								background-color: #fff;
								font-size: 16px;
								padding: 5px;
							}
							.body div.cuenta-info label {
								font-weight: bolder;
							}
						</style>
					</head>
					<body>
						<div>
							<div class="head">
								<h1>Recuperamos tu contraseña</h1>
							</div>
							<div class="body">
								<p>Puedes ingresar con los siguientes datos</p>
								<div class="cuenta-info">
									<label>Correo: </label>
									<p>' . $email . '</p>
									<label>Contraseña: </label>
									<p>' . $password . '</p>
								</div>
							</div>
						</div>
					</body>
				</html>
			';
			$mail->Body = $cuerpo;
			$mail->send();
		} catch (Exception $e) {
			return false;
		}
	}
}
