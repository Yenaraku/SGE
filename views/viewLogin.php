<div class="container">
            <div class="row">
                <div class="col-lg-12 rptaAjax">
                
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <center><h3 class="panel-title"><strong>Bienvenido a <br>Sistema de Gestion TI</h3></strong></center>
                        </div>
                        <div class="panel-body">
                            <form role="form" data-fn="Login" class="formularioAjax" action="./ajax/ajaxLogin" method="POST" data-form="1" autocomplete="off" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="form-group">
                                        <input type="hidden" name="op" value="101">
                                        <input class="form-control" placeholder="Usuario" name="txUsuario" type="text" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Contrasena" name="txContrasena" type="password" value="">
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="recordar" type="checkbox" value="Remember Me">Recordar Usuario
                                        </label>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <button type="submit" class="btn btn-lg btn-success btn-block">Entrar</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>