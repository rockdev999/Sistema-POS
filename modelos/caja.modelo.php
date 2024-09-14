<?php

require_once "conexion.php";

class ModeloCaja{

	/*=============================================
	MOSTRAR CAJA
	=============================================*/

	static public function mdlMostrarCaja($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		
		$stmt -> close();

		$stmt = null;

    }

     /*=============================================
	REGISTRO DE CAJA
	=============================================*/

	static public function mdlIngresarCaja($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_vendedor, ventas, gastos, encaja, codigosVenta, codigosGasto) VALUES (:codigo, :id_vendedor, :ventas, :gastos, :encaja, :codigosVenta, :codigosGasto)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
        $stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
        $stmt->bindParam(":ventas", $datos["ventas"], PDO::PARAM_STR);
        $stmt->bindParam(":gastos", $datos["gastos"], PDO::PARAM_STR);
        $stmt->bindParam(":encaja", $datos["encaja"], PDO::PARAM_STR);
        $stmt->bindParam(":codigosVenta", $datos["codigosVenta"], PDO::PARAM_STR);
        $stmt->bindParam(":codigosGasto", $datos["codigosGasto"], PDO::PARAM_STR);
       
		
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}
	/*=============================================
	ACTUALIZAR CAJA
	=============================================*/

	static public function mdlActualizarCaja($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE codigo = :codigo");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":codigo", $valor, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}
}