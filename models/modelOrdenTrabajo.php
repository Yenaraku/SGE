<?php

/**
 *
 */
 if ($peticionAjax) {
   require_once "../models/modelMain.php";
 }else {
   require_once "./models/modelMain.php";
 }
class modelOrdenTrabajo extends modelMain{

  protected function mostrarOrdenTrabajoM(){
    $sql = "SELECT * FROM orden_trabajo";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function consultarOrdenTrabajoM($id){
    $sql = "SELECT * FROM orden_trabajo WHERE idOrdenTrabajo=$id";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function agregarOrdenTrabajoM($datos){
    $rpta = false;
    $sql ="INSERT INTO orden_trabajo(ordenTrabajo,descripcion,estado) VALUES(?,?,?)";
  
    $guardar = modelMain::conectarBD()->prepare($sql);
    $guardar->bindParam(1 ,$datos['ordenTrabajo']);
    $guardar->bindParam(2 ,$datos['descripcion']);
    $guardar->bindParam(3 ,$datos['estado']);
    
    $rpta = $guardar->execute();

    return $rpta;
  }

  protected function modificarOrdenTrabajoM($datos){
    $rpta = false;
    
    $sql ="UPDATE orden_trabajo SET ordenTrabajo=:ordenTrabajo, descripcion=:descripcion WHERE idOrdenTrabajo=:id";

    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':ordenTrabajo' ,$datos['ordenTrabajo']);
    $modificar->bindParam(':descripcion' ,$datos['descripcion']);
    $modificar->bindParam('id' ,$datos['id']);
    
    $rpta = $modificar->execute();
    
    return $rpta;
  }

  protected function inactivarOrdenTrabajoM($datos){
    $rpta = false;
    $sql ="UPDATE orden_trabajo SET estado=:estado WHERE idOrdenTrabajo=:id";
  
    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':estado' ,$datos['estado']);
    $modificar->bindParam(':id' ,$datos['id']);
    
    
    $rpta = $modificar->execute();
  
    return $rpta;
  }
  

}
