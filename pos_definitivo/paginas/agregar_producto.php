<?php include_once('header.php') ?>
<h1>Agregar Producto</h1>
<div class="alert alert-danger" id="contenedor_errores" style="display: none;" >
  <ul id="errores">

  </ul>
</div>




<form id="formulario_producto" class="mt-3" onsubmit="crear_producto(); return false">
  <div class="form-row">
      
    
    
    <div class="form-group col">
    <label for="inputEmail4">Codigo de Barras</label>
      <input type="text" name="codigo_barras" class="form-control" required >
    </div>

    <div class="form-group col">
    <label for="inputEmail4">Descripcion</label>
      <input type="text" name="descripcion" class="form-control" required >
    </div>

    <div class="form-group col">
    <label for="inputEmail4">nombre</label>
      <input type="text" name="nombre"  id="nombre" class="form-control" >
    </div>
  </div>
  
  

  <div class="form-row">
      <div class="form-group col">
        <label for="inputEmail4">Presentacion</label>
         <input type="text" name="presentacion" class="form-control" required >
      </div>
    
    
    <div class="form-group col">
    <label for="inputEmail4">Fabricante</label>
      <input type="text" id="nombre_fabricante"  class="form-control" required readonly >
    </div>

    <div class="form-group col">
    <label>Elegir Fabricante</label>
    <input type="button" value="Elegir Fabricante" onclick="mostrar_modal_fabricante()" class="btn btn-primary form-control"/>
  </div>
</div>
<div class="form-row">
      <div class="form-group col">
        <label for="inputEmail4">Precio compra</label>
         <input type="number" id="precio_compra" onchange="cambiar_costo_fraccion()" name="precio_compra" class="form-control" required >
      </div>
    
    
    <div class="form-group col">
    <label for="inputEmail4"  >Fraccion</label>
      <input type="number"  onchange="cambiar_costo_fraccion()" id="fraccion" name="fraccion" class="form-control" required >
    </div>

    <div class="form-group col">
    <label>Costo Fracion</label>
    <input type="number" id="costo_fraccion" name="costo_fraccion"  class="form-control" required readonly >
  </div>
</div>
<div class="form-row">
      <div class="form-group col">
        <label for="inputEmail4">IVA</label>
         <input type="number" id="iva" name="iva" class="form-control" required >
      </div>
    
    
    <div class="form-group col">
    <label for="inputEmail4">stock Maximo</label>
      <input type="number" id="stock_maximo" name="stock_maximo" class="form-control" required >
    </div>

    <div class="form-group col">
    <label>stock_minimo</label>
    <input type="number" id="stock_minimo" name="stock_minimo" class="form-control" required  >
  </div>
</div>

  <div class="form-row">
  <div class="form-group col">
        <label for="inputEmail4">Precio Venta</label>
         <input type="number" id="precio_venta" name="precio_venta" class="form-control" required >
      </div>
      <div class="form-group col-4">
        <label for="inputEmail4">Estante</label>
         <input type="text" id="nombre_estante" class="form-control" required readonly >
      </div>
    
    
    <div class="form-group col-4">
    <label for="inputEmail4">Elegir Estante</label>
    <input type="button" value="Elegir Estante" onclick="mostrar_modal_estante()" class="btn btn-primary form-control"/>
    </div>

   


</div>
<div class="form-row">
<div class="form-group col-6 offset-3">
    <label for="inputEmail4"></label>
    <input type="submit" value="Crear producto"  class="btn btn-primary form-control"/>
    </div>
</div>

  
</form>

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
          <h2 id="titulo_modal">¿?</h2>
          <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>codigo</th>
                            
                            <th></th>

                        </tr>
                    </thead>
             
                <tbody id="contendor_productos">
                        <tr>
                                <td>id </td>
                                <td>codigo </td>
                               
                                
                                <td><a data-href="'/productos/eliminar/'" href="#"  data-toggle="modal"
                                data-target="#modal-confirma" data-placement="top" title="Eliminar registro" class="btn btn-danger"><i class="fas fa-trash"></i></a> 
                                </td>

                                
                            </tr>
                         </tbody>
                    </table>
</div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="btn_confirmar" class="btn btn-danger" >Si</button>
      </div>
    </div>
  </div >
</div>

<?php include_once('footer.php') ?>
<script src="../js/crear_productos.js"></script>
