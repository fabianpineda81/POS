<?php
namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\ConfiguracionModel;

class Configuracion extends BaseController{
    protected $configuracion ;
    protected $reglas;
    public  function __construct()
    {
        $this->configuracion = new ConfiguracionModel();
        helper(['form','upload']);

        // aca lo que se hace es que  se le da la regla del campo y despues en errors se le da el mensaje que aparece en pantalla 
        $this->reglas=[
            'tienda_nombre'=>[
                'rules'=>'required',
                'errors'=>[
                     'required'=>'El campo {field} es obligatorio'
                         ]
                ],
                'tienda_rfc'=>[
                    'rules'=>'required',
                    'errors'=>[
                         'required'=>'El campo {field} es obligatorio'
                             ]
                    ]

        
            ];
    }

    public function index($activo=1){

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
           $nombre =$this->configuracion->where('nombre','tienda_nombre')->first();  
           $rfc = $this->configuracion->where('nombre','tienda_rfc')->first();  
           $telefono = $this->configuracion->where('nombre','tienda_telefono')->first();  
           $email = $this->configuracion->where('nombre','tienda_email')->first();  
           $direccion = $this->configuracion->where('nombre','tienda_direccion')->first();  
           $leyenda = $this->configuracion->where('nombre','ticket_leyenda')->first();  


           
            // array de datos que se le envia a la vista 
           $data =['titulo'=>'Configuracion','nombre'=>$nombre,'rfc'=>$rfc,'telefono'=>$telefono,'email'=>$email,'direccion'=>$direccion,'leyenda'=>$leyenda];

            echo view('header');
            echo view('configuracion/configuracion',$data);
            echo view('footer');
    }

    
    

   
        
    

    public function editar($id,$valid=null){

        // aca se valida  las reglas para para que todo es correctamente

        
            $unidad= $this->configuracion->where('id',$id)->first();

            if($valid!=null){
                $data =['titulo'=>'Editar unidad','datos'=>$unidad,'validation'=>$valid];

            }else{
                $data =['titulo'=>'Editar unidad','datos'=>$unidad];
            }


            echo view('header');
            echo view('configuracion/editar',$data);
            echo view('footer');
    
    }

    public function actualizar(){
       
       if($this->request->getMethod()=="post"  && $this->validate($this->reglas)){
        // aca se hace una actualizacion sin el id se debe seguir la sieguiente estructura
        $this->configuracion->whereIn('nombre',['tienda_nombre'])->set(['valor'=>$this->request->getPost('tienda_nombre')])->update();
        $this->configuracion->whereIn('nombre',['tienda_rfc'])->set(['valor'=>$this->request->getPost('tienda_rfc')])->update();
        $this->configuracion->whereIn('nombre',['tienda_telefono'])->set(['valor'=>$this->request->getPost('tienda_telefono')])->update();
        $this->configuracion->whereIn('nombre',['tienda_email'])->set(['valor'=>$this->request->getPost('tienda_email')])->update();
        $this->configuracion->whereIn('nombre',['tienda_direccion'])->set(['valor'=>$this->request->getPost('tienda_direccion')])->update();
        $this->configuracion->whereIn('nombre',['ticket_leyenda'])->set(['valor'=>$this->request->getPost('ticket_leyenda')])->update();
        
        // aca estamos haciendo la carga de la imagen (se mueve a la carpeta de uploads)


        

        // estas son la reglas de validacion para las imagenes
        $validacion= $this->validate([
            'tienda_logo'=>[
                'uploaded[tienda_logo]',
                /* 'mime_in[tienda_logo,image/jpg]', */
                'max_size[tienda_logo,10000]',

            ]
        ]) ;

        if($validacion){
            $ruta_logo="images/logotipo.jpg";

            if(file_exists($ruta_logo)){
                unlink($ruta_logo);
            }
            $img= $this->request->getFile('tienda_logo');
            $img->move('./images','logotipo.jpg');
        }else{
            echo 'Error en la validacion';
            exit;
        }
        
        /* $img->move(WRITEPATH.'uploads');

        $img->getName();
        $img->getSize();
        $img->getExtension();
          */

    
           return redirect()->to(base_url().'/configuracion');

       }else{
           //return $this->editar($this->request->getPost('id'),$this->validator);

       }
       
    }
   
   


}
?>