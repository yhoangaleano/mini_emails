<?php

namespace Mini\Model;

use Mini\Core\Model;
use Mini\Model\Log;
use Mini\Libs\Helper;
use \Exception, \PDOException;

class User extends Model
{
    /**
     * Obtener todos los usuarios de la base de datos
     */
    public function getAllUsers()
    {
        $sql = "SELECT idUsuario, usuario, contrasena, nombreCompleto, correoElectronico, estado, rol, codigo, fechaRecuperacion FROM tblUsuario";

        try {

            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll();

        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;

        } catch (Exception $e) {
            
            $logModel = new Log();
            $sql = Helper::debugPDO($sql);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;
        }        
    }

    /**
     * Obtener todos los usuarios de la base de datos filtrado por estado
     * 
     * @param tinyint $p_estado Estado de los usuarios a mostrar
     */
    public function getAllUsersByStatus($p_estado)
    {

        $sql = "SELECT idUsuario, usuario, contrasena, nombreCompleto, correoElectronico, estado, rol, codigo, fechaRecuperacion FROM tblUsuario WHERE estado = :p_estado";
        $parameters = array(':p_estado' => $p_estado);

        try {

            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            return $query->fetchAll();

        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;

        } catch (Exception $e) {
            
            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Agregar un usuario a la base de datos
     * 
     * 
     * Por favor, tenga en cuenta que no es necesario "limpiar" 
     * nuestra entrada de ninguna manera. Con PDO todas las 
     * entradas se escapan correctamente automáticamente. 
     * Tampoco usamos strip_tags() etc. por lo que mantenemos 
     * la entrada 100% original (para que sea posible para guardar 
     * HTML y JS en la base de datos, que es un caso de uso válido). 
     * Los datos sólo se limpiarán cuando se publiquen en las vistas 
     * (ver las vistas para más información).
     * 
     * 
     * @param string $p_usuario usuario con el cual ingresara
     * @param string $p_contrasena contraseña con la cual ingresara
     * @param string $p_nombreCompleto Nombre Completo del usuario
     * @param string $p_correoElectronico correo electrónico con al cual se le enviara la contraseña en caso de olvidarse
     */
    public function addUser($p_usuario, $p_contrasena, $p_nombreCompleto, $p_correoElectronico)
    {
        $sql = "INSERT INTO tblUsuario(usuario, contrasena, nombreCompleto, correoElectronico) VALUES(:p_usuario, :p_contrasena, :p_nombreCompleto, :p_correoElectronico)";
        $parameters = array(
            ':p_usuario' => $p_usuario,
            ':p_contrasena' => $p_contrasena,
            ':p_nombreCompleto' => $p_nombreCompleto,
            ':p_correoElectronico' => $p_correoElectronico
        );

        try {

            $query = $this->db->prepare($sql);
            return ($query->execute($parameters) ? $this->db->lastInsertId() : false);

        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;

        } catch (Exception $e) {
            
            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Cambia el estado actual del usuaruo en la base de datos
     * @param int $p_idUsuario Id del Usuario
     * @param tinyint $p_estado Estado actual del Usuario
     */
    public function changeUserStatus($p_idUsuario, $p_estado)
    {
        $p_estado == 1 ? 0 : 1;
        $sql = "UPDATE tblUsuario SET estado = :p_estado WHERE idUsuario = :p_idUsuario";
        $parameters = array(
            ':p_idUsuario' => $p_idUsuario,
            ':p_estado' => $p_estado
        );

        try {

            $query = $this->db->prepare($sql);
            return $query->execute($parameters);

        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;

        } catch (Exception $e) {
            
            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener un usuario de la base de datos
     * @param int $p_idUsuario Id del usuario a buscar
     */
    public function getUser($p_idUsuario)
    {
        $sql = "SELECT idUsuario, usuario, contrasena, nombreCompleto, correoElectronico, estado, rol, codigo, fechaRecuperacion FROM tblUsuario WHERE idUsuario = :p_idUsuario LIMIT 1";
        $parameters = array(':p_idUsuario' => $p_idUsuario);

        try {

            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            return ($query->rowcount() ? $query->fetch() : false);

        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;

        } catch (Exception $e) {
            
            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Actualizar un usuario
     * @param string $p_usuario Usuario 
     * @param string $p_nombreCompleto Nombre Completo 
     * @param string $p_correoElectronico Correo Electrónico
     * @param tinyint $p_estado Estado del usuario
     * @param string $p_rol Rol del usuario
     * @param int $p_idUsuario Id del usuario que se actualizara
     * 
     */
    public function updateUser($p_usuario, $p_nombreCompleto, $p_correoElectronico, $p_estado, $p_rol, $p_idUsuario)
    {
        $sql = "UPDATE tblUsuario SET usuario = :p_usuario, nombreCompleto = :p_nombreCompleto, correoElectronico = :p_correoElectronico, estado = :p_estado, rol = :p_rol WHERE idUsuario = :p_idUsuario";
        $parameters = array(
            ':p_usuario' => $p_usuario,
            ':p_nombreCompleto' => $p_nombreCompleto,
            ':p_correoElectronico' => $p_correoElectronico,
            ':p_estado' => $p_estado,
            ':p_rol' => $p_rol,
            ':p_idUsuario' => $p_idUsuario
        );

        try {

            $query = $this->db->prepare($sql);
            return $query->execute($parameters);

        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;

        } catch (Exception $e) {
            
            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener una persona con su usuario
     * @param string $p_correoElectronico
     */
    public function getUserWithUser($p_usuario)
    {
        $sql = "SELECT idUsuario, usuario, contrasena, nombreCompleto, correoElectronico, estado, rol, codigo, fechaRecuperacion FROM tblUsuario WHERE usuario = :p_usuario LIMIT 1";
        $parameters = array(':p_usuario' => $p_usuario);

        try {

            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            return ($query->rowcount() ? $query->fetch() : false);

        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;

        } catch (Exception $e) {
            
            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener una persona con correo Electronico
     * @param string $p_correoElectronico
     */
    public function getUserWithEmail($p_correoElectronico)
    {
        $sql = "SELECT idUsuario, usuario, contrasena, nombreCompleto, correoElectronico, estado, rol, codigo, fechaRecuperacion FROM tblUsuario WHERE correoElectronico = :p_correoElectronico LIMIT 1";
        $parameters = array(':p_correoElectronico' => $p_correoElectronico);

        try {

            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            return ($query->rowcount() ? $query->fetch() : false);

        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;

        } catch (Exception $e) {
            
            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener una persona por el código generado para el cambio de contraseña
     * @param string $p_codigo
     */
    public function getUserWithCode($p_codigo)
    {
        $sql = "SELECT idUsuario, usuario, contrasena, nombreCompleto, correoElectronico, estado, rol, codigo, fechaRecuperacion FROM tblUsuario WHERE codigo = :p_codigo LIMIT 1";
        $parameters = array(':p_codigo' => $p_codigo);

        try {

            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            return ($query->rowcount() ? $query->fetch() : false);

        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;

        } catch (Exception $e) {
            
            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Cambiar la contraseña y actualizar el campo para verificar al entrar
     * @param string $p_correoElectronico Correo Electrónico
     * @param string $p_codigo Código que se enviara al correo electronico y luego se validara
     * @param string $p_fechaRecuperacion Fecha para validar que el código este valido (24 horas)
     */
    public function recoverPassword($p_correoElectronico, $p_codigo, $p_fechaRecuperacion)
    {
        $sql = "UPDATE tblUsuario SET codigo = :p_codigo, fechaRecuperacion = :p_fechaRecuperacion WHERE correoElectronico = :p_correoElectronico";
        $parameters = array(
            ':p_correoElectronico' => $p_correoElectronico,
            ':p_codigo' => $p_codigo,
            ':p_fechaRecuperacion' => $p_fechaRecuperacion
        );

        try {

            $query = $this->db->prepare($sql);
            return $query->execute($parameters);

        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;

        } catch (Exception $e) {
            
            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Cambiar la contraseña desde la recuperación de la cuenta
     * @param string $p_idUsuario Id Usuario
     * @param string $p_contrasena Contraseña
     */
    public function updatePasswordFromRecover($p_idUsuario, $p_contrasena)
    {
        $sql = "UPDATE tblUsuario SET contrasena = :p_contrasena, codigo = NULL, fechaRecuperacion = NULL WHERE idUsuario = :p_idUsuario";
        $parameters = array(
            ':p_contrasena' => $p_contrasena,
            ':p_idUsuario' => $p_idUsuario
        );

        try {

            $query = $this->db->prepare($sql);
            return $query->execute($parameters);

        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;

        } catch (Exception $e) {
            
            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Cambiar la contraseña desde el perfil
     * @param string $p_idUsuario Id Usuario
     * @param string $p_contrasena Contraseña
     */
    public function updatePassword($p_idUsuario, $p_contrasena)
    {
        $sql = "UPDATE tblUsuario SET contrasena = :p_contrasena WHERE idUsuario = :p_idUsuario";
        $parameters = array(
            ':p_contrasena' => $p_contrasena,
            ':p_idUsuario' => $p_idUsuario
        );

        try {

            $query = $this->db->prepare($sql);
            return $query->execute($parameters);

        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;

        } catch (Exception $e) {
            
            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;
        }
    }

    /**
     * Cambiar la contraseña desde el perfil
     * @param string $p_idUsuario Id Usuario
     * @param string $p_rol Rol
     */
    public function updateRole($p_idUsuario, $p_rol)
    {
        $sql = "UPDATE tblUsuario SET rol = :p_rol WHERE idUsuario = :p_idUsuario";
        $parameters = array(
            ':p_idUsuario' => $p_idUsuario,
            ':p_rol' => $p_contrasena
        );

        try {

            $query = $this->db->prepare($sql);
            return $query->execute($parameters);

        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;

        } catch (Exception $e) {
            
            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'User', $e->getCode(), $e->getMessage());
            return false;
        }
    }

}
