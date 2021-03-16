<?php
namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\CajasModel;
use App\Models\ArqueoCajaModel;
use App\Models\VentasModel;


class Cajas extends BaseController{
    protected $cajas ;
    protected $reglas;
    protected $arqueoModel,$ventas;
    
    public  function __construct()
    {
        $this->cajas = new CajasModel();
        $this->arqueoModel = new ArqueoCajaModel() ;
        $this->ventas= new VentasModel();
        helper(['form']);

        // aca lo que se hace es que  se le da la regla del campo y despues en errors se le da el mensaje que aparece en pantalla 
        $this->reglas=[
            'nombre'=>[
                'rules'=>'required',
                'errors'=>[
                     'required'=>'El campo {field} es obligatorio'
                         ]
                ],
                'numero_caja'=>[
                    'rules'=>'required',
                    'errors'=>[
                         'required'=>'El campo {field} es obligatorio'
                             ]
                    ]

        
            ];
    }

    public function index($activo=1){

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
            $cajas = $this->cajas->where('activo',$activo)->findAll();  
            // array de datos que se le envia a la vista 
            $data =['titulo'=>'Cajas','datos'=>$cajas];

            echo view('header');
            echo view('cajas/cajas',$data);
            echo view('footer');
    }

    public function eliminados($activo=0){

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
            $cajas = $this->cajas->where('activo',$activo)->findAll();  
            // array de datos que se le envia a la vista 
            $data =['titulo'=>'Cajas Eliminados','datos'=>$cajas];

            echo view('header');
            echo view('cajas/eliminados',$data);
            echo view('footer');
    }

    public function nuevo(){
        $data =['titulo'=>'Agregar unidad'];

        echo view('header');
        echo view('cajas/nuevo',$data);
        echo view('footer');
    }

    public function insertar(){
                                                    // aca es como se validad que los campos esten llenos desde php (mirar la documentacion para mas informacion)
        if($this->request->getMethod()=="post" && $this->validate($this->reglas)){

        

        // esto se usa para guardar en la tabla se una el name de que esta en la tabla  y con el $this->request->gotPost tiene que tener el nombre que esta en from
        $this->cajas->save(['nombre'=>$this->request->getPost('nombre'),'numero_caja'=>
        $this->request->getPost('numero_caja')]);
        return redirect()->to(base_url().'/cajas');
        }else{
                                                            //esto devuelve las validaciones que no se cumplieron
            $data =['titulo'=>'Agregar caja','validation'=>$this->validator];
            echo view('header');
            echo view('cajas/nuevo',$data);
            echo view('footer');

        }
        
    }

    public function editar($id,$valid=null){

        // aca se valida  las reglas para para que todo es correctamente

        
            $unidad= $this->cajas->where('id',$id)->first();

            if($valid!=null){
                $data =['titulo'=>'Editar unidad','datos'=>$unidad,'validation'=>$valid];

            }else{
                $data =['titulo'=>'Editar unidad','datos'=>$unidad];
            }


            echo view('header');
            echo view('cajas/editar',$data);
            echo view('footer');
    
    }

    public function actualizar(){
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
       if($this->request->getMethod()=="post"  && $this->validate($this->reglas)){
           $this->cajas->update($this->request->getPost('id'),['nombre'=>$this->request->getPost('nombre'),'numero_caja'=>
           $this->request->getPost('numero_caja')]);
    
           return redirect()->to(base_url().'/cajas');

       }else{
           return $this->editar($this->request->getPost('id'),$this->validator);

       }
       
    }
    // cuando una variable no se manda por pos y se manda por get se puede poner como parametro que lo recibe 
    public function eliminar($id){
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        $this->cajas->update($id,['activo'=>0]);

        return redirect()->to(base_url().'/cajas');
    }

    public function reingresar ($id){
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        $this->cajas->update($id,['activo'=>1]);

        return redirect()->to(base_url().'/cajas');
    }

    public function arqueo($idcaja){
        $arqueos=$this->arqueoModel->getDatos($idcaja);
        
        $data=['titulo'=>'cierres de caja','datos'=>$arqueos];
        echo view('header');
        echo view('cajas/arqueo',$data);
        echo view('footer');
    }

    public function nuevo_arqueo(){
         $session = session();
         $existe=0;
         $existe=$this->arqueoModel->where(['id_caja'=>$session->id_caja,'estatus'=>1])->countAllResults();
         if($existe>0){
            echo 'La caja ya esra abierta';
            exit;
        }


         if($this->request->getMethod()=="post"){
            $fecha= date('Y-m-d H:i:s');
           

            $this->arqueoModel->save(['id_caja'=>$session->id_caja,
             'id_usuario'=>$session->id,
             'fecha_apertura'=>$fecha,
             'monto_inicial'=>$this->request->getPost('monto_inicial')]);
             return redirect()->to(base_url().'/cajas');
         }else{
             $caja=$this->cajas->where('id',$session->id_caja)->first();
            $data=['titulo'=>'Apertura de caja','caja'=>$caja,'session'=>$session];

            echo view('header');
            echo view('cajas/nuevo_arqueo',$data);
            echo view('footer');

         }
    }

    public function cerrar(){
        $session = session();
       


        if($this->request->getMethod()=="post"){
           $fecha= date('Y-m-d H:i:s');
          

           $this->arqueoModel->update($this->request->getPost('id_arqueo'), [

            'fecha_fin'=>$fecha,
            'monto_final'=>$this->request->getPost('monto_final'),
            'total_ventas'=>$this->request->getPost('total_ventas'),
            'estatus'=>0
            ]);
            return redirect()->to(base_url().'/cajas');
        }else{
            $montoTotal= $this->ventas->totalDia(date('Y-m-d'));

            $arqueo= $this->arqueoModel->where(['id_caja'=>$session->id_caja,'estatus'=>1])->first();

            $caja=$this->cajas->where('id',$session->id_caja)->first();

           $data=['titulo'=>'cerrar  caja','caja'=>$caja,'session'=>$session,'arqueo'=>$arqueo,'monto'=>$montoTotal];


           echo view('header');
           echo view('cajas/cerrar',$data);
           echo view('footer');

        }
   }







}
?>