<?php
require_once "./models/modelVista.php";

/**
 *
 */
class controllerVista extends modelVista
{

  public function controller_obtenerVista(){
    $respuesta = "";
    if(isset($_GET["view"]))
    {
      $view       = $_GET["view"];
      $ruta       = explode("/",$view);
      $respuesta  = modelVista::model_obtenerVista($ruta[0]);

    }else {
      $respuesta  = "./views/viewTablero.php";
    }

    return $respuesta;
  }

}
