<?php

/**
 *
 */
 if ($peticionAjax) {
   require_once "../models/modelMain.php";
 }else {
   require_once "./models/modelMain.php";
 }
class modelMaquinaCategoria extends modelMain{

  protected function mostrarMaquinaCategoriaM(){
    $sql = "SELECT * FROM maquina_categoria";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function consultarMaquinaCategoriaM($id){
    $sql = "SELECT * FROM maquina_categoria WHERE idMaquinaCategoria=$id";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function subirImgMaquinaCategoriaM($tmp,$size,$type,$id){
    $nombreArchivo = "";
    if (($size > 1000) && ($size < 1000000)) {
      $nombreArchivo = "imgCtg".$id.".".$type[1];
      $urlArchivo = "../attachment/categoria/".$nombreArchivo;
      if(!move_uploaded_file($tmp, $urlArchivo)){
        $nombreArchivo = "";
      }
    }else{
      $nombreArchivo = "";
    }
    return $nombreArchivo;
  }

  protected function agregarMaquinaCategoriaM($datos){
    $rpta = false;
    $sql ="INSERT INTO maquina_categoria(categoria,idMaquinaTipo_fk,descripcion,imagen,estado) VALUES(?,?,?,?,?)";
    
    $guardar = modelMain::conectarBD()->prepare($sql);
    $guardar->bindParam(1 ,$datos['maquinaCategoria']);
    $guardar->bindParam(2 ,$datos['tipo']);
    $guardar->bindParam(3 ,$datos['descripcion']);
    $guardar->bindParam(4 ,$datos['imagen']);
    $guardar->bindParam(5 ,$datos['estado']);
    
    $rpta = $guardar->execute();

    return $rpta;
  }

  protected function modificarMaquinaCategoriaM($datos){
    $rpta = false;
    $nombreImg = "";
    $sql = "UPDATE maquina_categoria SET categoria=:maquinaCategoria, idMaquinaTipo_fk=:tipo,descripcion=:descripcion,imagen=:imagen WHERE idMaquinaCategoria=:id";
    if (empty($datos['imagen'])) {
      $consulta = modelMain::consulta_simpleBD("SELECT imagen FROM maquina_categoria WHERE idMaquinaCategoria=".$datos['id']);
      while ($res = $consulta->fetch(PDO::FETCH_OBJ)) {
        $nombreImg = $res->imagen;
      }
    }else{
      $nombreImg = $datos['imagen'];
    }
    
    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':maquinaCategoria' ,$datos['maquinaCategoria']);
    $modificar->bindParam(':tipo' ,$datos['tipo']);
    $modificar->bindParam(':descripcion' ,$datos['descripcion']);
    $modificar->bindParam(':imagen' ,$nombreImg);
    $modificar->bindParam(':id' ,$datos['id']);
    
    $rpta = $modificar->execute();
    
    return $rpta;
  }

  protected function inactivarMaquinaCategoriaM($datos){
    $rpta = false;
    $sql ="UPDATE maquina_categoria SET estado=:estado WHERE idMaquinaCategoria=:id";
  
    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':estado' ,$datos['estado']);
    $modificar->bindParam(':id' ,$datos['id']);
    
    
    $rpta = $modificar->execute();
  
    return $rpta;
  }

  protected function cambiarImgMaquinaCategoriaM($datos){
    $rpta = false;
    $nombreImg = "";
    $sql ="UPDATE maquina_categoria SET imagen=:imagen WHERE idMaquinaCategoria=:id";
    if (empty($datos['imagen'])) {
      $consulta = modelMain::consulta_simpleBD("SELECT imagen FROM maquina_categoria WHERE idMaquinaCategoria=".$datos['id']);
      while ($res = $consulta->fetch(PDO::FETCH_OBJ)) {
        $nombreImg = $res->imagen;
      }
    }else{
      $nombreImg = $datos['imagen'];
    }
    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':imagen' ,$nombreImg);
    $modificar->bindParam(':id' ,$datos['id']);
    
    
    $rpta = $modificar->execute();
  
    return $rpta;
  }
  

}
