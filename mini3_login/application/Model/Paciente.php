<?php

namespace Mini\Model;

use Mini\Core\Model;

class Paciente extends Model
{

    /**
     * Obtener todos los pacientes de la base de datos
     */
    public function getAllPacientes()
    {
        $sql = "SELECT idPaciente, nombrePaciente, apellidoPaciente, epsPaciente, documentoPaciente, estadoPaciente FROM tblPaciente";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll()
        // $query->fetchAll(PDO::FETCH_ASSOC);
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    /**
     * Obtener todos los pacientes de la base de datos filtrado por estado
     * 
     * @param tinyint $p_estado Estado de los pacientes a mostrar
     */
    public function getAllPacientesPorEstado($p_estado)
    {
        $sql = "SELECT idPaciente, nombrePaciente, apellidoPaciente, epsPaciente, documentoPaciente, estadoPaciente FROM tblPaciente WHERE estadoPaciente = :p_estadoPaciente";

        $query = $this->db->prepare($sql);

        $parameters = array(':p_estadoPaciente' => $p_estado);

        $query->execute($parameters);

        // fetchAll()
        // $query->fetchAll(PDO::FETCH_ASSOC);
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    /**
     * Agregar un paciente a la base de datos
     * 
     * 
     * Por favor, tenga en cuenta que no es necesario "limpiar" nuestra entrada de ninguna manera. Con PDO todas las entradas se escapan correctamente automáticamente. Tampoco usamos strip_tags() etc. por lo que mantenemos la entrada 100% original (para que sea posible para guardar HTML y JS en la base de datos, que es un caso de uso válido). Los datos sólo se limpiarán cuando se publiquen en las vistas (ver las vistas para más información).
     * 
     * 
     * @param string $p_nombrePaciente Nombre Paciente
     * @param string $p_apellidoPaciente Apellido Paciente
     * @param string $p_epsPaciente EPS Paciente
     * @param string $p_documentoPaciente Documento Paciente
     */
    public function addPaciente($p_nombrePaciente, $p_apellidoPaciente, $p_epsPaciente, $p_documentoPaciente)
    {

        try {

            $sql = "CALL SP_Agregar_Paciente(:p_nombrePaciente, :p_apellidoPaciente, :p_epsPaciente, :p_documentoPaciente)";

            $query = $this->db->prepare($sql);

            $parameters = array(
                ':p_nombrePaciente' => $p_nombrePaciente,
                ':p_apellidoPaciente' => $p_apellidoPaciente,
                ':p_epsPaciente' => $p_epsPaciente,
                ':p_documentoPaciente' => $p_documentoPaciente
            );

        // useful for debugging: you can see the SQL behind above construction by using:
        //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

            $query->execute($parameters);

        } catch (PDOException $e) {
            
            throw new $e->getCode();

        }

    }

    /**
     * Cambie el estado actual del paciente en la base de datos
     * @param int $p_idPaciente Id del paciente
     * @param tinyint $p_estadoPaciente Estado actual del paciente
     */
    public function changeStatusPaciente($p_idPaciente, $p_estadoPaciente)
    {
        $p_estadoPaciente == 1 ? 0 : 1;

        $sql = "CALL SP_CambiarEstado_Paciente(:p_idPaciente, :p_estadoPaciente)";

        $query = $this->db->prepare($sql);

        $parameters = array(
            ':p_idPaciente' => $p_idPaciente,
            ':p_estadoPaciente' => $p_estadoPaciente
        );

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Obtener un paciente de la base de datos
     * @param int $p_idPaciente Id del paciente a buscar
     */
    public function getPaciente($p_idPaciente)
    {
        $sql = "SELECT idPaciente, nombrePaciente, apellidoPaciente, epsPaciente, documentoPaciente, estadoPaciente FROM tblPaciente WHERE idPaciente = :p_idPaciente LIMIT 1";

        $query = $this->db->prepare($sql);

        $parameters = array(':p_idPaciente' => $p_idPaciente);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return ($query->rowcount() ? $query->fetch() : false);
    }

    /**
     * Update a song in database
     * // TODO put this explaination into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $p_nombrePaciente Nombre del Paciente
     * @param string $p_apellidoPaciente Apellido del Paciente
     * @param string $p_epsPaciente EPS del Paciente
     * @param string $p_documentoPaciente Documento del Paciente
     * @param tinyint $p_estadoPaciente Estado del Paciente
     * @param int $p_idPaciente Id del Paciente que se actualizar
     * 
     */
    public function updatePaciente($p_nombrePaciente, $p_apellidoPaciente, $p_epsPaciente, $p_documentoPaciente, $p_estadoPaciente, $p_idPaciente)
    {
        $sql = "UPDATE tblPaciente SET nombrePaciente = :p_nombrePaciente, apellidoPaciente = :p_apellidoPaciente, epsPaciente = :p_epsPaciente, documentoPaciente = :p_documentoPaciente, estadoPaciente = :p_estadoPaciente WHERE idPaciente = :p_idPaciente";

        $query = $this->db->prepare($sql);

        $parameters = array(
            ':p_nombrePaciente' => $p_nombrePaciente,
            ':p_apellidoPaciente' => $p_apellidoPaciente,
            ':p_epsPaciente' => $p_epsPaciente,
            ':p_documentoPaciente' => $p_documentoPaciente,
            ':p_estadoPaciente' => $p_estadoPaciente,
            ':p_idPaciente' => $p_idPaciente
        );

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

}