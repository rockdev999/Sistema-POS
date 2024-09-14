<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=u422563687_posviacha",
			            "u422563687_sergioviacha",
			            "Zps6756724");

		$link->exec("set names utf8");

		return $link;

	}

}