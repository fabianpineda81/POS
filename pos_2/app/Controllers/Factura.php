<?php
namespace App\Controllers;


use App\Controllers\BaseController;

use App\Models\VentasModel;
use App\Models\DetalleVentaModel;
use App\Models\ConfiguracionModel;



class Factura extends BaseController{
    public $ventas,$detalle_venta,$configuracion;
    
    public  function __construct()
    {
        $this->detalle_venta= new DetalleVentaModel();
        $this->configuracion= new ConfiguracionModel();
        $this->ventas= new VentasModel();
        helper(['form']);

        // aca lo que se hace es que  se le da la regla del campo y despues en errors se le da el mensaje que aparece en pantalla 
        
    }

    public function facturar($id_venta){
        

        $datosVenta=$this->ventas->where('id',$id_venta)->first();

        if($datosVenta['timbrado']==1){
            echo 'la venta esta timbrada';
            exit;
        }
         // esto de puede hacer en una sola linea
         $this->detalle_venta->select('*');
         $this->detalle_venta->where('id_venta',$id_venta);
         $detalleVenta=$this->detalle_venta->findAll();

         // con el get getrow me trae los resultados como objetos
         $this->configuracion->select('valor');
         $this->configuracion->where('nombre','tienda_rfc');
         $rfcTienda=$this->configuracion->get()->getRow()->valor;
            echo $rfcTienda;

         $this->detalle_venta->select('valor');
         $this->detalle_venta->where('nombre','tienda_nombre');
         $nombreTienda=$this->configuracion->get()->getRow()->valor;

        

         $this->detalle_venta->select('valor');
         $this->detalle_venta->where('nombre','tienda_direccion');
         $direccionTienda=$this->configuracion->get()->getRow()->valor;

         $this->detalle_venta->select('valor');
         $this->detalle_venta->where('nombre','ticket_leyenda');
         $leyendaTicket=$this->configuracion->get()->getRow()->valor;

        date_default_timezone_set('America/Mexico_City');
	
        $datosFactura = array();
        
        $dirCfdi = APPPATH . 'Libraries/cfdi_sat/cfdi/';
        $dir = APPPATH . 'Libraries/cfdi_sat/';
        
        $nombre = "A2";
        
        //Datos generales de factura
        $datosFactura["version"] = "3.3";
        $datosFactura["serie"] = "A";
        $datosFactura["folio"] = "2";
        $datosFactura["fecha"] = date('YmdHis');
        $datosFactura["formaPago"] = $datosVenta["forma_pago"];
        $datosFactura["noCertificado"] = "20001000000300022762";
        $datosFactura["subTotal"] = $datosVenta["total"];
        $datosFactura["descuento"] = "0.00";
        $datosFactura["moneda"] = "MXN";
        $datosFactura["total"] = $datosVenta["total"];
        $datosFactura["tipoDeComprobante"] = "I";
        $datosFactura["metodoPago"] = "PUE";
        $datosFactura["lugarExpedicion"] = "01000";
        
        //Datos del emisor
        $datosFactura['emisor']['rfc'] = $rfcTienda;
        $datosFactura['emisor']['nombre'] =$nombreTienda ;
        $datosFactura['emisor']['regimen'] = '601';
        
        //Datos del receptor
        $datosFactura['receptor']['rfc'] = 'XAXX010101000';
        $datosFactura['receptor']['nombre'] = 'Publico en general';
        $datosFactura['receptor']['usocfdi'] = 'P01';

        foreach($detalleVenta as $row ){
        $importe=number_format( $row["cantidad"]*$row["precio"],2,'.','');
        
        $datosFactura["conceptos"][] = array("clave" => "01010101", "sku" => "75654123", "descripcion" =>$row["nombre"], "cantidad" =>$row["cantidad"] , "claveUnidad" => "H87", "unidad" => "Pieza", "precio" => $row["precio"], "importe" => $importe, "descuento" => "0.00", "iBase" => $importe, "iImpuesto" => "002", "iTipoFactor" => "Tasa", "iTasaOCuota" => "0.000000", "iImporte" => "0.00");
        }
        $datosFactura['traslados']['impuesto'] = "002";
        $datosFactura['traslados']['tasa'] = "0.000000";
        $datosFactura['traslados']['importe'] = "0.00";
        
        $xml = new \GeneraXML;
        $xmlBase = $xml->satxmlsv33($datosFactura, '', $dir, '');	
        
        $timbra = new \Pac();
        $cfdi = $timbra->enviar("UsuarioPruebasWS","b9ec2afa3361a59af4b4d102d3f704eabdf097d4",$rfcTienda, $xmlBase);
        
        if($cfdi)
        {
            file_put_contents($dirCfdi.$nombre.'.xml', base64_decode($cfdi->xml));
            unlink($dir.'/tmp/'.$nombre.'.xml');
            $xml= simplexml_load_file($dirCfdi. $nombre.'.xml');
            $ns=$xml->getNamespaces(true);
            $xml->registerXPathNamespace('c',$ns['cfdi']);
            $xml->registerXPathNamespace('t',$ns['tfd']);
            $uuid="";
            $fechaTimbrado="";
            foreach($xml->xpath('//t:TimbreFiscalDigital') as $tfd){
                $uuid =$tfd['UUID'];
                $fechaTimbrado= $tfd['FechaTimbrado'];

            }
            $this->ventas->update($id_venta,['uuid'=>$uuid,'fecha_timbrado'=>$fechaTimbrado,'timbrado'=>1]);
        }
    
    }

    public function genera_pdf($folio){
        // aca se lee un xml
        $dirCfdi = $dirCfdi = APPPATH . 'Libraries/cfdi_sat/cfdi/';
        $xml= simplexml_load_file($dirCfdi. $folio.'.xml');
        $ns=$xml->getNamespaces(true);
        $xml->registerXPathNamespace('c',$ns['cfdi']);
        $xml->registerXPathNamespace('t',$ns['tfd']);

        foreach($xml->xpath('//cfdi:Comprobante')as $cfdiComprobante){
            echo $cfdiComprobante['Version']."<br>";
            echo $cfdiComprobante['Total'];
        }
    }


    


}
?>