<?php
/**
 *
 */

 if ($peticionAjax) {
   require_once "../models/modelMaquinaMarca.php";
 }else {
   require_once "./models/modelMaquinaMarca.php";
 }


class controllerMaquinaMarca extends modelMaquinaMarca{

  public $opcion;
  public $idMaquinaMarca;      
  public $maquinaMarca;
  public $descripcion;   
  public $etiqueta;   
        


  protected function prepararDatosC(){
    $this->opcion         = (isset($_POST['op'])) ? $_POST['op'] : "0";
    $this->idMaquinaMarca = (isset($_POST['id'])) ? $_POST['id'] : "0";
    $this->maquinaMarca   = (isset($_POST['txMaquinaMarca'])) ? $_POST['txMaquinaMarca'] : "";
    $this->descripcion    = (isset($_POST['txDescripcion'])) ? $_POST['txDescripcion'] : "";
    $this->etiqueta       = (isset($_POST['txEtiqueta'])) ? $_POST['txEtiqueta'] : "";

    $this->opcion         = modelMain::limpiarCadena($this->opcion);
    $this->idMaquinaMarca = modelMain::limpiarCadena($this->idMaquinaMarca);
    $this->maquinaMarca   = modelMain::limpiarCadena($this->maquinaMarca);
    $this->descripcion    = modelMain::limpiarCadena($this->descripcion);
    $this->etiqueta       = modelMain::limpiarCadena($this->etiqueta);

  }

  public function ajaxMaquinaMarcaC(){
    
    switch ($_POST['op']) {
      case '1':

        self::agregarMaquinaMarcaC();

        break;
      case '2':
        if (isset($_POST['txMaquinaMarca'])) {

          self::modificarMaquinaMarcaC();

        }else {

          self::consultarJsonMaquinaMarcaC();
          
        }
        break;
      case '3':

          self::inactivarMaquinaMarcaC();

          break;
      case '4':

          self::cambiarClaveMaquinaMarcaC();

        break;
      default:

        session_start();
        session_destroy();
        echo '<script>window.location.href="'.SERVERURL.'"login</script>';

        break;
    }
   
    
  }


  public function mostrarMaquinaMarcaC(){

    return $rpta = modelMaquinaMarca::mostrarMaquinaMarcaM();
  }

  public function consultarMaquinaMarcaC(){
    $preparar = self::prepararDatosC();
  
    return $rpta = modelMaquinaMarca::consultarMaquinaMarcaM($this->idMaquinaMarca);
  }

  public function consultarJsonMaquinaMarcaC(){
    $res = self::consultarMaquinaMarcaC();

    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
      echo json_encode($row);
    }

  }

  public function agregarMaquinaMarcaC(){
    $rpta = false;
    self::prepararDatosC();
 
   
    $datoMaquinaMarca = [
      'maquinaMarca'=>$this->maquinaMarca,
      'descripcion'=>$this->descripcion,
      'etiqueta'=>$this->etiqueta,
      'estado'=>'A'
    ];
    $rpta = modelMaquinaMarca::agregarMaquinaMarcaM($datoMaquinaMarca); 
  
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function modificarMaquinaMarcaC(){
    $rpta = false;
    self::prepararDatosC();
 
    $datoMaquinaMarca = [
      'id'=>$this->idMaquinaMarca,
      'maquinaMarca'=>$this->maquinaMarca,
      'descripcion'=>$this->descripcion,
      'etiqueta'=>$this->etiqueta,
    ];

    $rpta = modelMaquinaMarca::modificarMaquinaMarcaM($datoMaquinaMarca);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function inactivarMaquinaMarcaC(){
    $rpta = false;
    self::prepararDatosC();

    $sql = "SELECT * FROM maquina_marca WHERE idMaquinaMarca=".$this->idMaquinaMarca;
    $res = modelMain::consulta_simpleBD($sql);
    $estado = '';
   
    while($row = $res->fetch(PDO::FETCH_OBJ)){
  
      if(($row->estado) == 'A'){
        $estado = 'I';
        
      }else {
        $estado = 'A';
      }
    }

    $datoMaquinaMarca = [
      'id'=>$this->idMaquinaMarca,
      'estado'=>$estado
    ];
    $rpta = modelMaquinaMarca::inactivarMaquinaMarcaM($datoMaquinaMarca);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function etiquetaMaquinaMarcaC($etiqueta){
    return modelMain::etiquetas($etiqueta);
  }
}
