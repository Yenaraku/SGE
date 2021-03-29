<?php
/**
 *
 */

 if ($peticionAjax) {
   require_once "../models/modelMaquinaDetalle.php";
 }else {
   require_once "./models/modelMaquinaDetalle.php";
 }


class controllerMaquinaDetalle extends modelMaquinaDetalle{

  public $opcion;
  public $idMaquinaDetalle;
  public $tipo;      
  public $cod;
  public $nSerial;
  public $modelo;
  public $categoria;
  public $marca;
  public $procesador;
  public $ram;
  public $disco;
  public $mac;
  public $sOperativo;
  public $nombre;
  public $etiqueta;
  public $ubicacion;
  public $cCosto;
  public $fCompra;
  public $proveedor;
  public $nFactura;
  public $precio;
  public $asignado;
  public $prioridad;
  public $nota;

        


  protected function prepararDatosC(){
    
    $this->opcion           = (isset($_POST['op']))           ? $_POST['op'] : "0";
    $this->idMaquinaDetalle = (isset($_POST['id']))           ? $_POST['id'] : "0";
    $this->tipo             = (isset($_POST['tipo']))         ? $_POST['tipo'] : "";
    $this->nSerial          = (isset($_POST['txNSerial']))    ? $_POST['txNSerial'] : "";
    $this->modelo           = (isset($_POST['txModelo']))     ? $_POST['txModelo'] : "";
    $this->categoria        = (isset($_POST['slCategoria']))  ? $_POST['slCategoria'] : "";
    $this->marca            = (isset($_POST['slMarca']))      ? $_POST['slMarca'] : "";
    $this->procesador       = (isset($_POST['txProcesador'])) ? $_POST['txProcesador'] : "";
    $this->ram              = (isset($_POST['txRam']))        ? $_POST['txRam'] : "";
    $this->disco            = (isset($_POST['txDisco']))      ? $_POST['txDisco'] : "";
    $this->mac              = (isset($_POST['txMac']))        ? $_POST['txMac'] : "";
    $this->sOperativo       = (isset($_POST['slSOperativo'])) ? $_POST['slSOperativo'] : "";
    $this->nombre           = (isset($_POST['txNombre']))     ? $_POST['txNombre'] : "";
    $this->etiqueta         = (isset($_POST['txEtiqueta']))   ? $_POST['txEtiqueta'] : "";
    $this->ubicacion        = (isset($_POST['txUbicacion']))  ? $_POST['txUbicacion'] : "";
    $this->cCosto           = (isset($_POST['slCCosto']))     ? $_POST['slCCosto'] : "";
    $this->fCompra          = (isset($_POST['txFCompra']))    ? $_POST['txFCompra'] : "";
    $this->proveedor        = (isset($_POST['txProveedor']))  ? $_POST['txProveedor'] : "";
    $this->nFactura         = (isset($_POST['txNFactura']))   ? $_POST['txNFactura'] : "";
    $this->precio           = (isset($_POST['txPrecio']))     ? $_POST['txPrecio'] : "0";
    $this->asignado         = (isset($_POST['chxAsignado']))  ? $_POST['chxAsignado'] : "N";
    $this->prioridad        = (isset($_POST['slPrioridad']))  ? $_POST['slPrioridad'] : "B";
    $this->nota             = (isset($_POST['txNota']))       ? $_POST['txNota'] : "";

    $this->opcion           = modelMain::limpiarCadena($this->opcion);
    $this->idMaquinaDetalle = modelMain::limpiarCadena($this->idMaquinaDetalle);
    $this->tipo             = modelMain::limpiarCadena($this->tipo);
    $this->nSerial          = modelMain::limpiarCadena($this->nSerial);
    $this->modelo           = modelMain::limpiarCadena($this->modelo);
    $this->categoria        = modelMain::limpiarCadena($this->categoria);
    $this->marca            = modelMain::limpiarCadena($this->marca);
    $this->procesador       = modelMain::limpiarCadena($this->procesador);
    $this->ram              = modelMain::limpiarCadena($this->ram);
    $this->disco            = modelMain::limpiarCadena($this->disco);
    $this->mac              = modelMain::limpiarCadena($this->mac);
    $this->sOperativo       = modelMain::limpiarCadena($this->sOperativo);
    $this->nombre           = modelMain::limpiarCadena($this->nombre);
    $this->etiqueta         = modelMain::limpiarCadena($this->etiqueta);
    $this->ubicacion        = modelMain::limpiarCadena($this->ubicacion);
    $this->cCosto           = modelMain::limpiarCadena($this->cCosto);
    $this->fCompra          = modelMain::limpiarCadena($this->fCompra);
    $this->proveedor        = modelMain::limpiarCadena($this->proveedor);
    $this->nFactura         = modelMain::limpiarCadena($this->nFactura);
    $this->precio           = modelMain::limpiarCadena($this->precio);
    $this->asignado         = modelMain::limpiarCadena($this->asignado);
    $this->prioridad        = modelMain::limpiarCadena($this->prioridad);
    $this->nota             = modelMain::limpiarCadena($this->nota);

  }

  public function ajaxMaquinaDetalleC(){

    switch ($_POST['op']) {
      case '1':

        self::agregarMaquinaDetalleC();

        break;
      case '2':
        if (isset($_POST['slCategoria'])) {

          self::modificarMaquinaDetalleC();

        }else {

          self::consultarJsonMaquinaDetalleC();
          
        }
        break;
      case '3':

          self::inactivarMaquinaDetalleC();

          break;
      case '7':

        self::consultarJsonMaquinaDetalleC();

        break;
      default:

        session_start();
        session_destroy();
        echo '<script>window.location.href="'.SERVERURL.'"login</script>';

        break;
    }
   
    
  }


  public function mostrarMaquinaDetalleC(){

    return $rpta = modelMaquinaDetalle::mostrarMaquinaDetalleM();
  }

  public function consultarMaquinaDetalleC(){
    $preparar = self::prepararDatosC();
  
    return $rpta = modelMaquinaDetalle::consultarMaquinaDetalleM($this->idMaquinaDetalle);
  }

  public function consultarJsonMaquinaDetalleC(){
    $res = self::consultarMaquinaDetalleC();

    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
      echo json_encode($row);
    }

  }

  public function cargarTipoC(){
    return $rpta = modelMaquinaDetalle::cargarTipoM();
  }

  public function cargarCategoriaC(){
    $id = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
    return $rpta = modelMaquinaDetalle::cargarCategoriaM($id);
  }

  public function cargarMarcaC(){
    $filtro = (isset($_POST['filtro'])) ? $_POST['filtro'] : '';
    return $rpta = modelMaquinaDetalle::cargarMarcaM($filtro);
  }

  public function cargarCCostoC(){
    return $rpta = modelMaquinaDetalle::cargarCCostoM();
  }

  public function cargarProveedorC(){
    $filtro = (isset($_POST['filtro'])) ? $_POST['filtro'] : '';
    return $rpta = modelMaquinaDetalle::cargarProveedorM($filtro);
  }
  public function cargarSistemaOperativoC(){
    
    return $rpta = modelMaquinaDetalle::cargarSistemaOperativoM();
  }
  public function ultimoCodigo($tipo,$ccosto){
    $ultimo = "";
    $sql = "SELECT MAX(d.codInterno) AS ultimo FROM maquina_detalle d INNER JOIN maquina_categoria c ON d.idMaquinaCategoria_fk=c.idMaquinaCategoria WHERE c.idMaquinaTipo_fk=$tipo AND d.idCentroCosto_fk=$ccosto";
    $consulta = modelMain::consulta_simpleBD($sql);
    while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
      $ultimo = $row->ultimo;
    }
    $ultimo = ($ultimo == NULL) ? 0 : $ultimo;

    return $ultimo;
  }
  public function generarCodigo($ccosto,$cat){
    $sql = "SELECT idMaquinaTipo_fk FROM maquina_categoria WHERE idMaquinaCategoria=".$cat;
    $consulta = modelMain::consulta_simpleBD($sql);
    $tipo = 0;
    $codigo = 0;
    while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
      $tipo = $row->idMaquinaTipo_fk;
    }
    $ultimo = self::ultimoCodigo($tipo,$ccosto);
    
    if ($ultimo == 0) {
      $codigo = $ccosto;
      $codigo = ($tipo<10) ? $codigo."0".$tipo : $codigo.$tipo;
      $codigo = $codigo."0001";
    }else{
      $codigo = $ultimo+1;
    }
    
    return $codigo;
  }
  public function generarId(){
    $rpta = 0;
    $consulta = modelMaquinaDetalle::ultimoIdMaquinaDetalleM(); 
    while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
      $rpta = $row->ultimoId;
    }
    return $rpta+1;
  }

  public function agregarMaquinaDetalleC(){
    $rpta = false;
    self::prepararDatosC();
    $id     = self::generarId();
    $codigo = self::generarCodigo($this->cCosto,$this->categoria);
    
    $sql = "";
    $sql .= $id;
    $sql .= ",".$codigo;
    $sql .= ",".$this->categoria;
    $sql .= ",".$this->marca;
    $sql .= ",".$this->modelo;
    $sql .= ",".$this->nSerial;
    $sql .= ",".$this->procesador;
    $sql .= ",".$this->ram;
    $sql .= ",".$this->disco;
    $sql .= ",".$this->mac;
    $sql .= ",".$this->sOperativo;
    $sql .= ",".$this->nombre;
    $sql .= ",".$this->ubicacion;
    $sql .= ",".$this->etiqueta;
    $sql .= ",".$this->cCosto;
    $sql .= ",".$this->fCompra;
    $sql .= ",".$this->proveedor;
    $sql .= ",".$this->nFactura;
    $sql .= ",".$this->precio;
    $sql .= ",".$this->nota;
    $sql .= ",".$this->prioridad;
    $sql .= ",".$this->asignado;
    $sql .= ",A";
    
    
    $rpta = modelMaquinaDetalle::agregarMaquinaDetalleM($sql); 
  
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function modificarMaquinaDetalleC(){
    $rpta = false;
    self::prepararDatosC();
 
    $sql = "";
    $sql .= $this->categoria;
    $sql .= ",".$this->marca;
    $sql .= ",".$this->modelo;
    $sql .= ",".$this->nSerial;
    $sql .= ",".$this->procesador;
    $sql .= ",".$this->ram;
    $sql .= ",".$this->disco;
    $sql .= ",".$this->mac;
    $sql .= ",".$this->sOperativo;
    $sql .= ",".$this->nombre;
    $sql .= ",".$this->ubicacion;
    $sql .= ",".$this->etiqueta;
    $sql .= ",".$this->cCosto;
    $sql .= ",".$this->fCompra;
    $sql .= ",".$this->proveedor;
    $sql .= ",".$this->nFactura;
    $sql .= ",".$this->precio;
    $sql .= ",".$this->nota;
    $sql .= ",".$this->prioridad;
    $sql .= ",".$this->asignado;
    $sql .= ",".$this->idMaquinaDetalle;

    $rpta = modelMaquinaDetalle::modificarMaquinaDetalleM($sql);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

  public function inactivarMaquinaDetalleC(){
    $rpta = false;
    self::prepararDatosC();

    $sql = "SELECT * FROM maquina_detalle WHERE idMaquinaDetalle=".$this->idMaquinaDetalle;
    $res = modelMain::consulta_simpleBD($sql);
    $estado = '';
   
    while($row = $res->fetch(PDO::FETCH_OBJ)){
  
      if(($row->estado) == 'A'){
        $estado = 'I';
        
      }else {
        $estado = 'A';
      }
    }

    $datoMaquinaDetalle = [
      'id'=>$this->idMaquinaDetalle,
      'estado'=>$estado
    ];
    $rpta = modelMaquinaDetalle::inactivarMaquinaDetalleM($datoMaquinaDetalle);
    echo modelMain::msjAlertas($rpta,$this->opcion);
    return $rpta;
  }

}
