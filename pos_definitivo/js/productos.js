/* variables globales  */
let id_producto="20"
let id_reingresar="20"
let mostrar_eliminados=false



window.onload=()=>{
    
    toggle_productos()
    activar_tabla()
    
    
    
    
};

const contenedor_productos=document.querySelector("#contendor_productos")
const activar_tabla= ()=>{
    
      $('#dataTable').DataTable(); 
    
}

const destruir_tabla =()=>{
    $('#dataTable').dataTable().fnDestroy(); 
}



 function mostrar_modal(id,nombre){
    id_producto=id
    
     document.getElementById("id_modal").value=id
    document.getElementById("nombre_modal").value=nombre
    document.getElementById("titulo_modal").innerHTML="¿Desea Eliminar este producto?"
    modal_toggle()
    document.getElementById("btn_confirmar").setAttribute("onclick","eliminar_producto()")

    


}

function mostrar_modal_reingresar(id,nombre){
    id_producto=id
     
     document.getElementById("id_modal").value=id
     document.getElementById("nombre_modal").value=nombre
     document.getElementById("titulo_modal").innerHTML="¿Desea Reingresar este producto?"
     document.getElementById("btn_confirmar").setAttribute("onclick","reingresar_producto()")
     modal_toggle()
     
     
 
 
 }

const monstar_mensaje=(mensaje)=>{
var x = document.getElementById("snackbar");

  // Add the "show" class to DIV
  x.className = "show";
  document.querySelector("#mensaje_toas").innerHTML=mensaje
  // After 3 seconds, remove the show class from DIV
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

const modal_toggle=()=>{
    $('#modal').modal('toggle')
}



const eliminar_html=(e)=>{
    e.target.parentNode.parentNode.remove()
}


const realiazar_peticion=async(url)=>{
    const resultado = await fetch(url)
    const json =await resultado.json()
    /* console.log("productos",json) */
    return json
    
}








/* codigo para la carga de los productos  */
const toggle_productos=async()=>{
    
    
    if(mostrar_eliminados){
        document.getElementById("btn_toggle_productos").innerHTML="ver Productos"
        await  cargar_producto_eliminados()
        mostrar_eliminados=false
        
    }else{
        document.getElementById("btn_toggle_productos").innerHTML="ver eliminados"
        await cargar_productos()
        mostrar_eliminados=true
        
    }
}

const cargar_productos=async()=>{
    document.getElementById("titulo_pagina").innerHTML="Productos"
    const productos=await buscar_productos()
    render_producto_lista(productos,contenedor_productos,false)
    
    
}



const cargar_producto_eliminados=async()=>{
    
    document.getElementById("titulo_pagina").innerHTML="Productos eliminados"
    const productos=await buscar_productos_eliminados()
    render_producto_lista(productos,contenedor_productos,true)
}

function render_producto_lista(list,$container,eliminados){
    
    while ($container.hasChildNodes()) {  
        $container.removeChild($container.firstChild);
    }
    list.forEach(producto => {
        let htmlstring
        
        if(eliminados){
            htmlstring= plantilla_producto_eliminado(producto)
        }else{
            htmlstring= plantilla_producto(producto)
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
function plantilla_producto(producto){
return `<tr id="pro${producto.id}" >
<td>${producto.id} </td>
<td>${producto.codigo_barras} </td>
<td>${producto.nombre} </td>
<td>${producto.precio_venta} </td>
<td >${producto.existencias} </td>
<td> <img src="" width="100">  </td>                                
<td><a class="btn btn-warning col-12" href="./modificar_producto.php?id=${producto.id}"><i class="fas fa-pencil-alt "></i></a> </td>
<td onclick="mostrar_modal(${producto.id},'${producto.nombre}')"><a   
data-target="#modal-confirma" data-placement="top" title="Eliminar registro" class="btn btn-danger"><i class="fas fa-trash"></i></a> 
</td>
</tr>`}

function plantilla_producto_eliminado(producto){
    return `<tr id="pro${producto.id}" >
    <td>${producto.id} </td>
    <td>${producto.codigo_barras} </td>
    <td>${producto.nombre} </td>
    <td>${producto.precio_venta} </td>
    <td >${producto.existencias} </td>
    <td> <img src="" width="100">  </td>                                
    <td><a class="btn btn-warning col-12" href="./modificar_producto.php?id=${producto.id}" ><i class="fas fa-pencil-alt "></i></a> </td>
    <td onclick="mostrar_modal_reingresar(${producto.id},'${producto.nombre}')"><a   
    data-target="#modal-confirma" data-placement="top" title="Eliminar registro" class="btn btn-danger"><i class="fas fa-arrow-alt-circle-up"></i></a> 
    </td>
    </tr>`
}

/* aca se acab */


























const eliminar_producto= async()=>{
    modal_toggle();
    const resultado = await realiazar_peticion(`http://localhost/pos_2/public/productos/eliminar/${id_producto}`);
    monstar_mensaje("Eliminado correctamente")
    await cargar_productos()
     activar_tabla() 
    
} 

const reingresar_producto=async()=>{
    
    modal_toggle();
    const resultado = await realiazar_peticion(`http://localhost/pos_2/public/productos/reingresar/${id_producto}`);
    monstar_mensaje("Reingresado correctamente")
    await cargar_producto_eliminados()
     activar_tabla() 
    
}

const buscar_productos= async()=>{
    destruir_tabla() 
    const json = await realiazar_peticion("http://localhost/pos_2/public/productos")
     console.log("lista productos",json) 
    return json.datos

    
}



const buscar_productos_eliminados= async()=>{
     destruir_tabla() 
    const json = await realiazar_peticion("http://localhost/pos_2/public/productos/eliminados")
    /* console.log("lista productos",json.datos) */
    return json.datos
    
}