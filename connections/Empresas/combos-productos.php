<?php
session_start();
$id_cliente = $_SESSION["id_cliente"];

require_once('model/Productos.php');
require_once('../model/Catalogos.php');

$catalogos = new Catalogos();
$estudios = $catalogos->getCatEstudios();

$productos = new Productos();
$datos = $productos->getCombosProductos($id_cliente);
$list_productos = $productos->getProductos($id_cliente);
$estudios = $productos->getEstudiosCombo();

//mensaje de operacion exitosa
if (isset($_REQUEST["msg"]))
  $msg = $_REQUEST["msg"];
else
  $msg = "";

//Información para vistas
$page_title = "Combos por estudio";
$usuario = $_SESSION["usuario"];



require("view/_blocks/header.php");
require("view/_blocks/menu.php");
require("view/_blocks/navbar.php");
require("view/combos-productos.php");
require("view/_blocks/copy.php");
require("view/_blocks/footer.php");
?>

<!-- DataTables -->
<link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- DataTables  & Plugins -->
<script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../assets/plugins/jszip/jszip.min.js"></script>
<script src="../assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Select2 -->
<link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<script src="../assets/plugins/select2/js/select2.full.min.js"></script>

<!-- Toastr -->
<link rel="stylesheet" href="../assets/plugins/toastr/toastr.min.css">
<script src="../assets/plugins/toastr/toastr.min.js"></script>

<link rel="stylesheet" href="../assets/css/style.css">
<script src="js/inventario.js"></script>
<?php
//cerrar conexion
$productos->close();
?>