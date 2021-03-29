<?php
  $peticionAjax = false;
  include_once "./controller/controllerMaquinaCategoria.php";
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Administrador Categoria Equipo</h2>
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
                <a class="btn" role="button" data-opt="1" data-id="0" data-toggle="modal" data-target="#modalAgregarCategoria"><i class="fa fa-plus-circle"></i> Agregar Categoria Equipo</a>
                <a class="btn" role="button" href="MaquinaTipo"><i class="fa  fa-arrow-circle-o-right"></i> Tipo de Equipo</a>
                <a class="btn" role="button" href="MaquinaMarca"><i class="fa  fa-arrow-circle-o-right"></i> Marcas de Equipo</a>
                <a class="btn" role="button" href="MaquinaDetalle"><i class="fa fa-cubes"></i> Inventario Equipos</a>  
              </div>
              <div class="table-responsive">
                <table class="table table-hover table-condensed">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Categoria</th>
                      <th>Descripcion</th>
                      <th>Tipo</th>
                      <th>Estado</th>
                      <th>...</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $objCategoria = new controllerMaquinaCategoria();
                    $res = $objCategoria->mostrarMaquinaCategoriaC();

                    while($row = $res->fetch(PDO::FETCH_OBJ)){
                      $r = $objCategoria->mostrarTipoMaquinaFkC($row->idMaquinaTipo_fk);
                      $tipoMaquina = "";
                      while ($aux = $r->fetch(PDO::FETCH_OBJ)) {
                        $tipoMaquina = $aux->maquinaTipo;
                      }
                      echo "<tr>";
                      echo "<td>" . $row->idMaquinaCategoria . "</td>";
                      echo "<td>" . $row->categoria . "</td>";
                      echo "<td>" . $row->descripcion . "</td>";
                      echo "<td>" . $tipoMaquina . "</td>";
                      echo "<td>" . $row->estado . "</td>";
                      echo '<td>
                            <a class="btn btn-link btn-xs" data-opt="2" data-id="'.$row->idMaquinaCategoria.'" role="button" data-toggle="modal" data-target="#modalModificarCategoria" title="Actualizar Registro"><i class="fa fa-pencil"></i></a>';
                      if ($row->estado == 'A') {
                        echo '<a class="btn btn-link btn-xs" data-opt="3" data-id="'.$row->idMaquinaCategoria.'" role="button" title="Inactivar Registro"><i class="fa fa-ban"></i></a>';
                      }else{
                        echo '<a class="btn btn-link btn-xs" data-opt="3" data-id="'.$row->idMaquinaCategoria.'" role="button" title="Activar Registro"><i class="fa fa-check"></i></a>';
                      }
                      if (!empty($row->imagen) && file_exists("./attachment/categoria/".$row->imagen)) {
                        echo '<a class="btn btn-link btn-xs" data-opt="6" data-id="'.$row->idMaquinaCategoria.'" role="button" data-toggle="modal" data-target="#modalImgCategoria" title="Imagen Adjunta"><i class="fa fa-image"></i></a>';
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

            <div class="modal fade" id="modalAgregarCategoria" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                <form role="form" data-fn="MaquinaCategoria" class="formularioAjax" action="./ajax/ajaxMaquinaCategoria" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Agregar Categoria Equipo</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-xs-2 col-md-1 col-lg-2">
                          <a class="thumbnail">
                              <img id="imgAgregarCategoria" src="./attachment/categoria/imgInputFile.png" alt="..." class="img-rounde">
                          </a>
                      </div>
                      <div class="col-xs-2 col-md-3">
                          <div class="form-group">
                              <label for="">Imagen: </label>
                              <input class="inputFileImg" data-img="#imgAgregarCategoria" type="file" name="flImgCategoria" accept="image/png, .jpeg, .jpg">
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                          <div class="form-group">
                              <label>Categoria de Equipo:</label>
                              <input type="hidden" name="op" value="1">
                              <input type="hidden" name="id" value="0">
                              <input class="form-control" type="text" name="txMaquinaCategoria" placeholder="Categoria" required>
                          </div>
                          <div class="form-group">
                            <label>Tipo:</label>
                            <select class="form-control" name="slTipo" required>
                              <?php
                              $r = $objCategoria->mostrarTipoMaquinaFkC('');
                              
                              while ($aux = $r->fetch(PDO::FETCH_OBJ)) {
                                echo " <option value='". $aux->idMaquinaTipo ."'>". $aux->maquinaTipo ."</option>";
                              }
                              ?>
                            </select>
                          </div>
                          <div class="form-group">
                              <label>Descripcion:</label>
                              <textarea class="form-control" rows="3" name="txDescripcion" placeholder="Descripcion" required></textarea>
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
            
            <div class="modal fade" id="modalModificarCategoria" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                <form role="form" data-fn="MaquinaCategoria" class="formularioAjax" action="./ajax/ajaxMaquinaCategoria" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-pencil"></i> Actualizar Categoria Equipo</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-xs-2 col-md-1 col-lg-2">
                          <a class="thumbnail">
                              <img id="imgActualizarCategoria" src="./attachment/categoria/imgInputFile.png" alt="..." class="img-rounde">
                          </a>
                      </div>
                      <div class="col-xs-2 col-md-3">
                          <div class="form-group">
                              <input type="hidden" name="op" value="2">
                              <input type="hidden" name="id" value="0">
                              <label for="">Imagen: </label>
                              <input class="inputFileImg" data-img="#imgActualizarCategoria" type="file" name="flImgCategoria" accept="image/png, .jpeg, .jpg">
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                          <div class="form-group">
                              <label>Categoria de Equipo:</label>  
                              <input class="form-control" type="text" name="txMaquinaCategoria" placeholder="Categoria" required>
                          </div>
                          <div class="form-group">
                            <label>Tipo:</label>
                            <select class="form-control" name="slTipo" required>
                              <?php
                              $r = $objCategoria->mostrarTipoMaquinaFkC('');
                              
                              while ($aux = $r->fetch(PDO::FETCH_OBJ)) {
                                echo " <option value='". $aux->idMaquinaTipo ."'>". $aux->maquinaTipo ."</option>";
                              }
                              ?>
                            </select>
                          </div>
                          <div class="form-group">
                              <label>Descripcion:</label>
                              <textarea class="form-control" rows="3" name="txDescripcion" placeholder="Descripcion" required></textarea>
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

            <div class="modal fade" id="modalImgCategoria" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                <form role="form" data-fn="MaquinaCategoria" class="formularioAjax" action="./ajax/ajaxMaquinaCategoria" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-pencil"></i> Imagen Categoria Equipo</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-xs-2 col-md-3 col-lg-3">
                          <a class="thumbnail">
                              <img id="imgCategoria" src="./attachment/categoria/imgInputFile.png" alt="..." class="img-rounde">
                          </a>
                      </div>
                      <div class="col-xs-2 col-md-3">
                          <div class="form-group">
                              <input type="hidden" name="op" value="6">
                              <input type="hidden" name="id" value="0">
                              <label for="">Imagen: </label>
                              <input class="inputFileImg" data-img="#imgCategoria" type="file" name="flImgCategoria" accept="image/png, .jpeg, .jpg">
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
