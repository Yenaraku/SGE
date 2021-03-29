<?php

/**
 *
 */
class modelVista
{
  protected function model_obtenerVista($vista)
  {
    $lista = ["Tablero","Mantenimiento","OrdenTrabajo","Usuario","MaquinaDetalle","MaquinaTipo","MaquinaCategoria","MaquinaMarca","CentroCosto","Proveedor","Prueba"];
    $contenido = "";

    if (in_array($vista,$lista)) {

      if (is_file("./views/view$vista.php")) {

          $contenido = "./views/view".$vista.".php";
      }else {
          $contenido = "./views/viewTablero.php";
      }
    }else{
    
          $contenido = "./views/viewTablero.php";
    }

    return $contenido;
  }
}
