<?php

/**
 *
 */
 if ($peticionAjax) {
   require_once "../models/modelMain.php";
 }else {
   require_once "./models/modelMain.php";
 }
class modelUsuario extends modelMain{

  protected function mostrarUsuarioM(){
    $sql = "SELECT * FROM usuario";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    /*while ($row = $consultar->fetch(PDO::FETCH_OBJ)) {
      echo modelMain::decryption($row->clave);
    }*/
    return $consultar;
  }

  protected function consultarUsuarioM($id){
    $sql = "SELECT * FROM usuario WHERE idUsuario=$id";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function agregarUsuarioM($datos){
    $rpta = false;
    $sql ="INSERT INTO usuario(nombre,apellido,tipoId,nIdentificacion,usuario,clave,estado) VALUES(?,?,?,?,?,?,?)";
    $encrypt = modelMain::encryption($datos['clave']);
    $guardar = modelMain::conectarBD()->prepare($sql);
    $guardar->bindParam(1 ,$datos['nombre']);
    $guardar->bindParam(2 ,$datos['apellido']);
    $guardar->bindParam(3 ,$datos['tipoId']);
    $guardar->bindParam(4 ,$datos['identificacion']);
    $guardar->bindParam(5 ,$datos['usuario']);
    $guardar->bindParam(6 ,$encrypt);
    $guardar->bindParam(7 ,$datos['estado']);
    
    $rpta = $guardar->execute();

    return $rpta;
  }

  protected function modificarUsuarioM($datos){
    $rpta = false;
    
    $sql ="UPDATE usuario SET nombre=:nombre, apellido=:apellido, tipoId=:tipo, nIdentificacion=:nid WHERE idUsuario=:id";

    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':nombre' ,$datos['nombre']);
    $modificar->bindParam(':apellido' ,$datos['apellido']);
    $modificar->bindParam(':tipo' ,$datos['tipoId']);
    $modificar->bindParam(':nid' ,$datos['identificacion']);
    $modificar->bindParam('id' ,$datos['id']);
    
    $rpta = $modificar->execute();
    
    return $rpta;
  }

  protected function inactivarUsuarioM($datos){
    $rpta = false;
    $sql ="UPDATE usuario SET estado=:estado WHERE idUsuario=:id";
  
    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':estado' ,$datos['estado']);
    $modificar->bindParam(':id' ,$datos['id']);
    
    
    $rpta = $modificar->execute();
  
    return $rpta;
  }
  
  protected function cambiarClaveUsuarioM($datos){
    $rpta = false;
    $sql ="UPDATE usuario SET clave=? WHERE idUsuario=?";
    $encrypt = modelMain::encryption($datos['clave']);
    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(1 ,$encrypt);
    $modificar->bindParam(2 ,$datos['id']);
    
    $rpta = $modificar->execute();
 
    return $rpta;
  }

}
