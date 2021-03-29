<?php
/**
 *
 */

 if ($peticionAjax) {
   require_once "../models/modelCentroCosto.php";
 }else {
   require_once "./models/modelCentroCosto.php";
 }


class controllerCentroCosto extends modelCentroCosto{

  public $opcion;
  public $idCentroCosto;      
  public $centroCosto;
  public $descripcion;
  public $asociado;       
        


  protected function prepararDatosC(){
    $this->opcion         = (isset($_POST['op'])) ? $_POST['op'] : "0";
    $this->idCentroCosto  = (isset($_POST['id'])) ? $_POST['id'] : "0";
    $this->centroCosto    = (isset($_POST['txCentroCosto'])) ? $_POST['txCentroCosto'] : "";
    $this->descripcion    = (isset($_POST['txDescripcion'])) ? $_POST['txDescripcion'] : "";
    $this->asociado       = (isset($_POST['slAsociado'])) ? $_POST['slAsociado'] : "0";

    $this->opcion         = modelMain::limpiarCadena($this->opcion);
    $this->idCentroCosto  = modelMain::limpiarCadena($this->idCentroCosto);
    $this->centroCosto    = modelMain::limpiarCadena($this->centroCosto);
    $this->descripcion    = modelMain::limpiarCadena($this->descripcion);
    $this->asociado       = modelMain::limpiarCadena($this->asociado);

  }

  public function ajaxCentroCostoC(){
    
    switch ($_POST['op']) {
      case '1':

        self::agregarCentroCostoC();

        break;
      case '2':
        if (isset($_POST['txCentroCosto'])) {

          self::modificarCentroCostoC();

        }else {

          self::consultarJsonCentroCostoC();
          
        }
        break;
      case '3':

          self::inactivarCentroCostoC();

          break;

      default:

        session_start();
        session_destroy();
        echo '<script>window.location.href="'.SERVERURL.'"login</script>';

        break;
    }
   
    
  }


  public function mostrarCentroCostoC(){

    return $rpta = modelCentroCosto::mostrarCentroCostoM();
  }

  public function consultarCentroCostoC(){
    $preparar = self::prepararDatosC();
  
    return $rpta = modelCentroCosto::consultarCentroCostoM($this->idCentroCosto);
  }

  public function consultarJsonCentroCostoC(){
    $res = self::consultarCentroCostoC();

    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
      echo json_encode($row);
    }

  }

  public function generarIdCentroCostoC(){
    $ultimoId = 0;
    
    if (empty($this->asociado) || $this->asociado == 0) {
      $sql = "SELECT MAX(idCentroCosto) AS ultimoId FROM centrocosto WHERE idCentroCosto<100";
    }elseif($this->asociado>0){
      $sql = "SELECT MAX(idCentroCosto) AS ultimoId FROM centrocosto WHERE idCentroCosto>".($this->asociado*100)." AND idCentroCosto<=".(($this->asociado*100)+99);
    }
    $consulta = modelMain::consulta_simpleBD($sql);
    while($row = $consulta->fetch(PDO::FETCH_OBJ)){
     
        $ultimoId = ($row->ultimoId>0) ? $row->ultimoId : ($this->asociado*100);

    }
    
    return $ultimoId+1;
  }

  public function agregarCentroCostoC(){
    $rpta = false;
    self::prepararDatosC();
    $generarId=self::generarIdCentroCostoC();
    
    $datoCentroCosto = [
      'id'=>$generarId,
      'centroCosto'=>$this->centroCosto,
      'descripcion'=>$this->descripcion,
      'asociado'=>$this->asociado,
      'estado'=>'A'
    ];
    $rpta = modelCentroCosto::agregarCentroCostoM($datoCentroCosto); 
  
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function modificarCentroCostoC(){
    $rpta = false;
    self::prepararDatosC();
 
    $datoCentroCosto = [
      'id'=>$this->idCentroCosto,
      'centroCosto'=>$this->centroCosto,
      'descripcion'=>$this->descripcion,
      'asociado'=>$this->asociado
    ];

    $rpta = modelCentroCosto::modificarCentroCostoM($datoCentroCosto);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function inactivarCentroCostoC(){
    $rpta = false;
    self::prepararDatosC();

    $sql = "SELECT * FROM centrocosto WHERE idCentroCosto=".$this->idCentroCosto;
    $res = modelMain::consulta_simpleBD($sql);
    $estado = '';
   
    while($row = $res->fetch(PDO::FETCH_OBJ)){
  
      if(($row->estado) == 'A'){
        $estado = 'I';
        
      }else {
        $estado = 'A';
      }
    }

    $datoCentroCosto = [
      'id'=>$this->idCentroCosto,
      'estado'=>$estado
    ];
    $rpta = modelCentroCosto::inactivarCentroCostoM($datoCentroCosto);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

}
