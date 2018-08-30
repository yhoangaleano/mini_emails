<?php

namespace Mini\Controller;

use Mini\Model\Paciente;

class PacientesController
{
    public function index(){

        require APP. 'view/_templates/header.php';

        require APP. 'view/pacientes/index.php';

        require APP. 'view/_templates/footer.php';
    }

    public function guardar(){

            if(isset($_POST['btnGuardar'])){

                $pacienteModel = new Paciente();
                $pacienteModel->addPaciente( $_POST['txtNombre'], $_POST['txtApellido'], $_POST['txtEPSPaciente'], $_POST['txtDocumento']);
    
            }
    
            header('location:'.URL.'pacientes/index');


    }

    public function actualizar(){
        
    }

    public function eiminar(){
        
    }
}
