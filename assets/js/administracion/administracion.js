var montoglobal=0
var saldoOriginal=0;
var listaOrdenes=[];

$(document).ready(function () {

    if ($("#msg").val() == "ok") {
        toastr.success("Operación Exitosa");
        $('#toast-container').addClass('toast-top-center');
        $('#toast-container').removeClass('toast-top-right');
    }

//===================== Aplicación de pagos empresas

    //------al seleccionar una empresa en la ventana aplicación
    $("#empresa").change(function(){
      var id_empresa=$(this).val();
      console.log(id_empresa)
      var fecha_inicial=$("#fecha_inicial").val(); 
      var fecha_final=$("#fecha_final").val();
        $.ajax({
            url: "controller/administracion/administracion?opc=lista_ordenes",
            type: "POST",
            data: {'id_empresa': id_empresa,'fecha_inicial':fecha_inicial,'fecha_final':fecha_final},
     
            success: function (data) {
                console.log(data)
                saldoOriginal=data.saldo
                $("#saldo").val(data.saldo)
                $("#ordenes_pago").dataTable().fnDestroy();
                $("#tabla_ordenes").html(data.html)
                $("#ordenes_pago").dataTable()
                $("#monto").val("0")
                $("#totalordenes").val("0")
                $("#saldoFinal").val("0")
                $("#usarsaldo").prop("checked",false);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    })

    //------Usar saldo en la ventana aplicación
    $("#usarsaldo").click(function(){
      if($(this).prop("checked")==true){
           let totalOrden=parseFloat($("#totalordenes").val());
           let saldo=parseFloat($("#saldo").val())
           let monto=parseFloat($("#monto").val())
           $("#monto").attr("min",saldo);
           $("#monto").val(monto+saldo);
           $("#saldo").val(monto+saldo);
           $("#saldoFinal").val((monto+saldo)-totalOrden)
        }
        else{
          let totalOrden=parseFloat($("#totalordenes").val());
          let saldo=parseFloat($("#saldo").val())
          let monto=parseFloat($("#monto").val())
          $("#monto").attr("min","0")
          let saldoFinal=saldo-saldoOriginal;
          if(saldoFinal<totalOrden){
            alert('No se puede ejecutar la acción:El total rebasa el monto de pago')
            $("#usarsaldo").prop("checked",true);
        }
        else{
            $("#monto").val(saldoFinal);
            $("#saldo").val(saldoOriginal)
        }
        $("#saldoFinal").val(saldoFinal-totalOrden)

        }
    })

    //--------------------Seleccionar las ordenes para ser pagadas ventan Aplicación
    $("#tabla_ordenes").on('click','.checkdinero',function(){
       var montoCantidad=$("#monto").val();
       var numeroOrden=$(this).attr("data-orden");
       if(montoCantidad!=undefined &&  montoCantidad!=""){
           var monto=parseFloat($(this).attr("data-monto"));
           if($(this).is(':checked')){
             montoglobal=montoglobal+monto
             if(montoglobal>montoCantidad){
                toastr.error("Monto superado, no se puede agregar");
                $('#toast-container').addClass('toast-top-center');
                $('#toast-container').removeClass('toast-top-right');
                $(this).prop("checked",false);
                montoglobal=montoglobal-monto

            }
            else{
                $("#totalordenes").val(montoglobal) 
                listaOrdenes.push(numeroOrden);
            }
        } else {
            montoglobal=montoglobal-monto
            $("#totalordenes").val(montoglobal)
            let indice=listaOrdenes.indexOf(numeroOrden)
            listaOrdenes.splice(indice,1)
        }
        if($("#usarsaldo").prop("checked")==true){
            var saldo=parseFloat($("#saldo").val())
            saldo=saldo-montoglobal
            $("#saldoFinal").val(saldo)
        }
        var cadena=""
        for (i=0;i<listaOrdenes.length;i++){
          cadena=cadena+listaOrdenes[i]+",";
      }
      $("#lista_ordenes").val(cadena)

    }

    });

    //-----------------Botón filtrar en la ventana pagos
    $("#btn_filtrar").click(function(){
      var fecha_inicio=$("#fecha_inicio").val();
      var fecha_fin=$("#fecha_fin").val();
      var id_empresa=$("#empresa_lista").val();

      $.ajax({
            url: "controller/administracion/administracion?opc=pagos_empresa",
            type: "POST",
            data: {'empresa': id_empresa,'fecha_inicio':fecha_inicio,'fecha_fin':fecha_fin},
            success: function (data) {
                $("#cuerpoTablal").html(data);
                $("#tabla_lista_pagos").DataTable();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    })
    

});


function verestudios(id_orden,nombre_paciente){
    $.ajax({
            url: "controller/administracion/administracion?opc=lista_estudios_orden",
            type: "POST",
            data: {'id_orden': id_orden},
            dataType: 'json',
            success: function (data) {
                $("#lista-estudios .modal-body").html(data.html)
                $("#paciente_modal").text(nombre_paciente)
                $("#lista-estudios").modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
}




//===================== Aplicación de pagos empresas==========================