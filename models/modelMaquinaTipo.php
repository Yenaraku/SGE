<?php

/**
 *
 */
 if ($peticionAjax) {
   require_once "../models/modelMain.php";
 }else {
   require_once "./models/modelMain.php";
 }
class modelMaquinaTipo extends modelMain{

  protected function mostrarMaquinaTipoM(){
    $sql = "SELECT * FROM maquina_tipo";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function consultarMaquinaTipoM($id){
    $sql = "SELECT * FROM maquina_tipo WHERE idMaquinaTipo=$id";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function agregarMaquinaTipoM($datos){
    $rpta = false;
    $sql ="INSERT INTO maquina_tipo(maquinaTipo,descripcion,estado) VALUES(?,?,?)";
  
    $guardar = modelMain::conectarBD()->prepare($sql);
    $guardar->bindParam(1 ,$datos['maquinaTipo']);
    $guardar->bindParam(2 ,$datos['descripcion']);
    $guardar->bindParam(3 ,$datos['estado']);
    
    $rpta = $guardar->execute();

    return $rpta;
  }

  protected function modificarMaquinaTipoM($datos){
    $rpta = false;
    
    $sql ="UPDATE maquina_tipo SET maquinaTipo=:maquinaTipo, descripcion=:descripcion WHERE idMaquinaTipo=:id";

    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':maquinaTipo' ,$datos['maquinaTipo']);
    $modificar->bindParam(':descripcion' ,$datos['descripcion']);
    $modificar->bindParam('id' ,$datos['id']);
    
    $rpta = $modificar->execute();
    
    return $rpta;
  }

  protected function inactivarMaquinaTipoM($datos){
    $rpta = false;
    $sql ="UPDATE maquina_tipo SET estado=:estado WHERE idMaquinaTipo=:id";
  
    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':estado' ,$datos['estado']);
    $modificar->bindParam(':id' ,$datos['id']);
    
    
    $rpta = $modificar->execute();
  
    return $rpta;
  }
  

}
