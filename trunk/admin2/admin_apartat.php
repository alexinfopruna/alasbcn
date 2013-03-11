<?php 
require_once('../Connections/alasdb.php');
// COMPROVA SESSIO OBERTA
//session_start();
require_once('../script/alex100.inc');if (!valida_admin()) {
echo '<meta http-equiv="refresh" content="0;URL=nolog.htm">';
exit();
}if ($_GET["x"]==-1) {
$_SESSION["pass"]=null;
session_unregister('admin');
session_unregister('pass');
session_destroy();
echo '<meta http-equiv="refresh" content="0;URL=login.htm">';
exit();
}
$like="";
/////// LIKE
if (isset($_SESSION["like"])) $like=$_SESSION["like"];
if (isset($_GET["like"])) $like=$_GET["like"];   
$_SESSION["like"]=$like;
///////////////

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 50;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_alas, $alas);
$query_Recordset1 = "SELECT apartat, descripcio, nom_cs, profe, text_cs FROM apartats2013 WHERE apartat LIKE '$like%' ORDER BY apartat";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $alas) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . implode("&", $newParams);
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
  ?>





<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#CCCCFF" link="#0033CC" vlink="#0033CC" alink="#0033CC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
<div align="center"><font color="#FFFFFF"><strong>Administraci&oacute;n 
        de FICHAS</strong></font></div></td>
    <td width="41%" bgcolor="#000000"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="500" height="60">
        <param name="movie" value="../css/alas_sup.swf">
        <param name=quality value=high>
        <embed src="../css/alas_sup.swf" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="500" height="60"></embed> 
      </object></td>
  </tr>
</table>


<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><p align="center"><font size="2">+<a href="admin_insert_apartat.php?like=<?echo $like?>"><strong> A&ntilde;adir nueva 
  fitxa </strong></a>+ </font></p></td>
   <td><div align="center"><a href="admin_apartat.php?like="><strong><font size="2">TODO</font></strong></a></div></td>
    <td><div align="center"><a href="admin_apartat.php?like=F0"><strong><font size="2">FICHAS</font></strong></a></div></td>
    <td><div align="center"><a href="admin_apartat.php?like=F99"><strong><font size="2">PROFESORES</font></strong></a></div></td>
    <td><div align="center"><a href="admin_apartat.php?like=F98"><strong><font size="2">CREACIONES</font></strong></a></div></td>
   <td><div align="center"><a href="admin_apartat.php?like=L"><strong><font size="2">LINKS</font></strong></a></div></td>
    <td><div align="center"><font size="2"><a href="puja_fitxer.php?filtre=gif;jpg;jpeg"><strong>Subir imagen </strong></a></font></div></td>
 <!--   <td><div align="center"><font size="2"><a href="puja_fitxer.php?=img_root=../plantilles&filtre=htm;html;lbi;php"><strong>Subir Plantilla </strong></a></font></div></td> --!>
    <td><div align="center"><font size="2"><a href="../admenu.php"><strong>Editar MENUS</strong></a></font></div></td>
    <td><div align="center"><font size="2"><a href="admin_apartat.php?x=-1"><strong>Cerrar sesi&oacute;n</strong></a></font></div></td>
  </tr>
</table>
<br>
<table width="100%" border="1" align="center">
  <tr bgcolor="#9999FF"> 
    <td width="115"> <div align="center"><strong><font color="#000099">apartat</font></strong></div></td>
    <td width="133"> <div align="center"><strong><font color="#000099">descripcio</font></strong></div></td>
    <td width="120"> <div align="center"><strong><font color="#000099">nom</font></strong></div></td>
    <td width="106"> <div align="center"><strong><font color="#000099">profe</font></strong></div></td>
    <td width="116"> <div align="center"><strong><font color="#000099">text</font></strong></div></td>
  </tr>
  <?php do { ?>
  <tr bgcolor="#CCFFFF"> 
    <td><font color="#000066" size="2"><a href="admin_modificar_apartat.php?fitxa=<?php echo $row_Recordset1['apartat'] ?>&like=<? echo $like ?>"><?php echo $row_Recordset1['apartat']; ?></a></font></td>
    <td><font color="#000066" size="2"><?php echo $row_Recordset1['descripcio']; ?></font></td>
    <td><font color="#000066" size="2"><?php echo $row_Recordset1['nom_cs']; ?></font></td>
    <td><font color="#000066" size="2"><?php echo substr($row_Recordset1['profe'],0,12); ?></font></td>
    <td><font color="#000066" size="2"><?php echo substr($row_Recordset1['text_cs'],0,50); ?></font></td>
        <td width="108"> <font color="#000066" size="2"><a href="admin_modificar_apartat.php?fitxa=<?php echo $row_Recordset1['apartat'] ?>&like=<? echo $like ?>">Modificar</a> 
      | <a href="admin_del_apartat.php?fitxa=<?php echo $row_Recordset1['apartat'] ?>&like=<? echo $like ?>"> 
      Eliminar</a> </font></td>
  </tr>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<p> 
<table border="0" width="150" align="center">
  <tr> 
    <td width="50" align="center"> <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
      <a href="<?php printf("%25s?pageNum_Recordset1=%25d%25s", $currentPage, 0, $queryString_Recordset1); ?>">Primero</a> 
      <?php } // Show if not first page ?> </td>
    <td width="50" align="center"> <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
      <a href="<?php printf("%25s?pageNum_Recordset1=%25d%25s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Anterior</a> 
      <?php } // Show if not first page ?> </td>
    <td width="50" align="center"> <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
      <a href="<?php printf("%25s?pageNum_Recordset1=%25d%25s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Siguiente</a> 
      <?php } // Show if not last page ?> </td>
    <td width="50" align="center"> <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
      <a href="<?php printf("%25s?pageNum_Recordset1=%25d%25s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">&Uacute;ltimo</a> 
      <?php } // Show if not last page ?> </td>
  </tr>
</table></p>
<p align="center">&nbsp; <font color="#FF6600" size="1">R<font size="2">egistros 
  <?php echo ($startRow_Recordset1 + 1) ?> a <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> de <?php echo $totalRows_Recordset1 ?></font></font> </p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>