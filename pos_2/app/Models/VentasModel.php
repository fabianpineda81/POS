<?php 
namespace App\Models;
use CodeIgniter\Model;

class VentasModel extends Model{
    protected $table      = 'ventas';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['folio', 'total','id_usuario','id_caja','id_cliente','forma_pago','activo','uuid','timbrado','fecha_timbrado'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function insertaVenta($id_venta,$total,$id_usuario,$id_caja,$id_cliente,$fomar_pago){
        $this->insert([
            'folio'=>$id_venta,
            'total'=>$total,
            'id_usuario'=>$id_usuario,
            'id_caja'=>$id_caja,
            'id_cliente'=>$id_cliente,
            'forma_pago'=>$fomar_pago
        ]);
            // me devueve el ultimo id insertado 
        return $this->insertID();
    }

    public function obtener($activo=1){

        $this->select('ventas.*,u.usuario AS cajero, c.nombre AS cliente'); // el as es para ponerle una alias a la tabla , tabien se le poner la restricion de la llave foranea la cual se va hacer la forma en la que se van a comunicar 
        $this->join('usuarios AS u','ventas.id_usuario = u.id' );// aca se van a agregar las tablas que se van a usar (la tabla desde donde se llama la funcion no se pone en este caso la tabla venta no se pone)
        $this->join('clientes AS c','ventas.id_cliente = c.id' ); // join 
        $this->where("ventas.activo",$activo);


        $this->orderBy('ventas.fecha_alta','DESC');// asi se hace un ordeBy primero se pone la columna a ordenarse  y despues se pone la forma de ordenamiento 
        $datos=$this->findAll();

        //print_r($this->getLastQuery());// esto me sirve para mostrar la ultima consulta o codigo que se realizo en la base de datos
        return $datos;
       }

       public function totalDia($fecha){
           // aca se cuenta como los resultados de la busqueda

           // aca se hace una busqueda para saber la cantidad de ventas hechas en el dia  
          /*  $where= "activo=1 AND DATE(fecha_alta)='$fecha'";
           return $this->where($where)->countAllResults(); */
            // aca se hace la consulta para saber el total de las ventas del dia 
            $this->select("sum(total)AS total");
           $where= "activo=1 AND DATE(fecha_alta)='$fecha'";
           return $this->where($where)->first();

           // recuerda que el find all te traer un arreglo de resultados y el first te lo trae de una vez (sin un arreglo ) 
       }


}

?>