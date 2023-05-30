<?php

    class ControladorClientes{

        public function index(){
            echo json_encode( ['detalle' => 'Estas en la vista de Registro - index'], true );
            return;
        }

        public function create($datos){

            /* =========================================
                       Validando Nombre 
            ========================================= */
            if( !preg_match( '/^[A-Za-z\s]+$/', $datos['nombre'] ) ) {
                echo json_encode( ['detalle' => 'El nombre es debe ser solo texo'], true );
                return;
            }

            /* =========================================
                       Validando Apellido
            ========================================== */
            if( !preg_match( '/^[A-Za-z\s]+$/', $datos['apellido'] ) ){
                echo json_encode( ['detalle' => 'El apellido debe ser solo texto'], true );
                return;
            }

            /* ========================================= 
                           Validando Email 
            ========================================= */
            if( !preg_match( '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $datos['email'] ) ){
                echo json_encode( ['detalle' => 'Error en el campo email'], true );
                return;
            }
            
            /* =========================================
                          Email repetido
            ========================================= */
            $clientes = ModeloClientes::index('clientes');     // enviamos al modelo el nombre de la tabla
            foreach ($clientes as $key => $value) {
                if( $value['email'] == $datos['email'] ){
                    echo json_encode(['detalle' => 'El email está repetido'], true);
                    return;
                }
            }
        
            /* ========================================
                 Generar credenciales del cliente
            ========================================== */
            
            // Concatenamos datos del nuevo cliente y la LLAVE_BLOBAL para generar las credenciales
            $id_cliente = password_hash( $datos['nombre'].$datos['apellido'].$datos['email'].LLAVE_GLOBAL, PASSWORD_BCRYPT );
            $llave_secreta = password_hash( $datos['email'].$datos['apellido'].$datos['nombre'].LLAVE_GLOBAL, PASSWORD_BCRYPT );

            $datos = [
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'email' => $datos['email'],
                'id_cliente' => $id_cliente,
                'llave_secreta' => $llave_secreta,
                'create_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ];

            $create = ModeloClientes::create('clentes', $datos);

            if( $create == 'ok' ){
                echo json_encode([
                    'detalle'      => 'Se generaron las credenciales exitosamente',
                    'credenciales' => [
                        'id_cliente'    => $id_cliente,
                        'llave_secreta' => $llave_secreta
                    ]
                ]);
                return;
            } else {
                echo $create;
                return;
            }

        }

    }

?>