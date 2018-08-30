<?php

namespace Mini\Controller;

use Mini\Model\User;
use Mini\Core\Controller;
use Mini\Libs\Helper;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class LoginController extends Controller
{
    public function index()
    {
        $this->render('login/index', 'Iniciar Sesión', null, false);
    }

    public function register()
    {
        $this->render('login/register', 'Registrar Usuario', null, false);
    }

    public function template()
    {
        $this->render('login/template', 'Registrar Usuario', null, false);
    }

    public function recover()
    {
        $this->render('login/recover', 'Recuperar Contraseña', null, false);
    }

    public function sendRecoveryCode()
    {
        if (isset($_POST["txtCorreoElectronico"]) && trim($_POST["txtCorreoElectronico"] != '')) {
            $correoElectronico = $_POST['txtCorreoElectronico'];
            $codigo = $this->createRandomCode();
            $fechaRecuperacion = date("Y-m-d H:i:s", strtotime('+24 hours'));
            $userModel = new User();
            $user = $userModel->getUserWithEmail($correoElectronico);

            if ($user === false) {
                $mensaje = 'El correo electrónico no se encuentra registrado en el sistema.';
                $this->render('login/recover', 'Recuperar Contraseña', array('mensaje' => $mensaje), false);
            } else {
                $respuesta = $userModel->recoverPassword($correoElectronico, $codigo, $fechaRecuperacion);
            
                if ($respuesta) {
                    $this->sendMail($correoElectronico, $user->nombreCompleto, $codigo);
                    
                    $mensaje = 'Se ha enviado un correo electrónico con las instrucciones para el cambio de tu contraseña. Por favor verifica la información enviada.';
                    $this->render('login/recover', 'Recuperar Contraseña', array('mensaje' => $mensaje), false);
                } else {
                    $mensaje = 'No se recuperar la cuenta. Si los errores persisten comuniquese con el administrador del sitio.';
                    $this->render('login/recover', 'Recuperar Contraseña', array('mensaje' => $mensaje), false);
                }
            }
        } else {
            $mensaje = 'El campo de correo electrónico es requerido.';
            $this->render('login/recover', 'Recuperar Contraseña', array('mensaje' => $mensaje), false);
        }
    }

    public function newPassword($code = null)
    {
        if (isset($code)) {
            // Instance new Model (Song)
            $userModel = new User();
            // do deleteSong() in model/model.php
            $user = $userModel->getUserWithCode($code);

            if ($user === false) {
                $mensaje = 'El código de recuperación de contraseña no es valido. Por favor intenta de nuevo.';
                $this->render('login/recover', 'Recuperar Contraseña', array('mensaje' => $mensaje), false);
            } else {
                $current = date("Y-m-d H:i:s");

                if (strtotime($current) > strtotime($user->fechaRecuperacion)) {
                    $mensaje = 'El código de recuperación de contraseña ha expirado. Por favor intenta de nuevo.';
                    $this->render('login/recover', 'Recuperar Contraseña', array('mensaje' => $mensaje), false);
                } else {
                    $this->render('login/newPassword', 'Nueva Contraseña', array('user' =>  $user), false);
                }
            }
        } else {
            header('location: ' . URL);
        }
    }

    public function updatePasswordWithCode()
    {
        if (isset($_POST['btnGuardar'])) {
            $idUsuario = $_POST['txtIdUsuario'];
            $contrasena = $_POST['txtContrasena'];
            $repetirContrasena = $_POST['txtRepetirContrasena'];

            if ($contrasena != $repetirContrasena) {

                $user = new stdClass();
                $user->idUsuario = $idUsuario;

                $mensaje = 'Las contraseñas no coinciden. Por favor, verifique la información.';
                $this->render('login/newPassword', 'Registrar Usuario', array('user' => $user, 'mensaje' => $mensaje), false);
                return;

            } else {
                $userModel = new User();

                $contrasena = password_hash($_POST['txtContrasena'], PASSWORD_BCRYPT);

                $resultado = $userModel->updatePasswordFromRecover($idUsuario, $contrasena);
                if ($resultado != false) {
                    
                    $mensaje = 'Su contraseña ha sido cambiada con éxito.';
                    $this->render('login/index', 'Iniciar Sesion', array('mensaje' => $mensaje), false);
                    return;

                } else {
                    $user = new stdClass();
                    $user->idUsuario = $idUsuario;
                    $mensaje = 'Ocurrio un error al intentar cambiar la contraseña. Por favor, verifique la información.';
                    $this->render('login/newPassword', 'Registrar Usuario', array('user' => $user, 'mensaje' => $mensaje), false);
                    return;
                }
            }
        }else{
            header('location:'.URL);
        }
        
    }

    public function saveUser()
    {
        if (isset($_POST['btnGuardar'])) {
            $userModel = new User();

            $contrasena = password_hash($_POST['txtContrasena'], PASSWORD_BCRYPT);

            $resultado = $userModel->addUser($_POST['txtUsuario'], $contrasena, $_POST['txtNombreCompleto'], $_POST['txtCorreoElectronico']);
            if ($resultado != false) {
                $user = $userModel->getUser($resultado);

                $_SESSION["role"] = $user->rol;
                $_SESSION["user"] = $user;
                $_SESSION["authenticated"] = true;

                header('location: '.URL.'home');
                return;
            } else {
                $mensaje = 'Usuario o contraseña incorrectos. Por favor, verifique la información.';
                $this->render('login/register', 'Registrar Usuario', array('mensaje' => $mensaje), false);
                return;
            }
        }

        header('location:'.URL);
    }

    public function sendMail($correoElectronico, $nombre, $codigo)
    {
        $template = file_get_contents(APP.'view/login/template.php');
        $template = str_replace("{{name}}", $nombre, $template);
        $template = str_replace("{{action_url_2}}", '<b>http:'.URL.'login/newPassword/'.$codigo.'</b>', $template);
        $template = str_replace("{{action_url_1}}", 'http:'.URL.'login/newPassword/'.$codigo, $template);
        $template = str_replace("{{year}}", date('Y'), $template);
        $template = str_replace("{{operating_system}}", Helper::getOS(), $template);
        $template = str_replace("{{browser_name}}", Helper::getBrowser(), $template);

        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.googlemail.com';  //gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'phpminitest@gmail.com';   //username
            $mail->Password = 'sena2018.';   //password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;                    //smtp port

            $mail->setFrom('phpminitest@gmail.com', 'Variedades y Comunicaciones');
            $mail->addAddress($correoElectronico, $nombre);

            $mail->isHTML(true);

            $mail->Subject = 'Recuperación de contraseña - Variedades y Comunicaciones';
            $mail->Body    = $template;

            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
            // echo 'Message could not be sent.';
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public function createRandomCode()
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;
    
        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
    
        return time().$pass;
    }

    public function auth()
    {
        $usuario = $_POST["txtUsuario"];
        $contrasena = $_POST["txtContrasena"];

        $userModel = new User();

        $user = $userModel->getUserWithUser($usuario);

        if ($user === false) {
            $mensaje = 'Usuario o contraseña incorrectos. Por favor, verifique la información.';
            $this->render('login/index', 'Iniciar Sesión', array('mensaje' => $mensaje), false);
        } else {
            if (password_verify($contrasena, $user->contrasena)) {
                $_SESSION["role"] = $user->rol;
                $_SESSION["user"] = $user;
                $_SESSION["authenticated"] = true;

                header('location: '.URL.'home');
            } else {
                $mensaje = 'Usuario o contraseña incorrectos. Por favor, verifique la información.';
                $this->render('login/index', 'Iniciar Sesión', array('mensaje' => $mensaje), false);
            }
        }
    }

    public function closeSession()
    {
        session_unset();
        session_destroy();
        header('Location:'.URL);
    }
}
