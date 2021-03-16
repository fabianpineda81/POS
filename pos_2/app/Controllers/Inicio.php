<?php namespace App\Controllers;
	use App\Models\ProductosModel;
	use App\Models\VentasModel;
class Inicio extends BaseController
{
	protected $productosModel,$ventasModel,$session;
	public function __construct()
	{
		$this->productosModel= new ProductosModel();
		$this->ventasModel= new VentasModel();
		$this->session= session();
	}
	public function index()
	{	// aca se usa para verificar que el usuario este logueado 

		if(!isset($this->session->id)){
			return redirect()->to(base_url());
		}
		$total = $this->productosModel->totalProductos();
												//aca pideo la fecha del dia de hoy y se le envia a la funcion 
		$totalVentas= $this->ventasModel->totalDia(date('Y-m-d'));
		
		$minimos = $this->productosModel->productosMimimo();
		$datos=['total'=>$total,'totalVentas'=>$totalVentas,'minimos'=>$minimos];


		echo view('header');
		echo  view('inicio',$datos);
		echo view('footer');
	}

	//--------------------------------------------------------------------

}
