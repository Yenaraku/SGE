<?php

require_once "./core/config.php";
$peticionAjax = false;
include_once "./controller/controllerLogin.php";
$login = new controllerLogin();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Bienvenido SGTI -[<?php echo $login->obtenerNombreUsuarioC(); ?>]</title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo SERVERURL; ?>assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="<?php echo SERVERURL; ?>assets/css/metisMenu.min.css" rel="stylesheet">

        <link href="<?php echo SERVERURL; ?>assets/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">

        <link href="<?php echo SERVERURL; ?>assets/css/dataTables/dataTables.responsive.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php echo SERVERURL; ?>assets/css/startmin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo SERVERURL; ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <link href="<?php echo SERVERURL; ?>assets/css/main.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    <?php
       
        if ($login->validarSesionC()) {
            include "./views/viewApp.php";
        }else {
            include "./views/viewLogin.php";
        }
        
    ?>

        <!-- jQuery -->
        <script src="<?php echo SERVERURL; ?>assets/js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo SERVERURL; ?>assets/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo SERVERURL; ?>assets/js/metisMenu.min.js"></script>

        <script src="<?php echo SERVERURL; ?>assets/js/dataTables/jquery.dataTables.min.js"></script>

        <script src="<?php echo SERVERURL; ?>assets/js/dataTables/dataTables.bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo SERVERURL; ?>assets/js/startmin.js"></script>

        <!-- Main JavaScript -->
        <script src="<?php echo SERVERURL; ?>assets/js/main.js"></script>

    </body>
</html>
