<?php

namespace Mini\Model;

use Mini\Core\Model;
use \Exception, \PDOException;

class Log extends Model
{

    /**
     * Obtener todos los logs de la base de datos
     */
    public function getAllLogs()
    {
        try{

            $sql = "SELECT idLog, sql, modelo, codigoError, mensajeError, fecha FROM tblLog";
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll();

        }catch (PDOException $ex) {
            return false;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Agregar un log a la base de datos
     * 
     * 
     * Por favor, tenga en cuenta que no es necesario "limpiar" 
     * nuestra entrada de ninguna manera. 
     * Con PDO todas las entradas se escapan correctamente automáticamente. 
     * Tampoco usamos strip_tags() etc. por lo que mantenemos la 
     * entrada 100% original (para que sea posible para guardar HTML y 
     * JS en la base de datos, que es un caso de uso válido). 
     * Los datos sólo se limpiarán cuando se publiquen en 
     * las vistas (ver las vistas para más información).
     * 
     * 
     * @param string $p_sql SQL que se ejecuto y genero el error
     * @param string $p_modelo nombre del modelo donde se genero el error
     * @param string $p_codigoError codigo del error generado
     * @param string $p_mensajeError mensaje de error que se genero
     */
    public function addLog($p_sql, $p_modelo, $p_codigoError, $p_mensajeError)
    {

        try {

            $sql = "INSERT INTO tblLog(sql, modelo, codigoError, mensajeError) VALUES (:p_sql, :p_modelo, :p_codigoError, :p_mensajeError)";

            $query = $this->db->prepare($sql);

            $parameters = array(
                ':p_sql' => $p_sql,
                ':p_modelo' => $p_modelo,
                ':p_codigoError' => $p_codigoError,
                ':p_mensajeError' => $p_mensajeError
            );
        
            return ($query->execute($parameters) ? $this->db->lastInsertId() : false);

        }catch (PDOException $ex) {
            return false;
        } catch (Exception $ex) {
            return false;
        }

    }

    /**
     * Obtener un usuario de la base de datos
     * @param int $p_idLog Id del log a buscar
     */
    public function getLog($p_idLog)
    {

        try {

            $sql = "SELECT idLog, sql, modelo, codigoError, mensajeError, fecha FROM tblLog WHERE idLog = :p_idLog LIMIT 1";
            $query = $this->db->prepare($sql);
            $parameters = array(':p_idLog' => $p_idLog);
            $query->execute($parameters);
            return ($query->rowcount() ? $query->fetch() : false);

        }catch (PDOException $ex) {
            return false;
        } catch (Exception $ex) {
            return false;
        }
    }

}
