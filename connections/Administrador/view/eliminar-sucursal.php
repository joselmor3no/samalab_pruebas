<input type="hidden" id="msg" name="msg" value="<?= $msg ?>" class="d-none">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6 col-sm-6">
                    <h1><i class="fas fa-trash-alt nav-icon pr-2"></i><?= $page_title ?></h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">


        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> Consulta rápida de Sucursal</h3>
            </div>
            <div class="card-body">
                <?php
              
                if (count($_POST) > 0) {
                    $id_sucursal = $_REQUEST["id_sucursal"];
                    $empresas->eliminarSucursal($id_sucursal);
                }
                $datos = $empresas->getSucurales();
                ?>
                <table id="" class="table table-bordered table-hover dataTable">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Código</th>
                            <th>Sucursal</th>
                            <th>Direccion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($datos AS $row) {
                            ?>
                            <tr>
                                <td><?= $row->cliente ?></td>
                                <td><?= $row->codigo ?></td>
                                <td><?= $row->nombre ?></td>
                                 <td><?= $row->direccion ?></td>
                                <td> 
                                    <div class="text-center">

                                        <button class="btn btn-sm btn-danger rounded-circle m-1 delete-empresa" data-id="<?= $row->id ?>" data-nombre="<?= $row->nombre ?>" data-toggle="tooltip" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>

                            </tr>

                            <?php
                            $i++;
                        }
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


<!-- Eliminar Doctor -->
<div class="modal fade" id="modConfirmarDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¿Está seguro que desea eliminar la Sucursal?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Seleccione "Eliminar" para eliminar la sucursal <span id="nombre" class="font-weight-bold text-primary"></span>. Esta acción no se podrá deshacer.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <form action="eliminar-sucursal-empresa" method="POST" >
                    <input type="hidden" class="d-none" id="id_empresa" name="id_sucursal" value="">
                    <input type="hidden" name="msg" value="ok">
                    <button id="" class="btn btn-danger btn-cargando" >Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
