'use strict'

var express=require('express');
var DCMController=require('../controllers/dcm')

var router=express.Router();

router.get('/obtener-dcm/:nombre',DCMController.obtenerImagen);

module.exports=router;