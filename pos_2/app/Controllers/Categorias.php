<?php
namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\CategoriasModel;

class Categorias extends BaseController{
    protected $categorias;
    public  function __construct()
    {
        $this->categorias = new CategoriasModel();
    }

    public function index($activo=1){

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
            $categorias = $this->categorias->where('activo',$activo)->findAll();  
            // array de datos que se le envia a la vista 
            $data =['titulo'=>'Categorias','datos'=>$categorias];

            echo view('header');
            echo view('categorias/categorias',$data);
            echo view('footer');
    }

    public function eliminados($activo=0){

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
            $categorias = $this->categorias->where('activo',$activo)->findAll();  
            // array de datos que se le envia a la vista 
            $data =['titulo'=>'categorias Eliminados','datos'=>$categorias];

            echo view('header');
            echo view('categorias/eliminados',$data);
            echo view('footer');
    }

    public function nuevo(){
        $data =['titulo'=>'Agregar categoria'];

        echo view('header');
        echo view('categorias/nuevo',$data);
        echo view('footer');
    }

    public function insertar(){
        // esto se usa para guardar en la tabla se una el name de que esta en la tabla  y con el $this->request->gotPost tiene que tener el nombre que esta en from
        $this->categorias->save(['nombre'=>$this->request->getPost('nombre')]);

        return redirect()->to(base_url().'/categorias');
    }

    public function editar($id){
        $unidad= $this->categorias->where('id',$id)->first();

        $data =['titulo'=>'Editar categoria','datos'=>$unidad];

        echo view('header');
        echo view('categorias/editar',$data);
        echo view('footer');
    }

    public function actualizar(){
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        $this->categorias->update($this->request->getPost('id'),['nombre'=>$this->request->getPost('nombre')]);

        return redirect()->to(base_url().'/categorias');
    }
    // cuando una variable no se manda por pos y se manda por get se puede poner como parametro que lo recibe 
    public function eliminar($id){
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        $this->categorias->update($id,['activo'=>0]);

        return redirect()->to(base_url().'/categorias');
    }

    public function reingresar($id){
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        $this->categorias->update($id,['activo'=>1]);

        return redirect()->to(base_url().'/categorias');
    }


}
?>