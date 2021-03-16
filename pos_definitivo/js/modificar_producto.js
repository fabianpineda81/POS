
const valores =window.location.search;
var producto=""
let fabricante_id=0
let estante_id=0


//Mostramos los valores en consola:
/* console.log(valores); */

//Creamos la instancia
const urlParams = new URLSearchParams(valores);

//Accedemos a los valores
var id = urlParams.get('id');

window.onload=()=>{
    buscar_producto_id();
}

const realizar_peticion=async(url)=>{
    const resultado = await fetch(url)
    const json =await resultado.json()
    /* console.log("productos",json) */
    return json
    
}

const buscar_producto_id=async()=>{
    const json = await realizar_peticion(`http://localhost/pos_2/public/productos/id/${id}`)
    
    if(json.existe==true){
        console.log(json)
        
       await mostrar_informacion(json.datos)
    }else{
        alert("no existe")
    }
}

 const mostrar_informacion=async(producto)=>{
    /* producto = JSON.parse(producto) */
    id_fabricante=producto.id_fabricante
    id_estante=producto.id_estante
    let estante= await buscar_estante(id_estante)
    let fabricante=await buscar_fabricante(id_fabricante)

    document.querySelector("#nombre_estante").value=estante.nombre
    document.querySelector("#nombre_fabricante").value=fabricante.nombre
    document.querySelector("#codigo_barras").value=producto.codigo_barras
    document.querySelector("#descripcion").value=producto.descripcion
    document.querySelector("#nombre").value=producto.nombre
    document.querySelector("#presentacion").value=producto.presentacion
    document.querySelector("#precio_compra").value=producto.precio_compra
    document.querySelector("#fraccion").value=producto.fraccion
    document.querySelector("#costo_fraccion").value=producto.precio_compra_fraccion
    document.querySelector("#iva").value=producto.iva
    document.querySelector("#stock_maximo").value=producto.stock_maximo
    document.querySelector("#stock_minimo").value=producto.stock_minimo
    document.querySelector("#precio_venta").value=producto.precio_venta

 }

 const buscar_fabricante=async(id_fabricante)=>{
    const json =await  realizar_peticion(`http://localhost/pos_2/public/fabricantes/id/${id_fabricante}`)
    return json.datos
 } 

 const buscar_estante=async(id_estante)=>{
    const json =await  realizar_peticion(`http://localhost/pos_2/public/estantes/id/${id_estante}`)
    return json.datos
 }



 const actualizar_producto=async()=>{
    /* event.preventDefault() */
    formulario = document.getElementById("formulario_producto")
    formdata=new FormData(formulario);
    formdata.append("id",id)
    formdata.append("id_estante",estante_id)
    formdata.append("id_fabricante",fabricante_id)
    formdata.append("precio_compra_fraccion",costo_fraccion)
    console.log(formdata)
  
   const resultado = await realiazar_peticion_enviar("http://localhost/pos_2/public/productos/actualizar",formdata)
   console.log(resultado)
   if(resultado.validation==null){
    /* alert("no hay errores") */
    mostrar_mensaje("Producto Actualizado correctamente")
   /* const form= document.querySelector("#formulario_producto").reset()  */
   let contenedor_errores= document.getElementById("contenedor_errores")
   contenedor_errores.style.display="none";  
   }else{
    /*  */
    console.log(resultado.validation)
    
    
     mostrar_errores(resultado.validation)
   }
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


  const realiazar_peticion_enviar=async(url,formdata)=>{
    const resultado = await fetch(url,{
      method:"POST",
      body:formdata
    })
    const json =await resultado.json()
    /* console.log("productos",json) */
    return json
    
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


  const mostrar_mensaje=(mensaje)=>{
    var x = document.getElementById("snackbar");
    
      // Add the "show" class to DIV
      x.className = "show";
      document.querySelector("#mensaje_toas").innerHTML=mensaje
      // After 3 seconds, remove the show class from DIV
      setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
  


