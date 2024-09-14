<?php

require_once "conexion.php";

class ModeloEgresos{

    /*=============================================
	MOSTRAR EGRESOS
	=============================================*/

	static public function mdlMostrarEgresos($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		

		$stmt -> close();

		$stmt = null;

    }
    /*=============================================
	REGISTRO DE VENTA
	=============================================*/

	static public function mdlIngresarEgresos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_vendedor, descripcion, monto) VALUES (:codigo, :id_vendedor, :descripcion, :monto)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}
}