<?php include("./header.php")?>


<h4 class="mt-4" id="titulo_pagina"> productos</h4>
            <div>
                <p>
                    <a href="./agregar_producto.php" class="btn btn-info">Agregar</a>
                    <button onclick="toggle_productos()" id="btn_toggle_productos" class="btn btn-warning">eliminados</button>
                    <a href="/productos/muestraCodigos" class="btn btn-primary">Codigos de barras</a>
                </p>
            </div>
<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>codigo</th>
                            <th>nombre</th>
                            <th>precio</th>
                            <th>existencias</th>
                            <th>Imagen</th>
                            <th></th>
                            <th></th>

                        </tr>
                    </thead>
             
                <tbody id="contendor_productos">
                        <tr>
                                <td>id </td>
                                <td>codigo </td>
                                <td>nombre </td>
                                <td>precio de venta </td>
                                <td>existencias </td>

                                <td> <img src="" width="100">  </td>                                

                                <td><a  href="./modificar_producto.php?id=1" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a> 

                                </td>
                                

                                

                                <td><a data-href="'/productos/eliminar/'" href="#"  data-toggle="modal"
                                data-target="#modal-confirma" data-placement="top" title="Eliminar registro" class="btn btn-danger"><i class="fas fa-trash"></i></a> 
                                </td>

                                
                            </tr>
                         </tbody>
                    </table>
</div>   


<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <h2 id="titulo_modal">¿Desea eliminar este producto?</h2>
          <div class="form-row">
          <div class="form-group col-6">
              <label for="exampleFormControlFile1">id</label>
              <input type="text" id="id_modal" readonly class="form-control" value="0">
             
         </div>
         <div class="form-group col-6">
            <label for="exampleFormControlFile1">Nombre</label>
            <input type="text" id="nombre_modal" readonly class="form-control" value="nombre">
             </div> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="btn_confirmar" class="btn btn-danger" >Si</button>
      </div>
    </div>
  </div>
</div>




<script src="../js/productos.js">
    
</script>

   <?php include("./footer.php")?>           