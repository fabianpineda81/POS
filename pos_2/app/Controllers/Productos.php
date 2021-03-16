<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\ProductosModel;
use App\Models\UnidadesModel;
use App\Models\CategoriasModel;
use App\Models\DetallesPermisosRolesModel;


class Productos extends BaseController
{
    protected $productos;
    protected $reglas;
    protected $detalleRoles,$session;
    public  function __construct()
    {
        $this->productos = new ProductosModel();
        $this->unidades = new UnidadesModel();
        $this->categorias = new CategoriasModel();
        $this->detalleRoles= new DetallesPermisosRolesModel();
        $this->session= session();

        helper(['form']);

        // aca lo que se hace es que  se le da la regla del campo y despues en errors se le da el mensaje que aparece en pantalla 
        $this->reglas = [
            'codigo_barras' => [            //para hacer la validacion del campo que sea unico  se pone is:unique y tabla.campo al cual se va hacer la comparacion  
                'rules' => 'required|is_unique[productos.codigo_barras]',
                'errors' => [
                    'required' => 'El campo codigo de barras es obligatorio',
                    'is_unique' => 'El  codigo de barras debe ser unico'

                ]
            ],
            'descripcion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            ,
            'presentacion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            ,
            'precio_compra' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            ,
            'iva' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            ,
            'stock_minimo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            ,
            'stock_maximo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            ,
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            

            


        ];

       
            
    }

    public function index($activo = 1)
    { /*   $idRol= $this->session->id_rol; */
       

       
        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
        $productos = $this->productos->where('activo', $activo)->findAll();
        // array de datos que se le envia a la vista 
        $data = ['titulo' => 'Productos', 'datos' => $productos];
         
        
        echo json_encode($data);
        
        
    }

    public function eliminados($activo = 0)
    {

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
        $productos = $this->productos->where('activo', $activo)->findAll();
        // array de datos que se le envia a la vista 
        $data = ['titulo' => 'Productos Eliminados', 'datos' => $productos];

        echo json_encode( $data);
        
    }




    public function nuevo()
    {
        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
        $unidades = $this->unidades->where('activo', 1)->findAll();

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
        $categorias = $this->categorias->where('activo', 1)->findAll();


        $data = ['titulo' => 'Agregar producto', 'unidades' => $unidades, 'categorias' => $categorias];

       /*  echo view('header');
        echo view('productos/nuevo', $data);
        echo view('footer'); */
        echo json_encode($data);
    }






    public function insertar()
    {
        // aca es como se validad que los campos esten llenos desde php (mirar la documentacion para mas informacion)

        if ($this->request->getMethod() == "post"  && $this->validate($this->reglas)) {

            $codigo_barras=$this->request->getPost("codigo_barras");
            $descripcion=$this->request->getPost("descripcion");
            $presentacion=$this->request->getPost("presentacion");
            $id_estante=$this->request->getPost("id_estante");
            $id_fabricante=$this->request->getPost("id_fabricante");
            $precio_compra_fraccion=$this->request->getPost("precio_compra_fraccion");
            $precio_compra=$this->request->getPost("precio_compra");
            $precio_venta=$this->request->getPost("precio_venta");
            $iva=$this->request->getPost("iva");
            $stock_minimo=$this->request->getPost("stock_minimo");
            $stock_maximo=$this->request->getPost("stock_maximo");
            $fraccion=$this->request->getPost("fraccion");
            $nombre=$this->request->getPost("nombre");
            
            $data=["nombre"=>$nombre,
                "codigo_barras"=>$codigo_barras,
                "descripcion"=>$descripcion,
                "presentacion"=>$presentacion,
                "id_estante"=>$id_estante,
                "id_fabricante"=>$id_fabricante,
                "precio_compra_fraccion"=>$precio_compra_fraccion,
                "precio_compra"=>$precio_compra,
                "iva"=>$iva,
                "stock_minimo"=>$stock_minimo,
                "stock_maximo"=>$stock_maximo,
                "fraccion"=>$fraccion,
                "precio_venta"=>$precio_venta



        ];

         $this->productos->save($data); 
        
        $id= $this->productos->getInsertID();  

        echo json_encode(['id'=>$id,'datos'=>$data]);


            // esto se usa para guardar en la tabla se una el name de que esta en la tabla  y con el $this->request->gotPost tiene que tener el nombre que esta en from

            /* $this->productos->save([
                'codigo' => $this->request->getPost('codigo'),
                'nombre' => $this->request->getPost('nombre'),
                'precio_venta' => $this->request->getPost('precio_venta'),
                'precio_compra' => $this->request->getPost('precio_compra'),
                'stock_minimo' => $this->request->getPost('stock_minimo'),
                'inventariable' => $this->request->getPost('inventariable'),
                'id_unidad' => $this->request->getPost('id_unidad'),
                'id_categoria' => $this->request->getPost('id_categoria')

            ]); */

            // estas son la reglas de validacion para las imagenes
           /*  $validacion = $this->validate([
                'tienda_logo' => [
                    'uploaded[img_producto]',
                    // 'mime_in[tienda_logo,image/jpg]', 
                    'max_size[img_producto,10000]',

                ]
            ]); */

            /* if ($validacion) {
                $ruta_logo = "images/productos/".$id.".jpg";

                if (file_exists($ruta_logo)) {
                    unlink($ruta_logo);
                }
                $img = $this->request->getFile('img_producto');
                $img->move('./images/productos',$id.'.jpg');
            } else {
                echo 'Error en la validacion';
                exit;
            }
 */
            /* $img->move(WRITEPATH.'uploads');

        $img->getName();
        $img->getSize();
        $img->getExtension();
          */








            
        }else{
            $data =['validation' => $this->validator->getErrors(),'datos'=>[]];
            echo json_encode($data);
        }
    }





    public function editar($id)
    {


        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
        $unidades = $this->unidades->where('activo', 1)->findAll();

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
        $categorias = $this->categorias->where('activo', 1)->findAll();
        $producto = $this->productos->where('id', $id)->first();

        $data = ['titulo' => 'Editar producto', 'unidades' => $unidades, 'categorias' => $categorias, 'producto' => $producto];

        echo view('header');
        echo view('productos/editar', $data);
        echo view('footer');
    }






    public function actualizar()
    {
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 

        $reglas2 = [
            'codigo_barras' => [            //para hacer la validacion del campo que sea unico  se pone is:unique y tabla.campo al cual se va hacer la comparacion  
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo codigo de barras es obligatorio',
                   

                ]
            ],
            'descripcion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            ,
            'presentacion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            ,
            'precio_compra' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            ,
            'iva' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            ,
            'stock_minimo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            ,
            'stock_maximo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            ,
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]

            

            


        ];

        if ($this->request->getMethod() == "post"  && $this->validate($reglas2)) {
        $id=$this->request->getPost("id");
        $codigo_barras=$this->request->getPost("codigo_barras");
        $descripcion=$this->request->getPost("descripcion");
        $presentacion=$this->request->getPost("presentacion");
        $id_estante=$this->request->getPost("id_estante");
        $id_fabricante=$this->request->getPost("id_fabricante");
        $precio_compra_fraccion=$this->request->getPost("precio_compra_fraccion");
        $precio_compra=$this->request->getPost("precio_compra");
        $precio_venta=$this->request->getPost("precio_venta");
        $iva=$this->request->getPost("iva");
        $stock_minimo=$this->request->getPost("stock_minimo");
        $stock_maximo=$this->request->getPost("stock_maximo");
        $fraccion=$this->request->getPost("fraccion");
        $nombre=$this->request->getPost("nombre");


        $data=["nombre"=>$nombre,
                "codigo_barras"=>$codigo_barras,
                "descripcion"=>$descripcion,
                "presentacion"=>$presentacion,
                "id_estante"=>$id_estante,
                "id_fabricante"=>$id_fabricante,
                "precio_compra_fraccion"=>$precio_compra_fraccion,
                "precio_compra"=>$precio_compra,
                "iva"=>$iva,
                "stock_minimo"=>$stock_minimo,
                "stock_maximo"=>$stock_maximo,
                "fraccion"=>$fraccion,
                "precio_venta"=>$precio_venta



        ];
        $this->productos->update($id, $data);
        $data =["id"=>$id];
        echo json_encode($data);
    }else{
        $data =['validation' => $this->validator->getErrors(),'datos'=>[]];
        echo json_encode($data);
        }

        
    }
    // cuando una variable no se manda por pos y se manda por get se puede poner como parametro que lo recibe 
    public function eliminar($id)
    {
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        $this->productos->update($id, ['activo' => 0]);
        $id=$this->productos->getInsertID();
        $data=["error"=>""];

      echo   json_encode($data);
    }

    public function reingresar($id)
    {
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        $this->productos->update($id, ['activo' => 1]);
        $data=["error"=>""];

      echo   json_encode($data);

        
    }
    // los imput que viene por get se pasan como parametro en la funcion 






    public function id($id)
    {

        // ejemplo de como se hace un select con varios where
        $this->productos->select('*');
        $this->productos->where('id', $id);
        $this->productos->where('activo', 1);
        $datos = $this->productos->get()->getrow();

        $res['existe'] = false;
        $res['datos'] = '';
        $res['error'] = '';

        if ($datos) {
            $res['datos'] = $datos;
            $res['existe'] = true;
        } else {
            $res['error'] = 'no existe';
            $res['existe'] = false;
        }

        echo json_encode($res);
    }


    public function autocompleteData()
    {
        $returnData = array();
        // esta variable llega des de la funcion de jquery
        $valor = $this->request->getGet('term');
        // aca se hace una consulta con la restricion like 
        $clientes = $this->productos->like('codigo', $valor)->where('activo', 1)->findAll();
        if (!empty($clientes)) {
            foreach ($clientes as $row) {
                //el id es el id v:
                // el label es lo que se muestra
                // y el value es lo que se manda el imput cuando se preciona
                $data['id'] = $row['id'];
                $data['label'] = $row['codigo'] . ' - ' . $row['nombre'];
                $data['value'] = $row['codigo'];


                array_push($returnData, $data);
            }

            echo json_encode($returnData);
        }
    }

     public function generaBarras()
    {   // aca usamos la libreria para generar codigos 
        // la libreria tiene que estar en el auto load .php
        $pdf= new \FPDF('p','mm','letter');
        $pdf->AddPage();
        $pdf->SetMargins(10,10,10);
        $pdf->SetTitle("codigos de barras");
        $productos = $this->productos->where('activo', 1)->findAll();


        foreach($productos as $producto){
            $codigo=$producto['codigo'];
            $generaBarcode= new \barcode_genera();
            $generaBarcode->barcode($codigo.".png",$codigo,20,"horizontal","code128",true);
            $pdf->Image($codigo.".png");
            /*aca se eliminan las imagenes  unlink($codigo.".png"); */
        }
        // aca mandamos un header 
        $this->response->setHeader('Content-type','application/pdf');
        $pdf->Output("Codigo.pdf","I");


        



    }

    function mostrarMinimos(){
        
      
        echo view('header');
        echo view('productos/ver_minimos');
        echo view('footer');
    }




    function muestraCodigos(){
        
      
        echo view('header');
        echo view('productos/ver_codigos');
        echo view('footer');
    }
    public function generaMinimosPdf()
    {   // aca usamos la libreria para generar codigos 
        // la libreria tiene que estar en el auto load .php
        $pdf= new \FPDF('p','mm','letter');
        $pdf->AddPage();
        $pdf->SetMargins(10,10,10);
        $pdf->SetTitle("Productos Minimos ");
        $pdf->SetFont("Arial",'B',10);
        $pdf->Image("images/logotipo.jpg",10,5,20);
        $pdf->Cell(0,5,"Reporte de productos minimos",0,1,'C');
        $pdf->Ln(10);
        $pdf->Cell(40,5,"Codigo",1,0,"C");
        $pdf->Cell(80,5,"NOmbres",1,0,"C");
        $pdf->Cell(30,5,"existencias",1,0,"C");
        $pdf->Cell(30,5,"Stock minimo",1,1,"C");

        $datosProductos = $this->productos->getproductosMimimo();

        foreach($datosProductos as $producto){
        $pdf->Cell(40,5,$producto['codigo'],1,0,"C");
        $pdf->Cell(80,5,$producto['nombre'],1,0,"C");
        $pdf->Cell(30,5,$producto['existencias'],1,0,"C");
        $pdf->Cell(30,5,$producto['stock_minimo'],1,1,"C");

        }

      

        
        // aca mandamos un header 
        $this->response->setHeader('Content-type','application/pdf');
        $pdf->Output("ProductosMinimos.pdf","I");


        



    }

   
}
