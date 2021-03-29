<?php

/**
 *
 */
 if ($peticionAjax) {
   require_once "../models/modelMain.php";
 }else {
   require_once "./models/modelMain.php";
 }
class modelCentroCosto extends modelMain{

  protected function mostrarCentroCostoM(){
    $sql = "SELECT * FROM centrocosto";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function consultarCentroCostoM($id){
    $sql = "SELECT * FROM centrocosto WHERE idCentroCosto=$id";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function agregarCentroCostoM($datos){
    $rpta = false;
    
    if (empty($datos['asociado']) || $datos['asociado'] == 0) {
      $sql ="INSERT INTO centrocosto(idCentroCosto,centroCosto,descripcion,estado) VALUES(?,?,?,?)";
  
      $guardar = modelMain::conectarBD()->prepare($sql);
      $guardar->bindParam(1 ,$datos['id']);
      $guardar->bindParam(2 ,$datos['centroCosto']);
      $guardar->bindParam(3 ,$datos['descripcion']);
      $guardar->bindParam(4 ,$datos['estado']);
    }else{
      $sql ="INSERT INTO centrocosto(idCentroCosto,centroCosto,descripcion,idAsociado_fk,estado) VALUES(?,?,?,?,?)";
  
      $guardar = modelMain::conectarBD()->prepare($sql);
      $guardar->bindParam(1 ,$datos['id']);
      $guardar->bindParam(2 ,$datos['centroCosto']);
      $guardar->bindParam(3 ,$datos['descripcion']);
      $guardar->bindParam(4 ,$datos['asociado']);
      $guardar->bindParam(5 ,$datos['estado']);
    }
    
    
    $rpta = $guardar->execute();

    return $rpta;
  }

  protected function modificarCentroCostoM($datos){
    $rpta = false;
    if (empty($datos['asociado']) || $datos['asociado'] == 0) {
      $sql ="UPDATE centrocosto SET centroCosto=:centroCosto, descripcion=:descripcion WHERE idCentroCosto=:id";

      $modificar = modelMain::conectarBD()->prepare($sql);
      $modificar->bindParam(':centroCosto' ,$datos['centroCosto']);
      $modificar->bindParam(':descripcion' ,$datos['descripcion']);
      $modificar->bindParam('id' ,$datos['id']);
    }else{
      $sql ="UPDATE centrocosto SET centroCosto=:centroCosto, descripcion=:descripcion,idAsociado_fk=:asociado WHERE idCentroCosto=:id";

      $modificar = modelMain::conectarBD()->prepare($sql);
      $modificar->bindParam(':centroCosto' ,$datos['centroCosto']);
      $modificar->bindParam(':descripcion' ,$datos['descripcion']);
      $modificar->bindParam(':asociado' ,$datos['asociado']);
      $modificar->bindParam('id' ,$datos['id']);
    }
    $rpta = $modificar->execute();
    
    return $rpta;
  }

  protected function inactivarCentroCostoM($datos){
    $rpta = false;
    $sql ="UPDATE centrocosto SET estado=:estado WHERE idCentroCosto=:id";
  
    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':estado' ,$datos['estado']);
    $modificar->bindParam(':id' ,$datos['id']);
    
    
    $rpta = $modificar->execute();
  
    return $rpta;
  }
  

}
