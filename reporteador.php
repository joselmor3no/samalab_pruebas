<?php
session_start();
$id_usuario = $_SESSION["id"];
$id_sucursal = $_SESSION["id_sucursal"];

require('model/catalogos/Users.php');

$usuarios = new Users();
$permisos = $usuarios->getPermisosUsuario($id_usuario);
$listaUsuario=$usuarios->getUsuariosReporteGlobal($id_sucursal);  
$listaEmpresa=$usuarios->getEmpresasReporteGlobal($id_sucursal); 
$listaDoctor=$usuarios->getDoctoresReporteGlobal($id_sucursal); 
$listaFormaP=$usuarios->getFormaPagoReporteGlobal($id_sucursal); 
$empresa=-1;
$usuario=-1;
$doctor=-1;
$estatus=-1;
$tipop=-1;
$respuestaRG=$usuarios->obtenerReporteGlobal(date("Y-m-d"),date("Y-m-d"),$id_sucursal,$empresa,$usuario,$doctor,$estatus,$tipop); 

$respuestaRGC=$usuarios->obtenerReporteGlobalCaja(date("Y-m-d"),date("Y-m-d"),$id_sucursal,$usuario);
$respuestaRGCP=$usuarios->obtenerReporteGlobalCajaPago(date("Y-m-d"),date("Y-m-d"),$id_sucursal,$usuario);

//----------------------------------reporte de caja 


$timporte=0;
$tcubierto=0;
$tdeudor=0;
$contador=1;
$consecutivoActual=-1;
$pagoAT=0;
$pagosAnteriores=0;
$cajaR="";
foreach ($respuestaRGC AS $row) {
    $orden_id=$row->id;
    $resTpo=$usuarios->obtenerReporteGlobalDescripcionPago($orden_id);
    $tdeudor=$tdeudor+$row->saldo_deudor;
	if($row->credito==1){
		$status="E.Credito";
	}
	elseif($row->saldo_deudor==0){
		$status="Pagado";
	}
	else{
		$status="C/adeudo";
	}
	$nombreU=explode(" ", $row->nombre_usuario);
	$fecha_r=substr($row->fecha_registro,0,10);
	$fecha_p=substr($row->fecha_pago,0,10);
	$cajaR.='<tr>
		<td>'.$contador.'</td>
		<td>'.utf8_encode($row->nombre).'</td>
		<td>'.$row->fecha_registro.'</td>
		<td>'.$row->consecutivo.'</td>
		<td>'.utf8_encode($row->nombre_empresa).'</td>
		<td>'.utf8_encode($row->nombre_paciente).'</td>';
		if($consecutivoActual!=$row->consecutivo){
			$cajaR.='<td style="text-align:right">'.number_format($row->importe,2).'</td>';
			$consecutivoActual=$row->consecutivo;
			$timporte=$timporte+$row->importe;
		}
		else{
			$cajaR.='<td style="text-align:right"></td>';
		}
		
		if($fecha_r==$fecha_p  && $row->credito!=1){
			$cajaR.='
			<td style="text-align:right">'.number_format($row->pago,2).'</td>
			<td style="text-align:right;color:purple;">'.$row->fecha_pago.'</td>
			<td style="text-align:right"></td>
			';
			$tcubierto=$tcubierto+$row->pago;
			$pagoAT=$pagoAT+$row->pago;
		} 
		else{
			$cajaR.='
			<td style="text-align:right"></td>
			<td style="text-align:right;color:purple;">'.$row->fecha_pago.'</td>
			<td style="text-align:right;color:purple;">'.number_format($row->pago,2).'</td>
			';
			$tcubierto=$tcubierto+$row->pago;
			$pagosAnteriores=$pagosAnteriores+$row->pago;
		}

	$cajaR.='<td style="text-align:right">'.number_format($row->pago,2).'</td>
		<td style="text-align:right">'.number_format($row->saldo_deudor,2).'</td>
		<td>';
			foreach ($resTpo AS $row2) {
				$cajaR.= $row2->descripcion.'<br>';
			}
		
		$cajaR.='</td>
		<td>'.$status.'</td>
		<td>'.utf8_encode($nombreU[0]).'</td>
	</tr>';
	$contador++;
    
}


//----------------------------------------------------
//mensaje de operacion exitosa
$msg = $_REQUEST["msg"];

//Información para vistas
$page_title = "Reportes";
$usuario = $_SESSION["usuario"]; 

require("view/_blocks/header.php");
require("view/_blocks/menu.php");
require("view/_blocks/navbar.php");
include "view/administracion/reportes.php";
require("view/_blocks/copy.php");
require("view/_blocks/footer.php");
?>

<!-- DataTables -->
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- DataTables  & Plugins -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/plugins/jszip/jszip.min.js"></script>
<script src="assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Toastr -->
<link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
<script src="assets/plugins/toastr/toastr.min.js"></script>

<script src="assets/js/administracion/reporteador.js"></script>

<?php
//cerrar conexion
$usuarios->close();
?>

