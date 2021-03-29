<?php

/**
 *
 */
 if ($peticionAjax) {
   require_once "../models/modelMain.php";
 }else {
   require_once "./models/modelMain.php";
 }
class modelProveedor extends modelMain{

  protected function mostrarProveedorM(){
    $sql = "SELECT * FROM proveedor";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function consultarProveedorM($id){
    $sql = "SELECT * FROM proveedor WHERE idProveedor=$id";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function agregarProveedorM($datos){
    $rpta = false;
    $datos = explode(',|',$datos);
    
    $sql ="INSERT INTO proveedor(tipoId, nId, proveedor, direccion, telefono, estado) VALUES (?,?,?,?,?,?)";
  
    $guardar = modelMain::conectarBD()->prepare($sql);
    $guardar->bindParam(1 ,$datos[0]);
    $guardar->bindParam(2 ,$datos[1]);
    $guardar->bindParam(3 ,$datos[2]);
    $guardar->bindParam(4 ,$datos[3]);
    $guardar->bindParam(5 ,$datos[4]);
    $guardar->bindParam(6 ,$datos[5]);
    
    $rpta = $guardar->execute();

    return $rpta;
  }

  protected function modificarProveedorM($datos){
    $rpta = false;
    $datos = explode(',|',$datos);
    $sql ="UPDATE proveedor  SET tipoId=:v1, nId=:v2, proveedor=:v3, direccion=:v4, telefono=:v5 WHERE idProveedor=:id";

    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':v1' ,$datos[0]);
    $modificar->bindParam(':v2' ,$datos[1]);
    $modificar->bindParam(':v3' ,$datos[2]);
    $modificar->bindParam(':v4' ,$datos[3]);
    $modificar->bindParam(':v5' ,$datos[4]);
    $modificar->bindParam('id' ,$datos[5]);
    
    $rpta = $modificar->execute();
    
    return $rpta;
  }

  protected function inactivarProveedorM($datos){
    $rpta = false;
    $sql ="UPDATE proveedor SET estado=:estado WHERE idProveedor=:id";
  
    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':estado' ,$datos['estado']);
    $modificar->bindParam(':id' ,$datos['id']);
    
    
    $rpta = $modificar->execute();
  
    return $rpta;
  }
  

}
