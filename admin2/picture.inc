<?php
function upload($nombre,$directorio,$midax=NULL,$miday=NULL){
        $ruta_fichero = "$_SERVER[DOCUMENT_ROOT]/$directorio/";
        if (!is_dir("$ruta_fichero")) mkdir("$ruta_fichero",0777);
        $ruta_relativa ="$directorio/";
        $name=$_FILES[$nombre]['name'];   
        $arxiu=$_FILES[$nombre];
 
        $name = ereg_replace("[^a-z0-9._]", "",str_replace(" ", "_", str_replace("%20", "_", strtolower($name))));
        $location = $ruta_fichero.$name;
		//echo $_FILES[$nombre]['tmp_name']."___".$location;
        if (copy($_FILES[$nombre]['tmp_name'],$location)){
            unlink($_FILES[$nombre]['tmp_name']);
        }
 
        //if ((isset($midax))||(isset($midax)))
        //$erep=error_reporting(0)   ;
        //set_error_handler("ha_petat");
            // $pic=new picture($ruta_fichero,$name,$midax,$miday);        
        //echo "........".$directorio.$name;
           
        //restore_error_handler();    
        //error_reporting($erep);
            //$fichero = $ruta_relativa.$name;
          $fichero = $name;
	
	if (!isset($fichero)||(empty($fichero)))	{
		$fichero=$_POST[$nombre];
	}
   return($fichero);   
}




/////////////////////////////////////////////////////////////////////////////////////////

class picture
{
       var $save_dir;                    //where file will be saved
       var $filename="spacer.gif";        //default file name initially 
       var $error_message="";            //string to be output if neccesary
       var $width;                        //height of final image
       var $height;                      //width of final image

       function picture($save_directory, $fitxer, $max_width=NULL, $max_height=NULL)
       {
               $this->save_dir = $save_directory;                
               $this->width =    $max_width;
               $this->height =  $max_height;

               //--change filename to time - make it unique
               $file_array['tmp_name']=$save_directory.$fitxer;
               $file_array['name']=$fitxer;


               $temp_filename =$file_array['name'];
               $nom = $temp_filename;
               $ext = explode('.',$temp_filename);
               $ext = $ext[count($ext)-1];
               $temp_filename = time().".".$ext;

               
               //--check that it's a jpeg or gif
               if (preg_match('/^(gif|jpe?g)$/',$ext)) { 
                       // resize in proportion
                       list($width_orig, $height_orig) = getimagesize($file_array['tmp_name']);//getimagesize($file_array['tmp_name']);
                       if  (!isset($max_width))$this->width=$max_width=  $width_orig;
                       if  (!isset($max_height)) $this->height=$max_height= $height_orig;
                       
                       if ($this->width && ($width_orig < $height_orig)) {
                               $this->width = ($this->height / $height_orig) * $width_orig;
                       } else {
                               $this->height = ($this->width / $width_orig) * $height_orig;
                       }
                       $image_p = imagecreatetruecolor($this->width, $this->height) ;     
                      // $image_p =           imagecreate ($this->width, $this->height);
                       //handle gifs and jpegs separately
                       if($ext=='gif'){
                           $image = imagecreatefromgif($file_array['tmp_name']);                            
                           imagecopyresampled($image_p, $image, 0, 0, 0, 0, $this->width, $this->height, $width_orig, $height_orig);
                           imagegif($image_p, $this->save_dir.$nom, 80);
                       }
                       else
                       {      
                           echo "<br><br>S'està intentant reduïr la imatge. Si aquest procès falla la imatge estarà disponible a la mida original.<br>És recomanable reduïr-la manualment<br>Si el procés no acaba en 30 segons prem enrera<br><br>";
                             $image = imagecreatefromjpeg($file_array['tmp_name']) or die("<br><br>No és possible reduïr la imatge!!!<br><br>");      
                               echo "<br><br>La imatge s'ha reduït correctament.<br><br>";

                           if ($image){                    
                               imagecopyresampled($image_p, $image, 0, 0, 0, 0, $this->width, $this->height, $width_orig, $height_orig);                            
                               //imagecopyresized($thumb,$img,0,0,0,0,$this->width, $this->height, $width_orig, $height_orig);   
                                imagejpeg($image_p, $this->save_dir.$nom, 80); 
                           }  
                           else
                           {
                                echo "<br><br>No és possible reduïr la imatge!!!<br><br>";
                           }
                       }
                       //echo $this->save_dir.$nom;
                       imagedestroy($image_p);
                       imagedestroy($image);

                       $this->filename=$temp_filename;

               }else{
                       $this->error_message.="<br> file is not a jpeg or gif picture <br>";
               }
       }
}
?>