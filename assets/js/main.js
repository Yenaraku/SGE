$(document).ready(function(){
 //Inicio plugin datable
  $('#tabla').DataTable({
    language: {
      "decimal": ".",
      "emptyTable": "No hay información",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
      "infoEmpty": "Mostrando 0 to 0 of 0 Registros",
      "infoFiltered": "(Filtrado de _MAX_ total Registros)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar _MENU_ Registros",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "Sin resultados encontrados",
      "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": ">",
          "previous": "<"
      },
  
    }
  }); //Fin plugin datatable

  //Inicio funcion para formularios
  var formAjax = $('.formularioAjax');
  formAjax.submit(function(e){
    e.preventDefault();
    //alert('Enviaste la informacion');
    var form    = $(this);
    var tipo    = form.attr('data-form');
    var accion  = form.attr('action');
    var metodo  = form.attr('method');
    var option = $('input[name="op"]').val();
    var rpta    = $('.rptaAjax');

    var msjError ='Error Fatal';

    var formdata = new FormData(this);

    var datos = (formdata ? formdata : form.serialize());
    
    alert(form.serialize());
    //alert("Tipo: "+tipo+", Accion: "+accion+", Metodo: "+metodo+", Formulario: "+datos);
    if (option==2) {
      if(confirm("¿Estas seguro de modificar este registro?")){
        $.ajax({
          type: metodo,
          url: accion+'.php',
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          /*xhr: function(){
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress",function(evt){
              if(evt.lengtComputable){
                var porcentComplete = evt.loaded /evt.total;
                porcentComplete = parseInt(porcentComplete * 100);
                if (porcentComplete < 100) {
                  rpta.append("");
                }else {
                  rpta.html("");
                }
              }
            }, false);
            return xhr;
          },*/
          success: function(data){
          
            rpta.html(data);
          },
          error: function(){
            rpta.html(msjError);
          }
        });
      }
    }else{
      $.ajax({
        type: metodo,
        url: accion+'.php',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        /*xhr: function(){
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress",function(evt){
            if(evt.lengtComputable){
              var porcentComplete = evt.loaded /evt.total;
              porcentComplete = parseInt(porcentComplete * 100);
              if (porcentComplete < 100) {
                rpta.append("");
              }else {
                rpta.html("");
              }
            }
          }, false);
          return xhr;
        },*/
        success: function(data){
        
          rpta.html(data);
          alert(data);
        },
        error: function(){
          rpta.html(msjError);
        }
      });
    } 
  });//fin ajax


  $('body').on('click','a[data-opt]',function(){
    var a = $(this);
    var op = a.attr('data-opt');
    var id = a.attr('data-id');
    var funcion = formAjax.attr('data-fn');
    
    $('input[name="op"]').val(op);
    $('input[name="id"]').val(id);
    if(op == 1){
      $(".formularioAjax")[0].reset();
    }

    if (op == 2 || op == 6 || op==7) {
      seleccionarRegistro(funcion,op,id);
    }
    if(op == 3){
      if (confirm('¿Estas seguro de cambiar el estado del registro?')) {
        seleccionarRegistro(funcion,op,id);
      }
    }
    if (op == 102) {
      cerrarSesion(op);
    }
    
      
  });
  $('tr').on('dblclick',function(){
    var id    = $('a[data-opt]',this).attr('data-id');
    var op    = 2;
    var modal = $('a[data-opt]',this).attr('data-target');
    $(modal).modal('show');
    var funcion = formAjax.attr('data-fn');
    
    $('input[name="op"]').val(op);
    $('input[name="id"]').val(id);

    if (op == 2) {
      
      seleccionarRegistro(funcion,op,id);
    }


  });

  function seleccionarRegistro(fn, opcion, codigo) {

    $.post('./ajax/ajax'+fn+'.php', {op: opcion, id: codigo}, function(datos){
      if (opcion == 2) {
        //alert(datos);
        var reg = JSON.parse(datos);
        switch (fn) {
          case 'Usuario':
            cargarUsuario(reg);
            break;
          case 'MaquinaTipo':
            cargarMaquinaTipo(reg);
            break;
          case 'MaquinaCategoria':
            cargarMaquinaCategoria(reg);
            break;
          case 'MaquinaMarca':
            cargarMaquinaMarca(reg);
            break;
          case 'CentroCosto':
            cargarCentroCosto(reg);
            break;
          case 'Proveedor':
            cargarProveedor(reg);
            break;
          case 'MaquinaDetalle':
              cargarMaquinaDetalle(reg);
            break;  
          default:
            break;
        }
      }
      if (opcion == 3) {
        $('.rptaAjax').html(datos);
      }
      if(opcion == 6){
        
        var reg = JSON.parse(datos);
        var src = "./attachment/categoria/";
        var img = "";
        if (reg.imagen == "" || reg.imagen == null) {
          img = src+"imgInputFile.png";
        }else{
          img = src+reg.imagen;
        }
        $('#modalImgCategoria img').attr('src',img); 
      }

      if(opcion == 7){
        $.post('./ajax/ajax'+fn+'.php', {op: opcion, id: codigo}, function(datos){
          var reg = JSON.parse(datos);
          console.log(reg);
          var fr = new Date(reg.fechaRegistro);
          var fm = new Date(reg.fechaModificacion);
          $('#md-id').text("(Equipo ID: "+reg.idMaquinaDetalle+")");
          $('#md-tipo').text(reg.maquinaTipo);
          $('#md-categoria').text(reg.categoria);
          $('#md-marca').text(reg.marca);
          $('#md-modelo').text(((reg.modelo=='') ? '-': reg.modelo));
          $('#md-serial').text(((reg.nSerial==null) ? '-': reg.nSerial));
          $('#md-codigo').text(reg.codInterno);
          $('#md-procesador').text(((reg.procesador=='') ? '-': reg.procesador));
          $('#md-ram').text(((reg.ram=='') ? '-': reg.ram));
          $('#md-disco').text(((reg.disco=='') ? '-': reg.disco));
          $('#md-soperativo').text(((reg.sOperativo== null) ? '-': reg.sistemaOperativo));
          $('#md-nombre').text(((reg.nombre=='') ? '-': reg.nombre));
          $('#md-mac1').text(((reg.mac=='') ? '-': reg.mac));
          $('#md-etiqueta').text(((reg.etiqueta=='') ? '-': reg.etiqueta));
          $('#md-ubicacion').text(((reg.ubicacion=='') ? '-': reg.ubicacion));
          $('#md-ccosto').text(reg.centroCosto);
          $('#md-fcompra').text(((reg.fechaCompra==null) ? '-': reg.fechaCompra));
          $('#md-proveedor').text(((reg.proveedor==null) ? '-': (reg.proveedor+' - '+reg.nombreProveedor)));
          $('#md-nfactura').text(((reg.nFactura=='') ? '-': reg.nFactura));
          $('#md-nota').text(((reg.nota=='') ? '-': reg.nota));
          $('#md-reg').text(fr.toLocaleString('es-CO'));
          $('#md-mod').text(((reg.fechaModificacion ==null) ? '-': fm.toLocaleString('es-CO')));

        });
      }
    });

    function cargarUsuario(r) {
      $('#modalModificarUsuario input[name="id"]').val(r.idUsuario);
      $('#modalModificarUsuario input[name="txNombre"]').val(r.nombre);
      $('#modalModificarUsuario input[name="txApellido"]').val(r.apellido);
      $('#modalModificarUsuario select[name="slTipoId"]').val(r.tipoId);
      $('#modalModificarUsuario input[name="txIdentificacion"]').val(r  .nIdentificacion);
    }

    function cargarMaquinaTipo(r) {
      $('#modalModificarMaquinaTipo input[name="id"]').val(r.idMaquinaTipo);
      $('#modalModificarMaquinaTipo input[name="txMaquinaTipo"]').val(r.maquinaTipo);
      $('#modalModificarMaquinaTipo textarea[name="txDescripcion"]').val(r.descripcion);
    }

    function cargarMaquinaCategoria(r) {
      var src = "./attachment/categoria/";
      var img = "";
      $('#modalModificarCategoria input[name="id"]').val(r.idMaquinaCategoria);
      $('#modalModificarCategoria input[name="txMaquinaCategoria"]').val(r.categoria);
      $('#modalModificarCategoria select[name="slTipo"]').val(r.idMaquinaTipo_fk);
      $('#modalModificarCategoria textarea[name="txDescripcion"]').val(r.descripcion);
      if (r.imagen == "" || r.imagen == null) {
        img = src+"imgInputFile.png";
      }else{
        img = src+r.imagen;
      }
      $('#modalModificarCategoria img').attr('src',img);
      $('#modalModificarCategoria input[name="flImgCategoria"]').val("");
    
    }

    function cargarMaquinaMarca(r) {
      
      $('#modalModificarMarca input[name="id"]').val(r.idMaquinaMarca);
      $('#modalModificarMarca input[name="txMaquinaMarca"]').val(r.marca);
      $('#modalModificarMarca textarea[name="txDescripcion"]').val(r.descripcion);
      $('#modalModificarMarca input[name="txEtiqueta"]').val(r.etiqueta);
    }

    function cargarCentroCosto(r) {
      
      $('#modalModificarCentroCosto input[name="id"]').val(r.idCentroCosto);
      $('#modalModificarCentroCosto input[name="txCentroCosto"]').val(r.centroCosto);
      $('#modalModificarCentroCosto textarea[name="txDescripcion"]').val(r.descripcion);
      $('#modalModificarCentroCosto select[name="slAsociado"]').val(r.idAsociado_fk);
    }

    function cargarProveedor(r) {
      
      $('#modalModificarProveedor input[name="id"]').val(r.idProveedor);
      $('#modalModificarProveedor select[name="slTipoId"]').val(r.tipoId);
      $('#modalModificarProveedor input[name="txIdentificacion"]').val(r.nId);
      $('#modalModificarProveedor input[name="txProveedor"]').val(r.proveedor);
      $('#modalModificarProveedor input[name="txDireccion"]').val(r.direccion);
      $('#modalModificarProveedor input[name="txTelefono"]').val(r.telefono);
    }

    function cargarMaquinaDetalle(r) {

      console.log(r);
      $('#tipoEquipo').val(r.idMaquinaTipo);
      $('#modalMaquinaDetalle .modal-title').html('<i class="fa fa-pencil"></i> Editar Equipo de Inventario - ID: '+r.idMaquinaDetalle+' / Tipo: '+r.maquinaTipo+'</h4>');
      cargarFormMaquinaDetalle(r.idMaquinaTipo,r.maquinaTipo,r.idMaquinaCategoria_fk,r.idMaquinaMarca_fk);
      $('#modalMaquinaDetalle input[name="txModelo"]').val(r.modelo);
      $('#modalMaquinaDetalle input[name="txNSerial"]').val(r.nSerial);
      $('#modalMaquinaDetalle input[name="txProcesador"]').val(r.procesador);
      $('#modalMaquinaDetalle input[name="txRam"]').val(r.ram);
      $('#modalMaquinaDetalle input[name="txDisco"]').val(r.disco);
      $('#modalMaquinaDetalle input[name="txMac"]').val(r.mac);
      $('#modalMaquinaDetalle select[name="slSOperativo"]').val(r.sOperativo);
      $('#modalMaquinaDetalle input[name="txNombre"]').val(r.nombre);
      $('#modalMaquinaDetalle input[name="txUbicacion"]').val(r.ubicacion);
      $('#modalMaquinaDetalle textarea[name="txEtiqueta"]').val(r.etiqueta);
      $('#modalMaquinaDetalle select[name="slCCosto"]').val(r.idCentroCosto_fk);
      $('#modalMaquinaDetalle input[name="txFCompra"]').val(r.fechaCompra);
      $('#modalMaquinaDetalle input[name="txProveedor"]').val(r.proveedor);
      $('#modalMaquinaDetalle input[name="txBuscarProveedor"]').val(r.nombreProveedor);
      $('#modalMaquinaDetalle input[name="txNFactura"]').val(r.nFactura);
      $('#modalMaquinaDetalle input[name="txPrecio"]').val(r.precio);
      $('#modalMaquinaDetalle textarea[name="txNota"]').val(r.nota);
      if (r.asignado == "S") {
      
        $('#modalMaquinaDetalle input[name="chxAsignado"]').prop("checked", true);
      }else{
        
        $('#modalMaquinaDetalle input[name="chxAsignado"]').prop("checked", false);
      }
      $('#modalMaquinaDetalle select[name="slPrioridad"]').val(r.prioridad);
    }

  }
  //Evento que se dispara cuando se selcciona una imagen 
  $('.inputFileImg').change(function(e) {
    var id = $(this).attr('data-img');
    addImage(e,id); 
  });

  function addImage(e,id){
    var file = e.target.files[0],
    imageType = /image.*/;

    if (!file.type.match(imageType))
      return;

    var reader = new FileReader();

    reader.onload = function(e){
      var result=e.target.result;
      $(id).attr("src",result);
    }
    
  reader.readAsDataURL(file);
  }

  $('#tipoEquipo').on('change',function(){
    var tipo = $(this).val();
    var eq = $('option:selected',this).html();
    cargarFormMaquinaDetalle(tipo, eq,0,0); 
  });

  function cargarFormMaquinaDetalle(tipo, eq, cat, mar){
    
    $('input [name="tipo"]').val(tipo);
    if (tipo>1) {
      $('#soloComputador').hide();
    }else{
      $('#soloComputador').show();
    }
    $.post('./ajax/ajaxMaquinaDetalle.php', {cargar: 'categoria', tipo: tipo, slcat: cat}, function(datos){ 
      $('#slCategoria').html(datos);
    });
    $.post('./ajax/ajaxMaquinaDetalle.php', {cargar: 'marca', filtro: eq, slmar: mar}, function(datos){  
      $('#slMarca').html(datos);
    });
  }

  $('#txBuscarProveedor').on('keyup',function(e){
    var b = $(this).val();
    if(b == ''){
      $('.sugerencia').html('');
    }else{
      $.post('./ajax/ajaxMaquinaDetalle.php', {cargar: 'proveedor', filtro: b}, function(datos){
        $('.sugerencia').show(datos);
        $('.sugerencia').html(datos);
      });
    }
  });
  
  $('.sugerencia').on('click','.sugerencia-elemento',function(){
    var texto = $(this).html();
    var id = $(this).attr('data-elemt');
    $('#txBuscarProveedor').val(texto);
    $('.sugerencia').html('');
    $('#modalMaquinaDetalle input[name="txProveedor"]').val(id);
    
  });

  function cerrarSesion(op){
    var salir = confirm('¿Desea Salir de la aplicacion?');
    if (salir) {
      $.post('./ajax/ajaxLogin.php', {op: 102}, function(datos){ 
        $('body').append("<div>"+datos+"</div>");
      });
    }
  }
})
