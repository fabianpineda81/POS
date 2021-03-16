<?php 
namespace App\Models;
use CodeIgniter\Model;

class EstantesModel extends Model{
    protected $table      = 'estantes';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'descripcion','activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


}

?>