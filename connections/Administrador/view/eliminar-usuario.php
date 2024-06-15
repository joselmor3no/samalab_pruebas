<input type="hidden" id="msg" name="msg" value="<?= $msg ?>" class="d-none">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6 col-sm-6">
                    <h1><i class="fas fa-user-times nav-icon pr-2"></i><?= $page_title ?></h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">


        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> Consulta rápida de Usuarios</h3>
            </div>
            <div class="card-body">

                <form class="needs-validation" action="eliminar-usuario" method="post" novalidate="">
                    <input type="hidden" id="id_admin" name="id_admin" value="<?= $id_admin ?>">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_sucursal">Empresa - Sucursal</label>
                                <select class="form-control select2" id="id_sucursal" name="id_sucursal" style="width: 100%;" required="">
                                    <option value="">Selecciona una Empresa - Sucursal</option>
                                    <?php
                                    foreach ($sucursales AS $row) {
                                        ?>
                                        <option value="<?= $row->id ?>" <?= $row->id == $id_sucursal ? "selected" : "" ?>>
                                            <?= $row->cliente . " - " . $row->nombre ?>
                                        </option>

                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Favor de capturar el campo Empresa - Sucursal
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="id_sucursal">Usuario</label>
                                <select class="form-control select2" id="id_usuario" name="id_usuario" style="width: 100%;" required="">
                                    <option value="">Selecciona una Empresa - Sucursal</option>
                                </select>
                                <div class="invalid-feedback">
                                    Favor de capturar el campo Empresa - Sucursal
                                </div>
                            </div>
                        </div>


                        <div class="col-md-2 mt-2">
                            <br>
                            <button type="submit" class="btn btn-block bg-gradient-danger"><i class="fa fa-trash pr-2"></i> Eliminar</button>
                        </div>

                    </div>
                    <!-- /.row -->
                </form>

                <?php
                if (count($_POST) > 0) {

                    //$empresas->eliminarOrden($id_sucursal);

                    $datos = $empresas->getOrdenes($id_sucursal, $ini, $fin);
                    ?>

                    <table id="" class="table table-bordered table-hover dataTable" width="30%">
                        <thead>
                            <tr>
                                <th>Consecutivo</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($datos AS $row) {
                                ?>
                                <tr>
                                    <td><?= $row->consecutivo ?></td>
                                    <td><i class="fas fa-times text-danger"></i></td>
                                </tr>

                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                }
                ?>


            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

