<?php

    // capturamos la ruta
    $arrayRutas = explode('/', $_SERVER['REQUEST_URI']);

    // echo ($_SERVER['REQUEST_URI']) . "\n";
    // echo ($_SERVER['REQUEST_METHOD']) . "\n";
    // print_r($arrayRutas);
    


    // Eliminamos los indices que estan vacíos en el array
    $arrayRutas = array_filter($arrayRutas);



    // Evaluamos si está en el directorio raiz
    if ( count($arrayRutas) == 1) {        

        /*=======================================================
          Cuando no se le hace petición a la API
        =========================================================*/
        
        echo json_encode(["detalle" => "No encontrado"], true);
        return; 
        
    } else {
        
        /*=======================================================
          Cuando le pasamos solo un indice al array $arrayRutas
        =========================================================*/
        
        if( count($arrayRutas) == 2 ){

            /* ===========================================
                          Petición a CURSOS 
             ============================================*/
            if($arrayRutas[2] == "cursos" ){

                if( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' ){

                    $cursos = new ControladorCursos();
                    $cursos->create();

                }else if( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET' ){
                    
                    $cursos = new ControladorCursos();
                    $cursos->index();
                
                }
                
            } 
            
            /* =========================================== 
                       Petición a REGISTRO 
            =============================================*/
            if($arrayRutas[2] == "registro" ){
                
                if( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET' ){
                    $clientes = new ControladorClientes();
                    $clientes->index();
                }else if( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' ){
                                        
                    // recogiendo los datos enviados por 'form-encode'
                    if( !isset($_POST['nombre']) || !isset($_POST['apellido']) || !isset($_POST['email']) ){ 
                        echo json_encode( ['detalle' => 'Datos incompletos'], true );
                        return;
                     }
                    $datos = [
                        'nombre' => $_POST['nombre'],
                        'apellido' => $_POST['apellido'],
                        'email' => $_POST['email']
                    ];
                    
                    $clientes = new ControladorClientes();
                    $clientes->create($datos);
                }

            }



        } else if( count($arrayRutas) == 3 ){
            
            /* =========================================== 
                   Petición a CURSOS con parámetro 
             ==========================================*/
            if( $arrayRutas[2] == "cursos" && is_numeric($arrayRutas[3]) ){

                if( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT' ){
                    $cursosActualizar = new ControladorCursos();
                    $cursosActualizar->update( $arrayRutas[3] );
                }else if( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET' ){
                    $cursos = new ControladorCursos();
                    $cursos->show( $arrayRutas[3] );
                }else if( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE' ){
                    $cursosEliminar = new ControladorCursos();
                    $cursosEliminar->delete( $arrayRutas[3] );
                }
                
            } 

        }

    }







    // $json = array(
    //     "detalle" => "No encontrado"
    // );

    // echo json_encode($json, true);
?>