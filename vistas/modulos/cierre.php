<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}
$subtotal = 0;
$subgastos = 0;
$total = 0;
?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      CIERRE DE CAJA
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Cierre de caja</li>
    
    </ol>

  </section>

  <section class="content">
  <div class="row">
    <div class="col-lg-7 col-xs-12">
    <div class="box">

      <div class="box-body">
        
      <?php

      $codigosVenta = array();
      
      $item = null;
      $valor = null;

      $ventas = ControladorVentas::ctrMostrarVentas($item,$valor);

      foreach ($ventas as $key => $value) {
          
          if($value["cerrado"]==0){
                
            ?>
              <section class="invoice">
                <div class="row">
                    <div class="col-xs-12">
                    <h2 class="page-header" style="border-bottom:0px;">
                        <i class="fa fa-globe"></i> Mac Mart
                        <small class="pull-right">Fecha: <span> <?php echo $value["fecha"]?> </span></small><br>
                        <small class="pull-right">Hora: <span id="hora"></span></small>
                    </h2>
                    <hr>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                    Cliente:
                    <address>
                      <?php
                        $item2 = "id";
                        $valor2 = $value["id_cliente"];
                        $cliente = ControladorClientes::ctrMostrarClientes($item2,$valor2);
                      ?>
                        <strong><?php echo $cliente["nombre"]?></strong><br>
                    </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                    Vendedor: 
                    <address>
                      <?php
                        $item1 = "id";
                        $valor1 = $value["id_vendedor"];
                        $vendedor = ControladorUsuarios::ctrMostrarUsuarios($item1,$valor1); 
                      ?>
                        <strong ><?php echo $vendedor["nombre"] ?></strong><br>
                    </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                    <b>Venta Número: <span><?php echo $value["codigo"]?></span></b><br>
                    </div>

                </div>
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Cost. Unidad</th>
                        <th>SubTotal</th>
                        </tr>
                        </thead>
                        <tbody id="productos">
                        <?php $array=json_decode($value["productos"],true); 
                              for ($i=0; $i < count($array) ; $i++) { 
                              ?><tr><th><?php  echo $array[$i]["id"];?></th><?php
                              ?><th><?php  echo $array[$i]["descripcion"];?></th><?php
                              ?><th><?php  echo $array[$i]["cantidad"];?></th><?php
                              ?><th><?php  echo $array[$i]["precio"];?></th><?php
                              ?><th><?php  echo $array[$i]["total"];?></th></tr><?php
                              }
                        ?>
                         
                        </tbody>
                    </table>
                    </div>
                    
                </div>
                
            
                <div class="row">
                
                    <div class="col-xs-6">
                    
                    </div>
                
                    <div class="col-xs-6">
                        
                    <div class="table-responsive">
                        <table class="table">
                        
                        <tr>
                            <th></th>
                            <th>Total:</th>
                            <td><?php echo $value["total"]?></td>
                        </tr>
                        </table>
                    </div>
                    </div>
                
                </div>
                
                </section>
            
          <?php
          $subtotal = $subtotal+$value["total"];

          array_push($codigosVenta,$value["codigo"]);
          
          }
            
      }
      ?>   

      </div>

      </div>
    </div>
    <div class="col-lg-5 col-xs-12">
      
        <div class="box-body">
            
          <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
            
            <thead>
            
            <tr>
              
              <th style="width:10px">#</th>
              <th>Codigo</th>
              <th>Descripcion</th>
              <th>Monto</th>
              <th>Acciones</th>

            </tr> 

            </thead>

            <tbody>

            <?php

            $codigosGasto = array();
            $item = null;
            $valor = null;

            $egresos = ControladorEgresos::ctrMostrarEgresos($item, $valor);

          foreach ($egresos as $key => $value){
            if($value["control"]==0){
              echo ' <tr>
                      <td>'.($key+1).'</td>
                      <td>'.$value["codigo"].'</td>
                      <td>'.$value["descripcion"].'</td>
                      <td>'.$value["monto"].'</td>
                      <td>

                        <div class="btn-group">
                            
                          <button class="btn btn-warning btnEditarUsuario" idUsuario="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pencil"></i></button>

                          <button class="btn btn-danger btnEliminarUsuario" idUsuario="'.$value["id"].'"><i class="fa fa-times"></i></button>

                        </div>  

                      </td>

                    </tr>';
                    $subgastos = $subgastos+$value["monto"];
                    array_push($codigosGasto,$value["codigo"]);
            }
            
          }


            ?> 

            </tbody>

          </table>

          </div>

      <form role="form" method="POST">

        <!--=====================================
        ENTRADA DEL VENDEDOR
        ======================================-->
    
        <div class="form-group">
        
          <div class="input-group">
            
            <span class="input-group-addon"><i class="fa fa-user"></i></span> 

            <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

            <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">

          </div>

        </div> 

        <!--=====================================
        ENTRADA DEL CÓDIGO
        ======================================--> 

        <div class="form-group">
          
          <div class="input-group">
            
            <span class="input-group-addon"><i class="fa fa-key"></i></span>

            <?php

            $item = null;
            $valor = null;

            $ventas = ControladorCaja::ctrMostrarCaja($item, $valor);

            if(!$ventas){

              echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="10001" readonly>';
          

            }else{

              foreach ($ventas as $key => $value) {
              
              }

              $codigo = $value["codigo"] + 1;
              echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="'.$codigo.'" readonly>';
          
            }

            ?>            
          </div>
        </div>


      <div class="row">
        <div class="col-6">

          <div class="small-box bg-aqua">
            
            <div class="inner">
              
              <h3>Bs <?php echo $subtotal?></h3>
              <input type="hidden" name="ventas" value="<?php echo $subtotal?>"></input>

              <p>Ventas</p>
            
            </div>
            
            <div class="icon">
              
              <i class="ion ion-social-usd"></i>
            
            </div>
            
            <a href="ventas" class="small-box-footer">
              
              Más info <i class="fa fa-arrow-circle-right"></i>
            
            </a>

          </div>

        </div>

        <div class="col-6">

          <div class="small-box bg-red">
          
            <div class="inner">
            
              <h3>Bs <?php echo $subgastos?></h3>
              <input type="hidden" name="gastos" value="<?php echo $subgastos?>"></input>

              <p>Gastos</p>
            
            </div>
            
            <div class="icon">
              
              <i class="ion ion-ios-cart"></i>
            
            </div>
            
            <a href="productos" class="small-box-footer">
              
              Más info <i class="fa fa-arrow-circle-right"></i>
            
            </a>

          </div>

        </div>

        <div class="col-12">

          <div class="small-box bg-green">
            
            <div class="inner">

              <?php $total=$subtotal-$subgastos?>
              <h3>Bs <?php echo $total?></h3>
              <input type="hidden" name="encaja" value="<?php echo $total?>"></input>

              <input type="hidden" name="codigosVenta" value="<?php echo implode(',',$codigosVenta)?>"></input>
              <input type="hidden" name="codigosGasto" value="<?php echo implode(',',$codigosGasto)?>"></input>

              <p>Categorías</p>
            
            </div>
            
            <div class="icon">
            
              <i class="ion ion-clipboard"></i>
            
            </div>
            
            <a href="categorias" class="small-box-footer">
              
              Más info <i class="fa fa-arrow-circle-right"></i>
            
            </a>

          </div>

        </div>

      </div>

        
        </div>

        <div class="box-footer">

            <button type="submit" class="btn btn-primary pull-right">Cerrar Caja</button>

          </div>
      </form>


      <?php

      $guardarCaja = new ControladorCaja();
      $guardarCaja -> ctrCrearCaja();

      ?>
      
      

    </div>
  </div>

    

  </section>

</div>