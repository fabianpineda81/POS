<?php
namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\EstantesModel;

class Estantes extends BaseController{
    protected $estantes ;
    protected $reglas;
    public  function __construct()
    {
        $this->estantes = new EstantesModel();
        helper(['form']);

        // aca lo que se hace es que  se le da la regla del campo y despues en errors se le da el mensaje que aparece en pantalla 
        $this->reglas=[
            'nombre'=>[
                'rules'=>'required',
                'errors'=>[
                     'required'=>'El campo {field} es obligatorio'
                         ]
                ],
                'descripcion'=>[
                    'rules'=>'required',
                    'errors'=>[
                         'required'=>'El campo {field} es obligatorio'
                             ]
                    ]

        
            ];
    }

    public function index($activo=1){

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
            $unidades = $this->estantes->where('activo',$activo)->findAll();  
            // array de datos que se le envia a la vista 
            $data =['titulo'=>'Estantes','datos'=>$unidades];

           echo json_encode($data);
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
        $data =['titulo'=>'Agregar unidad'];

        echo view('header');
        echo view('unidades/nuevo',$data);
        echo view('footer');
    }

    public function insertar(){
                                                    // aca es como se validad que los campos esten llenos desde php (mirar la documentacion para mas informacion)
        if($this->request->getMethod()=="post" && $this->validate($this->reglas)){

        

        // esto se usa para guardar en la tabla se una el name de que esta en la tabla  y con el $this->request->gotPost tiene que tener el nombre que esta en from
        $this->unidades->save(['nombre'=>$this->request->getPost('nombre'),'nombre_corto'=>
        $this->request->getPost('nombre_corto')]);
        return redirect()->to(base_url().'/unidades');
        }else{
                                                            //esto devuelve las validaciones que no se cumplieron
            $data =['titulo'=>'Agregar unidad','validation'=>$this->validator];
            echo view('header');
            echo view('unidades/nuevo',$data);
            echo view('footer');

        }
        
    }

    public function id($id){

        $this->estantes->select('*');
        $this->estantes->where('id', $id);
        $this->estantes->where('activo', 1);
        $datos = $this->estantes->get()->getrow();
        $res["datos"]=false;
        $res["datos"]="";
        $res["error"]="";
        if($datos){
            $res["datos"]=$datos;
            $res["existe"]=true;
        }else{
            $res['error'] = 'no existe';
            $res['existe'] = false;
        }
        echo json_encode($res);
    }



    public function editar($id,$valid=null){

        // aca se valida  las reglas para para que todo es correctamente

        
            $unidad= $this->unidades->where('id',$id)->first();

            if($valid!=null){
                $data =['titulo'=>'Editar unidad','datos'=>$unidad,'validation'=>$valid];

            }else{
                $data =['titulo'=>'Editar unidad','datos'=>$unidad];
            }


            echo view('header');
            echo view('unidades/editar',$data);
            echo view('footer');
    
    }

    public function actualizar(){
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
       if($this->request->getMethod()=="post"  && $this->validate($this->reglas)){
           $this->unidades->update($this->request->getPost('id'),['nombre'=>$this->request->getPost('nombre'),'nombre_corto'=>
           $this->request->getPost('nombre_corto')]);
    
           return redirect()->to(base_url().'/unidades');

       }else{
           return $this->editar($this->request->getPost('id'),$this->validator);

       }
       
    }
    // cuando una variable no se manda por pos y se manda por get se puede poner como parametro que lo recibe 
    public function eliminar($id){
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        $this->unidades->update($id,['activo'=>0]);

        return redirect()->to(base_url().'/unidades');
    }

    public function reingresar ($id){
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        $this->unidades->update($id,['activo'=>1]);

        return redirect()->to(base_url().'/unidades');
    }


}
?>