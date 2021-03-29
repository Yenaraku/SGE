<?php
/**
 *
 */

 if ($peticionAjax) {
   require_once "../models/modelMaquinaCategoria.php";
 }else {
   require_once "./models/modelMaquinaCategoria.php";
 }


class controllerMaquinaCategoria extends modelMaquinaCategoria{

  public $opcion;
  public $idMaquinaCategoria;      
  public $maquinaCategoria;
  public $tipo;
  public $descripcion;
  
  public $imgTmp;
  public $imgSize;
  public $imgType;
        
  protected function prepararDatosC(){
    $this->opcion                  = (isset($_POST['op'])) ? $_POST['op'] : "0";
    $this->idMaquinaCategoria      = (isset($_POST['id'])) ? $_POST['id'] : "0";
    $this->maquinaCategoria        = (isset($_POST['txMaquinaCategoria'])) ? $_POST['txMaquinaCategoria'] : "";
    $this->tipo                    = (isset($_POST['slTipo'])) ? $_POST['slTipo'] : "";
    $this->descripcion             = (isset($_POST['txDescripcion'])) ? $_POST['txDescripcion'] : "";

    if (isset($_FILES['flImgCategoria']) && $_FILES['flImgCategoria']['error'] === UPLOAD_ERR_OK) {
      $this->imgTmp                  = (!empty($_FILES['flImgCategoria']['tmp_name'])) ? $_FILES['flImgCategoria']['tmp_name'] : "";
      $this->imgSize                 = (!empty($_FILES['flImgCategoria']['size'])) ? $_FILES['flImgCategoria']['size'] : "0";
      $this->imgType                 = (!empty($_FILES['flImgCategoria']['type'])) ? $_FILES['flImgCategoria']['type'] : "";  
      
      if (!empty($this->imgType)) {
        $this->imgType = explode("/",$this->imgType);
      }
    }

    $this->opcion                  = modelMain::limpiarCadena($this->opcion);
    $this->idMaquinaCategoria      = modelMain::limpiarCadena($this->idMaquinaCategoria);
    $this->maquinaCategoria        = modelMain::limpiarCadena($this->maquinaCategoria);
    $this->tipo                    = modelMain::limpiarCadena($this->tipo);
    $this->descripcion             = modelMain::limpiarCadena($this->descripcion);

  }

  public function validarMaquinaCategoriaC(){
    $rpta = false;
 
    return $rpta;
  }

  public function ajaxMaquinaCategoriaC(){
    
    switch ($_POST['op']) {
      
      case '1':

        self::agregarMaquinaCategoriaC();

        break;
      case '2':
        if (isset($_POST['txMaquinaCategoria'])) {

          self::modificarMaquinaCategoriaC();

        }else {

          self::consultarJsonMaquinaCategoriaC();
          
        }
        break;
      case '3':

          self::inactivarMaquinaCategoriaC();

          break;
      case '6':
        
        if (isset($_FILES['flImgCategoria'])) {
          
          self::cambiarImgMaquinaCategoriaC();
        
        }else {
          
          self::consultarJsonMaquinaCategoriaC();

        }
        break;
      default:

        session_start();
        session_destroy();
        echo '<script>window.location.href="'.SERVERURL.'"login</script>';

        break;
    }
   
    
  }


  public function mostrarMaquinaCategoriaC(){

    return $rpta = modelMaquinaCategoria::mostrarMaquinaCategoriaM();
  }

  public function mostrarTipoMaquinaFkC($id){

    $sql = "SELECT * FROM maquina_tipo ";
    if (isset($id) && !empty($id)) {
      $sql .= "WHERE idMaquinaTipo=". $id;
    }
    $consultar = modelMain::conectarBD()->prepare($sql);
    $consultar->execute();
    return $consultar;

  }
  public function consultarMaquinaCategoriaC(){

    $preparar = self::prepararDatosC();
    return $rpta = modelMaquinaCategoria::consultarMaquinaCategoriaM($this->idMaquinaCategoria);

  }

  public function consultarJsonMaquinaCategoriaC(){

    $res = self::consultarMaquinaCategoriaC();
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
      echo json_encode($row);
    }

  }

  public function agregarMaquinaCategoriaC(){
    $rpta = false;
    self::prepararDatosC();
    $consulta = modelMain::consulta_simpleBD("SELECT MAX(idMaquinaCategoria) AS ultimoId FROM maquina_categoria");
    $ultimoId = 0;
    while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
      $id = $row->ultimoId+1;
    }
    $nombreArchivo = modelMaquinaCategoria::subirImgMaquinaCategoriaM($this->imgTmp,$this->imgSize,$this->imgType,$id);
    
    $datoMaquinaCategoria = [
      'maquinaCategoria'=>$this->maquinaCategoria,
      'tipo'=>$this->tipo,
      'descripcion'=>$this->descripcion,
      'imagen'=>$nombreArchivo,
      'estado'=>'A'
    ];
    $rpta = modelMaquinaCategoria::agregarMaquinaCategoriaM($datoMaquinaCategoria); 
  
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function modificarMaquinaCategoriaC(){
    $rpta = false;
    $nombreArchivo = "";
    self::prepararDatosC();
    if ($this->imgSize > 0) {
      $nombreArchivo = modelMaquinaCategoria::subirImgMaquinaCategoriaM($this->imgTmp,$this->imgSize,$this->imgType,$this->idMaquinaCategoria);
    }
    
    $datoMaquinaCategoria = [
      'id'=>$this->idMaquinaCategoria,
      'maquinaCategoria'=>$this->maquinaCategoria,
      'tipo'=>$this->tipo,
      'descripcion'=>$this->descripcion,
      'imagen'=>$nombreArchivo,
    ];

    $rpta = modelMaquinaCategoria::modificarMaquinaCategoriaM($datoMaquinaCategoria);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function inactivarMaquinaCategoriaC(){
    $rpta = false;
    self::prepararDatosC();

    $sql = "SELECT * FROM maquina_categoria WHERE idMaquinaCategoria=".$this->idMaquinaCategoria;
    $res = modelMain::consulta_simpleBD($sql);
    $estado = '';
   
    while($row = $res->fetch(PDO::FETCH_OBJ)){
  
      if(($row->estado) == 'A'){
        $estado = 'I';
        
      }else {
        $estado = 'A';
      }
    }

    $datoMaquinaCategoria = [
      'id'=>$this->idMaquinaCategoria,
      'estado'=>$estado
    ];
    $rpta = modelMaquinaCategoria::inactivarMaquinaCategoriaM($datoMaquinaCategoria);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function cambiarImgMaquinaCategoriaC(){
    
    $rpta = false;
    $nombreArchivo = "";
    self::prepararDatosC();
  
    if ($this->imgSize > 0) {
      
      $nombreArchivo = modelMaquinaCategoria::subirImgMaquinaCategoriaM($this->imgTmp,$this->imgSize,$this->imgType,$this->idMaquinaCategoria);
    }
    
    $datoMaquinaCategoria = [
      'id'=>$this->idMaquinaCategoria,
      'imagen'=>$nombreArchivo,
    ];

    $rpta = modelMaquinaCategoria::cambiarImgMaquinaCategoriaM($datoMaquinaCategoria);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

}
