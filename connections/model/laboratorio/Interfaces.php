<?php
require_once( $_SERVER["DOCUMENT_ROOT"] . '/model/Conexion.php');

class Interfaces {

	public function getArchivoSucursal($codigo_sucursal){
		$directorio=opendir($_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$codigo_sucursal."/");
		//recoger los  datos
		while ($archivo = readdir($directorio)) { 
		  if(($archivo != '.')&&($archivo != '..')){
		     if(strpos($archivo,$codigo_sucursal)>0){
		     	return 1;
		     }
		  } 
		}
		closedir($directorio);
		return 0;
	}

	public function getResultadoInterfaz($ruta,$id_estudio,$interfaz_letra,$codigo_orden,$codigo_estudio){
		$xx="";
		
		if($id_estudio==1){
			$nombreArchivo=$ruta."/interfaz_bh_".$ruta.".txt";
			if(file_exists($_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo)){
				$file = fopen($_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo, "r");

				if($ruta=='ime'){
					while($linea = fgets($file)) {
                           
							if($pos=strpos($linea,$codigo_orden."^^")){
									$linea_encontrada=$pos;
									$subLinea=substr($linea, $pos, 1500);
									//echo $subLinea."<br>";
							}
							elseif($pos=strpos($linea,"OBR|1||".$codigo_orden."|")){
							    $linea_encontrada=$pos;
									$subLinea=substr($linea, $pos, 1500);
							}
							
							if($pos=strpos($subLinea,$interfaz_letra) && $linea_encontrada>0){
							    //echo $interfaz_letra;
									$pos=strpos($subLinea,$interfaz_letra);
									$subString=substr($subLinea, $pos, 20); 
									$infoLInea=explode("||", $subString);
									//echo $subString."<br>";
									$xx=$infoLInea[1];
							}
							if(strpos($subLinea,"|1|N")>0){
									$linea_encontrada=0;
							}
						}
				}
				elseif($ruta=='biosalud' ){
					while($linea = fgets($file)) {
						if($pos=strpos($linea,$codigo_orden."")){
								$linea_encontrada=$pos;
								$subLinea=substr($linea, $pos, 1500);
								//echo $subLinea."<br>";
						}
						if($pos=strpos($subLinea,$interfaz_letra) && $linea_encontrada>0){
								$pos=strpos($subLinea,$interfaz_letra);
								$subString=substr($subLinea, $pos, 20); 
								$infoLInea=explode("|", $subString);
								$xx=$infoLInea[1];
						}
					}
				}
				else if( ($ruta=='vilar' && $_SESSION["id_sucursal"]==133) || $ruta=='central' || $ruta=='adn' ){

					$linea_encontrada=0;
		            while($linea = fgets($file)) {
		            	$pos=strpos($linea,$codigo_orden);
		            	
						if($pos!==false){
							$linea_encontrada=1;
							$subLinea=substr($linea, $pos, 50);
							if($pos>=0 && $linea_encontrada>0){
								
								$pos2=strpos($subLinea,$interfaz_letra."|");
								if($pos2!==false){
									$subString=substr($subLinea, $pos2, 20); 
									$infoLInea=explode("|", $subString);
									$xx=floatval($infoLInea[1]);
								}
								
							}
						}
						if(strpos($subLinea,"|1|N")>0){
								$linea_encontrada=0;
						}
					}
				}

				else if( $ruta=='vilar' && $_SESSION["id_sucursal"]>133){
					$sucursal=1;
					switch ($_SESSION["id_sucursal"]) {
						case 139:
							$sucursal=2;
							break;
						case 140:
							$sucursal=3;
							break;
						case 141:
							$sucursal=4;
							break;
						case 142:
							$sucursal=5;
							break;
						case 143:
							$sucursal=6;
							break;
						case 144:
							$sucursal=7;
							break;
						default:
							$sucursal=1;
							break;
					}
					$linea_encontrada=0;
					$xx=11;
		            while($linea = fgets($file)) {
		            	$pos=strpos($linea,$codigo_orden."-".$sucursal);
		            	
						if($pos!==false){
							$linea_encontrada=1;
							$subLinea=substr($linea, $pos, 50);
							if($pos>=0 && $linea_encontrada>0){
								
								$pos2=strpos($subLinea,$interfaz_letra."|");
								if($pos2!==false){
									$subString=substr($subLinea, $pos2, 20); 
									$infoLInea=explode("|", $subString);
									$xx=floatval($infoLInea[1]);
								}
								
							}
						}
						if(strpos($subLinea,"|1|N")>0){
								$linea_encontrada=0;
						}
					}
				}
				else{
					//Output a line of the file until the end is reached
					$xx=12;
				}
	            
			}
		}


		$xx=10;
		return $xx;

		if($id_estudio==354 || $id_estudio==344 || $id_estudio==361 || $id_estudio==887 || $id_estudio==982 || $id_estudio==2637 || $id_estudio==300 || $id_estudio==92 || $id_estudio==369|| $id_estudio==395 || $id_estudio==324 || $id_estudio==68 || $id_estudio==315 || $id_estudio==394 || $id_estudio==2196 || $id_estudio==2618 || $id_estudio==1622 || $id_estudio==320 || $id_estudio==321 || $id_estudio==2199 || $id_estudio==2677 || $id_estudio==332 || $id_estudio==316 || $id_estudio==879 || $id_estudio==298 || $id_estudio==91 || $id_estudio==1355 || $id_estudio==94 || $id_estudio==78 || $id_estudio==367 || $id_estudio==349 || $id_estudio==93 || $id_estudio==332|| $id_estudio==342 || $id_estudio==984|| $id_estudio==88|| $id_estudio==1516 || $id_estudio==411|| $id_estudio==75|| $id_estudio==406 || $id_estudio==927){
			//cacho
			$nombreArchivo=$ruta."/interfaz_qca_".$ruta.".txt";

			if($ruta=="cervantes"){
				if(file_exists ( $_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo)){
					$file = fopen($_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo, "r") or exit("Unable to open file!");
		                $linea_encontrada=0;
                    while($linea = fgets($file)) {
                        $arregloMayor=explode("R,",$linea);

                        for($j=0;$j<count($arregloMayor);$j++){
                            $posicion=strpos($arregloMayor[$j],"NORMAL");
                           
                            if($posicion!==-1){
                                $subLinea=substr($arregloMayor[$j], $posicion, 800);
                                $subLinea=str_replace(" ","",$subLinea);
                               
                                $arreglo=explode(",",$subLinea);
                                
                                if(strpos($subLinea,$codigo_orden)>-1){
                               
                                    for($i=0;$i<count($arreglo);$i++){
                                        if($arreglo[$i]==$interfaz_letra){
                                           // echo $arreglo[$i+2]."<br>";
                                            $xx=$arreglo[$i+2];    
                                        }
                                    }
              
                                }
                            }
                        }
                        
                    }
		        }
			}
			else if($ruta=="vidasana"){
				if(file_exists ( $_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo)){
					$file = fopen($_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo, "r") or exit("Unable to open file!");
					while($linea = fgets($file)) {
						$posicion=strpos($linea,'|'.$codigo_orden.'|');
						$xx=1;
					}
				}
			}
			else if($ruta=="vilar" || $ruta=='adn'){
				if(file_exists ( $_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo)){
					$file = fopen($_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo, "r") or exit("Unable to open file!");
					while($linea = fgets($file)) {
						$posicion=strpos($linea,'|'.$codigo_orden.'|');
						if($posicion>-1){
							$subLinea=substr($linea, $posicion-20, 100);
							$posicion2=strpos($subLinea,'O');
							$subLinea2=substr($subLinea, $posicion2,20);
							$array1=explode("|", $subLinea2);
	

							$posicionInicial=strpos($linea,'O|'.$array1[1]);
							$posicionFinal=strpos($linea,'L|'.$array1[1]);

							$sublinea=substr($linea, $posicionInicial, $posicionFinal-$posicionInicial);
							$arreglo=explode("R|",$sublinea);
							for($i=1;$i<count($arreglo);$i++){
								$arreglo[$i]=str_replace(" ","",$arreglo[$i]);
								$pos=strpos($arreglo[$i],"^".$interfaz_letra."^");
								if($pos>0){
									$arreglo[$i]=str_replace("^","",$arreglo[$i]);
									$arreglo2=explode("|",$arreglo[$i]);
									$xx=$arreglo2[2];
								}
							}
						}
					}
				}
			}
			else{
				if(file_exists ( $_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo)){
					$file = fopen($_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo, "r") or exit("Unable to open file!");
		                //Output a line of the file until the end is reached
		                while(!feof($file))
		                {
		                    $res__=fgets($file);
		                    $fila=str_replace("||","|",$res__);
		                    $filas=explode("|",$fila);
		           
		                    if($filas[0]==$codigo_orden && $codigo_estudio==$filas[3])
		                        $xx=$filas[2];
		                }
		        }
			}
			
	        //udi
	        $nombreArchivo="/interfaz_qca_".$ruta.".csv";
	        if(file_exists ( $_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo)){
				if (($gestor = fopen($_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo, "r")) !== FALSE) {
                    while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                        $numero = count($datos);

                        $fila++;

                        if($codigo_orden==$datos[2]){
                            for($j=3;$j<$numero;$j++){
                                if($datos[$j]==$interfaz_letra){
                                    $xx=$datos[$j+1];
                                }
                            }
                            //echo $datos[2];
                        }
                    }
                    fclose($gestor);
                }
	        }

	        //anur
	        $nombreArchivo=$ruta."/interfaz_qca_".$ruta.".csv";
	        if(file_exists ( $_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo)){
				if (($gestor = fopen($_SERVER["DOCUMENT_ROOT"] . '/interfaces/'.$nombreArchivo, "r")) !== FALSE) {
                    while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                        $numero = count($datos);

                        $fila++;

                        if($codigo_orden==$datos[2]){
                            for($j=3;$j<$numero;$j++){
                                if($interfaz_letra!=null && $datos[$j]==$interfaz_letra){
                                    $xx=$datos[$j+1];
                                }
                            }
                            //echo $datos[2];
                        }
                    }
                    fclose($gestor);
                }
	        }
	    }

		return $xx;
	}
}