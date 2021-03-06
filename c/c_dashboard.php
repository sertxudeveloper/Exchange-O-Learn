<?php

class c_dashboard {

    public function obtenerAlumnos() {
        $dashboard = new dashboard();
        $pdo = $dashboard->obtenerAlumnos();
        $array = $pdo->fetchAll(PDO::FETCH_ASSOC);
        
        array_walk($array, function (&$elemento, $clave){
            
            $acciones = '<div class="btn-group" role="group"><button type="button" onClick="editarUsuario(' . $elemento['id'] . ')" class="btn btn-primary">Editar</button>';
            
            if($elemento['status'] == 0){
                $acciones .= '<button type="button" onClick="bloquearUsuario(' . $elemento['id'] . ')" class="btn btn-warning">Bloquear</button>';
            }elseif($elemento['status'] == 1){
                $acciones .= '<button type="button" onClick="desbloquearUsuario(' . $elemento['id'] . ')" class="btn btn-success">Desbloquear</button>';
            }
            
            $acciones .= '<button type="button" onClick="borrarUsuario(' . $elemento['id'] . ')" class="btn btn-danger">Eliminar</button></div>';
            
            if($elemento['status'] == 0){
                $elemento['status'] = 'Activo';
            }elseif($elemento['status'] == 1){
                $elemento['status'] = 'Bloqueado';
            }
            
            $elemento['acciones'] = $acciones;
        });
        
        return json_encode(array(
            "data" => $array
        ));
    }

    public function obtenerProfesores() {
        $dashboard = new dashboard();
        $pdo = $dashboard->obtenerProfesores();
        $array = $pdo->fetchAll(PDO::FETCH_ASSOC);
        
        array_walk($array, function (&$elemento, $clave){

            $acciones = '<div class="btn-group" role="group"><button type="button" onClick="editarUsuario(' . $elemento['id'] . ')" class="btn btn-primary">Editar</button>';
            
            if($elemento['status'] == 0){
                $acciones .= '<button type="button" onClick="bloquearUsuario(' . $elemento['id'] . ')" class="btn btn-warning">Bloquear</button>';
            }elseif($elemento['status'] == 1){
                $acciones .= '<button type="button" onClick="desbloquearUsuario(' . $elemento['id'] . ')" class="btn btn-success">Desbloquear</button>';
            }
            
            $acciones .= '<button type="button" onClick="borrarUsuario(' . $elemento['id'] . ')" class="btn btn-danger">Eliminar</button></div>';
            
            if($elemento['status'] == 0){
                $elemento['status'] = 'Activo';
            }elseif($elemento['status'] == 1){
                $elemento['status'] = 'Bloqueado';
            }
            
            $elemento['acciones'] = $acciones;
        });
        
        return json_encode(array(
            "data" => $array
        ));
    }

    public function obtenerMensajes() {
        $dashboard = new dashboard();
        $pdo = $dashboard->obtenerMensajes();
        $array = $pdo->fetchAll(PDO::FETCH_ASSOC);
        
        array_walk($array, function (&$elemento, $clave){
            
            if ( substr($elemento['text'], 0, 3) === "em_" ) {
                $elemento['text'] = '<i style="font-size: 35px;" class="em ' . $elemento['text'] . '"></i>';
            }
            
            if ( substr($elemento['text'], 0, 3) === "ba_" ) {
                $elemento['text'] = '<i style="font-size: 100px;" class="em ' . $elemento['text'] . '"></i>';
            }
            
            if ( substr($elemento['text'], 0, 1) === "<" && substr($elemento['text'], 0, 9) !== "<i style=" ) {
                $elemento['text'] = '<code>' .  htmlspecialchars($elemento['text']) . '</code>';
            }

            $time = date('d/m/Y H:m', $elemento['time']);

            $acciones = '<div class="btn-group" role="group" aria-label="...">
                            <button type="button" onClick="borrarMensaje(' . $elemento['id'] . ')" class="btn btn-danger">Eliminar</button>
                        </div>';
            
            $elemento['time'] = $time;
            $elemento['acciones'] = $acciones;
        });
        
        return json_encode(array(
            "data" => $array
        ));
    }

    public function obtenerEventos() {
        $dashboard = new dashboard();
        $pdo = $dashboard->obtenerEventos();
        $array = $pdo->fetchAll(PDO::FETCH_ASSOC);
        
        array_walk($array, function (&$elemento, $clave){

            $acciones = '<div class="btn-group" role="group">
                            <div class="btn-group" role="group">
                                <button type="button" onClick="editarEvento(' . $elemento['id'] . ')" class="btn btn-primary">Editar</button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" onClick="borrarEvento(' . $elemento['id'] . ')" class="btn btn-danger">Eliminar</button>
                            </div>
                        </div>';
            
            $elemento['acciones'] = $acciones;
        });
        
        return json_encode(array(
            "data" => $array
        ));
    }
    
    public function crearUsuario($post_username, $post_password, $post_name, $post_surname, $post_type){
        $dashboard = new dashboard();
        
        $username = $this->sanitizeString($post_username);
        $password = hash('sha512', $this->sanitizeString($post_password));
        $name     = $this->sanitizeString($post_name);
        $surname  = $this->sanitizeString($post_surname);
        $type     = $this->sanitizeString($post_type);

        return $dashboard->crearUsuario($username, $password, $name, $surname, $type);
    }
    
    public function borrarUsuario($post_id) {
        $dashboard = new dashboard();
        
        $id = $this->sanitizeString($post_id);
        
        return $dashboard->borrarUsuario($id);
    }
    
    public function borrarMensaje($post_id) {
        $dashboard = new dashboard();
        
        $id = $this->sanitizeString($post_id);
        
        return $dashboard->borrarMensaje($id);
    }
    
    public function borrarMensajes() {
        $dashboard = new dashboard();
        
        return $dashboard->borrarMensajes();
    }
    
    public function resetear() {
        $dashboard = new dashboard();
        
        return $dashboard->resetear();
    }
    
    private function sanitizeString($string){
        return filter_var($string, FILTER_SANITIZE_STRING);
    }


}