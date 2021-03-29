<?php


$peticionAjax = true;
require_once "../core/config.php";

if (isset($_POST['op']) || isset($_POST['cargar'])) {
  include_once "../controller/controllerMaquinaDetalle.php";
  $objMaquina = new controllerMaquinaDetalle();
  if (isset($_POST['op']) && !empty($_POST['op'])) {
    $objMaquina->ajaxMaquinaDetalleC();
  }else{
      $cargar = '';
      $slc = (isset($_POST['slcat'])) ? $_POST['slcat'] : 0;
      $slm = (isset($_POST['slmar'])) ? $_POST['slmar'] : 0;

      switch ($_POST['cargar']) {
        
        case 'categoria':
          
          $res = $objMaquina->cargarCategoriaC();
          while ($row = $res->fetch(PDO::FETCH_OBJ)) {
            if ($slc > 0) {
              if ($slc == $row->idMaquinaCategoria) {
                $cargar .= "<option value='$row->idMaquinaCategoria' selected>$row->categoria</option>";
              }else{
                $cargar .= "<option value='$row->idMaquinaCategoria'>$row->categoria</option>";
              }
            }else{
              $cargar .= "<option value='$row->idMaquinaCategoria'>$row->categoria</option>";
            }
          }
          break;
        case 'marca':
          $res = $objMaquina->cargarMarcaC();
          while ($row = $res->fetch(PDO::FETCH_OBJ)) {
            if ($slm > 0) {
              if ($slm == $row->idMaquinaMarca) {
                $cargar .= "<option value='$row->idMaquinaMarca' selected>$row->marca</option>";
              }else{
                $cargar .= "<option value='$row->idMaquinaMarca'>$row->marca</option>";
              }
            }else {
              $cargar .= "<option value='$row->idMaquinaMarca'>$row->marca</option>";
            }  
          }
          break;
        case 'proveedor':
          $res = $objMaquina->cargarProveedorC();
          $cargar .="<ul>";
          while ($row = $res->fetch(PDO::FETCH_OBJ)) {
            $cargar .= "<li class='sugerencia-elemento' data-elemt='$row->nId'>$row->proveedor</li>";
          }
          $cargar .="</ul>";
        break;
        default:
          break;
      }

      echo $cargar;
  }
  

}else {
    session_start();
    session_destroy();
    echo '<script>window.location.href="'.SERVERURL.'"login</script>';
}
