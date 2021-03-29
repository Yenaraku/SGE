<?php
/**
 *
 */

 if ($peticionAjax) {
   require_once "../models/modelOrdenTrabajo.php";
 }else {
   require_once "./models/modelOrdenTrabajo.php";
 }


class controllerOrdenTrabajo extends modelOrdenTrabajo{

  public $opcion;
  public $idOrdenTrabajo;      
  public $ordenTrabajo;
  public $descripcion;       
        


  protected function prepararDatosC(){
    $this->opcion         = (isset($_POST['op'])) ? $_POST['op'] : "0";
    $this->idOrdenTrabajo      = (isset($_POST['id'])) ? $_POST['id'] : "0";
    $this->ordenTrabajo        = (isset($_POST['txOrdenTrabajo'])) ? $_POST['txOrdenTrabajo'] : "";
    $this->descripcion    = (isset($_POST['txDescripcion'])) ? $_POST['txDescripcion'] : "";

    $this->opcion         = modelMain::limpiarCadena($this->opcion);
    $this->idOrdenTrabajo      = modelMain::limpiarCadena($this->idOrdenTrabajo);
    $this->ordenTrabajo        = modelMain::limpiarCadena($this->ordenTrabajo);
    $this->descripcion    = modelMain::limpiarCadena($this->descripcion);

  }

  public function ajaxOrdenTrabajoC(){
    
    switch ($_POST['op']) {
      case '1':

        self::agregarOrdenTrabajoC();

        break;
      case '2':
        if (isset($_POST['txOrdenTrabajo'])) {

          self::modificarOrdenTrabajoC();

        }else {

          self::consultarJsonOrdenTrabajoC();
          
        }
        break;
      case '3':

          self::inactivarOrdenTrabajoC();

          break;
      case '4':

          self::cambiarClaveOrdenTrabajoC();

        break;
      default:

        session_start();
        session_destroy();
        echo '<script>window.location.href="'.SERVERURL.'"login</script>';

        break;
    }
   
    
  }


  public function mostrarOrdenTrabajoC(){

    return $rpta = modelOrdenTrabajo::mostrarOrdenTrabajoM();
  }

  public function consultarOrdenTrabajoC(){
    $preparar = self::prepararDatosC();
  
    return $rpta = modelOrdenTrabajo::consultarOrdenTrabajoM($this->idOrdenTrabajo);
  }

  public function consultarJsonOrdenTrabajoC(){
    $res = self::consultarOrdenTrabajoC();

    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
      echo json_encode($row);
    }

  }

  public function agregarOrdenTrabajoC(){
    $rpta = false;
    self::prepararDatosC();
 
   
    $datoOrdenTrabajo = [
      'ordenTrabajo'=>$this->ordenTrabajo,
      'descripcion'=>$this->descripcion,
      'estado'=>'A'
    ];
    $rpta = modelOrdenTrabajo::agregarOrdenTrabajoM($datoOrdenTrabajo); 
  
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function modificarOrdenTrabajoC(){
    $rpta = false;
    self::prepararDatosC();
 
    $datoOrdenTrabajo = [
      'id'=>$this->idOrdenTrabajo,
      'ordenTrabajo'=>$this->ordenTrabajo,
      'descripcion'=>$this->descripcion,
    ];

    $rpta = modelOrdenTrabajo::modificarOrdenTrabajoM($datoOrdenTrabajo);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function inactivarOrdenTrabajoC(){
    $rpta = false;
    self::prepararDatosC();

    $sql = "SELECT * FROM orden_trabajo WHERE idOrdenTrabajo=".$this->idOrdenTrabajo;
    $res = modelMain::consulta_simpleBD($sql);
    $estado = '';
   
    while($row = $res->fetch(PDO::FETCH_OBJ)){
  
      if(($row->estado) == 'A'){
        $estado = 'I';
        
      }else {
        $estado = 'A';
      }
    }

    $datoOrdenTrabajo = [
      'id'=>$this->idOrdenTrabajo,
      'estado'=>$estado
    ];
    $rpta = modelOrdenTrabajo::inactivarOrdenTrabajoM($datoOrdenTrabajo);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

}
