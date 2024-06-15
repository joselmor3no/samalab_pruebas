'use strict'

var fs= require('fs');
var path=require('path')

var controller={

	obtenerImagen:function(req,res){
		var nombre=req.params.nombre.replace(/-/g,"/")
		var path_file="../uploads/discoDuro1/"+nombre
		//console.log(path_file);
		fs.exists(path_file,(exists) =>{
			if(exists){
				return res.sendFile(path.resolve(path_file))
			}
			else{
				return res.status(200).send({
					message: "no existe:"+path_file
				})
			}
		})
	}

};

module.exports= controller;