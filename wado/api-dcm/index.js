'use strict'
var fs=require("fs");
var https=require("https")
//servidor

var app=require('./app');
var port=3700;

https.createServer({
    key: fs.readFileSync("d9fb7_3a9a1_f02b79959be403016c1040af7fa0fa88.key"),
    cert: fs.readFileSync("connectionslab_net_d9fb7_3a9a1_1721001599_b4b98c2fb9a898c456a81c526520a414.crt")
}, app).listen(port,'connectionslab.net',() =>{
	console.log('servidor corriendo en 3700')
})