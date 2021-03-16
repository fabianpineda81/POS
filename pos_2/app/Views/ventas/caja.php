<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">

            <?php

            $idVentaTmp = uniqid();
            ?>
            <br>
            <form id="form_venta" name="form_venta" class="from-horizontal" method="POST" action="<?php echo base_url() ?>/ventas/guarda" autocomplete="off">
                <input type="hidden" id="id_venta" name="id_venta" value="<?php echo $idVentaTmp; ?>">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="iu-widget">
                                <label for="">Cliente:</label>
                                <input type="hidden" id="id_cliente" name="id_cliente" value="1">

                                <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Escribe el nombre del cliente" value="Publico en general" onkeyup="" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-sm-6">

                            <label for="">Forma de pago:</label>

                            <select id="forma_pago" name="forma_pago" class="form-control" required>
                                <option value="01">Efectivo </option>
                                <option value="02">Tarjeta </option>
                                <option value="03">Transferencia </option>
                            </select>

                        </div>



                    </div>
                </div>
                <div class="from-group">

                    <div class="row mb-3">

                        <div class="col-12 col-sm-4">
                            <input type="hidden" id="id_producto" name="id_prodcutos">

                            <label>Codigo de barras </label>
                            <!-- aca enviamos los datos a la funcion de js -->
                            <input class="form-control" id="codigo" name="codigo" type="text" autofocus placeholder="Escrbe el codigo y enter" onkeyup="agregarProducto(event,this.value,1,'<?php echo $idVentaTmp?>');" />

                        </div>
                        <div class="col-sm-2">
                            <label for="codigo" id="resultado_error" style="color:red"></label>
                        </div>



                        <div class="col-12 col-sm-4">
                            <label style="font-weight: bold; font-size: 30px; text-align: center;">total$ </label>
                            <input type="text" id="total" name="total" size="7" readonly value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;">

                        </div>
                    </div>
                </div>

                <div class="from-group">
                    <button type="button" id="completa_venta" class="btn btn-success">Completar Venta</button>
                </div>













                <div class="row">
                    <table id="tablaProductos" class="table table-hover table-striped table-sm table-responsive tablaProductos col-12">
                        <thead class="thead-dark">
                            <th>#</th>
                            <th>Cadigo</th>
                            <th>nombre</th>
                            <th>precio</th>
                            <th>cantidad</th>
                            <th>total</th>
                            <th width="1%"></th>

                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </form>
        </div>

    </main>

    <script>
        //esta es la funcion de auto completado
        $(function() {
            $("#cliente").autocomplete({
                // se donde se va a sacar la informacion
                source: "<?php echo base_url() ?>/clientes/autocompleteData",
                // longitud minima para que se realize la funcion 
                minLength: 3,
                // el select es lo que hace cuando se seleciona un elemento 
                select: function(event, ui) {
                    event.preventDefault();
                    // aca se manda al imput type hiden el id y al imput de texto coja el nombre 
                    $('#id_cliente').val(ui.item.id);
                    $('#cliente').val(ui.item.value);
                }
            })
        })

        $(function() {
            $("#codigo").autocomplete({
                // se donde se va a sacar la informacion
                source: "<?php echo base_url() ?>/productos/autocompleteData",
                // longitud minima para que se realize la funcion 
                minLength: 3,
                // el select es lo que hace cuando se seleciona un elemento 
                select: function(event, ui) {
                    event.preventDefault();
                    // aca se manda al imput type hiden el id y al imput de texto coja el nombre 
                    $('#codigo').val(ui.item.value);
                    setTimeout(
                        function() {

                            e = jQuery.Event("keypress")
                            // aca se simula que se preciona la tecla enter cambiando del valor del objeto e 
                            e.which = 13;
                            agregarProducto(e,ui.item.id,1,'<?php echo $idVentaTmp?>');
                        }
                    )


                }
            })
        })

        function agregarProducto(e, id_producto, cantidad, id_venta) {
            // el enter en codigo 13 en la table asky v:
            let enterKey = 13;
            if (codigo != '') {
                if (e.which == enterKey) {



                    if (id_producto != null && id_producto != 0 && cantidad > 0) {


                        $.ajax({
                            url: '<?php echo base_url(); ?>/TemporalCompra/inserta/' + id_producto + "/" + cantidad + "/" + id_venta,
                            dataType: 'json',
                            success: function(resultado) {

                                // si no nos trae nada viene en 0 
                                if (resultado == 0) {


                                } else {
                                    debugger

                                    if (resultado.error == '') {
                                        $("#tablaProductos tbody").empty();
                                        $("#tablaProductos tbody").append(resultado.datos);
                                        $("#total").val(resultado.total);
                                        $('#id_producto').val('');
                                        $('#nombre').val('');
                                        $('#codigo').val('');
                                        $('#cantidad').val('');
                                        $('#precio_compra').val('');
                                        $('#sub_total').val('');

                                    }
                                }

                            }
                        })

                    }

                }
            }
        }


        function eliminaProducto(id_producto,id_venta) {
            // el enter en codigo 13 en la table asky v:
            var enterkey = 13;
            

                    $.ajax({
                        url: '<?php echo base_url(); ?>/TemporalCompra/eliminar/' + id_producto+"/"+id_venta,
                        dataType: 'json',
                        success: function(resultado) {
                            // si no nos trae nada viene en 0 
                            if (resultado == 0) {

                                $(tagcodigo).val('')
                            } else {
                                $("#tablaProductos tbody").empty();
                                $("#tablaProductos tbody").append(resultado.datos);
                                $("#total").val(resultado.total);
                               
                            }

                        }
                    })


            }



            $(function(){
                $('#completa_venta').click(function(){
                    let nfilas=$("#tablaProductos tr").length;
                    if(nfilas<2){
                            alert("debe agrear un producto")
                    }else{
                        $("#form_venta").submit();
                    }
                })
            })
    </script>