<?php

include_once 'conexion.php';

class ModeloClientes{

    static public function index($tabla){
        
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();

        return $stmt->fetchAll();

        $stmt->close();
        $stmt = null;

    }

    static public function create( $tabla, $datos ){
     
        $stmt = Conexion::conectar()->prepare("INSERT INTO clientes (nombre, apellido, email, id_cliente, llave_secreta, create_at, updated_at) 
                                    VALUES(:nombre, :apellido, :email, :id_cliente, :llave_secreta, :create_at, :updated_at)");
        
        $stmt->bindParam( ':nombre', $datos['nombre'], PDO::PARAM_STR );
        $stmt->bindParam( ':apellido', $datos['apellido'], PDO::PARAM_STR );
        $stmt->bindParam( ':email', $datos['email'], PDO::PARAM_STR );
        $stmt->bindParam( ':id_cliente', $datos['id_cliente'], PDO::PARAM_STR );
        $stmt->bindParam( ':llave_secreta', $datos['llave_secreta'], PDO::PARAM_STR );
        $stmt->bindParam( ':create_at', $datos['create_at'], PDO::PARAM_STR );
        $stmt->bindParam( ':updated_at', $datos['updated_at'], PDO::PARAM_STR );

        if( $stmt->execute() ){
            return 'ok';
        } else {
            return json_encode( ['detalle' => Conexion::conectar()->errorInfo()], true );
        }

        $stmt->close();
        $stmt = null;
    }

}



?>