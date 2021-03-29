<?php
     require_once "./controller/controllerVista.php";
     $objVista = new controllerVista();
?>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">SGTI</a>
                </div>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <ul class="nav navbar-nav navbar-left navbar-top-links">
                    <!--<li><a href="#"><i class="fa fa-home fa-fw"></i> Website</a></li>-->
                </ul>

                <ul class="nav navbar-right navbar-top-links">
                    <span></span>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['usuario']['usuario'] ?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href=""><?php echo $_SESSION['usuario']['nombreCompleto'] ?></a></li>
                            <li><a href=""><i class="fa fa-gear fa-fw"></i> Acerca de..</a>
                            </li>
                            <li class="divider"></li>
                            <li><a data-opt="102"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- /.navbar-top-links -->
                <!-- Menu Left-->
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="Tablero"><i class="fa fa-dashboard fa-fw"></i>Tablero</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Gestion de Equipo<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">

                                    <li>
                                        <a href="MaquinaDetalle">Inventario de Equipo</a>
                                    </li>
                                    <li>
                                        <a href="OrdenTrabajo">Orden de Trabajo</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-wrench fa-fw"></i> Administrativo<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="Usuario">Usuario</a>
                                    </li>
                                    <li>
                                        <a href="#">Equipo<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a href="MaquinaTipo">Tipo de Maquina</a>
                                            </li>
                                            <li>
                                                <a href="MaquinaCategoria">Categoria de Mquina</a>
                                            </li>
                                            <li>
                                                <a href="MaquinaMarca">Marca de Maquina</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="Proveedor">Proveedor</a>
                                    </li>
                                    <li>
                                        <a href="CentroCosto">Centro de Costo</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
                <!--/. Menu Left-->
            </nav>

            <!-- Page Content -->
            <?php
             
              $cargarVista = $objVista->controller_obtenerVista();

              include $cargarVista;
            ?>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

