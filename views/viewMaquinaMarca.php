<?php
  $peticionAjax = false;
  include_once "./controller/controllerMaquinaMarca.php";
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Administrador Marca Equipo</h2>
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
                <a class="btn" role="button" data-opt="1" data-id="0" data-toggle="modal" data-target="#modalAgregarMarca"><i class="fa fa-plus-circle"></i> Agregar Marca Equipo</a>
                <a class="btn" role="button" href="MaquinaTipo"><i class="fa  fa-arrow-circle-o-right"></i> Tipo de Equipo</a>
                <a class="btn" role="button" href="MaquinaCategoria"><i class="fa  fa-arrow-circle-o-right"></i> Categoria de Equipo</a>
                <a class="btn" role="button" href="MaquinaDetalle"><i class="fa fa-cubes"></i> Inventario Equipo</a>
              </div>
              <div class="table-responsive">
                <table class="table table-hover table-condensed">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Marca</th>
                      <th>Descripcion</th>
                      <th>Etiqueta</th>
                      <th>Estado</th>
                      <th>...</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $objMarca = new controllerMaquinaMarca();
                    $res = $objMarca->mostrarMaquinaMarcaC();

                    while($row = $res->fetch(PDO::FETCH_OBJ)){
                      echo "<tr>";
                      echo "<td>" . $row->idMaquinaMarca . "</td>";
                      echo "<td>" . $row->marca . "</td>";
                      echo "<td>" . $row->descripcion . "</td>";
                      echo "<td>" . $objMarca->etiquetaMaquinaMarcaC($row->etiqueta) . "</td>";
                      echo "<td>" . $row->estado . "</td>";
                      echo '<td>
                            <a class="btn btn-link btn-xs" data-opt="2" data-id="'.$row->idMaquinaMarca.'" role="button" data-toggle="modal" data-target="#modalModificarMarca" title="Actualizar Registro"><i class="fa fa-pencil"></i></a>';
                      if ($row->estado == 'A') {
                        echo '<a class="btn btn-link btn-xs" data-opt="3" data-id="'.$row->idMaquinaMarca.'" role="button" title="Inactivar Registro"><i class="fa fa-ban"></i></a>';
                      }else{
                        echo '<a class="btn btn-link btn-xs" data-opt="3" data-id="'.$row->idMaquinaMarca.'" role="button" title="Activar Registro"><i class="fa fa-check"></i></a>';
                      }
                      
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
            <div class="modal fade" id="modalAgregarMarca" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                <form role="form" data-fn="MaquinaMarca" class="formularioAjax" action="./ajax/ajaxMaquinaMarca" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-pencil"></i> Agregar Marca Equipo</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-12">
                        
                          <div class="form-group">
                              <label>Marca de Equipo:</label>
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
            
            <div class="modal fade" id="modalModificarMarca" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                <form role="form" data-fn="MaquinaMarca" class="formularioAjax" action="./ajax/ajaxMaquinaMarca" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Actualizar Marca Equipo</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-12">
                        
                          <div class="form-group">
                              <label>Marca de Equipo:</label>
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
