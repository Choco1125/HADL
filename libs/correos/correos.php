<?php



class Correos
{
  private $mail;

  public function __construct()
  {
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
    $this->mail = $mail;
  }

  public function sendUserCreated($email, $name, $password)
  {
    try {
      $this->mail->addAddress($email, $name);
      $this->mail->Subject = "{$name}, bienvenido a " . constant('APPNAME');
      $this->mail->isHTML(true);
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
            .foot a {
              display: inline-block;
              padding: 10px;
              background-color: rgb(226, 226, 226);
              text-decoration: none;
              color: #000;
              border-radius: 5px;
              margin: 0 0 5px 35%;
            }
          </style>
        </head>
        <body>
          <div>
            <div class="head">
              <h1>Bienvenido ' . $name . '</h1>
            </div>
            <div class="body">
              <p>Te damos la vienvenida a ' . constant('APPNAME') . '</p>
              <div class="cuenta-info">
                <label>Correo: </label>
                <p>' . $email . '</p>
                <label>Contraseña: </label>
                <p>' . $password . '</p>
              </div>
            </div>
            <div class="foot">
              <a href="' . constant('APPNAME') . '" class="btn">Ir a la plataforma</a>
            </div>
          </div>
        </body>
      </html>
		';
      $this->mail->Body = $cuerpo;
      $this->mail->send();
      return true;
    } catch (Exception $ex) {
      return false;
    }
  }
}
