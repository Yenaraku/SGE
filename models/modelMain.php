<?php
/**
 *
 */
if ($peticionAjax) {
  require_once "../core/configApp.php";
}else {
  require_once "./core/configApp.php";
}

class modelMain
{

  protected function conectarBD(){
    $enlace = new PDO(SGDB,USER,PASS);

    return $enlace;
  }

  protected function consulta_simpleBD($consulta){
    $respuesta = self::conectarBD()->prepare($consulta);
    $respuesta->execute();

    return $respuesta;
  }

  public function encryption($string){
    $output = FALSE;
    $key    = hash('sha256',SECRET_KEY);
    $iv     = substr(hash('sha256',SECRET_IV),0,16);
    $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
    $output = base64_encode($output);
    return $output;
  }

  protected function decryption($string){
    $key    = hash('sha256',SECRET_KEY);
    $iv     = substr(hash('sha256',SECRET_IV),0,16);
    $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
    return $output;
  }

  public function limpiarCadena($cadena){
    $cadena = trim($cadena);
    $cadena = stripcslashes($cadena);
    $cadena = str_ireplace("<script>","",$cadena);
    $cadena = str_ireplace("</script>","",$cadena);
    $cadena = str_ireplace("<script src","",$cadena);
    $cadena = str_ireplace("SELECT * FROM","",$cadena);
    $cadena = str_ireplace("DELETE FROM","",$cadena);
    $cadena = str_ireplace("INSERT INTO","",$cadena);
    $cadena = str_ireplace("--","",$cadena);
    $cadena = str_ireplace("^","",$cadena);
    $cadena = str_ireplace("==","",$cadena);
    $cadena = str_ireplace("[","",$cadena);
    $cadena = str_ireplace("]","",$cadena);

    return $cadena;
  }

  public function msjAlertas($rpta,$opcion){
    $msj = "";
    if ($rpta) {
      $msj .= '<div class="alert alert-success">';
      switch ($opcion) {
        case '1':
          $msj .= "Se ha <b>AGREGADO</b> un nuevo Registro";
          break;
        case '2':
          $msj .= "Se ha <b>ACTUALIZADO</b> el Registro";
          break;
        case '3':
          $msj .= "Se ha cambiado el <b>ESTADO</b> del Registro";
          break;
        case '4':
          $msj .= "Se ha cambiado la <b>CONTRASEÑA</b> del Registro";
          break;
        case '6':
          $msj .= "Se ha cambiado la <b>IMAGEN</b> del Registro";
          break;
        case '101':
          
          $msj .= "Se ha iniciado Sesion con el Usuario <b>".$_SESSION['usuario']['usuario']."</b>";
          break;
  
        default:
          break;
      }
      $msj .="<br>
      <script type='text/javascript'>
      $('.modal').hide();
      var int=self.setInterval('refresh()',2000);
      function refresh(){
       
      location.reload(true);
      }
      </script>";
      $msj .= '</div>'; 
    }else{
      $msj = "<div class='alert alert-danger'>
      Se ha producido un <b>Error</b>: pueda que hayan campos vacios o campos que no coinciden con el tipo de datos</div>";
    }
    echo $msj;
  }

  public function etiquetas($etiqueta){
      $rpta = "";
      $etiqueta = explode(" ",$etiqueta);
      $cant = count($etiqueta);
      if ( $cant > 0 ) {
        for ($i=0; $i < $cant ; $i++) { 
          $rpta .= '<span class="label label-default">'. $etiqueta[$i] .'</span> ';
        }
      }

      return $rpta;
  }

  public function iniciarSesionM($usuario, $contrasena){
    $contrasena =self::encryption($contrasena);
    $sql = "SELECT * FROM usuario WHERE usuario = '$usuario' AND clave = '$contrasena' AND estado ='A'";
    
    $rpta = self::consulta_simpleBD($sql);
    return $rpta;
  }
  public function validarSesionM($cedula){
    $rpta=0;
    $sql = "SELECT COUNT(*) AS cantidad FROM usuario WHERE nidentificacion = $cedula AND estado ='A'";
    $consulta = self::consulta_simpleBD($sql);
    while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
      $rpta = $row->cantidad;
    }
    return $rpta;
  }

}
