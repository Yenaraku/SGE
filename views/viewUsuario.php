<?php
  $peticionAjax = false;
  include_once "./controller/controllerUsuario.php";
  
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Administrador de Usuario</h2>
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
                <a class="btn" role="button" data-opt="1" data-id="0" data-toggle="modal" data-target="#modalAgregarUsuario"><i class="fa fa-plus-circle"></i> Agregar Usuario</a>
              </div>
              <div class="table-responsive">
                <table class="table table-hover table-condensed">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Tipo ID</th>
                      <th>Cedula</th>
                      <th>Usuario</th>
                      <th>Estado</th>
                      <th>...</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $objUsuario = new controllerUsuario();
                    $res = $objUsuario->mostrarUsuarioC();

                    while($row = $res->fetch(PDO::FETCH_OBJ)){
                      $estado = ($row->estado == 'A') ? '<span class="label label-success">activo</span>' : '<span class="label label-danger">inactivo</span>';
                      echo "<tr>";
                      echo "<td>" . $row->idUsuario . "</td>";
                      echo "<td>" . $row->nombre . "</td>";
                      echo "<td>" . $row->apellido . "</td>";
                      echo "<td>" . $row->tipoId . "</td>";
                      echo "<td>" . $row->nIdentificacion . "</td>";
                      echo "<td>" . $row->usuario . "</td>";
                      echo "<td>" . $estado . "</td>";
                      echo '<td>
                            <a class="btn btn-link btn-xs" data-opt="2" data-id="'.$row->idUsuario.'" role="button" data-toggle="modal" data-target="#modalModificarUsuario" title="Actualizar Registro"><i class="fa fa-pencil"></i></a>';
                      if ($row->estado == 'A') {
                        echo '<a class="btn btn-link btn-xs" data-opt="3" data-id="'.$row->idUsuario.'" role="button" title="Inactivar Registro"><i class="fa fa-ban"></i></a>';
                      }else{
                        echo '<a class="btn btn-link btn-xs" data-opt="3" data-id="'.$row->idUsuario.'" role="button" title="Activar Registro"><i class="fa fa-check"></i></a>';
                      }
                      echo '<a class="btn btn-link btn-xs" data-opt="4" data-id="'.$row->idUsuario.'" role="button" data-toggle="modal" data-target="#modalCambiarUsuario" title="Cambiar Contraseña"><i class="fa fa-key"></i></a>';
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

            <div class="modal fade" id="modalAgregarUsuario" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                <form role="form" data-fn="Usuario" class="formularioAjax" action="./ajax/ajaxUsuario" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Agregar Usuario</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-12">
                        
                          <div class="form-group">
                              <label>Nombres:</label>
                              <input type="hidden" name="op" value="1">
                              <input type="hidden" name="id" value="0">
                              <input class="form-control" type="text" name="txNombre" placeholder="Nombre" required>
                          </div>
                          <div class="form-group">
                              <label>Apellidos:</label>
                              <input class="form-control" type="text" name="txApellido" placeholder="Apellidos" required>
                          </div>
                          <div class="form-group">
                            <label>Identificacion:</label>
                            <div class="form-inline">
                              <select class="form-control" name="slTipoId" required>
                                  <option value="0">-- --</option>
                                  <option value="TI">T.I</option>
                                  <option value="CC">C.C</option>
                              </select>
                              <input class="form-control" type="number" name="txIdentificacion" placeholder="Identificacion" required>
                            </div>
                          </div>
                          <div class="form-group">
                              <label>Usuario:</label>
                              <input class="form-control" type="text" name="txUsuario" placeholder="Usuario" required>
                          </div>
                          <div class="form-group">
                              <label>Contraseña:</label>
                              <input class="form-control" type="password" name="txClave" placeholder="Contraseña" required>
                          </div>
                          <div class="form-group">
                              <label>Repetir Contraseña:</label>
                              <input class="form-control" type="password" name="txRepetir" placeholder="Repetir" required>
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

            <div class="modal fade" id="modalModificarUsuario" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                <form role="form" data-fn="Usuario" class="formularioAjax" action="./ajax/ajaxUsuario" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-pencil"></i> Modificar Usuario</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-12">
                        
                        <div class="form-group">
                            <label>Nombres:</label>
                            <input type="hidden" name="op" value="1">
                            <input type="hidden" name="id" value="0">
                            <input class="form-control" type="text" name="txNombre" placeholder="Nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Apellidos:</label>
                            <input class="form-control" type="text" name="txApellido" placeholder="Apellidos" required>
                        </div>
                        <div class="form-group">
                          <label>Identificacion:</label>
                          <div class="form-inline">
                            <select class="form-control" name="slTipoId" required>
                                <option value="0">-- --</option>
                                <option value="TI">T.I</option>
                                <option value="CC">C.C</option>
                            </select>
                            <input class="form-control" type="number" name="txIdentificacion" placeholder="Identificacion" required>
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

            <div class="modal fade" id="modalCambiarUsuario" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                  <form role="form" data-fn="Usuario" class="formularioAjax" action="./ajax/ajaxUsuario" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><i class="fa fa-key"></i> Cambiar Contraseña de Usuario</h4>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-lg-12">
                          
                            <div class="form-group">
                                <input type="hidden" name="op" value="1">
                                <input type="hidden" name="id" value="0">
                            </div>

                            <div class="form-group">
                                <label>Contraseña:</label>
                                <input class="form-control" type="password" name="txClave" placeholder="Contraseña" required>
                            </div>
                            <div class="form-group">
                                <label>Confirmar:</label>
                                <input class="form-control" type="password" name="txRepetir" placeholder="Repetir" required>
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
