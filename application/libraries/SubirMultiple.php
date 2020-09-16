<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


class SubirMultiple {





function SubirArchivo($filename='',$ext='',$folder='',$file_delete=''){

	if (isset($_FILES[$filename])){
	  
		$ftmp = $_FILES[$filename]['tmp_name'];
		$oname = $_FILES[$filename]['name'];
		
		if(trim($ftmp)!='' && $this->validar_extension($oname,$ext) ){
		
			$extension=extension($oname);
			$newid = substr(uniqid(rand()),0,15);
			if(move_uploaded_file($ftmp, $folder.$newid.'.'.$extension))
			{
				if(!empty($file_delete))//eliminar el archivo anterior
				RemoveFile($folder,$file_delete);
				return $newid.'.'.$extension;
			}
		}
	}
  
}



function UploadMultipleArchivo($filename='',$ext='',$folder=''){

	$count_files = count($_FILES[$filename]['name']);

	for($i=0; $i<$count_files; $i++)
	{
		//Get the temp file path
		$tmpFilePath = $_FILES[$filename]['tmp_name'][$i];
		//Make sure we have a filepath
		if ($tmpFilePath != ""){

			//Setup our new file path
			//$newFilePath = "./uploadFiles/" . $_FILES['upload']['name'][$i];
			$oname = $_FILES[$filename]['name'][$i];
			if(trim($tmpFilePath)!='' && $this->validar_extension($oname,$ext) ){

				$extension=$this->extension($oname);
				$newid = substr(uniqid(rand()),0,15);
				//$newFilePath = $folder . $_FILES[$filename]['name'][$i];
				//Upload the file into the temp dir
				//if(move_uploaded_file($tmpFilePath, $newFilePath)) {
				if(move_uploaded_file($tmpFilePath, $folder.$newid.'.'.$extension)){
					//Handle other code here
					return $newid.'.'.$extension;
				}
			}
				
		}
		return null;
	}

}



function extension($filename){
$file = explode(".",$filename); return strtolower(end($file));
}


function validar_extension($file='',$extension='jpeg,jpg,png,gif,txt'){

	if(trim($file!='')){
		$extfile = extension($file);
		$extensiones = explode(",",$extension);
		if(in_array($extfile,$extensiones))
		return true;
		else
		return false;
	}
	return false;
	
}

//echo json_encode(array("123123","11111"));
//SubirArchivo("myfile","jpg,jpeg,gif,pdf,png","./");



//move_uploaded_file($_FILES["inputTypeFile"]["inputTypeFile"], $destination)
//echo json_encode(array('type'=>'warning', 'message'=>'<h3>Warning!</h3><p>Message here</p>'));





}


/* End of file SubirMultiple.php */
?>