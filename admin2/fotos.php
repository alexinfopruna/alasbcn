<?php 
require_once('../script/alex100.inc');
if (!isset($dir)) $dir='../imatges/';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	background-color: #CCCCFF;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
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
      <div align="center"><font color="#FFFFFF"><strong>Im&aacute;genes guardadas en el Servidor </strong></font></div></td>
    <td width="41%" bgcolor="#000000"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="500" height="60">
        <param name="movie" value="../css/alas_sup.swf">
        <param name=quality value=high>
        <embed src="../css/alas_sup.swf" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="500" height="60"></embed>
    </object></td>
  </tr>
</table>
<p align="center">&nbsp;</p>
<blockquote>
  <blockquote>
    <p align="left">  
      <?php $fotos=scan_Dir($dir);

foreach($fotos as $k => $v)
{
echo'<img src="'.$dir.$v.'" width="160" >';
//mostra_imatge('../imatges/'.$v,100); 
echo '--> '.$v.'<br>';

}?>
          
</p>
  </blockquote>
</blockquote>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
