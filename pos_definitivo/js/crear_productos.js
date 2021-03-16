


window.onload=async()=>{
    
   
    
    
    
};

const mostrar_mensaje=(mensaje)=>{
  var x = document.getElementById("snackbar");
  
    // Add the "show" class to DIV
    x.className = "show";
    document.querySelector("#mensaje_toas").innerHTML=mensaje
    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  }


const contenedor_productos=document.querySelector("#contendor_productos")
let fabricantes=null
let estantes=null
let fabricante_id=1 
let fabricante_nombre=""
let estante_id=1
let estante_nombre=""
let costo_fraccion=0
const activar_tabla= ()=>{
    
  $('#dataTable').DataTable({
    language: {
      "decimal": "",
      "emptyTable": "No hay información",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
      "infoFiltered": "(Filtrado de _MAX_ total entradas)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar _MENU_ Entradas",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "Sin resultados encontrados",
      "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
      }
  }
  }); 

}

function mostrar_modal_estante(id,nombre){
    id_producto=id
    cargar_estantes()
    
    document.getElementById("titulo_modal").innerHTML="Escojer estante"
    modal_toggle()
    

    


}

function mostrar_modal_fabricante(id,nombre){
  
  id_producto=id
  cargar_fabricantes()
  
  document.getElementById("titulo_modal").innerHTML="Escojer fabricante"
  modal_toggle()
  

}


const modal_toggle=()=>{
    $('#modal').modal('toggle')
}


const cargar_fabricantes=async()=>{
  destruir_tabla()
    if(fabricantes===null){
        fabricantes=await buscar_fabricantes()
    }
    console.log(fabricantes)
    render_lista(fabricantes,contenedor_productos,false)
    

}
const cargar_estantes=async()=>{
  destruir_tabla()
    if(estantes===null){
        estantes=await buscar_estantes()
    }
    console.log(estantes)
    render_lista(estantes,contenedor_productos,true)
    

}

const buscar_estantes=async ()=>{
  
  const json = await realiazar_peticion("http://localhost/pos_2/public/estantes")
  /* console.log("lista productos",json.datos) */
  return json.datos
}

const buscar_fabricantes=async ()=>{
  
  const json = await realiazar_peticion("http://localhost/pos_2/public/fabricantes")
  /* console.log("lista productos",json.datos) */
  return json.datos
}


function render_lista(list,$container,is_estante){
    
    while ($container.hasChildNodes()) {  
        $container.removeChild($container.firstChild);
      }
  list.forEach(producto => {
    let htmlstring
    
      if(is_estante){
       htmlstring= plantilla_estante(producto)
      }else{
         htmlstring= plantilla_fabricante(producto)
      }
      
   
    $producto_element=createTemplate(htmlstring);
   // agregar_evento_click($movie_element)
   /* console.log(contenedor_productos) */
   contenedor_productos.innerHTML+=$producto_element
    

    
    /*  esto es para que la imagen tenga una inimacion de entrada
    const imagen= $producto_element.querySelector('img')
    imagen.addEventListener('load',(event)=>{
      event.target.classList.add('fadeIn')  
    }) */
    
    
    //console.log(html)
  });
  activar_tabla()

  
} 



function createTemplate(HTMLString) {
      
    /* const html = document.implementation.createHTMLDocument();
    
    html.body.innerHTML = HTMLString;
    console.log("htlm",html)
    return html.body.children[0]; */
    return HTMLString
  }

  
function plantilla_estante(estante){
    return `<tr id="pro${estante.id}" >
    <td>${estante.id} </td>
    <td>${estante.nombre}</td>
    <td ><a   
    data-placement="top" onclick="elegir_estante(${estante.id},'${estante.nombre}')"  title="Selecionar estante"  class="btn btn-danger"><i class="fas fa-trash"></i></a> 
    </td>
    </tr>`
  }


  function plantilla_fabricante(fabricante){
    return `<tr id="pro${fabricante.id}" >
    <td>${fabricante.id} </td>
    <td>${fabricante.nombre}</td>
    <td ><a   
     data-placement="top" onclick="elegir_fabricante(${fabricante.id},'${fabricante.nombre}')" title="Selecionar fabricante" class="btn btn-danger"><i class="fas fa-trash"></i></a> 
    </td>
    </tr>`
  }


  const elegir_estante=(id,nombre)=>{
    estante_id= id 
    estante_nombre= nombre 
    document.querySelector("#nombre_estante").value=nombre
    console.log("estante",estante_id)
    console.log("nombre_estante",estante_nombre)
    modal_toggle()
  }

  const elegir_fabricante=(id,nombre)=>{
    fabricante_id= id 
    fabricante_nombre= nombre 
    document.querySelector("#nombre_fabricante").value=nombre
    console.log("id_fabricante",fabricante_id)
    console.log("nombre_estante",fabricante_nombre)
    modal_toggle()
  }
 
 
  const realiazar_peticion=async(url)=>{
    const resultado = await fetch(url)
    const json =await resultado.json()
    /* console.log("productos",json) */
    return json
    
}
const realiazar_peticion_enviar=async(url,formdata)=>{
  const resultado = await fetch(url,{
    method:"POST",
    body:formdata
  })
  const json =await resultado.json()
  /* console.log("productos",json) */
  return json
  
}

const destruir_tabla =()=>{
  $('#dataTable').dataTable().fnDestroy(); 
}

const crear_evento_submit=()=>{
  formulario = document.getElementById("formulario_producto").addEventListener("onsub")
}

const crear_producto=async()=>{
  /* event.preventDefault() */
  formulario = document.getElementById("formulario_producto")
  formdata=new FormData(formulario);
  formdata.append("id_estante",estante_id)
  formdata.append("id_fabricante",fabricante_id)
  formdata.append("precio_compra_fraccion",costo_fraccion)
  console.log(formdata)

 const resultado = await realiazar_peticion_enviar("http://localhost/pos_2/public/productos/insertar",formdata)
 console.log(resultado)
 if(resultado.validation==null){
  /* alert("no hay errores") */
  mostrar_mensaje("Producto creado correctamente")
 const form= document.querySelector("#formulario_producto").reset() 
 let contenedor_errores= document.getElementById("contenedor_errores")
 contenedor_errores.style.display="none";  
 }else{
  /*  */
  console.log(resultado.validation)
  
  
   mostrar_errores(resultado.validation)
 }
}

const mostrar_errores=(errores)=>{
  let resultado=""
  for (const property in errores) {
    resultado+= `<li>${errores[property]}</li>`
     
  }

 let errores_html= document.getElementById("errores")
 let contenedor_errores= document.getElementById("contenedor_errores")
 contenedor_errores.style.display="block";  
errores_html.innerHTML=resultado


}


const cambiar_costo_fraccion=()=>{
  let fraccion= document.querySelector("#fraccion").value
  let costo_producto=document.querySelector("#precio_compra").value
  let costo_fracc=document.querySelector("#costo_fraccion")
  
  
  if(fraccion!="" && costo_producto!=""){
    costo_fraccion= costo_producto/fraccion
    costo_fracc.value=costo_fraccion
  }else{
    
    costo_fracc.value=0
    costo_fraccion=0
  }
  console.log("costo_fraccion",costo_fraccion)

}
  
    
    
  