<?php
namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\ClientesModel;


class Clientes extends BaseController{
    protected $clientes ;
    protected $reglas;  
    public  function __construct()
    {
        $this->clientes = new ClientesModel();
        


        helper(['form']);

        // aca lo que se hace es que  se le da la regla del campo y despues en errors se le da el mensaje que aparece en pantalla 
        $this->reglas=[
            'nombre'=>[            //para hacer la validacion del campo que sea unico  se pone is:unique y tabla.campo al cual se va hacer la comparacion  
                'rules'=>'required',
                'errors'=>[
                     'required'=>'El campo {field} es obligatorio'
                     

                         ]
                ]

        
            ];
    }

    public function index($activo=1){

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
            $clientes = $this->clientes->where('activo',$activo)->findAll();  
            // array de datos que se le envia a la vista 
            $data =['titulo'=>'Clientes','datos'=>$clientes];

            echo view('header');
            echo view('clientes/clientes',$data);
            echo view('footer');
    }

    public function eliminados($activo=0){

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
            $clientes = $this->clientes->where('activo',$activo)->findAll();  
            // array de datos que se le envia a la vista 
            $data =['titulo'=>'Clientes Eliminados','datos'=>$clientes];

            echo view('header');
            echo view('clientes/eliminados',$data);
            echo view('footer');
    }

    public function nuevo(){
        


        $data =['titulo'=>'Agregar cliente'];

        echo view('header');
        echo view('clientes/nuevo',$data);
        echo view('footer');
    }

    public function insertar(){
       // aca es como se validad que los campos esten llenos desde php (mirar la documentacion para mas informacion)
        if($this->request->getMethod()=="post" && $this->validate($this->reglas)){

        

        // esto se usa para guardar en la tabla se una el name de que esta en la tabla  y con el $this->request->gotPost tiene que tener el nombre que esta en from
      
        $this->clientes->save([

                'nombre'=>$this->request->getPost('nombre'),
                'direccion'=>$this->request->getPost('direccion'),
                'telefono'=>$this->request->getPost('telefono'),
                'correo'=>$this->request->getPost('correo')
                ]);
        return redirect()->to(base_url().'/clientes');
        }else{
       
                      //esto devuelve las validaciones que no se cumplieron      
        $data =['titulo'=>'Agregar cliente','validation'=>$this->validator];

            
            echo view('header');
            echo view('clientes/nuevo',$data);
            echo view('footer');

        }
        
    }

    public function editar($id){
        

      // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
      
        $cliente = $this->clientes->where('id',$id)->first();

      $data =['titulo'=>'Editar cliente','cliente'=>$cliente];

        echo view('header');
        echo view('clientes/editar',$data);
        echo view('footer');
    }

    public function actualizar(){
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        

        $this->clientes->update($this->request->getPost('id'),['codigo'=>$this->request->getPost('codigo'),
        'nombre'=>$this->request->getPost('nombre'),
        'direccion'=>$this->request->getPost('direccion'),
        'telefono'=>$this->request->getPost('telefono'),
        'correo'=>$this->request->getPost('correo')
        
        ]);

        return redirect()->to(base_url().'/clientes');
    }
    // cuando una variable no se manda por pos y se manda por get se puede poner como parametro que lo recibe 
    public function eliminar($id){
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        $this->clientes->update($id,['activo'=>0]);

        return redirect()->to(base_url().'/clientes');
    }

    public function reingresar ($id){
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        $this->clientes->update($id,['activo'=>1]);

        return redirect()->to(base_url().'/clientes');
    }

    public function autocompleteData(){
        $returnData=array();
        // esta variable llega des de la funcion de jquery
        $valor = $this->request->getGet('term');
        // aca se hace una consulta con la restricion like 
        $clientes=$this->clientes->like('nombre',$valor)->where('activo',1)->findAll();
        if(!empty($clientes)){
            foreach($clientes as $row){
                $data['id']=$row['id'];
                $data['value']=$row['nombre'];
                
                array_push($returnData,$data);

            }

            echo json_encode($returnData);
        }
    }


}
?>