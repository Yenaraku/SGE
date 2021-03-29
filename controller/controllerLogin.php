<?php
/**
 *
 */

 if ($peticionAjax) {
   require_once "../models/modelMain.php";
 }else {
   require_once "./models/modelMain.php";
 }


class controllerLogin extends modelMain{

  public $opcion;
  public $idUsuario;
  public $usuario;      
  private  $contrasena;   
        


  protected function prepararDatosC(){
    $this->opcion       = (isset($_POST['op'])) ? $_POST['op'] : "0";
    $this->idUsuario    = (isset($_POST['idUsuario'])) ? $_POST['idUsuario'] : "0";
    $this->usuario      = (isset($_POST['txUsuario'])) ? $_POST['txUsuario'] : "";
    $this->contrasena   = (isset($_POST['txContrasena'])) ? $_POST['txContrasena'] : "";

    $this->opcion         = modelMain::limpiarCadena($this->opcion);
    $this->idUsuario      = modelMain::limpiarCadena($this->idUsuario);
    $this->usuario        = modelMain::limpiarCadena($this->usuario);
    $this->contrasena    = modelMain::limpiarCadena($this->contrasena);

  }

  public function ajaxLoginC(){
    
    switch ($_POST['op']) {
      case '101':
        
        $sesion = self::iniciarSesionC();
        if($sesion){
          echo modelMain::msjAlertas($sesion,$this->opcion);
        }
        break;
      case '102':
        $sesion = self::cerrarSesionC();
        if ($sesion) {
          echo "<script> location.reload(true); </script>";
        }
        break;
    
      default:

        session_start();
        session_destroy();
        echo '<script>window.location.href="'.SERVERURL.'"login</script>';

        break;
    } 
   
    
  }

  public function iniciarSesionC(){
    $rpta = false;
    self::prepararDatosC();
    $consulta = modelMain::iniciarSesionM($this->usuario, $this->contrasena);
    if ($consulta->rowCount() == 1){
      
      session_start();
      while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
        $_SESSION['usuario']['id'] = $row->idUsuario ;
        $_SESSION['usuario']['usuario'] = $row->usuario ;
        $_SESSION['usuario']['nombreCompleto'] = $row->nombre.' '.$row->apellido;
        $_SESSION['usuario']['cedula'] = $row->nIdentificacion ;
      }
      $rpta = true;
    }

    return $rpta;
  }

  public function validarSesionC(){
    $rpta = false;
  
    if (isset($_SESSION['usuario']['cedula']) ) {
      $consulta = modelMain::validarSesionM($_SESSION['usuario']['cedula']);
      $rpta = ($consulta == 1) ? true : false;
    }

    return $rpta;
  }

  public function cerrarSesionC(){
    $rpta = false;
    session_start();
    if(session_destroy()){
      $rpta =true;
    }
    return $rpta;
  }

  public function obtenerNombreUsuarioC(){
    session_start();
    $rpta = (self::validarSesionC()) ? $_SESSION['usuario']['nombreCompleto'] : 'Inicia Sesion';
    return $rpta;
  }

}
