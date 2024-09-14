<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class AjaxVentas{

	/*=============================================
	MOSTRAR VENTA
	=============================================*/	

	public $idVenta;

	public function ajaxMostrarVenta(){

		$item = "id";
		$valor = $this->idVenta;

		$respuesta = ControladorVentas::ctrMostrarVentas($item, $valor);

		echo json_encode($respuesta);

	}
	
}

/*=============================================
EDITAR USUARIO
=============================================*/
if(isset($_POST["idVenta"])){

	$Mostrar = new AjaxVentas();
	$Mostrar -> idVenta = $_POST["idVenta"];
	$Mostrar -> ajaxMostrarVenta();

}

