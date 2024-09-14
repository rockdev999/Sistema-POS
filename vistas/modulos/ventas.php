<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

$xml = ControladorVentas::ctrDescargarXML();

if($xml){

  rename($_GET["xml"].".xml", "xml/".$_GET["xml"].".xml");

  echo '<a class="btn btn-block btn-success abrirXML" archivo="xml/'.$_GET["xml"].'.xml" href="ventas">Se ha creado correctamente el archivo XML <span class="fa fa-times pull-right"></span></a>';

}

?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar ventas
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar ventas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <a href="crear-venta">

          <button class="btn btn-primary">
            
            Agregar venta

          </button>

        </a>

         <button type="button" class="btn btn-default pull-right" id="daterange-btn">
           
            <span>
              <i class="fa fa-calendar"></i> 

              <?php

                if(isset($_GET["fechaInicial"])){

                  echo $_GET["fechaInicial"]." - ".$_GET["fechaFinal"];
                
                }else{
                 
                  echo 'Rango de fecha';

                }

              ?>
            </span>

            <i class="fa fa-caret-down"></i>

         </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Código factura</th>
           <th>Cliente</th>
           <th>Vendedor</th>
           <th>Forma de pago</th>
           <th>Neto</th>
           <th>Total</th> 
           <th>Fecha</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          if(isset($_GET["fechaInicial"])){

            $fechaInicial = $_GET["fechaInicial"];
            $fechaFinal = $_GET["fechaFinal"];

          }else{

            $fechaInicial = null;
            $fechaFinal = null;

          }

          $respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

          foreach ($respuesta as $key => $value) {
           
           echo '<tr>

                  <td>'.($key+1).'</td>

                  <td>'.$value["codigo"].'</td>';

                  $itemCliente = "id";
                  $valorCliente = $value["id_cliente"];

                  $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                  echo '<td>'.$respuestaCliente["nombre"].'</td>';

                  $itemUsuario = "id";
                  $valorUsuario = $value["id_vendedor"];

                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                  echo '<td>'.$respuestaUsuario["nombre"].'</td>

                  <td>'.$value["metodo_pago"].'</td>

                  <td>$ '.number_format($value["neto"],2).'</td>

                  <td>$ '.number_format($value["total"],2).'</td>

                  <td>'.$value["fecha"].'</td>

                  <td>

                    <div class="btn-group">

                      <a class="btn btn-success" href="index.php?ruta=ventas&xml='.$value["codigo"].'">xml</a>

                      <button class="btn btn-info btnMostrarVenta" idVenta="'.$value["id"].'" data-toggle="modal" data-target="#modalMostrarVenta">

                        <i class="fa fa-print"></i>

                      </button>';
                        
                      // <button class="btn btn-info btnImprimirFactura" codigoVenta="'.$value["codigo"].'">

                      //   <i class="fa fa-print"></i>

                      // </button>

                      if($_SESSION["perfil"] == "Administrador"){

                      echo '<button class="btn btn-warning btnEditarVenta" idVenta="'.$value["id"].'"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger btnEliminarVenta" idVenta="'.$value["id"].'"><i class="fa fa-times"></i></button>';

                    }

                    echo '</div>  

                  </td>

                </tr>';
            }

        ?>
               
        </tbody>

       </table>

       <?php

      $eliminarVenta = new ControladorVentas();
      $eliminarVenta -> ctrEliminarVenta();

      ?>
       

      </div>

    </div>

  </section>

</div>


<!--=====================================
MODAL MOSTRAR VENTA
======================================-->

<div id="modalMostrarVenta" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header" style="border-bottom:0px;">
                <i class="fa fa-globe"></i> Mac Mart
                <small class="pull-right">Fecha: <span id="fecha"></span></small><br>
                <small class="pull-right">Hora: <span id="hora"></span></small>
                
              </h2>
              <hr>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              Cliente:
              <address>
                <strong id="cliente"></strong><br>
                
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              Vendedor: 
              <address>
                <strong id="vendedor"></strong><br>
               
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>Venta Número: <span id="codigo">007612</span></b><br>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
    
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Descripcion</th>
                  <th>Cost. Unidad</th>
                  <th>Cantidad</th>
                  <th>SubTotal</th>
                </tr>
                </thead>
                <tbody id="productos">
                
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
    
          <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
              
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                  
              <div class="table-responsive">
                <table class="table">
                  
                  <tr>
                    <th></th>
                    <th>Total:</th>
                    <td id="total"></td>
                  </tr>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
    
            
          <!--=====================================
        PIE DEL MODAL
        ======================================-->

        
            <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href=""  class="btn btn-default"><i class="fa fa-print"></i> Imprimir</a>
              <!-- <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
              </button> -->
              <button type="button" class="btn btn-success pull-right" style="margin-right: 5px;">
                <i class="fa fa-download"></i> Generar PDF
              </button>
            </div>
          </div>
        

        
          
        </section>

  </div>

</div>


