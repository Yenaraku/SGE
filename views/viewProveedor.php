<?php
  $peticionAjax = false;
  include_once "./controller/controllerProveedor.php";
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Administrador Proveedor</h1>
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
                <a class="btn" role="button" data-opt="1" data-id="0" data-toggle="modal" data-target="#modalAgregarProveedor"><i class="fa fa-plus-circle"></i> Agregar Proveedor</a>
              </div>
              <div class="table-responsive">
                <table class="table table-hover table-condensed">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Tipo</th>
                      <th>Identificacion</th>
                      <th>Proveedor</th>
                      <th>Direccion</th>
                      <th>Telefono</th>
                      <th>Estado</th>
                      <th>...</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $objUsuario = new controllerProveedor();
                    $res = $objUsuario->mostrarProveedorC();

                    while($row = $res->fetch(PDO::FETCH_OBJ)){
                      $estado = ($row->estado == 'A') ? '<span class="label label-success">activo</span>' : '<span class="label label-danger">inactivo</span>';
                      echo "<tr>";
                      echo "<td>" . $row->idProveedor . "</td>";
                      echo "<td>" . $row->tipoId . "</td>";
                      echo "<td>" . $row->nId . "</td>";
                      echo "<td>" . $row->proveedor . "</td>";
                      echo "<td>" . $row->direccion . "</td>";
                      echo "<td>" . $row->telefono . "</td>";
                      echo "<td>" . $estado . "</td>";
                      echo '<td>
                            <a class="btn btn-link btn-xs" data-opt="2" data-id="'.$row->idProveedor.'" role="button" data-toggle="modal" data-target="#modalModificarProveedor" title="Actualizar Registro"><i class="fa fa-pencil"></i></a>';
                      if ($row->estado == 'A') {
                        echo '<a class="btn btn-link btn-xs" data-opt="3" data-id="'.$row->idProveedor.'" role="button" title="Inactivar Registro"><i class="fa fa-ban"></i></a>';
                      }else{
                        echo '<a class="btn btn-link btn-xs" data-opt="3" data-id="'.$row->idProveedor.'" role="button" title="Activar Registro"><i class="fa fa-check"></i></a>';
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

            <div class="modal fade" id="modalAgregarProveedor" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                <form role="form" data-fn="Proveedor" class="formularioAjax" action="./ajax/ajaxProveedor" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Agregar Proveedor</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-12">
                          <div class="form-group">
                            <input type="hidden" name="op" value="1">
                            <input type="hidden" name="id" value="0">
                            <label>Doc Identificacion:</label>
                            <div class="form-inline">
                              <select class="form-control" name="slTipoId" required>
                                <option value="NIT">NIT</option>
                                <option value="CC">CC</option>
                              </select>
                              <input class="form-control" type="number" name="txIdentificacion" placeholder="Numero Identificacion" required>
                            </div> 
                          </div>
                         
                          <div class="form-group">
                              <label>Proveedor:</label>
                              <input class="form-control" type="text" name="txProveedor" placeholder="Proveedor" required>
                          </div>
                          <div class="form-group">
                              <label>Direccion:</label>
                              <input class="form-control" type="text" name="txDireccion" placeholder="Direccion">
                          </div>
                          <div class="form-group">
                              <label>Telefono:</label>
                              <input class="form-control" type="text" name="txTelefono" placeholder="Telefono">
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

            <div class="modal fade" id="modalModificarProveedor" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                <form role="form" data-fn="Proveedor" class="formularioAjax" action="./ajax/ajaxProveedor" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Actualizar Proveedor</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-12">
                          <div class="form-group">
                            <input type="hidden" name="op" value="1">
                            <input type="hidden" name="id" value="0">
                            <label>Doc Identificacion:</label>
                            <div class="form-inline">
                              <select class="form-control" name="slTipoId" required>
                                <option value="NIT">nit</option>
                                <option value="NIT">cc</option>
                              </select>
                              <input class="form-control" type="number" name="txIdentificacion" placeholder="Numero Identificacion" required>
                            </div> 
                          </div>
                         
                          <div class="form-group">
                              <label>Proveedor:</label>
                              <input class="form-control" type="text" name="txProveedor" placeholder="Proveedor" required>
                          </div>
                          <div class="form-group">
                              <label>Direccion:</label>
                              <input class="form-control" type="text" name="txDireccion" placeholder="Direccion">
                          </div>
                          <div class="form-group">
                              <label>Telefono:</label>
                              <input class="form-control" type="text" name="txTelefono" placeholder="Telefono">
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
