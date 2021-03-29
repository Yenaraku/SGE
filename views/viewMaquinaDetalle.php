<?php
  $peticionAjax = false;
  include_once "./controller/controllerMaquinaDetalle.php";
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Inventario de Equipos</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
          <div class="col-lg-12 rptaAjax">
          
          </div>
        </div>
        <div class="row">

            <div class="col-lg-12">
              <div class="well well-sm">
                <div class="form-inline">
                  <select class="form-control" id="tipoEquipo" name="txTipoEquipo">
                
                  <?php
                  $objEquipo = new controllerMaquinaDetalle();
                  $res = $objEquipo->cargarTipoC();
                  while($row = $res->fetch(PDO::FETCH_OBJ)){
                    echo "<option value='$row->idMaquinaTipo'>$row->maquinaTipo</option>";
                  }
                  ?>
                  </select>
                  <a class="btn" role="button" data-opt="1" data-id="0" data-toggle="modal" data-target="#modalMaquinaDetalle"><i class="fa fa-plus-circle"></i> Agregar Inventario</a>
                  
                  <div class="form-group input-group" style="margin-left:50px">
                   
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-hover table-condensed" id="tabla" data-order='[[ 0, "desc" ]]' data-page-length='10'>
                  <thead>
                    <tr>
                      <th>ID </th>
                      <th>Codigo</th>
                      <th>Tipo</th>
                      <th>Categoria</th>
                      <th>Marca</th>
                      <th>Modelo</th>
                      <th>N/S</th>
                      <th>Estado</th>
                      <th>...</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   
                    $res = $objEquipo->mostrarMaquinaDetalleC();
                    
                    while($row = $res->fetch(PDO::FETCH_OBJ)){
                      $estado = ($row->estado == 'A') ? '<span class="label label-success">activo</span>' : '<span class="label label-danger">inactivo</span>';
                      echo "<tr>";
                      echo "<td>" . $row->idMaquinaDetalle . "</td>";
                      echo "<td>" . $row->codInterno . "</td>";
                      echo "<td>" . $row->maquinaTipo . "</td>";
                      echo "<td>" . $row->categoria . "</td>";
                      echo "<td>" . $row->marca . "</td>";
                      echo "<td>" . $row->modelo . "</td>";
                      echo "<td>" . $row->nSerial . "</td>";
                      echo "<td>" . $estado . "</td>";
                      echo '<td>
                            <a class="btn btn-link btn-xs" data-opt="2" data-id="'.$row->idMaquinaDetalle.'" role="button" data-toggle="modal" data-target="#modalMaquinaDetalle" title="Actualizar Registro"><i class="fa fa-pencil"></i></a>';
                      if ($row->estado == 'A') {
                        echo '<a class="btn btn-link btn-xs" data-opt="3" data-id="'.$row->idMaquinaDetalle.'" role="button" title="Inactivar Registro"><i class="fa fa-ban"></i></a>';
                      }else{
                        echo '<a class="btn btn-link btn-xs" data-opt="3" data-id="'.$row->idMaquinaDetalle.'" role="button" title="Activar Registro"><i class="fa fa-check"></i></a>';
                      }
                      echo '<a class="btn btn-link btn-xs" data-opt="7" data-id="'.$row->idMaquinaDetalle.'" role="button" data-toggle="modal" data-target="#modalInfoDetallada" title="Info Detallada"><i class="fa fa-file-text-o"></i></a>';
                      echo '<a class="btn btn-link btn-xs" data-opt="8" data-id="'.$row->idMaquinaDetalle.'" role="button" data-toggle="modal" data-target="#modalModificarMaquinaDetalle" title="Agregar Orden Trabajo"><i class="fa fa-clipboard"></i></a>';
                      echo '<div class="btn-group">
                      <button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <span class="fa fa-ellipsis-v"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#">Adjuntos</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Cambiar Tipo</a></li>
                      </ul>
                    </div>';
                      echo '</td>';
                      echo "</tr>";
                  }

                  ?>
                  </tbody>
                </table>
              </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="modal fade" id="modalMaquinaDetalle" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <form role="form" data-fn="MaquinaDetalle" class="formularioAjax" action="./ajax/ajaxMaquinaDetalle" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Agregar Equipo al Inventario</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-12">
                          
                          <div class="form-group">
                              <input type="hidden" name="op" value="1">
                              <input type="hidden" name="id" value="0">
                              <input type="hidden" name="tipo" value="1">
                          </div>
                          
                          <div class="row borde borde-redondo">
                          <h5 class="borde-titulo"><span>General</span></h5>
                          <div class="form-group">
                            <div class="col-lg-3">
                              <label>Categoria</label>
                              <select class="form-control input-sm" id="slCategoria" name="slCategoria" required>
                                <?php
                                $res = $objEquipo->cargarCategoriaC();
                                while($row = $res->fetch(PDO::FETCH_OBJ)){
                                  echo "<option value='$row->idMaquinaCategoria'>$row->categoria</option>";
                                }
                                ?>
                              </select>
                            </div>
                            <div class="col-lg-2">
                              <label>Marca</label>
                              <select class="form-control input-sm" id="slMarca" name="slMarca" required>
                                
                                <?php
                                $res = $objEquipo->cargarMarcaC();
                                while($row = $res->fetch(PDO::FETCH_OBJ)){
                                  echo "<option value='$row->idMaquinaMarca'>$row->marca</option>";
                                }
                                ?>
                              </select>
                            </div>
                            <div class="col-lg-3">
                              <label>Modelo</label>
                              <input type="text" class="form-control input-sm" name="txModelo" placeholder="Modelo" required>
                            </div>
                            <div class="col-lg-4">
                              <label>N° Serial</label>
                              <input type="text" class="form-control input-sm" name="txNSerial" placeholder="N/S" required>
                            </div>
                          </div>
                          </div>
                          
                          <div class="row borde borde-redondo">
                          <h5 class="borde-titulo"><span>Caracteristicas</span></h5>
                          <div class="form-group" id="soloComputador">
                            <div class="col-lg-4">
                              <label>Procesador</label>
                              <input type="text" class="form-control input-sm" name="txProcesador" placeholder="Procesador">
                              <span>
                              
                              </span>
                            </div>
                            <div class="col-lg-2">
                              <label>Memoria Ram</label>
                              <input type="text" list="itemsRam" class="form-control input-sm" name="txRam" placeholder="Memoria Ram">
                              <datalist id="itemsRam">
                                <option value="4GB"></option>
                                <option value="8GB"></option>
                                <option value="16GB"></option>
                              </datalist>
                            </div>
                            <div class="col-lg-2">
                              <label>Disco Duro</label>
                              <input type="text" list="itemsDisco" class="form-control input-sm" name="txDisco" placeholder="Disco Duro">
                              <datalist id="itemsDisco">
                                <option value="500GB"></option>
                                <option value="1TB"></option>
                                <option value="2TB"></option>
                                <option value="500GB HDD"></option>
                                <option value="1TB HDD"></option>
                                <option value="2TB HDD"></option>
                                <option value="128GB SSD"></option>
                                <option value="250GB SSD"></option>
                                <option value="512GB SDD"></option>     
                              </datalist>
                            </div>
                          
                            <div class="col-lg-4">
                              <label>Sistema Operativo</label>
                              <select class="form-control input-sm" name="slSOperativo" placeholder="Sistema Operativo">
                                <option value=null></option>
                                <?php
                                  $res = $objEquipo->cargarSistemaOperativoC();
                                  while($row = $res->fetch(PDO::FETCH_OBJ)){
                                    echo "<option value='$row->idSistemaOperativo'>$row->sistemaOperativo</option>";
                                  }
                                ?>
                              </select>
                              <span>
                              
                              </span>
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-lg-3">
                              <label>Nombre Equipo</label>
                              <input type="text" class="form-control input-sm" name="txNombre" placeholder="Nombre Equipo">
                            </div>
                            <div class="col-lg-4">
                              <label>Mac 1</label>
                              <input type="text" class="form-control input-sm" name="txMac" placeholder="Mac">
                            </div>
                          </div>
                          </div>
                          
                          <div class="row borde borde-redondo">
                          <h5 class="borde-titulo"><span>Organizacion</span></h5>
                          <div class="form-group">
                            <div class="col-lg-3">
                              <label>Etiqueta</label>
                              <textarea class="form-control input-sm" rows="1" name="txEtiqueta" placeholder="Etiqueta"></textarea>
                            </div> 
                            <div class="col-lg-5">
                              <label>Ubicacion</label>
                              <input type="text" class="form-control input-sm" name="txUbicacion" placeholder="Ubicacion">
                            </div> 
                            <div class="col-lg-3">
                              <label>Centro Costo</label>
                              <select class="form-control input-sm" name="slCCosto" required>
                                <?php
                                $res = $objEquipo->cargarCCostoC();
                                while($row = $res->fetch(PDO::FETCH_OBJ)){
                                  echo "<option value='$row->idCentroCosto'>$row->centroCosto</option>";
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-lg-2">
                              <label>Asignar:</label>
                              <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="chxAsignado" value="S">Asignado
                                </label>
                              </div>
                          
                            </div>
                            <div class="col-lg-3">
                              <label>Prioridad Mtto:</label>
                              <select class="form-control input-sm" name="slPrioridad">
                                <option value='B'>Baja</option>
                                <option value='M'>Media</option>
                                <option value='A'>Alta</option>
                              </select>
                            </div>
                          </div>
                          </div>

                          <div class="row borde borde-redondo">
                          <h5 class="borde-titulo"><span>Informacion de Compra</span></h5>
                          <div class="form-group">
                            <div class="col-lg-3">
                              <label>Fecha Compra</label>
                              <input type="date" class="form-control input-sm" name="txFCompra" placeholder="Nit/CC" value="<?php echo date('Y-m-d');?>">
                                
                              <span>
                              
                              </span>
                            </div>
                            <div class="col-lg-3">
                              <label>Proveedor</label>
                              <input type="hidden" name="txProveedor" value="">
                              <input type="text" class="form-control input-sm" name="txBuscarProveedor" id="txBuscarProveedor" placeholder="Nombre del Proveedor">
                              <div class="sugerencia">
                                
                              </div>
                            </div>
                            <div class="col-lg-3">
                              <label># Factura</label>
                              <input type="text" class="form-control input-sm" name="txNFactura" placeholder="No. Factura">
                            </div>
                            <div class="col-lg-3">
                              <label>Precio Unit. $:</label>
                              <input type="text" class="form-control input-sm" name="txPrecio" placeholder="Precio del Equipo">
                            </div>
                          </div>
                          </div>
                          
                          <div class="row form-group">
                            <div class="col-lg-10">
                              <label>Nota</label>
                              <textarea class="form-control input-sm" rows="1" name="txNota" placeholder="Nota"></textarea>
                            </div> 
                          </div>
                        
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!-- modal Informacion Detallada-->
            <div class="modal fade" id="modalInfoDetallada" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-file-text-o"></i> Informacion Detallada - <strong id="md-id">(Equipo ID: 1)</strong></h4>
                  </div>
                  <div class="modal-body">
                    <div class="row borde borde-redondo">
                        <h5 class="borde-titulo"><span>General</span></h5>
                        <div class="col-lg-2 col-xs-6"> 
                          <b>Tipo: </b>
                        </div>
                        <div class="col-lg-4 col-xs-6">
                          <p id="md-tipo">Computador</p>
                        </div>
                        <div class="col-lg-2 col-xs-6">
                          <b>Categoria: </b>
                        </div>
                        <div class="col-lg-4 col-xs-6">  
                          <p id="md-categoria">Todo en uno</p>
                        </div>
                        <div class="col-lg-2 col-xs-6">
                          <b>Marca: </b>
                        </div>
                        <div class="col-lg-4 col-xs-6">
                          <p id="md-marca"> HP</p>
                        </div>
                        <div class="col-lg-2 col-xs-6">
                          <b>Modelo: </b>
                        </div>
                        <div class="col-lg-4 col-xs-6">
                          <p id="md-modelo">MD-432</p>
                        </div>
                        <div class="col-lg-2 col-xs-6">
                          <b>N/S: </b>
                        </div>
                        <div class="col-lg-4 col-xs-6">
                          <p id="md-serial">18764788399</p>
                        </div>
                        <div class="col-lg-2 col-xs-6">
                          <b>Cod Interno: </b>
                        </div>
                        <div class="col-lg-4 col-xs-6">
                          <p id="md-codigo">101010002</p>
                        </div>
                      
                    </div>
                    <div class="row borde borde-redondo">
                        <h5 class="borde-titulo"><span>Componente</span></h5>
                        <div class="col-lg-3 col-xs-6"> 
                          <b>Procesador: </b>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                          <p id="md-procesador">Core i3 @ 3.5</p>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                          <b>Memoria Ram: </b>
                        </div>
                        <div class="col-lg-3 col-xs-6">  
                          <p id="md-ram">Todo en uno</p>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                          <b>Disco Duro: </b>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                          <p id="md-disco">DDR3 4 GB</p>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                          <b>S/Operativo: </b>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                          <p id="md-soperativo">Windows 10 pro</p>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                          <b>Nombre: </b>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                          <p id="md-nombre">-</p>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                          <b>Mac 1: </b>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                          <p id="md-mac1">101010002</p>
                        </div>
                      
                    </div>
                    <div class="row borde borde-redondo">
                        <h5 class="borde-titulo"><span>Otro</span></h5>
                        <div class="col-lg-2 col-xs-6"> 
                          <b>Etiqueta: </b>
                        </div>
                        <div class="col-lg-4 col-xs-6">
                          <p id="md-etiqueta">-</p>
                        </div>
                        <div class="col-lg-2">
                          <b>Ubicacion: </b>
                        </div>
                        <div class="col-lg-4">  
                          <p id="md-ubicacion">-</p>
                        </div>
                        <div class="col-lg-2">
                          <b>C.Costo: </b>
                        </div>
                        <div class="col-lg-4">
                          <p id="md-ccosto">-</p>
                        </div>
                        <div class="col-lg-3">
                          <b>Fecha Compra: </b>
                        </div>
                        <div class="col-lg-3">
                          <p id="md-fcompra">-</p>
                        </div>
                        <div class="col-lg-2">
                          <b>Proveedor: </b>
                        </div>
                        <div class="col-lg-4">
                          <p id="md-proveedor">-</p>
                        </div>
                        <div class="col-lg-2">
                          <b>#Factura: </b>
                        </div>
                        <div class="col-lg-4">
                          <p id="md-nfactura">-</p>
                        </div>                     
                    </div>
                    <div class="row borde borde-redondo">
                      <h5 class="borde-titulo"><span>Nota</span></h5>
                      <div class="col-lg-12">
                        <p id="md-nota">Ejemplo</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <small><em><b><i class="fa fa-floppy-o"></i> Registrado: </b> <span id="md-reg">-</span></small></em>
                      </div>
                      <div class="col-lg-6">
                        <small><em><b><i class="fa fa-pencil-square-o"></i> Modificado: </b><span id="md-mod">-</span></small></em>
                      </div>
                    </div>
                  
                  </div>
                  <div class="modal-footer">
                    <button title="Cerrar" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
                    <button title="Exportar a PDF" type="button" class="btn btn-danger"> <i class="fa fa-file-pdf-o"></i></button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!-- modal Orden de Trabajo-->
            <div class="modal fade" id="modalInfoDetallada" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Orden de Trabajo</h4>
                  </div>
                  <div class="modal-body">
                    
                  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                    <button type="button" class="btn btn-danger">Exportar <i class="fa fa-file-pdf-o"></i></button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!-- Modal agregar orden de trabajo -->
            <div class="modal fade" id="modalOrdenDeTrabajo" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                <form role="form" data-fn="MaquinaMarca" class="formularioAjax" action="./ajax/ajaxMaquinaMarca" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-pencil"></i> Agregar Orden de Trabajo</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-12">
                        
                          <div class="form-group">
                              <label>Tipo de Orden:</label>
                              <input type="hidden" name="op" value="1">
                              <input type="hidden" name="id" value="0">
                              <input class="form-control" type="text" name="txMaquinaMarca" placeholder="Marca" required>
                          </div>
                          <div class="form-group">
                              <label>Descripcion:</label>
                              <textarea class="form-control" rows="3" name="txDescripcion" placeholder="Descripcion"></textarea>
                          </div>
                          <div class="form-group">
                              <label>Etiqueta:</label>
                              <input class="form-control" type="text" name="txEtiqueta" placeholder="Etiqueta">
                          </div>

                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
          
          </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
