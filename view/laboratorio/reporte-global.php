<input type="hidden" id="msg" name="msg" value="<?= $msg ?>" class="d-none">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">

                <div class="col-md-12">
                    <div class="row">

                        <div class="col-md-2 mb-2">
                            <h3 class="card-title"> Reporte de Resultados</h3>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button id="imprimir-reporte" type="" class="btn btn-block bg-gradient-primary"><i class="fa fa-file-pdf pr-2"></i>Imprimir</button>
                        </div>

                        <div class="col-md-2 mb-2">
                            <button type="" class="btn btn-block bg-gradient-secondary mail"><i class="fa fa-envelope pr-2"></i>Correo</button>
                        </div>

                        <div class="col-md-3 mb-2">
                            <button type="" class="btn btn-block bg-gradient-success whatsapp"><i class="fab fa-whatsapp pr-2"></i>Whatsapp</button>
                        </div>
                        <div class="col-md-2 text-right mb-2">

                            <a href="reporte-laboratorio" class="btn btn-primary rounded-circle" title="Buscar Pacientes" data-toggle="tooltip" >
                                <i class="fa fa-search"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <div id="paciente_codigo" class="border-bottom w-100 "> <?= $paciente[0]->codigo ?> </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="epediente">Expediente</label>
                            <div id="paciente_expediente" class="border-bottom w-100 "><?= $paciente[0]->expediente ?></div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="paciente">Paciente</label>
                            <div id="paciente_nombre" class="border-bottom w-100 "> <?= $paciente[0]->paciente ?> </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <div id="paciente_fecha" class="border-bottom w-100 "> <?= $paciente[0]->fecha ?> </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sexo">Sexo</label>
                            <div id="paciente_sexo" class="border-bottom w-100 text-uppercase"> <?= $paciente[0]->sexo != "Nino" ? $paciente[0]->sexo : "NIÑO" ?> </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <div id="paciente_edad" class="border-bottom w-100 text-uppercase"> <?= $paciente[0]->edad . " " . ($paciente[0]->tipo_edad != "Anios" ? $paciente[0]->tipo_edad : "AÑOS") ?> </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="medico">Médico</label>
                            <div id="paciente_medico" class="border-bottom w-100 "><?= $paciente[0]->doctor ?>  </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="observaciones">Observaciones de paciente</label>
                            <div id="paciente_observaciones" class="border-bottom w-100 "> &nbsp; <?= $paciente[0]->observaciones ?>  </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="custom-control custom-checkbox">
                            <input id="ingles" type="checkbox" <?= $paciente[0]->ingles == 1 ? "checked" : "" ?> class="custom-control-input">
                            <label class="custom-control-label" for="ingles">Inglés</label>
                        </div>
                    </div>

                </div><!-- .row -->

                <div class="row">

                    <div class="col-md-6 pt-2 mb-2" style="overflow:auto;max-height:180px" >

                        <table class="table table-bordered table-estudios">
                            <thead>
                                <tr>
                                    <th class="text-center">Pacientes </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($pacientes AS $row) {
                                    ?>
                                    <tr id="index_paciente_<?= $row->id ?>" class="bg-pacientes <?= $row->id == $id_orden ? "bg-light" : "" ?>">
                                        <td>
                                            <button id="btn-paciente-<?= $row->id ?>" data-id="<?= $row->id ?>" class="btn btn-link text-black pt-0 pb-0 pacientes"> 
                                                <?= $row->paciente ?>
                                            </button>
                                        </td>
                                    </tr>

                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>

                    </div>


                    <div class="col-md-6 pt-2 mb-2" style="overflow:auto;max-height:180px" >

                        <table id="table-estudios"
                               class="table table-bordered table-estudios">
                            <thead>
                                <tr>
                                    <th class="text-center" width="10%">Imprimir</th>
                                    <th class="text-center" width="10%">Página</th>
                                    <th class="text-center">Estudio </th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_estudios">
                                <?php
                                foreach ($estudios AS $estudio) {
                                    // var_dump($estudio);
                                    ?>
                                    <tr id="index_<?= $estudio->id ?>" class="bg-estudios">

                                        <td align="center">
                                            <div class="custom-control custom-checkbox">
                                                <input id="imprimir_<?= $estudio->id ?>" <?= $estudio->reportado > 0 ? "checked" : "disabled" ?> type="checkbox" name="imprimir[]" value="<?= $estudio->id ?>" class="custom-control-input imprimir">
                                                <label class="custom-control-label" for="imprimir_<?= $estudio->id ?>"></label>
                                            </div>
                                        </td>
                                        <td align="center">
                                            <div class="custom-control custom-checkbox">
                                                <input id="pagina_<?= $estudio->id ?>" <?= $estudio->reportado > 0 ? "" : "disabled" ?> <?= $estudio->pagina == 1 ? "checked" : "" ?> type="checkbox" name="pagina[]" value="<?= $estudio->id ?>"  class="custom-control-input pagina">
                                                <label class="custom-control-label" for="pagina_<?= $estudio->id ?>"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <button id="btn-estudio-<?= $estudio->id ?>" data-id="<?= $estudio->id ?>" data-estudio="<?= $estudio->estudio ?>" data-impresion="<?= $estudio->impresion ?>" data-reportado="<?= $estudio->reportado ?>" 
                                                    class="<?= $estudio->impresion > 0 ? "text-success" : ( $estudio->reportado > 0 ? "text-primary" : "text-black" ) ?> btn btn-link pt-0 pb-0 estudio"  data-tipo="<?= $estudio->resultado_componente == 1 ? "componente" : "texto" ?>"> 
                                                        <?= $estudio->estudio ?>
                                            </button>
                                        </td>
                                        <td class="text-center p-1">
                                            <button type="button" data-id="<?= $estudio->id ?>"  data-estudio="<?= $estudio->estudio ?>" class="btn btn-sm btn-primary rounded-circle load-activity "  title="Bitácora" data-toggle="tooltip" >
                                                <i class="fas fa-clipboard-list"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>


                </div>
                <!-- /.row -->

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->


        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 id="estudio" class="card-title text-center w-100 font-weight-bold"> </h3>
            </div>

            <div class="card-body">
                <form id="reporte-estudios" class="needs-validation" action="controller/laboratorio/Reporte?opc=save-resultados-lab" method="post" novalidate="">
                    <input type="hidden" id="id_sucursal" name="id_sucursal" value="<?= $id_sucursal ?>">
                    <input type="hidden" id="fecha_ini" name="ini" value="<?= $fecha_inicial ?>">
                    <input type="hidden" id="fecha_fin" name="fin" value="<?= $fecha_final ?>">
                    <input type="hidden" id="rango" name="rango" value="1">
                    <input type="hidden" id="codigo" name="codigo" value="<?= $codigo ?>">
                    <input type="hidden" id="id_orden" name="id_orden" value="<?= $id_orden ?>">
                    <input type="hidden" id="id_estudio" name="id_estudio" value="">
                    <input type="hidden" id="id_paciente" name="id_paciente" value="<?= $paciente[0]->id ?>">
                    <input type="hidden" id="hide_edad" name="hide_edad" value="<?= $paciente[0]->edad ?>">
                    <input type="hidden" id="hide_tipo_edad" name="hide_tipo_edad" value="<?= $paciente[0]->tipo_edad ?>">
                    <input type="hidden" id="hide_sexo" name="hide_sexo" value="<?= $paciente[0]->sexo ?>">
                    <input type="hidden" id="hide_observaciones" name="hide_observaciones" value="">
                    <input type="hidden" id="hide_tipo" name="hide_tipo" value="">

                    <div id="tipo-componente"  class="col-md-8 offset-md-2 d-none">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Resultado</th>
                                    <th class="text-center">BAJA</th>
                                    <th class="text-center">ALTA</th>
                                    <th class="text-center">Referencia/Unidad</th>
                                </tr>
                            </thead>
                            <tbody id="table-componentes">

                            </tbody>
                        </table>

                        <div id="table-imprimir">

                        </div>

                    </div>

                    <div id="tipo-texto" class="col-md-12 d-none" >
                        <div class="form-group">

                            <textarea  id="reporte-texto" class = "" name = "reporte-texto">
                                        
                            </textarea>

                        </div>
                    </div>

                    <div class="col-md-4 offset-md-4 ">
                        <button id="save" type="submit" class="btn btn-block bg-gradient-primary " disabled>
                            <i class="fa fa-save pr-2"></i>
                            Guardar/Validar</button>
                    </div>

                </form>
            </div>
        </div>
        <!-- /.card -->

    </section>

    <div class="modal fade" id="modalBitocara" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5  class="modal-title">Bitácora <span id="bitacora" class="text-primary"></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="row">
                        <table id="tableBitacora" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Actividad</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody id="table-bitacora"></tbody>
                        </table>

                    </div>


                </div>

                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>


<!-- /.content-wrapper -->
<style type="text/css">

    .table-responsive {
        height: 300px;
        overflow: scroll;
    }

    .form-control {
        height: 1.25rem;
        padding: 0px;
    }

    .table td,
    .table th {
        padding: 0px;
        font-size: 0.95rem;

    }

    .custom-control {
        min-height: 0.25rem; 
    }

    label {
        margin-bottom: 0px;
    }

    .form-group {
        margin-bottom: 0.25rem;
    }

    .text-black {
        color: #343a40 !important;

    }

    .text-danger {
        color: #dc3545!important;
    }

    .text-primary {
        color: #007bff!important;
    }
</style>