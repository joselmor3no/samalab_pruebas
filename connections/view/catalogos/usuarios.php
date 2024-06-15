<input type="hidden" id="msg" name="msg" value="<?= $msg ?>" class="d-none">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6 col-sm-6">
                    <h1><i class="fas fa-user nav-icon pr-2"></i><?= $page_title ?></h1>
                </div>
                <div class="col-md-2 offset-md-4 col-sm-4 offset-sm-2">
                    <a href="usuario" class="btn btn-block bg-gradient-success"><i class="fa fa-user-plus  pr-2"></i> Nuevo</a>
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
                <table id="" class="table table-bordered table-hover dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Horario</th>
                            <th>Estado</th>
                            <th>Tipo de usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $i = 1;
                        foreach ($datos AS $row) {
                            ?>
                            <tr>
                                <td><?= $row->no ?></td>
                                <td><?= $row->usuario ?></td>
                                <td><?= $row->nombre ?></td>
                                <td><?= $row->entrada_trabajo . " - " . $row->salida_trabajo ?></td>
                                <td>Activo</td>
                                <td><?= $row->tipo ?></td>
                                <td> 
                                    <div class="row">
                                        <form class="pr-2" action="usuario"  method="POST">
                                            <input type="hidden" name="id" value="<?= $row->id ?>" class="d-none">
                                            <button type="submit" class="btn btn-sm btn-info rounded-circle m-1"  data-toggle="tooltip" title="Editar">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </form>

                                        <button class="btn btn-sm btn-danger rounded-circle m-1 delete-usuario" data-id="<?= $row->id ?>" data-nombre="<?= $row->nombre ?>" data-toggle="tooltip" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>

                            </tr>

                            <?php
                            $i++;
                        }
                        ?>
                        <!--tr>
                            <td>1</td>
                            <td>connections_administrador</td>
                            <td>Pepe Pecas Pica Papas</td>
                            <td>8:30 - 18:00</td>
                            <td>Activo</td>
                            <td>Administrador</td>
                            <td> 
                                <div class="row">


                                    <button type="submit" class="btn btn-sm btn-info rounded-circle m-1" data-toggle="tooltip" title="Editar">
                                        <i class="fa fa-eye"></i>
                                    </button>


                                    <button class="btn btn-sm btn-danger rounded-circle m-1 " data-id="" data-nombre="" data-toggle="tooltip" title="Desactivar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr-->

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
                <h5 class="modal-title">¿Está seguro que desea eliminar el Doctor?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Seleccione "Eliminar" para eliminar el usuario <span id="nombre" class="font-weight-bold text-primary"></span>. Esta acción no se podrá deshacer.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <form action="controller/catalogos/Usuario?opc=delete" method="POST" >
                    <input type="hidden" class="d-none" id="id_doctor" name="id_usuario" value="">
                    <button id="" class="btn btn-danger btn-cargando" >Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>




