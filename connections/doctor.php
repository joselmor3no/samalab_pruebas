<?php
session_start();
$id_sucursal = $_SESSION["id_sucursal"];
$id_sucursal2 = $_SESSION["id_sucursal"];
if($id_sucursal==156)
    $id_sucursal2=121;
$id_cliente=$_SESSION["id_cliente"];
require_once('model/Catalogos.php');
require_once('model/catalogos/Doctores.php');

$catalogos = new Catalogos(); 
$doctores = new Doctores();

$estados = $catalogos->getEstados();
$especialidad = $catalogos->getEspecialidades();
$sucursal = $catalogos->getSucursal($id_sucursal2); 
$prefijo_doctor_sucursal=$sucursal[0]->prefijo_doctores;
if (isset($_REQUEST["id"])) {
    $id_doctor = $_REQUEST["id"];
    $doctor = $doctores->getDoctor($id_doctor);
    $municipios = $catalogos->getMunicipios($doctor[0]->estado);
} 
elseif(isset($_REQUEST['busqueda_paterno'])){
    $doctor = [ (object) [] ];
    $doctor[0]->apaterno=$_REQUEST['busqueda_paterno'];
    $doctor[0]->amaterno=$_REQUEST['busqueda_materno'];
    $doctor[0]->nombre=$_REQUEST['busqueda_nombre'];
    $Ultimoconsecutivo=$doctores->getUltimoConsecutivoSucursal($id_sucursal2)[0]; 
    if($Ultimoconsecutivo && !is_numeric($Ultimoconsecutivo->consecutivo)){
        $Ultimoconsecutivo->consecutivo=1;
    }
}
else {
    $id_doctor = "";
    $Ultimoconsecutivo=$doctores->getUltimoConsecutivoSucursal($id_sucursal2)[0]; 
    if(!is_numeric($Ultimoconsecutivo->consecutivo)){
        $Ultimoconsecutivo->consecutivo=1;
    }
}

$listaZonas=$doctores->getZonas($id_sucursal2);
$listaPromotores=$doctores->getPromotores($id_sucursal2);
//Información para vistas
$page_title = "Doctores";
$usuario = $_SESSION["usuario"];

require("view/_blocks/header.php");
require("view/_blocks/menu.php");
require("view/_blocks/navbar.php");
require("view/catalogos/doctor.php" );
require("view/_blocks/copy.php");
require("view/_blocks/footer.php");
?>


<!-- Select2 -->
<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<script src="assets/plugins/select2/js/select2.full.min.js"></script>

<!-- Toastr -->
<link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
<script src="assets/plugins/toastr/toastr.min.js"></script>

<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/catalogos/doctores.js"></script>

<?php
//cerrar conexion
$doctores->close();
$catalogos->close();
?>


