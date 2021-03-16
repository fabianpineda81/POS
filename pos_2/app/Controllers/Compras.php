<?php
namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\ComprasModel;
use App\Models\TemporalCompraModel;
use App\Models\DetalleCompraModel;
use App\Models\ProductosModel;
use App\Models\ConfiguracionModel;
use FPDF;

class Compras extends BaseController{
    protected $compras,$temporal_compra,$detalle_compra,$productos,$configuracion ;
    protected $reglas;
    
    public  function __construct()
    {
        $this->compras = new ComprasModel();
        $this->detalle_compra = new DetalleCompraModel();
        $this->productos = new ProductosModel();
        $this->configuracion = new ConfiguracionModel();

        
        helper(['form']);

       
       
    }

    public function index($activo=1){

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
         /*    $unidades = $this->unidades->where('activo',$activo)->findAll();   */
         $compras= $this->compras->where('activo',$activo)->findAll();
            // array de datos que se le envia a la vista 
            $data =['titulo'=>'Compras','compras'=>$compras];
            

            echo view('header');
            echo view('compras/compras',$data);
            echo view('footer');
    }

    public function eliminados($activo=0){

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
            $unidades = $this->unidades->where('activo',$activo)->findAll();  
            // array de datos que se le envia a la vista 
            $data =['titulo'=>'Unidades Eliminados','datos'=>$unidades];

            echo view('header');
            echo view('unidades/eliminados',$data);
            echo view('footer');
    }

    public function nuevo(){
        echo view('header');
        echo view('compras/nuevo');
        echo view('footer');
    }

    public function guarda(){
        $id_compra=$this->request->getPost('id_compra');
        // esto se hace para limpiar el texto , se pone una exprecion regular para que elimine la , y el signo peso  
        $total= preg_replace('/[\$,]/','',$this->request->getPost('total')) ;
        $session= session();
        
     
        $resultadoId= $this->compras->insertaCompra($id_compra,$total,$session->id);
        $this->temporal_compra = new TemporalCompraModel();

        if($resultadoId){
            $resultadoCompra=$this->temporal_compra->porCompra($id_compra);
            foreach($resultadoCompra as $row){
                $this->detalle_compra->save([
                    'id_compra'=>$resultadoId,
                    'id_producto'=>$row['id_producto'],
                    'nombre'=>$row['nombre'],
                    'cantidad'=>$row['cantidad'],
                    'precio'=>$row['precio'],
                ]);

                $this->productos->actualizaStock($row['id_producto'],$row['cantidad']);
            }
        }
        $this->temporal_compra->eliminarCompra($id_compra);

        return redirect()->to(base_url()."/compras/muestraCompraPdf/$resultadoId");

        
        
    }

   

    function muestraCompraPdf($id_compra){
        $data['id_compra']=$id_compra;
      
        echo view('header');
        echo view('compras/ver_compra_pdf',$data);
        echo view('footer');
    }

    function generaCompraPdf($id_compra)
    {
            $datosCompra=$this->compras->where('id',$id_compra)->first();

            // esto de puede hacer en una sola linea
            $this->detalle_compra->select('*');
            $this->detalle_compra->where('id_compra',$id_compra);
            $detalleCompra=$this->detalle_compra->findAll();

            // con el get getrow me trae los resultados como objetos
            $this->detalle_compra->select('valor');
            $this->detalle_compra->where('nombre','tienda_nombre');
            $nombreTienda=$this->configuracion->get()->getRow()->valor;

            $this->detalle_compra->select('valor');
            $this->detalle_compra->where('nombre','tienda_direccion');
            $direccionTienda=$this->configuracion->get()->getRow()->valor;

            //  aca se llama la libreria para userla (previamente se tiene que poner el autoload)
            //  aca los parametros son : orientacion, medida,tamaño
            $pdf=new \FPDF('P','mm','letter');
            $pdf->AddPage();
            // aca se le agregan los margenes
            $pdf->SetMargins(10,10,10);
            $pdf->SetTitle("Compra");
            // aca se envia la fuete que es arial , bold , y el tamaño de la letra 9 
            $pdf->SetFont('Arial','B',10);
            // se pone par lo siguiente que se va a escribir
            
            // aca se pasa la respuesta en una celda (es como un div )  se le pasa 
            // ancho, el alto , la altura,el contenido,el borde, un 1 para que tenga un salto de linea y C para que sea centrado 
            $pdf->Cell(195,5,"Entrada de productos",0,1,'C');
            // aca se hace para enviar una cabezera en la respuesta
            $pdf->SetFont('Arial','B',9);
            //  aca se manda una imagen, se le manda la posicion en x, en y , el ancho , alto, y el tipo de la imagen 
            $pdf->Image(base_url().'/images/imagen.jpg',185,10,20,20,'jpg');
            $pdf->Cell(50,5,$nombreTienda,0,1,'L');
            $pdf->Cell(20,5,utf8_decode("Direccion: "),0,0,'L');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(50,5,$direccionTienda,0,1,'L');
            $pdf->SetFont('Arial','B',9);
            
            $pdf->Cell(25,5,utf8_decode("Fecha y hora: "),0,0,'L');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(50,5,$datosCompra['fecha_alta'],0,1,'L');
            $pdf->ln();
            $pdf->SetFont('Arial','B',8);
            $pdf->SetFillColor(0,0,0); 
            $pdf->SetTextColor(255,255,255);
            // el 1 que esta despues de la "C" se hace para ponerle fondo y color se le pone con la funcion FillColor
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(196,5,'Detalle de productos',1,1,'C',1);
            $pdf->Cell(14,5,'No ',1,0,'L');
            $pdf->Cell(25,5,'Codigo ',1,0,'L');
            $pdf->Cell(77,5,'Nombre del prducto ',1,0,'L');
            $pdf->Cell(25,5,'Precio',1,0,'L');
            $pdf->Cell(25,5,'Cantidad',1,0,'L');
            $pdf->Cell(30,5,'Importe',1,1,'L');
             
            $this->response->setHeader('Content-Type','application/pdf');
            $contador=1;
           

            foreach($detalleCompra as $row){
                
                $pdf->Cell(14,5,$contador,1,0,'L');
                $pdf->Cell(25,5,$row['id_producto'],1,0,'L');
                $pdf->Cell(77,5,$row['nombre'],1,0,'L');
                $pdf->Cell(25,5,$row['precio'],1,0,'L');
                $pdf->Cell(25,5,$row['cantidad'],1,0,'L');

                $total= number_format($row['cantidad']*$row['precio'],2,'.',',')   ;
                $pdf->Cell(30,5,$total,1,1,'L');
                $contador++;

            }
            $pdf->ln();
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(195,5,'Total'.number_format($datosCompra['total'],2,'.',','),0,1,'R');


            $pdf->Output("compra_pdf.pdf","I");
            
    }
}
?>