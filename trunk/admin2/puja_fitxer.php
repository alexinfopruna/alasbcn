<?php 
require_once("../script/alex100.inc");

if (!isset($max_size)) $max_size=100000;
if (!isset($image_root)) $image_root='../imatges/';



if (isset($_FILES['userfile']['name']))
	{
		
		
		if (!get_cfg_var('file_uploads')) {
			die ("EROR al subir el fichero: El servidor");
		} 
		$tipo_archivo = $_FILES['userfile']['type']; 

		if (!((filtre_file($_FILES['userfile']['name'],$filtre))&&(tamano_archivo<$max_size)))
			die ('El formato o el tama�o no son correctos (tipo:'.$tipo_archivo.')<br><br><br><a align="center" href="puja_fitxer.php?filtre='.$filtre.'&image_root='.$image_root.'">Volver</a>');

		if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
			$destino = $image_root.$_FILES['userfile']['name'];
			if (move_uploaded_file ($_FILES['userfile']['tmp_name'],$destino)){
			
				//print "Archivo copiado en $destino<BR>";
			} 
			chmod($destino,0777);
			
		} else {?>
<div align="center" class="alerta">----------------&gt;&gt;&gt;&gt;ERROR AL SUBIR LA IMAGEN !!! &lt;&lt;&lt;&lt;--------------</div>
		<?php  }
 	}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
body,td,th {
	color: #000066;
}
body {
	background-color: #CCCCFF;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo1 {color: #FF0000}
.alerta {
width:100%;
padding:4px;
background-color:#FF0000;color: #FFFFFF}
.gal {padding:30px;margin:30px auto 30px auto;width:600px;background-color:#000033;
color:#FFFFFF}
-->
</style></head>

<body>  
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="19%" bgcolor="#000000"><font color="#990000"> 
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="186" height="54">
        <param name="movie" value="../css/logo_animat.swf">
        <param name=quality value=high>
        <embed src="../css/logo_animat.swf" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="186" height="54"></embed> 
      </object>
      </font></td>
    <td width="40%" valign="bottom" bgcolor="#000000">
<div align="center"><font color="#FFFFFF"><strong>Subir Fichero</strong></font></div></td>
    <td width="41%" bgcolor="#000000"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="500" height="60">
        <param name="movie" value="../css/alas_sup.swf">
        <param name=quality value=high>
        <embed src="../css/alas_sup.swf" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="500" height="60"></embed> 
      </object></td>
  </tr>
</table>
<br>&nbsp;&nbsp;&nbsp; <a href="admin_apartat.php">[&lt;&lt;Atr�s]</a>&nbsp;&nbsp;|&nbsp;&nbsp;[<a href="puja_fitxer.php?filtre=gif;jpg;jpeg&image_root=../galeria/">Galer�a</a>]&nbsp;&nbsp;|&nbsp;&nbsp;[<a href="puja_fitxer.php?filtre=gif;jpg;jpeg&image_root=../imatges/">Im�genes / Fondos</a>]&nbsp;&nbsp;
</a>
<form enctype="multipart/form-data" action="puja_fitxer.php?filtre=<?php  echo $filtre?>&image_root=<?php  echo $image_root?>" method="post"  >
  <p align="center" class="Estilo1">S&oacute;lo se admiten archivos <?php  echo $filtre ?> con 100Kb de tama&ntilde;o m&aacute;ximo. Para archivos grandes o, en caso de error, acceder con [<a href="ftp://ftp.alasbcn.com/html" target="_blank">Conexi�n FTP</a>]-&gt; user: alasbcn.com / pass: alas    </p>
  <p align="left">
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
  Archivo de imagen:
  <input name="userfile" type="file" size="60" >
</p>
  <p align="center">    <input type="submit" value="Copiar al servidor"> En caso de error acceder por [<a href="ftp://ftp.alasbcn.com/html" target="_blank">Conexi�n FTP</a>]-&gt; user: alasbcn.com / pass: alas  </p>
  
  <div class="gal">
    <p align="center"><strong>GALERIA</strong></p>
    <p>Las fotos de la galeria siempre deben ir en pareja foto / miniatura. (Hay que subir las dos!)<br>
    </p>
    <p>La miniatura debe tener m&aacute;x. 100 pixels en su lado largo </p>
    <p>El nombre debe ser <strong>IDENTICO</strong> a la foto a&ntilde;adiendo _small (ej. foto.jpg &gt;&gt; foto_small.jpg )<br>
    ATENCION: Id&eacute;ntico significa igual letra a letra, may&uacute;sc., min&uacute;sc., espacios... </p>
    <p>
	<p>Para borrar fotos de la galer&iacute;a acceder por FTP a la carpeta galeria y borrar foto y miniatura.</p>
	<br>
    [<a href="http://online-image-resize.kategorie.cz/" target="_blank">Herramienta para reducir im&aacute;genes</a>] (Poner resize to 100 pixels. Luego bot&oacute;n derecho-guardar como. Poner nombre como se ha explicado)</p>
    <p>
      [<a href="ftp://ftp.alasbcn.com/html" target="_blank">Conexi�n FTP</a>] -&gt; user: alasbcn.com / pass: alas <br>
      S&oacute;lo tocar las carpetas imatges o galeria!!.</p>
  </div>
  <p>&nbsp;</p>
</form>
<?php  
if ((isset($_FILES['userfile']['name']))&&(!(empty($_FILES['userfile']['name']))))
	{
?>
<div align="center">El archivo se ha copiado correctamente en <?php  echo  $destino;?></div>
<?php  		

			if (((strpos(strtolower($tipo_archivo), "gif") || strpos(strtolower($tipo_archivo), "jpeg")|| strpos(strtolower($tipo_archivo), "jpg")|| strpos(strtolower($tipo_archivo), "swf")) && ($tamano_archivo < $max_size))) 


			{?>
			<p align="center">&nbsp;</p>
	<?php  }?>
<?php  }?>
<p align="center">&nbsp;</p>

<?php  $files=scan_Dir($image_root,"gif;jpg;jpeg;swf");
	
	foreach ($files as $kay => $val)
	{
        echo "<div style='margin:25px;float:left'>$val<br/><a href='$image_root$val' target='_blank'><img src='$image_root$val' width='150'/ style='margin:25px;float:left'></a> </div>";
        
    }
?>
</body>
</html>