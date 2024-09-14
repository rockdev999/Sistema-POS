<?php

class ControladorCaja{
    /*=============================================
	MOSTRAR CAJA
    =============================================*/
    static public function ctrMostrarCaja($item, $valor){

        $tabla="caja1";

        $respuesta = ModeloCaja::mdlMostrarCaja($tabla, $item, $valor);

        return $respuesta;
    }

    /*=============================================
	INGRESO DE CAJA
    =============================================*/
    
    static public function ctrCrearCaja(){

        if(isset($_POST["nuevaVenta"])){
                      
            $tabla = "caja1";

            $datos = array("id_vendedor"=>$_POST["idVendedor"],
                        "codigo"=>$_POST["nuevaVenta"],
                        "ventas"=>$_POST["ventas"],
                        "gastos"=>$_POST["gastos"],
                        "encaja"=>$_POST["encaja"],
                        "codigosVenta"=>$_POST["codigosVenta"],
                        "codigosGasto"=>$_POST["codigosGasto"]);
            
            $codVenta = explode(",",$_POST["codigosVenta"]);
            $codGasto = explode(",",$_POST["codigosGasto"]);
            
            for ($i=0; $i < count($codVenta) ; $i++) { 
                
                $item1 = "cerrado";
                $valor1 = "1";
                $valor = $codVenta[$i];
                $tabla1 = "ventas";
                $comprasCliente = ModeloCaja::mdlActualizarCaja($tabla1, $item1, $valor1, $valor);
            }
            for ($j=0; $j < count($codGasto) ; $j++) { 
                
                $item2 = "control";
                $valor2 = "1";
                $valor3 = $codGasto[$j];
                $tabla2 = "egresos";
                $comprasCliente = ModeloCaja::mdlActualizarCaja($tabla2, $item2, $valor2, $valor3);
            }

            $respuesta = ModeloCaja::mdlIngresarCaja($tabla, $datos);

            if($respuesta=="ok"){
                echo'<script>

                localStorage.removeItem("rango");

                swal({
                    type: "success",
                    title: "La caja ha sido cerrada correctamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                    }).then(function(result){
                                if (result.value) {

                                window.location = "inicio";

                                }
                            })

                </script>';

            }if ($respuesta == "error") {
                echo'<script>

                localStorage.removeItem("rango");

                swal({
                    type: "warning",
                    title: "La caja NO PUDO SER GUARDADA",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                    }).then(function(result){
                                if (result.value) {

                                window.location = "inicio";

                                }
                            })

                </script>';
            }    
            
        }
    }
}