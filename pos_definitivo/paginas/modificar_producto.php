<?php 
include('header.php')
?>
<div class="alert alert-danger" id="contenedor_errores" style="display: none;" >
  <ul id="errores">
    
  </ul>
</div>
<form id="formulario_producto" class="mt-3" onsubmit="actualizar_producto(); return false">
  <div class="form-row">
      
    
    
    <div class="form-group col">
    <label for="inputEmail4">Codigo de Barras</label>
      <input type="text" name="codigo_barras" id="codigo_barras" class="form-control" required >
    </div>

    <div class="form-group col">
    <label for="inputEmail4">Descripcion</label>
      <input type="text" name="descripcion" id="descripcion" class="form-control" required >
    </div>

    <div class="form-group col">
    <label for="inputEmail4">nombre</label>
      <input type="text" name="nombre"  id="nombre" class="form-control" >
    </div>
  </div>
  
  

  <div class="form-row">
      <div class="form-group col">
        <label for="inputEmail4">Presentacion</label>
         <input type="text" name="presentacion"  id="presentacion" class="form-control" required >
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
         <input type="text" id="precio_compra"   onchange="cambiar_costo_fraccion()" name="precio_compra" class="form-control" required >
      </div>
    
    
    <div class="form-group col">
    <label for="inputEmail4"  >Fraccion</label>
      <input type="text" id="fraccion"  onchange="cambiar_costo_fraccion()" id="fraccion" name="fraccion" class="form-control" required >
    </div>

    <div class="form-group col">
    <label>Costo Fracion</label>
    <input type="text" id="costo_fraccion" name="costo_fraccion"  class="form-control" required readonly >
  </div>
</div>
<div class="form-row">
      <div class="form-group col">
        <label for="inputEmail4">IVA</label>
         <input type="text" id="iva" name="iva" class="form-control" required >
      </div>
    
    
    <div class="form-group col">
    <label for="inputEmail4">stock Maximo</label>
      <input type="text" id="stock_maximo" name="stock_maximo" class="form-control" required >
    </div>

    <div class="form-group col">
    <label>stock_minimo</label>
    <input type="text" id="stock_minimo" name="stock_minimo" class="form-control" required  >
  </div>
</div>

  <div class="form-row">
  <div class="form-group col">
        <label for="inputEmail4">Precio Venta</label>
         <input type="text" id="precio_venta" name="precio_venta" class="form-control" required >
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

<?php 
include('footer.php')
?>
<script src="./../js/modificar_producto.js"></script>