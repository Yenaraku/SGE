<?php
/**
 *
 */

 if ($peticionAjax) {
   require_once "../models/modelProveedor.php";
 }else {
   require_once "./models/modelProveedor.php";
 }


class controllerProveedor extends modelProveedor{

  public $opcion;
  public $idProveedor;
  public $tipoId;
  public $nId;      
  public $proveedor;
  public $direccion;   
  public $telefono;    
        


  protected function prepararDatosC(){
    $this->opcion         = (isset($_POST['op'])) ? $_POST['op'] : "0";
    $this->idProveedor    = (isset($_POST['id'])) ? $_POST['id'] : "0";
    $this->tipoId         = (isset($_POST['slTipoId'])) ? $_POST['slTipoId'] : "";
    $this->nId            = (isset($_POST['txIdentificacion'])) ? $_POST['txIdentificacion'] : "";
    $this->proveedor      = (isset($_POST['txProveedor'])) ? $_POST['txProveedor'] : "";
    $this->direccion      = (isset($_POST['txDireccion'])) ? $_POST['txDireccion'] : "";
    $this->telefono       = (isset($_POST['txTelefono'])) ? $_POST['txTelefono'] : "";

    $this->opcion         = modelMain::limpiarCadena($this->opcion);
    $this->idProveedor    = modelMain::limpiarCadena($this->idProveedor);
    $this->tipoId         = modelMain::limpiarCadena($this->tipoId);
    $this->nId            = modelMain::limpiarCadena($this->nId);
    $this->proveedor      = modelMain::limpiarCadena($this->proveedor);
    $this->direccion      = modelMain::limpiarCadena($this->direccion);
    $this->telefono       = modelMain::limpiarCadena($this->telefono);

  }

  public function ajaxProveedorC(){
    
    switch ($_POST['op']) {
      case '1':

        self::agregarProveedorC();

        break;
      case '2':
        if (isset($_POST['txProveedor'])) {

          self::modificarProveedorC();

        }else {

          self::consultarJsonProveedorC();
          
        }
        break;
      case '3':

          self::inactivarProveedorC();

          break;
      case '4':

          self::cambiarClaveProveedorC();

        break;
      default:

        session_start();
        session_destroy();
        echo '<script>window.location.href="'.SERVERURL.'"login</script>';

        break;
    }
   
    
  }


  public function mostrarProveedorC(){

    return $rpta = modelProveedor::mostrarProveedorM();
  }

  public function consultarProveedorC(){
    $preparar = self::prepararDatosC();
  
    return $rpta = modelProveedor::consultarProveedorM($this->idProveedor);
  }

  public function consultarJsonProveedorC(){
    $res = self::consultarProveedorC();

    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
      echo json_encode($row);
    }

  }

  public function agregarProveedorC(){
    $rpta = false;
    self::prepararDatosC();
 
    
    $datoProveedor = $this->tipoId;     
    $datoProveedor .= ",|".$this->nId;        
    $datoProveedor .= ",|".$this->proveedor; 
    $datoProveedor .= ",|".$this->direccion;  
    $datoProveedor .= ",|".$this->telefono;
    $datoProveedor .= ",|A"; 

  
  
    $rpta = modelProveedor::agregarProveedorM($datoProveedor); 
  
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function modificarProveedorC(){
    $rpta = false;
    self::prepararDatosC();
 
    $datoProveedor = $this->tipoId;     
    $datoProveedor .= ",|".$this->nId;        
    $datoProveedor .= ",|".$this->proveedor; 
    $datoProveedor .= ",|".$this->direccion;  
    $datoProveedor .= ",|".$this->telefono;
    $datoProveedor .= ",|".$this->idProveedor;

    $rpta = modelProveedor::modificarProveedorM($datoProveedor);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function inactivarProveedorC(){
    $rpta = false;
    self::prepararDatosC();

    $sql = "SELECT * FROM proveedor WHERE idProveedor=".$this->idProveedor;
    $res = modelMain::consulta_simpleBD($sql);
    $estado = '';
   
    while($row = $res->fetch(PDO::FETCH_OBJ)){
  
      if(($row->estado) == 'A'){
        $estado = 'I';
        
      }else {
        $estado = 'A';
      }
    }

    $datoProveedor = [
      'id'=>$this->idProveedor,
      'estado'=>$estado
    ];
    $rpta = modelProveedor::inactivarProveedorM($datoProveedor);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

}
