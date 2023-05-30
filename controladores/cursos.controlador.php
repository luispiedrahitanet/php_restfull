<?php

    class ControladorCursos{

        public function index(){

            /* =====================================
              Validando las Credenciales del cliente
            ========================================*/

            // Verificamos si se enviaron datos por el AUTH del http
            if( isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) ){
                
                $clientes = ModeloClientes::index('clientes');  // consultamos los clientes en la db
                
                // recorremos los clientes para comprobar si las credenciales coinciden
                foreach ($clientes as $key => $value) {
                    
                    if( $_SERVER['PHP_AUTH_USER'].':'.$_SERVER['PHP_AUTH_PW'] == $value['id_cliente'].':'.$value['llave_secreta'] ){
                        
                        $cursos = ModeloCursos::index('cursos');    // enviamos el nombre de la tabla que queremos que consulte
            
                        echo json_encode( ["total_registros" => count($cursos), "detalle" => $cursos], true );
                        return;
                    }

                }

            }
            
        }

        public function create(){
            echo json_encode( ["detalle" => "Estas en la vista de Cursos - Create"], true );
            return;
        }

        public function update( $id ){
            echo json_encode( ["detalle" => "Se ha actualizado el curso con id: $id"], true );
            return;
        }

        public function show( $id ){
            echo json_encode( ["detalle" => "Mostrando información del curso con id: $id"], true );
            return;
        }

        public function delete( $id ){
            echo json_encode( ["detalle" => "Eliminado el curso con id: $id"], true );
        }

    }

?>