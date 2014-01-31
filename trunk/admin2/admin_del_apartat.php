<?php  require_once('../Connections/alasdb.php');
require_once('../script/alex100.inc');if (!valida_admin()) echo '<meta http-equiv="refresh" content="0;URL=nolog.htm">';

/////// LIKE
if (isset($_SESSION["like"])) $like=$_SESSION["like"];
if (isset($_GET["like"])) $like=$_GET["like"];   
$_SESSION["like"]=$like;
///////////////
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = 'DELETE FROM apartats2013 WHERE apartat=\''.$fitxa.'\'';

  mysql_select_db($database_alas, $alas);
  $Result1 = mysql_query($updateSQL, $alas) or die(mysql_error());

  $updateGoTo = "admin_apartat.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_alas, $alas);
$query_Recordset1 = "SELECT * FROM apartats2013 WHERE apartat = '$fitxa'";
$Recordset1 = mysql_query($query_Recordset1, $alas) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body bgcolor="#CCCCFF" text="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
<div align="center"><font color="#FFFFFF"><strong>Eliminar FICHA</strong></font></div></td>
    <td width="41%" bgcolor="#000000"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="500" height="60">
        <param name="movie" value="../css/alas_sup.swf">
        <param name=quality value=high>
        <embed src="../css/alas_sup.swf" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="500" height="60"></embed> 
      </object></td>
  </tr>
</table>
<p align="center">- <a href="admin_apartat.php?like=<?php echo $like?>"><strong>Atr&aacute;s</strong></a> 
  -</p>
<p align="center"><font color="#FF0000"><strong>Esta operaci&oacute;n no se puede 
  deshacer. Para eliminar la ficha haga click en el bot&oacute;n abajo.</strong></font></p>
<p align="center">&nbsp;</p>

    
<form method="post" name="form1" action="<?php  echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline"> 
      <td align="right" nowrap bgcolor="#9999FF">Apartat:</td>
      <td bgcolor="#CCFFFF"><?php  echo $row_Recordset1['apartat']; ?></td>
    </tr>
    <tr valign="baseline"> 
      <td align="right" nowrap bgcolor="#9999FF">Descripcio:</td>
      <td bgcolor="#CCFFFF"><?php  echo $row_Recordset1['descripcio']; ?></td>
    </tr>
    <tr valign="baseline"> 
      <td align="right" nowrap bgcolor="#9999FF">T&iacute;tulo_cs:</td>
      <td bgcolor="#CCFFFF"><?php  echo $row_Recordset1['nom_cs']; ?></td>
    </tr>
    <tr valign="baseline"> 
      <td align="right" nowrap bgcolor="#9999FF">Profesor:</td>
      <td bgcolor="#CCFFFF"><?php  echo $row_Recordset1['profe']; ?></td>
    </tr>
    <tr valign="baseline"> 
      <td align="right" nowrap bgcolor="#9999FF">Texto:</td>
      <td bgcolor="#CCFFFF"><?php  echo $row_Recordset1['text_cs']; ?></td>
    </tr>
    <tr valign="baseline"> 
      <td align="right" nowrap bgcolor="#9999FF">Horario:</td>
      <td bgcolor="#CCFFFF"><?php  echo $row_Recordset1['text2_cs']; ?></td>
    </tr>
    <tr valign="baseline"> 
      <td align="right" nowrap bgcolor="#9999FF">Text3_cs:</td>
      <td bgcolor="#CCFFFF"><?php  echo $row_Recordset1['text3_cs']; ?></td>
    </tr>
    <tr valign="baseline"> 
      <td align="right" nowrap bgcolor="#9999FF">Text4_cs:</td>
      <td bgcolor="#CCFFFF"><?php  echo $row_Recordset1['text4_cs']; ?></td>
    </tr>
    <tr valign="baseline"> 
      <td align="right" nowrap bgcolor="#9999FF">&nbsp;</td>
      <td bgcolor="#CCFFFF">
<input type="submit" value="Eliminar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="apartat" value="<?php  echo $row_Recordset1['apartat']; ?>">
</form>
<p>&nbsp;</p>
  </body>
</html>
<?php 
mysql_free_result($Recordset1);
?>