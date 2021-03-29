<?php
/**
 *
 */

 if ($peticionAjax) {
   require_once "../models/modelMaquinaTipo.php";
 }else {
   require_once "./models/modelMaquinaTipo.php";
 }


class controllerMaquinaTipo extends modelMaquinaTipo{

  public $opcion;
  public $idMaquinaTipo;      
  public $maquinaTipo;
  public $descripcion;       
        


  protected function prepararDatosC(){
    $this->opcion         = (isset($_POST['op'])) ? $_POST['op'] : "0";
    $this->idMaquinaTipo      = (isset($_POST['id'])) ? $_POST['id'] : "0";
    $this->maquinaTipo        = (isset($_POST['txMaquinaTipo'])) ? $_POST['txMaquinaTipo'] : "";
    $this->descripcion    = (isset($_POST['txDescripcion'])) ? $_POST['txDescripcion'] : "";

    $this->opcion         = modelMain::limpiarCadena($this->opcion);
    $this->idMaquinaTipo      = modelMain::limpiarCadena($this->idMaquinaTipo);
    $this->maquinaTipo        = modelMain::limpiarCadena($this->maquinaTipo);
    $this->descripcion    = modelMain::limpiarCadena($this->descripcion);

  }

  public function ajaxMaquinaTipoC(){
    
    switch ($_POST['op']) {
      case '1':

        self::agregarMaquinaTipoC();

        break;
      case '2':
        if (isset($_POST['txMaquinaTipo'])) {

          self::modificarMaquinaTipoC();

        }else {

          self::consultarJsonMaquinaTipoC();
          
        }
        break;
      case '3':

          self::inactivarMaquinaTipoC();

          break;
      case '4':

          self::cambiarClaveMaquinaTipoC();

        break;
      default:

        session_start();
        session_destroy();
        echo '<script>window.location.href="'.SERVERURL.'"login</script>';

        break;
    }
   
    
  }


  public function mostrarMaquinaTipoC(){

    return $rpta = modelMaquinaTipo::mostrarMaquinaTipoM();
  }

  public function consultarMaquinaTipoC(){
    $preparar = self::prepararDatosC();
  
    return $rpta = modelMaquinaTipo::consultarMaquinaTipoM($this->idMaquinaTipo);
  }

  public function consultarJsonMaquinaTipoC(){
    $res = self::consultarMaquinaTipoC();

    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
      echo json_encode($row);
    }

  }

  public function agregarMaquinaTipoC(){
    $rpta = false;
    self::prepararDatosC();
 
   
    $datoMaquinaTipo = [
      'maquinaTipo'=>$this->maquinaTipo,
      'descripcion'=>$this->descripcion,
      'estado'=>'A'
    ];
    $rpta = modelMaquinaTipo::agregarMaquinaTipoM($datoMaquinaTipo); 
  
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function modificarMaquinaTipoC(){
    $rpta = false;
    self::prepararDatosC();
 
    $datoMaquinaTipo = [
      'id'=>$this->idMaquinaTipo,
      'maquinaTipo'=>$this->maquinaTipo,
      'descripcion'=>$this->descripcion,
    ];

    $rpta = modelMaquinaTipo::modificarMaquinaTipoM($datoMaquinaTipo);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function inactivarMaquinaTipoC(){
    $rpta = false;
    self::prepararDatosC();

    $sql = "SELECT * FROM maquina_tipo WHERE idMaquinaTipo=".$this->idMaquinaTipo;
    $res = modelMain::consulta_simpleBD($sql);
    $estado = '';
   
    while($row = $res->fetch(PDO::FETCH_OBJ)){
  
      if(($row->estado) == 'A'){
        $estado = 'I';
        
      }else {
        $estado = 'A';
      }
    }

    $datoMaquinaTipo = [
      'id'=>$this->idMaquinaTipo,
      'estado'=>$estado
    ];
    $rpta = modelMaquinaTipo::inactivarMaquinaTipoM($datoMaquinaTipo);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

}
