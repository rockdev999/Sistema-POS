<?php

class ControladorEgresos{
    /*=============================================
	INGRESO DE EGRESOS
    =============================================*/
    
    static public function ctrCrearEgreso(){

        if(isset($_POST["nuevaDescripcion"])){
            
            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["nuevaDescripcion"])){
                
                if ($_POST["nuevoMonto"]=="") {
                    
                    echo'<script>

                    swal({
                        type: "error",
                        title: "Debes indicar cuanto gastaste",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                    if (result.value) {

                                    window.location = "egresos";

                                    }
                                })

                    </script>';

                    return;

                }

                $tabla = "egresos";

                $datos = array("id_vendedor"=>$_POST["idVendedor"],
						   "codigo"=>$_POST["nuevoCodigo"],
						   "descripcion"=>$_POST["nuevaDescripcion"],
                           "monto"=>$_POST["nuevoMonto"]);
                
                
                $respuesta = ModeloEgresos::mdlIngresarEgresos($tabla, $datos);

                if($respuesta=="ok"){
                    echo'<script>

                    localStorage.removeItem("rango");

                    swal({
                        type: "success",
                        title: "El Egreso ha sido guardada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                                    if (result.value) {

                                    window.location = "egresos";

                                    }
                                })

                    </script>';

                }
                
            }    
            
        }
    }

    /*=============================================
	MOSTRAR EGRESOS
	=============================================*/

	static public function ctrMostrarEgresos($item, $valor){

		$tabla = "egresos";

		$respuesta = ModeloEgresos::MdlMostrarEgresos($tabla, $item, $valor);

		return $respuesta;
	}
}