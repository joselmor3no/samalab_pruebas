<?php

//date_default_timezone_set('America/Mexico_City');

session_start();
$id_sucursal = $_SESSION["id_sucursal"];

require_once($_SERVER["DOCUMENT_ROOT"] . '/libs/mpdf-5.7-php7-master/mpdf.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/model/laboratorio/Reportes.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/controller/laboratorio/Reporte.php');
require_once( $_SERVER["DOCUMENT_ROOT"] . '/model/Catalogos.php');

$codigo = $_REQUEST["codigo"];
$expediente = $_REQUEST["expediente"];
$laboratorio = $_REQUEST["lab"];


$reportes = new Reportes();
$id_orden = $reportes->getIdOrden($codigo, $id_sucursal);
$estudios = $reportes->estudiosPacientesImprimir($id_orden, $expediente, $id_sucursal);
$paciente = $reportes->getOrdenPaciente($id_orden)[0];
$formato = $reportes->getFormatoLab($id_sucursal)[0];

$catalogos = new Catalogos();
$sucursal = $catalogos->getSucursal($id_sucursal)[0];

//QR paciente
$contenidoQR = "https://" . $_SERVER['SERVER_NAME'] . "/Pacientes/controller/Acceso?opc=expediente&user=" . $expediente;
$qr = $catalogos->QR_Generator($contenidoQR);

//$laboratorio = 1;
//Filtrar por estudios estandar e impresos

$ant = "";
$paq = [];
$paquete = [];
foreach ($estudios AS $row) {

    if ($row->id_tipo_reporte == 4 && $row->impresion > 0) {
        $sig = $row->paquete;
        if ($sig != $ant) {
            $paq[] = array(
                "paquete" => $row->paquete,
                "materia" => $row->materia,
                "metodo" => $row->metodo_utilizado,
                "quimico" => $reportes->getQuimicoReporta($row->id_detalle_orden)[0],
            );
        }
        $ant = $sig;

        $paquete[] = array(
            "estudio" => $row->nombre_estudio,
            "paquete" => $row->paquete,
            "pagina" => $row->pagina,
            "componentes" => $controller->getComponentesData($row->id_detalle_orden, $id_sucursal, $paciente->edad, $paciente->tipo_edad, $paciente->sexo)
        );
    }
}
//var_dump($paquete);
//sino es el paciente parar
if (count($estudios) == 0) {
    return;
}


$pdf = new mPDF('UTF-8', 'A4', $formato->punto, strtolower($formato->fuente));
$pdf->SetTitle("REPORTE-PAQUETE-" . $codigo);

$pdf->setAutoTopMargin = 'stretch';
$pdf->setAutoBottomMargin = 'stretch';

if ($formato->color_linea == "Negro") {
    $linea = "#000000";
} else if ($formato->color_linea == "Azul") {
    $linea = "#001BFF";
} else if ($formato->color_linea == "Rojo") {
    $linea = "#FF0000";
} else if ($formato->color_linea == "Rosa") {
    $linea = "FF00C1";
} else if ($formato->color_linea == "Gris") {
    $linea = "#616d71";
} else if ($formato->color_linea == "Verde") {
    $linea = "09A11B";
} else if ($formato->color_linea == "Amarillo") {
    $linea = "FFFF11";
}


$edad = $paciente->edad . " " . ($paciente->tipo_edad != "Anios" ? $paciente->tipo_edad : "AÑOS") . " / " . $paciente->sexo;

$html_paciente = "
<table width='100%' style='font-size:9pt'>
    <tr>
        <td colspan='3'></td> 
        <td style='text-align: right;'>
        <font SIZE=2>
            Página {PAGENO} de {nbpg}
            </font>
        </td>
    </tr>
    <tr>
        <td colspan='3'><span style='font-weight: bold;'>PACIENTE: </span> " . $paciente->paciente . "</td>
        <td width=20% ><span style='font-weight: bold;'>FECHA: </span>" . $paciente->fecha . "</td>
    </tr>
    <tr>
        <td colspan='3'><span style='font-weight: bold;'>EDAD/SEXO: </span>" . $edad . "</td>
        <td><span style='font-weight: bold;'>MUESTRA: </span>" . ( count($paquete) == 1 ? $paquete[0]["materia"] : "" ) . "</td>
        
    </tr>
    <tr>
        <td colspan='3'><span style='font-weight: bold;'>MÉDICO: </span>" . $paciente->doctor . "</td>
        <td><span style='font-weight: bold;'>No. ORDEN: </span>" . $paciente->codigo . "</td>
    </tr>";

if ($paciente->empresa != "") {
    $html_paciente .= " <tr>
        <td colspan='3'><span style='font-weight: bold;'>EMPRESA: </span>" . $paciente->empresa . "</td>
    </tr>";
}
$html_paciente .= "</table>";



if ($laboratorio == 1) {
    $pdf->SetHTMLHeader('
    <div style="height:' . ($formato->head * 37.7) . 'px">
    </div>' . $html_paciente);

    //<img width="120px" src="data:image/png;base64,' . $qr . '"/>


    if ($sucursal->quimico != "") {
        $quimico = ' 
            <img src="../../images-sucursales/firmas/' . ($paq[0]["quimico"]->firma_digital != "" ? $paq[0]["quimico"]->firma_digital : "transparente.png") . '" style="height:150px; margin-bottom:-60px; margin-top:-35px;" />                       
            <br>____________________________
            <br><b>QUIMICO RESPONSABLE</b>
            <br>' . $paq[0]["quimico"]->nombre . '          
            <br>';
    }


    if ($sucursal->quimico_aux != "") {
        $quimico_aux = ' 
            <img src="../../images-sucursales/firmas/' . $sucursal->firma_aux . '" style="height:150px; margin-bottom:-60px; margin-top:-35px;" />                       
            <br>____________________________
            <br><b>QUIMICO AUXILIAR</b>
            <br>' . $sucursal->quimico_aux . '          
            <br>' . $sucursal->cedula_aux . '          
        ';
    }

    $pdf->SetHTMLFooter(
            '<div style="height:' . ($formato->footer * 37.7) . 'px">
                <div style="text-align: left;">
                   <font size=2>
                   * Fuera de intervalo biológico de referencia
                   </font>
               </div>
               <table width="100%">
                   <tr>
                       <td width=33% align="center">' .
            $quimico . '
                       </td>
                       <td width=33% align="center">' .
            $quimico_aux
            . '</td> 
                      <td width="34%" align="center" style="font-weight: bold;"><br><br><br><br><br><br>"La interpretación de resultados solo puede hacerla su médico"</td>
                   </tr>
               </table>
               <br>'
            . ($formato->horafecha == 1 ? '<font size=2>Fecha de impresión: ' . date("d/m/Y G:i") . ' hrs' : '') . '</font>
           </div>'
    );
} else {
    $pdf->SetHTMLHeader('
    <div style="height:' . ($formato->head * 37.7) . 'px">
    </div>' . $html_paciente);

    $pdf->SetHTMLFooter(
            '<div style="height:' . ($formato->footer * 37.7) .
            'px">
        <div style="text-align: left;">
            <font size=2>
            * Fuera de intervalo biológico de referencia
            </font>
        </div>
       <div style="height:' . (($formato->footer - 1) * 37.7) . 'px"></div>'
            . ($formato->horafecha == 1 ? '<font size=2>Fecha de impresión: ' . date("d/m/Y G:i") . ' hrs' : '') . '</font>
    </div>'
    );
}

//membrete
if ($laboratorio == 0) {
    $cabecera_resultado = "<style>
    body {
    background-image: url(membrete.png);
    background-size: cover;
    background-repeat: no-repeat;
    background-image-resize: 6;

    }
    </style>";
}


$cabecera_resultado .= "
    <div>
        <table width='100%' style='border-bottom:1px solid " . $linea . ";'>
            <tr>
                <td align='center' width='33%'>NOMBRE DE EXAMEN</td> 
                <td align='center' width='33%' style='font-weight: bold;'>RESULTADO</td> 
                <td align='center' width='33%'>INTERVALO DE REFERENCIA</td> 
            </tr>
        </table>
    </div> <br style='padding-bottom: 15px;' >    
";

$pdf->WriteHTML($cabecera_resultado);



$cuerpo = "";
foreach ($paq as $paq_) {
    $paquete_nombre = "
                <p align='center' style='padding-top: 5px; padding-bottom: 5px; border-bottom:1px solid " . $linea . ";'>
                    <span style='$color'><b>" . $paq_["paquete"] . "</b></span>
                </p>";
    $pdf->WriteHTML($paquete_nombre);

    $cuerpo = "<table width='100%' CELLPADDING=1 CELLSPACING=1 BORDER=0>";

    $pagina = 0;
    foreach ($paquete as $estudio) {

        if ($paq_["paquete"] == $estudio["paquete"]) {

            if ($estudio["pagina"] == 1) {
                $pagina = 1;
            }

            if ($formato->color == 1) {
                $color = "color:#466BF1";
            } else {
                $color = "color:#000000; ";
            }

            $i = 0;
            foreach ($estudio["componentes"] as $componente) {
                if ($componente["componente"]->imprimible == 1) {

                    if ($componente["componente"]->id_cat_componente == NULL) {
                        $cuerpo .= "<tr>
                    <td colspan='8'>
                    <font> " . (count($estudio["componentes"]) == 1 ? $estudio["estudio"] : $componente["componente"]->componente ) . "</font>
                    </td>
                    </tr>";
                    } else if ($componente["componente"]->id_cat_componente == 1 || $componente["componente"]->id_cat_componente == 2) {
                        if ($componente["componente"]->resultado < $componente["referencia"]->baja || $componente["componente"]->resultado > $componente["referencia"]->alta) {
                            if ($formato->color == 1) {
                                $color = "red";
                            } else {
                                $color = "black";
                            }

                            if ($formato->asterisco == 1) {
                                $marca = "<font color='$color'> * </font>";
                            } else {
                                $marca = "";
                            }
                        } else if ($componente["componente"]->resultado == $componente["referencia"]->alta || $componente["componente"]->resultado == $componente["referencia"]->baja) {
                            if ($formato->color == 1) {
                                $color = "blue";
                            } else {
                                $color = "black";
                            }
                            $marca = "";
                        } else {
                            $color = "black";
                            $marca = "";
                        }
                        //componente numerico y formula
                        $cuerpo .= "<tr>
                        <td width='33%'>
                        " . ($i == 0 ? $estudio["estudio"] : $componente["componente"]->componente ) . "
                        </td>
                        <td width='10%'></td>
                        <td align='center' width='13%'>
                        <font style='font-weight: bold;' color='" . $color . "'>  " . $componente["componente"]->resultado . "</font>
                        </td>
                        <td width='10%'> " . $marca . "</td>";
                        if ($componente["tabla"] != NULL) {
                            $cuerpo .= "
                            <td  width='34%' colspan='4'>
                            " . $componente["tabla"] . "
                            </td>
                            </tr>";
                        } else {
                            $cuerpo .= "
                            <td align='right' width='10%'>" . $componente["referencia"]->baja . "</td>
                            <td align='center' width='3%'> " . $formato->separador . " </td>
                            <td align='left' width='10%'>" . $componente["referencia"]->alta . "</td>
                            <td align='left' width='11%'> " . $componente["referencia"]->unidad . "</td>
                            </tr>";
                        }
                    } else if ($componente["componente"]->id_cat_componente == 3) {
                        //componente lista
                        $cuerpo .= "<tr>
                        <td width='33%'>
                        " . ($i == 0 ? $estudio["estudio"] : $componente["componente"]->componente ) . "
                        </td>
                        <td  colspan='3' align='center' width='33%'>
                        " . $componente["componente"]->resultado . "
                        </td>";
                        if ($componente["tabla"] != NULL) {
                            $cuerpo .= "
                            <td width='34%'  colspan='4'>
                            " . $componente["tabla"] . "
                            </td>
                            </tr>";
                        } else {
                            foreach ($componente["referencia"] as $lista) {
                                if ($lista->predeterminado == "1") {
                                    $referencia_imprimir = $lista->elemento;
                                }
                            }

                            $cuerpo .= "
                            <td align='center' width='34%' colspan='4'>
                            " . $referencia_imprimir . "
                            </td>
                            </tr>";
                        }
                    } else if ($componente["componente"]->id_cat_componente == 4) {
                        //componente texto  <td  align='justify' width='33%'>
                        $cuerpo .= "<tr>
                        <td width='33%'>
                        " . ($i == 0 ? $estudio["estudio"] : $componente["componente"]->componente ) . "
                        </td>
                        <td width='10%'></td>
                        <td align='center' width='13%'>
                          <font style='font-weight: bold;' color='" . $color . "'>  " . $componente["componente"]->resultado . "</font>
                        </td>
                        <td width='10%'></td>
                        <td align='center' width='34%' colspan='4'>
                        " . $componente["componente"]->unidad . "
                        </td>
                        </tr>";
                    }

                    //si tiene leyenda
                    if ($componente["componente"]->leyenda != "") {
                        $cuerpo .= "<tr><td colspan=8>" . $componente["componente"]->leyenda . "</td></tr>";
                    }

                    //linea
                    if ($componente["componente"]->linea == 1) {
                        $cuerpo .= "<tr style=' margin-top:-60px;'><td colspan=8 style='border-top:1px solid " . $linea . "; '></td></tr>";
                    }
                }
                $i++;
            }
        }
    }
    //metodo
    $cuerpo .= "<tr><td colspan=9 style='padding-bottom: 7px;'><span style='font-weight: bold; font-size:" . ($formato->punto - 2) . "pt'>Método empleado: " . $paq_["metodo"] . "</span></td></tr>";

    $cuerpo .= "
            </table>
            </div>
            ";
    $pdf->WriteHTML($cuerpo);

    if ($pagina == 1) {
        $pdf->AddPage();
        $pdf->WriteHTML($cabecera_resultado);
    }
}

$pdf->Output("REPORTE-PAQUETE-" . $codigo . ".pdf", 'I');
