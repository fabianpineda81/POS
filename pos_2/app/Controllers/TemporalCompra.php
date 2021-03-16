<?php
namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\TemporalCompraModel;
use App\Models\ProductosModel;


class TemporalCompra extends BaseController{
    protected $Temporal_compra,$productos ;
    
    public  function __construct()
    {
        $this->Temporal_compra = new TemporalCompraModel();
        $this->productos = new ProductosModel();
        

       
       
    }

   
    public function inserta($id_producto,$cantidad,$id_compra){
        $error='';
        $producto=$this->productos->where('id',$id_producto)->first();

        if($producto){
            // aca traemos el producto si ya esta en la tabla temporal 
          $datos_existe=$this->Temporal_compra->porIdProductoCompra($id_producto,$id_compra);
          $res['datos']=$datos_existe;
          $res['id_producto']=$id_producto;
          $res['folio']=$id_compra;
          if($datos_existe){
            $cantidad=$datos_existe->cantidad+ $cantidad;
            $subtotal= $cantidad* $datos_existe->precio;
             $this->Temporal_compra->actualizarProductoCompra($id_producto,$id_compra,$cantidad,$subtotal);
          }else{
              $subtotal= $cantidad*$producto['precio_compra'];
              $this->Temporal_compra->save([
                  'folio'=>$id_compra,
                  'id_producto'=>$id_producto,
                  'codigo'=>$producto['codigo'],
                  'nombre'=>$producto['nombre'],
                  'precio'=>$producto['precio_compra'],
                  'cantidad'=>$cantidad,
                  'subtotal'=>$subtotal
              ]);

          }

        }else{
            $error="No existe el producto";

        }
        // aca es como se validad que los campos esten llenos desde php (mirar la documentacion para mas informacion)
       $res['error']=$error;
       $res['hola']=$this;
       $res['datos']=$this->cargarProductos($id_compra);
       // aca le ponermos formato a los numeros
       $res['total']= number_format($this->totalProductos($id_compra),2,'.',',')  ;
       echo json_encode($res);
        
    }

        public function cargarProductos($id_compra){
            $resultado= $this->Temporal_compra->porCompra($id_compra);
            $fila='';
            $numfila =0; 

            foreach($resultado as $row){
                $numfila++;

                $fila.="<tr id='fila".$numfila."'>" ;
                $fila.="<td>".$numfila."</td>";
                $fila.="<td>".$row['codigo']."</td>";
                $fila.="<td>".$row['nombre']."</td>";
                $fila.="<td>".$row['precio']."</td>";
                $fila.="<td>".$row['cantidad']."</td>";
                $fila.="<td>".$row['subtotal']."</td>";
                $fila.="<td><a onclick=\"eliminaProducto(".$row['id_producto'].",'".$id_compra."')\"  class='borrar'> <span class='fas fa-fw fa-trash'></span></a> </td>";
                
                $fila.="</tr>";


            }

            return $fila;
        }

        public function totalProductos($id_compra){
            $resultado= $this->Temporal_compra->porCompra($id_compra);
            $total=0;

            foreach($resultado as $row){
                    $total+=$row['subtotal'];



            }

            return $total;
        }
        public function eliminar($id_producto,$id_compra)
        {
            $datos_existe=$this->Temporal_compra->porIdProductoCompra($id_producto,$id_compra);
            if($datos_existe){
                if($datos_existe->cantidad>1){
                  $cantidad=$datos_existe->cantidad-1;
                $subtotal=$cantidad*$datos_existe->precio;
                $this->Temporal_compra->actualizarProductoCompra($id_producto,$id_compra,$cantidad,$subtotal);

                }else{
                    $this->Temporal_compra->eliminarProductoCompra($id_producto,$id_compra);
                }
                

            }
            $res['datos']=$this->cargarProductos($id_compra);
            // aca le ponermos formato a los numeros
            $res['total']= number_format($this->totalProductos($id_compra),2,'.',',')  ;
            $res['error']='';
            echo json_encode($res);
            
        }
        
}
?>