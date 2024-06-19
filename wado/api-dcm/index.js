'use strict'

var http = require("http");

// Importar la aplicación de Express
var app = require('./app');

var port = 3700;

// Crear un servidor HTTP
http.createServer(app).listen(port, '0.0.0.0', () => {
    console.log(`Servidor corriendo en el puerto ${port}`);
});