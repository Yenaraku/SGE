<?php

/**
 *
 */
 if ($peticionAjax) {
   require_once "../models/modelMain.php";
 }else {
   require_once "./models/modelMain.php";
 }
class modelMaquinaDetalle extends modelMain{

  protected function mostrarMaquinaDetalleM(){
    $sql = "SELECT t.idMaquinaTipo, t.maquinaTipo, c.categoria, m.marca, d.* FROM maquina_detalle d INNER JOIN maquina_categoria c ON c.idMaquinaCategoria=d.idMaquinaCategoria_fk INNER JOIN maquina_tipo t ON t.idMaquinaTipo=c.idMaquinaTipo_fk INNER JOIN maquina_marca m ON m.idMaquinaMarca=d.idMaquinaMarca_fk ORDER BY fechaRegistro DESC";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function consultarMaquinaDetalleM($id){
    $sql = "SELECT t.idMaquinaTipo, t.maquinaTipo, c.categoria, m.marca, p.proveedor AS nombreProveedor, s.sistemaOperativo, ce.centroCosto, d.* FROM maquina_detalle d INNER JOIN maquina_categoria c ON c.idMaquinaCategoria=d.idMaquinaCategoria_fk INNER JOIN maquina_tipo t ON t.idMaquinaTipo=c.idMaquinaTipo_fk INNER JOIN maquina_marca m ON m.idMaquinaMarca=d.idMaquinaMarca_fk LEFT JOIN proveedor p ON p.nId=d.proveedor LEFT JOIN sistema_operativo s ON s.idSistemaOperativo=d.sOperativo INNER JOIN centrocosto ce ON ce.idCentroCosto=d.idCentroCosto_fk WHERE d.idMaquinaDetalle=$id";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function cargarTipoM(){
    $sql = "SELECT * FROM maquina_tipo WHERE estado='A'";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }
  protected function cargarCategoriaM($tipo){
    $sql = "SELECT * FROM maquina_categoria";
    if (!empty($tipo)) {
      $sql .=  " WHERE estado='A' AND idMaquinaTipo_fk=$tipo";
    }else {
      $sql .=  " WHERE estado='A' AND idMaquinaTipo_fk=1";
    }
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }
  protected function cargarMarcaM($filtro){
    $sql = "SELECT * FROM maquina_marca";
    if (!empty($filtro)) {
      $sql .=  " WHERE estado='A' AND etiqueta LIKE '%$filtro%' ORDER BY marca ASC";
    }else {
      $sql .=  " WHERE estado='A' AND etiqueta LIKE '%computador%' ORDER BY marca ASC";
    }
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function cargarCCostoM(){
    $sql = "SELECT * FROM centrocosto WHERE estado='A'";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function cargarSistemaOperativoM(){
    $sql = "SELECT * FROM sistema_operativo WHERE estado='A'";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function cargarProveedorM($filtro){
    $sql = "SELECT * FROM proveedor WHERE estado='A' AND proveedor LIKE '%$filtro%' ORDER BY proveedor DESC LIMIT 0,5";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function ultimoIdMaquinaDetalleM(){
    $sql = "SELECT MAX(idMaquinaDetalle) AS ultimoId FROM maquina_detalle WHERE estado='A'";
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;
  }

  protected function agregarMaquinaDetalleM($datos){
    $rpta = false;
    $datos = explode(',',$datos);
    $sql = "INSERT INTO maquina_detalle(idMaquinaDetalle,codInterno, idMaquinaCategoria_fk, idMaquinaMarca_fk, modelo, nSerial, procesador, ram, disco, mac, sOperativo, nombre, ubicacion, etiqueta, idCentroCosto_fk, fechaCompra, proveedor, nFactura, precio, nota, prioridad, asignado,estado) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $guardar = modelMain::conectarBD()->prepare($sql);
    $guardar->bindParam(1 ,$datos[0]);
    $guardar->bindParam(2 ,$datos[1]);
    $guardar->bindParam(3 ,$datos[2]);
    $guardar->bindParam(4 ,$datos[3]);
    $guardar->bindParam(5 ,$datos[4]);
    $guardar->bindParam(6 ,$datos[5]);
    $guardar->bindParam(7 ,$datos[6]);
    $guardar->bindParam(8 ,$datos[7]);
    $guardar->bindParam(9 ,$datos[8]);
    $guardar->bindParam(10 ,$datos[9]);
    $guardar->bindParam(11 ,$datos[10]);
    $guardar->bindParam(12 ,$datos[11]);
    $guardar->bindParam(13 ,$datos[12]);
    $guardar->bindParam(14 ,$datos[13]);
    $guardar->bindParam(15 ,$datos[14]);
    $guardar->bindParam(16 ,$datos[15]);
    $guardar->bindParam(17 ,$datos[16]);
    $guardar->bindParam(18 ,$datos[17]);
    $guardar->bindParam(19 ,$datos[18]);
    $guardar->bindParam(20 ,$datos[19]);
    $guardar->bindParam(21 ,$datos[20]);
    $guardar->bindParam(22 ,$datos[21]);
    $guardar->bindParam(23 ,$datos[22]);
    
    
    $rpta = $guardar->execute();
    return $rpta;
  }

  protected function modificarMaquinaDetalleM($datos){
    $rpta = false;
    $datos = explode(',',$datos);
    
    $sql ="UPDATE maquina_detalle SET idMaquinaCategoria_fk=:v1, idMaquinaMarca_fk=:v2, modelo=:v3, nSerial=:v4, procesador=:v5, ram=:v6, disco=:v7, mac=:v8, sOperativo=:v9, nombre=:v10, ubicacion=:v11, etiqueta=:v12, idCentroCosto_fk=:v13, fechaCompra=:v14, proveedor=:v15, nFactura=:v16, precio=:v17, nota=:v18, prioridad=:v19, asignado=:v20  WHERE idMaquinaDetalle=:id";

    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':v1' ,$datos[0]);
    $modificar->bindParam(':v2' ,$datos[1]);
    $modificar->bindParam(':v3' ,$datos[2]);
    $modificar->bindParam(':v4' ,$datos[3]);
    $modificar->bindParam(':v5' ,$datos[4]);
    $modificar->bindParam(':v6' ,$datos[5]);
    $modificar->bindParam(':v7' ,$datos[6]);
    $modificar->bindParam(':v8' ,$datos[7]);
    $modificar->bindParam(':v9' ,$datos[8]);
    $modificar->bindParam(':v10' ,$datos[9]);
    $modificar->bindParam(':v11' ,$datos[10]);
    $modificar->bindParam(':v12' ,$datos[11]);
    $modificar->bindParam(':v13' ,$datos[12]);
    $modificar->bindParam(':v14' ,$datos[13]);
    $modificar->bindParam(':v15' ,$datos[14]);
    $modificar->bindParam(':v16' ,$datos[15]);
    $modificar->bindParam(':v17' ,$datos[16]);
    $modificar->bindParam(':v18' ,$datos[17]);
    $modificar->bindParam(':v19' ,$datos[18]);
    $modificar->bindParam(':v20' ,$datos[19]);
    $modificar->bindParam(':id' ,$datos[20]);
    
    $rpta = $modificar->execute();
    
    return $rpta;
  }

  protected function inactivarMaquinaDetalleM($datos){
    $rpta = false;
    $sql ="UPDATE maquina_detalle SET estado=:estado WHERE idMaquinaDetalle=:id";
  
    $modificar = modelMain::conectarBD()->prepare($sql);
    $modificar->bindParam(':estado' ,$datos['estado']);
    $modificar->bindParam(':id' ,$datos['id']);
    
    
    $rpta = $modificar->execute();
  
    return $rpta;
  }
  

}
