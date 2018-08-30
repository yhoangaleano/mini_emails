<?php

/** For more info about namespaces plase @see http://php.net/manual/en/language.namespaces.importing.php */
namespace Mini\Core;

class Application
{
    /** @var null The controller */
    private $url_controller = null;

    /** @var null The method (of the above controller), often also named "action" */
    private $url_action = null;

    /** @var array URL parameters */
    private $url_params = array();

    /**
     * "Start" the application:
     * Analyze the URL elements and calls the according controller/method or the fallback
     */
    public function __construct()
    {
        // create array with URL parts in $url
        $this->splitUrl();
        $this->verifyAuthentication();

        // check for controller: no controller given ? then load start-page
        if (!$this->url_controller) {

            $page = new \Mini\Controller\LoginController();
            $page->index();

        } elseif (file_exists(APP . 'Controller/' . ucfirst($this->url_controller) . 'Controller.php')) {
            // here we did check for controller: does such a controller exist ?

            // if so, then load this file and create this controller
            // like \Mini\Controller\CarController
            $controller = "\\Mini\\Controller\\" . ucfirst($this->url_controller) . 'Controller';
            $this->url_controller = new $controller();

            // check for method: does such a method exist in the controller ?
            if (method_exists($this->url_controller, $this->url_action) &&
                is_callable(array($this->url_controller, $this->url_action))) {

                if (!empty($this->url_params)) {
                    // Call the method and pass arguments to it
                    call_user_func_array(array($this->url_controller, $this->url_action), $this->url_params);
                } else {
                    // If no parameters are given, just call the method without parameters, like $this->home->method();
                    $this->url_controller->{$this->url_action}();
                }

            } else {
                if (strlen($this->url_action) == 0) {
                    // no action defined: call the default index() method of a selected controller
                    $this->url_controller->index();
                } else {
                    $page = new \Mini\Controller\ErrorController();
                    $page->index();
                }
            }
        } else {
            $page = new \Mini\Controller\ErrorController();
            $page->index();
        }
    }

    /**
     * Get and split the URL
     */
    private function splitUrl()
    {
        if (isset($_GET['url'])) {

            // split URL
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // Put URL parts into according properties
            // By the way, the syntax here is just a short form of if/else, called "Ternary Operators"
            // @see http://davidwalsh.name/php-shorthand-if-else-ternary-operators
            $this->url_controller = isset($url[0]) ? $url[0] : null;
            $this->url_action = isset($url[1]) ? $url[1] : null;

            // Remove controller and action from the split URL
            unset($url[0], $url[1]);

            // Rebase array keys and store the URL params
            $this->url_params = array_values($url);

            // for debugging. uncomment this if you have problems with the URL
            //echo 'Controller: ' . $this->url_controller . '<br>';
            //echo 'Action: ' . $this->url_action . '<br>';
            //echo 'Parameters: ' . print_r($this->url_params, true) . '<br>';
        }
    }

    public function verifyAuthentication()
    {
        //Metodo para ingresar al login
        $login = array("/", "login/", "login/index");

        // Aca van los metodos a los que puedo acceder sin login
        $controllers = array("/", "login/", "login/index", "login/register", "login/saveUser", "login/recover", "login/newPassword", "login/sendRecoveryCode", "login/updatePasswordWithCode", "login/template", "login/auth", "error/", "error/index");

        $controllers = array_map('strtolower', $controllers);

        //Obtengo la url a la que estoy ingresando
        $access = strtolower($this->url_controller) . "/" . strtolower($this->url_action);

        //Verificamos si la url no se encuentra entre las opciones a las que se puede ingresar sin iniciar sesion
        if (!in_array($access, $controllers)) {

            //Si no esta dentro de las opciones anteriores, se verifica que este autenticado, sino lo esta se retorna al login
            if (isset($_SESSION["authenticated"])) {

                //Se verifican los permisos que tenga cada usuario apartir del metodo checkPermissions
                $this->checkPermissions();

            }else{
                header("location: " . URL);
            }
        }

        // Si va al login, se verifica que este logueado y si es así pasa al home. De esta manera si quiere regresar al login obligatoriamente debera cerrar sesión
        if (in_array($access, $login)) {

            if (isset($_SESSION["authenticated"])) {
                header("location: " . URL . "home");
            }
        }
    }

    public function checkPermissions()
    {
        //Obtengo la url a la que estoy ingresando
        $access = strtolower($this->url_controller) . "/" . strtolower($this->url_action);

        $generalPermissions = array("error/", "error/index", "home/", "home/index", "login/closeSession");

        $permissions = array(

            'VENDEDOR' => array("pacientes/", "pacientes/index"),

            'ADMINISTRADOR' => array("songs/", "songs/index")

        );

        if (isset($_SESSION["role"])) {
            
            $role = $_SESSION["role"];

            $generalPermissions = array_map('strtolower', $generalPermissions);
            $permissions[$role] = array_map('strtolower', $permissions[$role]);

            if (
                !in_array($access, $permissions[$role]) && 
                !in_array($access, $generalPermissions)
            ) {

                header("location: " . URL . "home");
            }

        }else{
            header("location: " . URL);
        }
    }

}
