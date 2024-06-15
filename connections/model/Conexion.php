<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Conexion {

    private $servername = "localhost";
    //mj
    /* private $username = "mjdevelo_connections";
      private $password = "conection$2021**";
      private $databases = "mjdevelo_connections"; */
    private $username = 'admin_connection';
    private $password = 'connection$LAB21';
    private $databases = "admin_connections";
    private $conn;

    // $private $db_produccion ;

    function __construct() {

        //Ultima petición
        $_SESSION["ultimo_acceso"] = date("Y-m-d G:i:s"); //Ultima petición
        //Cambio de conexion por cliente
        if ($_SESSION["user_db"] != "") {
            $this->username = $_SESSION["user_db"];
            $this->databases = $_SESSION["db"];
        }
        //echo "=================================================" . $this->username."<br>";
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->databases);

        //Cambiar a db del dominio
        $this->changeDB();

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        if (!$this->conn->set_charset("utf8")) {
            printf("Can't set utf8: %s\n", $this->conn->error);
        }
    }


    function getQuery($sql) {
        $data = [];

        if ($result = $this->conn->query($sql)) {
            while ($row = $result->fetch_object()) {
                $data[] = $row;
            }
            $result->close();
        } else {
            echo "Consulta fallida * $sql *: " . $this->conn->error;
        }
        return $data;
    }

    function setQuery($sql) {

        if ($this->conn->query($sql)) {
            
        } else {
            echo "Consulta fallida * $sql *: " . $this->conn->error;
        }
    }

    function changeDB() {
        session_start();

        $server = str_replace("www.", "", $_SERVER['SERVER_NAME']);

        if ($_SESSION["db"] == "") {

            $sql = "SELECT * FROM clientes
                    WHERE dominio = '" . $server . "'";

            $data = $this->getQuery($sql);
            $this->conn->select_db($data[0]->db);

            $_SESSION["user_db"] = $data[0]->user_db;
            $_SESSION["db"] = $data[0]->db;
            $_SESSION["ruta"] = $data[0]->ruta;
            $_SESSION["cliente"] = $data[0];
            $_SESSION["server"] = $server;
        } else {
            $this->conn->select_db($_SESSION["db"]);
        }
    }

    function close() {
        $this->conn->close();
    }

}

?>
