<?php
$id_compra = uniqid();

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">





            <form method="POST" id="form_compra" name="form_compra" action="<?php echo base_url(); ?>/Compras/guarda" autocomplete="off">

                <div class="from-group">

                    <div class="row mb-3">

                        <div class="col-12 col-sm-4">
                            <input type="hidden" id="id_producto" name="id_prodcutos">
                            <input type="hidden" id="id_compra" name="id_compra" value="<?php echo $id_compra?>">
                            <label>Codigo</label>
                            <!-- aca enviamos los datos a la funcion de js -->
                            <input class="form-control" id="codigo" name="codigo" type="text" autofocus placeholder="Escrbe el codigo y enter" onkeyup="buscarProducto(event,this,this.value )" />
                            <label for="codigo" id="resultado_error" style="color:red"></label>
                        </div>

                        <div class="col-12 col-sm-4">
                            <label>Nombre producto</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" required disabled />

                        </div>

                        <div class="col-12 col-sm-4">
                            <label>Cantidad</label>
                            <input class="form-control" id="cantidad" name="cantidas" type="number" oninput="calcular_subtotal()" />

                        </div>
                    </div>
                </div>


                <div class="from-group">

                    <div class="row mb-3">

                        <div class="col-12 col-sm-4">
                            <label>Precio de compra</label>
                            <input class="form-control" id="precio_compra" name="precio_compra" type="text" disabled />

                        </div>

                        <div class="col-12 col-sm-4">
                            <label>Subtotal</label>
                            <input class="form-control" id="subtotal" name="subtotal" type="text" disabled />

                        </div>

                        <div class="col-12 col-sm-4 mt-4">
                            <!-- aca se pasa el id_producto.value que es un imput  -->
                            <button id="agregar_producto" name="agregar_producto" type="button" class="btn btn-primary" onclick="agregarProducto(id_producto.value,cantidad.value,'<?php echo $id_compra; ?>')">Agregar producto</button>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <table id="tablaProductos" class="table table-hover table-striped table-sm table-responsive tablaProductos" width="100%">
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

                <div class="row">
                    <div class="col-12 col-sm-6 offset-sm-6">
                        <label style="font-weight: bold; font-size: 30px; text-align: center;">total$ </label>
                        <input type="text" id="total" name="total" size="7" readonly value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;">
                        <button type="button" id="completa_compra" class="btn btn-success">Completar comprar</button>
                    </div>
                </div>


            </form>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $("#completa_compra").click(function(){
                /* con esto sabemos cuantas filas tiene mi tabla */
                let nFila=$("#tablaProductos tr").length 
                if(nFila<2){

                }else{
                    
                    $("#form_compra").submit()
                }
            })
            

        });

        function calcular_subtotal() {
            let cantidad = $('#cantidad').val();
            let precio_compra = $('#precio_compra').val();
            let subtotal = cantidad * precio_compra;

            $('#subtotal').val(subtotal);

        }

        function buscarProducto(e, tagCodigo, codigo) {
            // el enter en codigo 13 en la table asky v:
            var enterkey = 13;
            if (codigo != '') {
                if (e.which == enterkey) {

                    $.ajax({
                        url: '<?php echo base_url(); ?>/productos/buscarPorCodigo/' + codigo,
                        dataType: 'json',
                        success: function(resultado) {
                            // si no nos trae nada viene en 0 
                            if (resultado == 0) {

                                $(tagcodigo).val('')
                            } else {
                                $(tagCodigo).remove('has-error');
                                $('#resultado_error').html(resultado.error);
                                if (resultado.existe) {
                                    $('#id_producto').val(resultado.datos.id);
                                    $('#nombre').val(resultado.datos.nombre);
                                    $('#cantidad').val(1);
                                    $('#precio_compra').val(resultado.datos.precio_compra);
                                    $('#subtotal').val(resultado.datos.precio_compra);
                                    $('#cantidad').focus();

                                } else {
                                    $('#id_producto').val('');
                                    $('#nombre').val('');
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

        function agregarProducto(id_producto, cantidad, id_compra) {
            // el enter en codigo 13 en la table asky v:

            if (id_producto != null && id_producto != 0 && cantidad > 0) {


                $.ajax({
                    url: '<?php echo base_url(); ?>/TemporalCompra/inserta/' + id_producto + "/" + cantidad + "/" + id_compra,
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

        function eliminaProducto(id_producto,id_compra) {
            // el enter en codigo 13 en la table asky v:
            var enterkey = 13;
            

                    $.ajax({
                        url: '<?php echo base_url(); ?>/TemporalCompra/eliminar/' + id_producto+"/"+id_compra,
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



        
        
        
            async function buscar() {
            const respuesta = await fetch('http://localhost/pos/public/productos/buscarPorCodigo/123458', {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            const json = await respuesta.json();
            debugger
            return json
        }

        // buscar();
    </script>