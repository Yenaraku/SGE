<?php
  $peticionAjax = false;
  include_once "./controller/controllerCentroCosto.php";
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Administrador Centro de Costo</h2>
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
                <a class="btn" role="button" data-opt="1" data-id="0" data-toggle="modal" data-target="#modalAgregarCentroCosto"><i class="fa fa-plus-circle"></i> Agregar Centro de Costo</a>
              </div>  
              <div class="table-responsive">
                <table class="table table-hover table-condensed">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>CCosto</th>
                      <th>Descripcion</th>
                      <th>CC Asociado</th>
                      <th>Estado</th>
                      <th>...</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $objCentroCosto = new controllerCentroCosto();
                    $res = $objCentroCosto->mostrarCentroCostoC();

                    while($row = $res->fetch(PDO::FETCH_OBJ)){
                      $r = $objCentroCosto->mostrarCentroCostoC();
                      $ccAsociado = "";
                      while ($aux = $r->fetch(PDO::FETCH_OBJ)) {
                        if ($aux->idCentroCosto == $row->idAsociado_fk) {
                          $ccAsociado = $aux->centroCosto;
                        }
                      }

                      echo "<tr>";
                      echo "<td>" . $row->idCentroCosto . "</td>";
                      echo "<td>" . $row->centroCosto . "</td>";
                      echo "<td>" . $row->descripcion . "</td>";
                      echo "<td>" . $ccAsociado . "</td>";
                      echo "<td>" . $row->estado . "</td>";
                      echo '<td>
                            <a class="btn btn-link btn-xs" data-opt="2" data-id="'.$row->idCentroCosto.'" role="button" data-toggle="modal" data-target="#modalModificarCentroCosto" title="Actualizar Registro"><i class="fa fa-pencil"></i></a>';
                      if ($row->estado == 'A') {
                        echo '<a class="btn btn-link btn-xs" data-opt="3" data-id="'.$row->idCentroCosto.'" role="button" title="Inactivar Registro"><i class="fa fa-ban"></i></a>';
                      }else{
                        echo '<a class="btn btn-link btn-xs" data-opt="3" data-id="'.$row->idCentroCosto.'" role="button" title="Activar Registro"><i class="fa fa-check"></i></a>';
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

            <div class="modal fade" id="modalAgregarCentroCosto" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                <form role="form" data-fn="CentroCosto" class="formularioAjax" action="./ajax/ajaxCentroCosto" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Agregar Centro Costo</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-12">
                        
                          <div class="form-group">
                              <label>Centro de Costo:</label>
                              <input type="hidden" name="op" value="1">
                              <input type="hidden" name="id" value="0">
                              <input class="form-control" type="text" name="txCentroCosto" placeholder="Centro de Costo" required>
                          </div>
                          <div class="form-group">
                              <label>Descripcion:</label>
                              <textarea class="form-control" rows="3" name="txDescripcion" placeholder="Descripcion"></textarea>
                          </div>
                          <div class="form-group">
                            <label>CC Asociado:</label>
                            <select class="form-control" name="slAsociado">
                              <option value="0">-</option>
                              <?php
                              $res = $objCentroCosto->mostrarCentroCostoC();

                              while($row = $res->fetch(PDO::FETCH_OBJ)){
                                if ($row->idCentroCosto < 100) {
                                  echo "<option value='$row->idCentroCosto'>$row->centroCosto</option>";
                                }else{
                                break;
                                }
                                
                              }
                              ?>
                            </select>
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
            
            <div class="modal fade" id="modalModificarCentroCosto" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                <form role="form" data-fn="CentroCosto" class="formularioAjax" action="./ajax/ajaxCentroCosto" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Actualizar Centro Costo</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-12">
                        
                          <div class="form-group">
                              <label>Centro de Costo:</label>
                              <input type="hidden" name="op" value="1">
                              <input type="hidden" name="id" value="0">
                              <input class="form-control" type="text" name="txCentroCosto" placeholder="Centro de Costo" required>
                          </div>
                          <div class="form-group">
                              <label>Descripcion:</label>
                              <textarea class="form-control" rows="3" name="txDescripcion" placeholder="Descripcion"></textarea>
                          </div>
                          <div class="form-group">
                            <label>CC Asociado:</label>
                            <select class="form-control" name="slAsociado">
                              <option value="0">-</option>
                              <?php
                              $res = $objCentroCosto->mostrarCentroCostoC();

                              while($row = $res->fetch(PDO::FETCH_OBJ)){
                                if ($row->idCentroCosto < 100) {
                                  echo "<option value='$row->idCentroCosto'>$row->centroCosto</option>";
                                }else{
                                break;
                                }
                                
                              }
                              ?>
                            </select>
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
