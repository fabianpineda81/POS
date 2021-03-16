<?php
namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\VentasModel;
use App\Models\TemporalCompraModel;
use App\Models\DetalleVentaModel;
use App\Models\ProductosModel;
use App\Models\ConfiguracionModel;
use App\Models\CajasModel;


use FPDF;

class Ventas extends BaseController{
    protected $ventas,$temporal_compra,$detalle_venta,$productos,$configuracion,$cajas ;
    
    
    public  function __construct()
    {
        $this->ventas = new VentasModel();
        $this->detalle_venta = new DetalleVentaModel();
        $this->productos = new ProductosModel();
        $this->configuracion = new ConfiguracionModel();
        $this->cajas = new CajasModel();
        

        
        helper(['form']);

       
       
    }

    public function index($activo=1){

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
         /*    $unidades = $this->unidades->where('activo',$activo)->findAll();   */
            $datos=$this->ventas->obtener(1);
            // array de datos que se le envia a la vista 
            $data =['titulo'=>'Ventas','datos'=>$datos];
            

            echo view('header');
            echo view('ventas/ventas',$data);
            echo view('footer');
    }

    public function eliminados($activo=1){

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
         /*    $unidades = $this->unidades->where('activo',$activo)->findAll();   */
            $datos=$this->ventas->obtener(0);
            // array de datos que se le envia a la vista 
            $data =['titulo'=>'Ventas Eliminadas','datos'=>$datos];
            

            echo view('header');
            echo view('ventas/eliminados',$data);
            echo view('footer');
    }

    

    public function venta(){
        echo view('header');
        echo view('ventas/caja');
        echo view('footer');
    }

    public function guarda(){
        $id_venta=$this->request->getPost('id_venta');
        $forma_pago=$this->request->getPost('forma_pago');
        $id_cliente=$this->request->getPost('id_cliente');
        // esto se hace para limpiar el texto , se pone una exprecion regular para que elimine la , y el signo peso  
        $total= preg_replace('/[\$,]/','',$this->request->getPost('total')) ;
        $session= session();
        // aca buscamos la caja por id 
        $caja= $this->cajas->where('id',$session->id_caja)->first();
        $folio=$caja["folio"];

     
        $resultadoId= $this->ventas->insertaVenta($folio,$total,$session->id,$session->id_caja,$id_cliente,$forma_pago);
        $this->temporal_compra = new TemporalCompraModel();

        if($resultadoId){
            $folio++;
            $this->cajas->update($session->id_caja,['folio'=>$folio]);

            $resultadoCompra=$this->temporal_compra->porCompra($id_venta);
            foreach($resultadoCompra as $row){
                $this->detalle_venta->save([
                    'id_venta'=>$resultadoId,
                    'id_producto'=>$row['id_producto'],
                    'nombre'=>$row['nombre'],
                    'cantidad'=>$row['cantidad'],
                    'precio'=>$row['precio'],
                ]);

                $this->productos->actualizaStock($row['id_producto'],$row['cantidad'],'-');
            }
        }
        $this->temporal_compra->eliminarCompra($id_venta);

        return redirect()->to(base_url()."/ventas/muestraTicket/$resultadoId"); 



    }
    function muestraTicket($id_venta){
        $data['id_venta']=$id_venta;
      
        echo view('header');
        echo view('ventas/ver_ticket',$data);
        echo view('footer');
    }

    function generaTicket($id_venta)
    {
            $datosVenta=$this->ventas->where('id',$id_venta)->first();

            // esto de puede hacer en una sola linea
            $this->detalle_venta->select('*');
            $this->detalle_venta->where('id_venta',$id_venta);
            $detalleVenta=$this->detalle_venta->findAll();

            // con el get getrow me trae los resultados como objetos
            $this->detalle_venta->select('valor');
            $this->detalle_venta->where('nombre','tienda_nombre');
            $nombreTienda=$this->configuracion->get()->getRow()->valor;

            $this->detalle_venta->select('valor');
            $this->detalle_venta->where('nombre','tienda_direccion');
            $direccionTienda=$this->configuracion->get()->getRow()->valor;

            $this->detalle_venta->select('valor');
            $this->detalle_venta->where('nombre','ticket_leyenda');
            $leyendaTicket=$this->configuracion->get()->getRow()->valor;

            //  aca se llama la libreria para userla (previamente se tiene que poner el autoload)
            //  aca los parametros son : orientacion, medida,tamaño
            $pdf=new \FPDF('P','mm',array(80,200));
            $pdf->AddPage();
            // aca se le agregan los margenes
            $pdf->SetMargins(5,5,5);
            $pdf->SetTitle("venta");
            // aca se envia la fuete que es arial , bold , y el tamaño de la letra 9 
            $pdf->SetFont('Arial','B',10);
            // se pone par lo siguiente que se va a escribir
            
            // aca se pasa la respuesta en una celda (es como un div )  se le pasa 
            // ancho, el alto , la altura,el contenido,el borde, un 1 para que tenga un salto de linea y C para que sea centrado 
            $pdf->Cell(70,5,$nombreTienda,0,1,'C');
            // aca se hace para enviar una cabezera en la respuesta
            $pdf->SetFont('Arial','B',9);
            //  aca se manda una imagen, se le manda la posicion en x, en y , el ancho , alto, y el tipo de la imagen 
            $pdf->Image(base_url().'/images/logotipo.jpg',5,0,20,20,'jpg');
            
            
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(70,5,$direccionTienda,0,1,'C');
            $pdf->SetFont('Arial','B',9);
            
            $pdf->Cell(25,5,utf8_decode("Fecha y hora: "),0,0,'L');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(50,5,$datosVenta['fecha_alta'],0,1,'L');


            $pdf->SetFont('Arial','B',9);
            
            $pdf->Cell(15,5,utf8_decode("Ticket: "),0,0,'L');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(50,5,$datosVenta['folio'],0,1,'L');


            $pdf->ln();
            $pdf->SetFont('Arial','B',7);
            
           
            $pdf->Cell(7,5,'Cant. ',0,0,'L');
            $pdf->Cell(35,5,'Nombre',0,0,'L');
            $pdf->Cell(15,5,'Precio',0,0,'L');
            $pdf->Cell(15,5,'Importe',0,1,'L');
             
            $this->response->setHeader('Content-Type','application/pdf');
            $contador=1;
           

            foreach($detalleVenta as $row){
                
                $pdf->Cell(7,5,$row['cantidad'],0,0,'L');
                $pdf->Cell(35,5,$row['nombre'],0,0,'L');
                $pdf->Cell(15,5,$row['precio'],0,0,'L');
               

                $total= number_format($row['cantidad']*$row['precio'],2,'.',',')   ;
                $pdf->Cell(15,5,$total,0,1,'L');
                $contador++;

            }
            $pdf->ln();
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(70,5,'Total'.number_format($datosVenta['total'],2,'.',','),0,1,'R');
            $pdf->Ln();
            $pdf->MultiCell(70,4,$leyendaTicket,0,'C',0);

            $pdf->Output("ticket.pdf","I");
            
    }
    public function eliminar($id_venta ){
        $productos= $this->detalle_venta->where('id_venta',$id_venta)->findAll();
        foreach($productos as $producto){
            $this->productos->actualizaStock($producto['id_producto'],$producto['cantidad'],'+');

        }

        $this->ventas->update($id_venta,['activo'=>0]);
        return redirect()->to(base_url().'/ventas');
    }



   

  

   
}
?>