<?php
session_start();
$id_sucursal = $_SESSION["id_sucursal"];
$codigo = $_REQUEST["codigo"];


require_once('model/catalogos/Estructuras.php');
require_once('model/Catalogos.php');


$estructuras = new Estructuras();
$datos = $estructuras->getFormasPagos($id_sucursal);

$catalogos = new Catalogos();
$sucursal = $catalogos->getSucursal($id_sucursal)[0];

//mensaje de operacion exitosa
$msg = $_REQUEST["msg"];

//Información para vistas
$page_title = "Pagos";
$usuario = $_SESSION["usuario"];

require("view/_blocks/header.php");
require("view/_blocks/menu.php");
require("view/_blocks/navbar.php");
require("view/admision/caja.php" );
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

<!-- Select2 -->
<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<script src="assets/plugins/select2/js/select2.full.min.js"></script>

<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/admision/caja.js"></script>

<?php
//cerrar conexion
$estructuras->close();
$catalogos->close();
?>

