<?php 
namespace App\Models;
use CodeIgniter\Model;

class ProductosModel extends Model{
    protected $table      = 'productos';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['codigo_barras', 'nombre'
    ,'precio_venta','precio_compra','existencias','presentacion','precio_compra_fraccion'
    ,'stock_minimo','stock_maximo','inventariable','id_estante','id_fabricante'
    ,'activo','descripcion','iva','fraccion'];
    

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = '';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

     public function actualizaStock($id_producto,$cantidad,$operador='+'){
        
        $this->set('existencias',"existencias+$operador $cantidad",FALSE);
        $this->where('id',$id_producto);
        $this->update();

     }

     public function totalProductos(){
        // aca  contamos la cantidad de resultaod que me trae la consulta 
      return  $this->where('activo',1)->countAllResults();
     }
     
     public function productosMimimo(){
        $where = "stock_minimo>=existencias AND inventariable=1 AND activo=1";
        $this->where($where);
        $sql=$this->countAllResults();
        return $sql;

     } 

     public function getproductosMimimo(){
      $where = "stock_minimo>=existencias AND inventariable=1 AND activo=1";
      
      return $this->where($where)->findAll();
      
      

   } 



}

?>