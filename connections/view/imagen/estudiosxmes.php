<?php 
if(isset($_REQUEST['fecha_final']) && isset($_REQUEST['fecha_inicial'])){
    $fechaInicial = $_REQUEST['fecha_inicial'];
    $fechaFinal = $_REQUEST['fecha_final'];
} else {
    // Obtener el primer día del mes actual
    $fechaInicial = date("Y-m-01");

    // Obtener el último día del mes actual
    $fechaFinal = date("Y-m-t");
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6 col-sm-6 ">
                    <h1><i class="fa fa-calculator nav-icon pr-2"></i><?= $page_title ?></h1>
                </div>
                
            </div>
        </div><!-- /.container-fluid -->
    </section> 

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <form class="needs-validation" action="estudiosxmes" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <h3 class="card-title">Lista de Resultados</h3>
                        </div> 

                        <div class = "col-md-3">
                            <div class = "form-group row m-0">
                                <label class="col-sm-4 col-form-label" for = "fecha_inicial">Fecha Inicio</label>
                                <div class="col-md-8"> <input type = "date" class = "form-control form-control-border" name = "fecha_inicial"  placeholder = "Fecha inicial" value="<?php echo $fechaInicial?>"></div>
                            </div>
                        </div>

                        <div class = "col-md-3">
                            <div class = "form-group row m-0">
                                <label class="col-sm-4 col-form-label" for = "fecha_final">Fecha Final</label>
                                <div class="col-md-8"> <input type = "date" class = "form-control form-control-border" name = "fecha_final"  placeholder = "Fecha final" value="<?php echo $fechaFinal ?>"></div>
                            </div>
                        </div> 

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-block bg-gradient-primary"><i class="fas fa-search pr-2"></i> Buscar</button>
                        </div>

                    </div>
                </form>

            </div><!--end card-header-->

            <div class="card-body">
                <?php
                    $respuesta=$imagenController->listaEstudiosXmes($fechaInicial,$fechaFinal);
                ?>
                <h3>Total de estudios interpretados: <?= $respuesta['totalCantidad']>0 ? $respuesta['totalCantidad'] : 0?>, Monto: $<?= $respuesta['totalGeneral']>0 ? number_format($respuesta['totalGeneral'],2) : 0?></h3>
                <table id="" class="table table-bordered table-hover dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No.Estudio </th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Costo Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                        
                        echo $respuesta["tabla"];
                        ?>
                    </tbody>
                </table>

            </div>

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



