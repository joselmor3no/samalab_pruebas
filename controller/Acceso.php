<?php

require_once('../model/Usuarios.php');

class Acceso {

    function __construct() {

        $opc = $_REQUEST["opc"];
        if ($opc == 'login') {
            $this->login();
        } else if ($opc == 'logout') {
            $this->logout();
        } else if ($opc == 'session') {
            $this->session();
        }
    }

    function login() {

        //Falta hacer todas las validaciones de acceso
        $user = $_REQUEST["user"];
        $pass = $_REQUEST["pass"];

        $usuario = new Usuarios();
        $datos = $usuario->getUsuario($user, $pass);

        if (count($datos) > 0) {
            session_start();
            $id_sesion_activa = session_id();
            $_SESSION["sesion_activa"] = $id_sesion_activa;
            $usuario->setSesionActiva($id_sesion_activa, $datos[0]->id);

            //Ultima petición
            $_SESSION["ultimo_acceso"] = date("Y-m-d G:i:s");

            $_SESSION["id"] = $datos[0]->id;
            $_SESSION["id_sucursal"] = $datos[0]->id_sucursal;
            $_SESSION["id_cliente"] = $datos[0]->id_cliente;
            $_SESSION["usuario"] = $datos[0]->usuario;
            $_SESSION["password"] = $datos[0]->contraseña;
            $_SESSION["permisos"] = $usuario->getPermisos($datos[0]->id);

            header("Location: /inicio");
        } else {
            header("Location: /?error=1");
        }

        $usuario->close();
    }

    function logout() {
        session_start();

        $usuario = new Usuarios();
        $id_sesion_activa = session_id();
        $usuario->setSesionInactiva($id_sesion_activa);

        session_destroy();
        header("Location: /");
    }

    function session() {

        session_start();

        $ultimo_acceso = $_SESSION["ultimo_acceso"];

        $now = date("Y-m-d G:i:s");
        $tiempo = strtotime($now) - strtotime($ultimo_acceso);
        $limite = 45 * 60; //45 min 
        if ($tiempo <= $limite && $_SESSION["id"] != "") {

            $data["stop"] = false;
        } else {
            $data["stop"] = true;
        }

        $data["tiempo"] = $tiempo;

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

}

new Acceso();

