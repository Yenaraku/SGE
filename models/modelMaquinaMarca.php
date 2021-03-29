<?php

/**
 *
 */
 if ($peticionAjax) {
   require_once "../models/modelMain.php";
 }else {
   require_once "./models/modelMain.php";
 }
class modelMaquinaMarca extends modelMain{

  protected function mostrarMaquinaMarcaM(){
    $sql = "SELECT * FROM maquina_marca";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function consultarMaquinaMarcaM($id){
    $sql = "SELECT * FROM maquina_marca WHERE idMaquinaMarca=$id";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function agregarMaquinaMarcaM($datos){
    $rpta = false;
    $sql ="INSERT INTO maquina_marca(marca,descripcion,etiqueta,estado) VALUES(?,?,?,?)";
  
    $guardar = modelMain::conectarBD()->prepare($sql);
    $guardar->bindParam(1 ,$datos['maquinaMarca']);
    $guardar->bindParam(2 ,$datos['descripcion']);
    $guardar->bindParam(3 ,$datos['etiqueta']);
    $guardar->bindParam(4 ,$datos['estado']);
    
    $rpta = $guardar->execute();

    return $rpta;
  }

  protected function modificarMaquinaMarcaM($datos){
    $rpta = false;
    
    $sql ="UPDATE maquina_marca SET marca=:maquinaMarca, descripcion=:descripcion, etiqueta=:etiqueta WHERE idMaquinaMarca=:id";
    
    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':maquinaMarca' ,$datos['maquinaMarca']);
    $modificar->bindParam(':descripcion' ,$datos['descripcion']);
    $modificar->bindParam(':etiqueta' ,$datos['etiqueta']);
    $modificar->bindParam(':id' ,$datos['id']);
    
    $rpta = $modificar->execute();
    
    return $rpta;
  }

  protected function inactivarMaquinaMarcaM($datos){
    $rpta = false;
    $sql ="UPDATE maquina_marca SET estado=:estado WHERE idMaquinaMarca=:id";
  
    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':estado' ,$datos['estado']);
    $modificar->bindParam(':id' ,$datos['id']);
    
    
    $rpta = $modificar->execute();
  
    return $rpta;
  }
  

}
