<?php
/**
 *
 */

 if ($peticionAjax) {
   require_once "../models/modelUsuario.php";
 }else {
   require_once "./models/modelUsuario.php";
 }


class controllerUsuario extends modelUsuario{

  public $opcion;
  public $idUsuario;      
  public $nombre;        
  public $apellido;       
  public $tipoId;        
  public $identificacion;
  public $usuario;       
  public $clave;       
  public $repetir;        


  protected function prepararDatosC(){
    $this->opcion         = (isset($_POST['op'])) ? $_POST['op'] : "0";
    $this->idUsuario      = (isset($_POST['id'])) ? $_POST['id'] : "0";
    $this->nombre         = (isset($_POST['txNombre'])) ? $_POST['txNombre'] : "NA";
    $this->apellido       = (isset($_POST['txApellido'])) ? $_POST['txApellido'] : "NA";
    $this->tipoId         = (isset($_POST['slTipoId'])) ? $_POST['slTipoId'] : "NA";
    $this->identificacion = (isset($_POST['txIdentificacion'])) ? $_POST['txIdentificacion'] : "NA";
    $this->usuario        = (isset($_POST['txUsuario'])) ? $_POST['txUsuario'] : "NA";
    $this->clave          = (isset($_POST['txClave'])) ? $_POST['txClave'] : "0";
    $this->repetir        = (isset($_POST['txRepetir'])) ? $_POST['txRepetir'] : "0";

    $this->opcion         = modelMain::limpiarCadena($this->opcion);
    $this->idUsuario      = modelMain::limpiarCadena($this->idUsuario);
    $this->nombre         = modelMain::limpiarCadena($this->nombre);
    $this->apellido       = modelMain::limpiarCadena($this->apellido);
    $this->tipoId         = modelMain::limpiarCadena($this->tipoId);
    $this->identificacion = modelMain::limpiarCadena($this->identificacion);
    $this->usuario        = modelMain::limpiarCadena($this->usuario);
    $this->clave          = modelMain::limpiarCadena($this->clave);
    $this->repetir        = modelMain::limpiarCadena($this->repetir);
  }

  public function ajaxUsuarioC(){
    
    switch ($_POST['op']) {
      case '1':
        self::agregarUsuarioC();

        break;
      case '2':
        if (isset($_POST['txNombre'])) {
          self::modificarUsuarioC();

        }else {
          self::consultarJsonUsuarioC();
          
        }
        break;
      case '3':
          self::inactivarUsuarioC();
          break;
      case '4':
          self::cambiarClaveUsuarioC();
        break;
      default:
        session_start();
        session_destroy();
        echo '<script>window.location.href="'.SERVERURL.'"login</script>';
        break;
    }
   
    
  }


  public function mostrarUsuarioC(){

    return $rpta = modelUsuario::mostrarUsuarioM();
  }

  public function consultarUsuarioC(){
    $preparar = self::prepararDatosC();
  
    return $rpta = modelUsuario::consultarUsuarioM($this->idUsuario);
  }

  public function consultarJsonUsuarioC(){
    $res = self::consultarUsuarioC();

    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
      echo json_encode($row);
    }

  }

  public function agregarUsuarioC(){
    $rpta = false;
    self::prepararDatosC();
 
    if (strcmp($this->clave, $this->repetir) === 0) {
      $datoUsuario = [
        'nombre'=>$this->nombre,
        'apellido'=>$this->apellido,
        'tipoId'=>$this->tipoId,
        'identificacion'=>$this->identificacion,
        'usuario'=>$this->usuario,
        'clave'=>$this->clave,
        'estado'=>'A'
      ];
      $rpta = modelUsuario::agregarUsuarioM($datoUsuario); 
    }
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function modificarUsuarioC(){
    $rpta = false;
    self::prepararDatosC();
 
    $datoUsuario = [
      'id'=>$this->idUsuario,
      'nombre'=>$this->nombre,
      'apellido'=>$this->apellido,
      'tipoId'=>$this->tipoId,
      'identificacion'=>$this->identificacion
    ];

    $rpta = modelUsuario::modificarUsuarioM($datoUsuario);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function inactivarUsuarioC(){
    $rpta = false;
    self::prepararDatosC();

    $sql = "SELECT * FROM usuario WHERE idUsuario=".$this->idUsuario;
    $res = modelMain::consulta_simpleBD($sql);
    $estado = '';
   
    while($row = $res->fetch(PDO::FETCH_OBJ)){
  
      if(($row->estado) == 'A'){
        $estado = 'I';
        
      }else {
        $estado = 'A';
      }
    }

    $datoUsuario = [
      'id'=>$this->idUsuario,
      'estado'=>$estado
    ];
    $rpta = modelUsuario::inactivarUsuarioM($datoUsuario);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function cambiarClaveUsuarioC(){
    $rpta = false;
    self::prepararDatosC();
    
    if (strcmp($this->clave, $this->repetir) === 0) {
      $datoUsuario = [
        'id'=>$this->idUsuario,
        'clave'=>$this->clave,
      ];
      $rpta = modelUsuario::cambiarClaveUsuarioM($datoUsuario);
      
    }
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }
}
