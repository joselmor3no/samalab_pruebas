<?php

require_once( $_SERVER["DOCUMENT_ROOT"] . '/model/Usuarios.php');
require_once( $_SERVER["DOCUMENT_ROOT"] . '/model/Conexion.php');
require_once( $_SERVER["DOCUMENT_ROOT"] . '/model/Catalogos.php');

class Resultados {

    private $conexion;

    function __construct() {
        //Validación de session
        $usuarios = new Usuarios();
        $acceso = $usuarios->validarSession();
        if (!$acceso) {
            header("Location: /");
        }

        $this->conexion = new Conexion();
    }

    function getResultadosImagen($fecha_ini, $fecha_fin, $id_sucursal) {

        $sql = "SELECT dcm.local,dcm.ruta, o.id,p.tel AS telefono,dcm.id as id_dcm,e.nombre as empresa,dr.id as id_dcmr, 
        o.consecutivo,CONCAT(p.nombre,' ',p.paterno,' ',p.materno) as paciente, p.cpEmail AS correo,
        o.fecha_registro,ce.nombre_estudio as estudio,o.saldo_deudor,o.credito,p.expediente,dr.cerrado  
            FROM orden o 
            inner join orden_estudio oe on oe.id_orden=o.id 
            inner join cat_estudio ce on ce.id=oe.id_estudio
            inner join paciente p on p.id=o.id_paciente
            inner join dcm on dcm.id_orden=o.id and dcm.id_categoria=ce.id
            left join empresa e on e.id=o.id_empresa 
            left join dcm_resultado dr on dr.id_dcm=dcm.id 
            where o.fecha_registro BETWEEN '$fecha_ini' AND '$fecha_fin 23:59:59' and o.id_sucursal=$id_sucursal";
         
        $data = $this->conexion->getQuery($sql);
        return $data;
    }

    function getResultados($fecha_ini, $fecha_fin, $id_sucursal) {

        $sql = "SELECT *, COUNT(*) AS estudios, SUM(reportado) AS reportado  
        FROM (SELECT orden.id, orden.consecutivo, orden.saldo_deudor, orden.credito, CONCAT(paciente.nombre, ' ', paciente.paterno , ' ', paciente.materno) AS paciente, DATE_FORMAT(paciente.fecha_nac, '%d/%m/%Y') AS fecha_nacimiento,
        DATE_FORMAT(orden.fecha_registro, '%d/%m/%Y') AS fecha_orden, paciente.expediente, paciente.tel AS telefono, paciente.cpEmail AS correo, empresa.nombre AS empresa,
        IF((SELECT COUNT(*)  FROM log_resultados_impresion WHERE id_orden = orden.id AND id_estudio = orden_estudio.id_estudio AND reset = 0 LIMIT 1) > 0,1,0) AS reportado
        FROM orden 
        INNER JOIN orden_estudio ON (orden.id = orden_estudio.id_orden)
        INNER JOIN cat_estudio ON (cat_estudio.id = orden_estudio.id_estudio)
        INNER JOIN paciente ON (paciente.id = orden.id_paciente)
        LEFT JOIN empresa ON (empresa.id = orden.id_empresa)
        WHERE orden.fecha_registro BETWEEN '$fecha_ini' AND '$fecha_fin 23:59:59' AND  orden.id_sucursal = '$id_sucursal'
        ORDER BY orden.id DESC) A
        GROUP BY id";

        $data = $this->conexion->getQuery($sql);
        return $data;
    }

    function addBitacoraCorreo($id, $correo, $message) {
        $sql = "INSERT INTO correos_enviados(id_orden,correo,mensaje,usuario) "
                . "VALUES('" . $id . "','" . $correo . "','" . base64_encode($message) . "','" . $_SESSION["id"] . "')";
        $this->conexion->setQuery($sql);
    }

    function close() {

        $this->conexion->close();
    }

}

?>
