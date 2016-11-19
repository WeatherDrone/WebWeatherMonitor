<?php

require 'mysql_login.php';

class Usuario {
	function __construct()
    {
    }
	
	public static function getUsers(){
		$query = "Select user,pass from users";
		try {
			$pdo = new PDO(
                'mysql:dbname=' . DATABASE .
                ';host=' . HOSTNAME .
                ';port:63343;',
                USERNAME,
                PASSWORD,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$command = $pdo->prepare($query);
			$command->execute();
		
            return $command->fetchAll(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e){
			return false;
		}
	}
	
	public static function getPermission(){
		$query = "Select permiso from users";
		try {
			$command = connect_mysql::getInstance()->getDB()->prepare($query);
			$command->execute();

            return $command->fetchAll(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e){
			return false;
		}
	}
	
	public static function getUserbyID($id){
		$query = "Select user, permiso from users where num_doc = ?";
		try {
			$command = connect_mysql::getInstance()->getDB()->prepare($query);
			$command->execute(array($id));

			$row = $command->fetch(PDO::FETCH_ASSOC);
            return $row;
		}
		catch (PDOException $e){
			return -1;
		}
	}
	
	public static function setPermit($username, $permisos){
		// Creando consulta UPDATE
		date_default_timezone_set('America/Monterrey');
		$date = date('Y-m-d H:i:s');
        $consulta = "UPDATE users" .
            " SET permiso=?, date_log=? WHERE user=?";

        // Preparar la sentencia
        $cmd = connect_mysql::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($permisos, $date, $username));

        return $cmd;
	}
	
	public static function setNewUser($username, $password, $permit){
		date_default_timezone_set('America/Monterrey');
		$date = date('Y-m-d H:i:s');
		$consulta = "Insert into Users (user,pass,permiso,date_log) Values(?,?,?,?)";
		
		$cmd = connect_mysql::getInstance()->getDb()->prepare($consulta);
		$cmd->execute(array($username, $password, $permit, $date));
		
		return $cmd;
	}
	
	public static function deleteUser($numdoc)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM Users WHERE num_doc=?";

        // Preparar la sentencia
        $sentencia = connect_mysql::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($numdoc));
    }

	public static function setData($datos){
		/* date_default_timezone_set('America/Monterrey');
		$date = date('Y-m-d H:i:s'); */
		$consulta = "Insert into Prueba (data) Values(?)";
		
		$pdo = new PDO(
                'mysql:dbname=' . DATABASE .
                ';host=' . HOSTNAME .
                ';port:63343;',
                USERNAME,
                PASSWORD,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
		
		
		$cmd = $pdo->prepare($consulta);
		$cmd->execute(array($datos));
		
		return $cmd;
	}
	
}

?>