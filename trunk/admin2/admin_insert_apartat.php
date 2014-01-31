<?php  
include_once("fckeditor/fckeditor.php") ;


require_once('../Connections/alasdb.php'); 
require_once('../script/alex100.inc');if (!valida_admin()) echo '<meta http-equiv="refresh" content="0;URL=nolog.htm">';

$like="F99";
/////// LIKE
if (isset($_SESSION["like"])) $like=$_SESSION["like"];
if (isset($_GET["like"])) $like=$_GET["like"];   
$_SESSION["like"]=$like;
///////////////
$camps=camps($like);



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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO apartats2013 (apartat, descripcio, plantilla, nom_cs, nom_ct, 
  profe, profe2,profe3,
  text_cs, text_ct, text2_cs, text2_ct, text3_cs, text3_ct, text4_cs, text4_ct, subtitol_cs,subtitol_ct,
  img_fons, img, img2, img3, img4, 
  linkprofe, link, link2, link3, link4, 
  color, calendario, publicado, data, text_calendari_cs,text_calendari_ct,n_fitxes) 
  VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s,%s,%s,%s,%s,%s,%s,%s)",
                       GetSQLValueString($_POST['apartat'], "text"),
                       GetSQLValueString($_POST['descripcio'], "text"),
                       GetSQLValueString($_POST['plantilla'], "text"),
                       GetSQLValueString($_POST['nom_cs'], "text"),
                       GetSQLValueString($_POST['nom_ct'], "text"),
                       GetSQLValueString($_POST['profe'], "text"),
                       GetSQLValueString($_POST['profe2'], "text"),
                       GetSQLValueString($_POST['profe3'], "text"),
                       GetSQLValueString($_POST['text_cs'], "text"),
                       GetSQLValueString($_POST['text_ct'], "text"),
                       GetSQLValueString($_POST['text2_cs'], "text"),
                       GetSQLValueString($_POST['text2_ct'], "text"),
                       GetSQLValueString($_POST['text3_cs'], "text"),
                       GetSQLValueString($_POST['text3_ct'], "text"),
                       GetSQLValueString($_POST['text4_cs'], "text"),
                       GetSQLValueString($_POST['text4_ct'], "text"),
                       GetSQLValueString($_POST['subtitol_cs'], "text"),
                       GetSQLValueString($_POST['subtitol_ct'], "text"),
                       GetSQLValueString($_POST['img_fons'], "text"),
                       GetSQLValueString($_POST['img'], "text"),
                       GetSQLValueString($_POST['img2'], "text"),
                       GetSQLValueString($_POST['img3'], "text"),
                       GetSQLValueString($_POST['img4'], "text"),
                       GetSQLValueString($_POST['linkprofe'], "text"),
                       GetSQLValueString($_POST['link'], "text"),
                       GetSQLValueString($_POST['link2'], "text"),
                       GetSQLValueString($_POST['link3'], "text"),
                       GetSQLValueString($_POST['link4'], "text"),
                       GetSQLValueString($_POST['color'], "text"),
                       GetSQLValueString($_POST['calendario']=='calendario'?1:0, "int"),
                       GetSQLValueString($_POST['publicado']=='publicado'?1:0, "int"),
                       GetSQLValueString($_POST['data'], "text"),
                       GetSQLValueString($_POST['text_calendari_cs'], "text"),
                       GetSQLValueString($_POST['text_calendari_ct'], "text"),
                       GetSQLValueString($_POST['n_fitxes'], "int"));


					   mysql_select_db($database_alas, $alas);
  $Result1 = mysql_query($insertSQL, $alas) or die(mysql_error());

  $insertGoTo = "admin_apartat.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
$row_Recordset1['apartat']=autunum($like);

switch ($like)
{
    case 'F99':
        $row_Recordset1["descripcio"]="PROFE";
    break;

    case 'F98':
        $row_Recordset1["descripcio"]="CREACIONES";
    break;

    case 'xxxxxxx':
        //$row_Recordset1["descripcio"]="LINK";
    break;

    case 'F0':
        $row_Recordset1["descripcio"]="FITXA";
        //$row_Recordset1['plantilla']="alas08.lbi";
    break;
    
}




function autunum($like)
{
    global $database_alas, $alas;
    
    mysql_select_db($database_alas, $alas);
    $query_Recordset1 = "SELECT * FROM apartats2013 WHERE apartat LIKE '$like%' AND apartat<>'F9999' ORDER BY apartat DESC";
    $Recordset1 = mysql_query($query_Recordset1, $alas) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysql_num_rows($Recordset1);
    
     $tipus=substr($row_Recordset1['apartat'],0,1);
     $ultim=substr($row_Recordset1['apartat'],1,6)+1000001;
     $ultim=substr($ultim,3,4);
     $ultim=$tipus.$ultim;
    
    mysql_free_result($Recordset1);
    return $ultim;
}

?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> 
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-ca.js"></script>
<script>
  $(function(){
    
 $.datepicker.setDefaults( $.extend({'dateFormat':'yy-mm-dd'}),$.datepicker.regional[ "ca" ] );   
    $( ".datepicker" ).datepicker({ });
    
     $("[name=calendario]").click(mostraData);
      mostraData();
  });
  
function mostraData(){

    if ($("[name=calendario]").is(":checked"))      $(".data-toggle").show("fast");
    else   $(".data-toggle").hide("fast");
    }  
  
</script>


<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/themes/base/jquery-ui.css" type="text/css" media="all" />
<style type="text/css">
<!--
.gal {padding:30px;margin:30px auto 30px auto;width:600px;background-color:#000033;
color:#FFFFFF}
.Estilo1 {font-size: x-small}


-->
</style>
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
<div align="center"><font color="#990000"><a name="inicio"></a></font><font color="#FFFFFF"><strong>Modificar FICHA</strong></font></div></td>
    <td width="41%" bgcolor="#000000"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="500" height="60">
        <param name="movie" value="../css/alas_sup.swf">
        <param name=quality value=high>
        <embed src="../css/alas_sup.swf" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="500" height="60"></embed> 
      </object></td>
  </tr>
</table>
<?php 
$torna="admin_apartat.php?like=$like";
if (isset($_GET["mnu"])) $torna="../admenu.php?fitxa=".$_GET["mnu"];
?>

<p align="center">[<a href="<?php echo $torna?>"><strong>&lt;&lt;atr&aacute;s</strong></a>]  | [<a href="admin_apartat.php?like=<?php  echo $like?>">llistat</a>] | [<a href="#texto">textos</a>] | [<a href="#imagenes">im&aacute;genes</a>] |   [<a href="#link">link</a>] | [<a href="#info">info</a>] </p>
<p align="center"><font color="#990000">Se deben subir las im&aacute;genes y plantillas en la pantalla anterior</font></p>

    
<form method="post" name="form1" action="<?php  echo $editFormAction; ?>">
  <table>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF">&nbsp;</td>
      <td colspan="2"><input name="submit" type="submit" value="Actualizar registro"></td>
    </tr>
<?php  
$n=0;
 if ($camps[0]['visible']){?>
    <tr valign="baseline">
      <td width="105" align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"><?php  //echo $row_Recordset1['apartat']; ?>
      <input type="text" name="apartat" value="<?php  echo $row_Recordset1['apartat']; ?>" size="32"></td>
      </td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
        <input type="text" name="descripcio" value="<?php  echo $row_Recordset1['descripcio']; ?>" size="32"></td>
    </tr>
<?php  
}else{?>
            <input type="hidden" name="descripcio" value="<?php  echo $row_Recordset1['descripcio']; ?>" size="32">

<?php }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td><select name="plantilla" >
        <option value=""></option>
        <?php  $files=scan_Dir('../plantilles/',"html;htm;lbi");
	
	foreach ($files as $kay => $val)
	{
        $diana=strcmp($row_Recordset1['plantilla'], $val) ?>
        <option value="<?php  echo $val?>"  <?php  if (!($diana)) {echo " SELECTED";}?>><?php  echo $val?></option>
        <?php  }?>
      </select></td>
      <td>&nbsp;</td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?></td> 
      <td colspan="2"> 
        <input type="text" name="nom_cs" value="<?php  echo $row_Recordset1['nom_cs']; ?>" size="32"></td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
        <input type="text" name="nom_ct" value="<?php  echo $row_Recordset1['nom_ct']; ?>" size="32"></td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
        
        
        <select name="profe" >
          <option value=""></option>     
      <?php mysql_select_db($database_alas, $alas);
    $query = "SELECT * FROM apartats2013 WHERE apartat LIKE 'F99%' AND apartat<>'F9999' AND nom_cs<>'' ORDER BY nom_cs";
    $rs = mysql_query($query, $alas) or die(mysql_error());      
      
     while ($profe = mysql_fetch_assoc($rs))
	{   
        $diana=strcmp($row_Recordset1['apartat'], $profe['apartat']) ?>
          <option value="<?php  echo $profe['apartat']?>"  <?php  if (!($diana)) {echo " SELECTED";}?>><?php  echo $profe['nom_cs']?></option>
          <?php  }?>
       </select>
        </td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?></td>
      <td colspan="2">
      
        <select name="profe2" >
          <option value=""></option>     
      <?php mysql_select_db($database_alas, $alas);
    $query = "SELECT * FROM apartats2013 WHERE apartat LIKE 'F99%' AND apartat<>'F9999' AND nom_cs<>'' ORDER BY nom_cs";
    $rs = mysql_query($query, $alas) or die(mysql_error());      
      
     while ($profe = mysql_fetch_assoc($rs))
	{   
        $diana=strcmp($row_Recordset1['apartat'], $profe['apartat']) ?>
          <option value="<?php  echo $profe['apartat']?>"  <?php  if (!($diana)) {echo " SELECTED";}?>><?php  echo $profe['nom_cs']?></option>
          <?php  }?>
       </select>
      
      </td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?></td>
      <td colspan="2">
        <select name="profe3" >
          <option value=""></option>     
      <?php mysql_select_db($database_alas, $alas);
    $query = "SELECT * FROM apartats2013 WHERE apartat LIKE 'F99%' AND apartat<>'F9999' AND nom_cs<>'' ORDER BY nom_cs";
    $rs = mysql_query($query, $alas) or die(mysql_error());      
      
     while ($profe = mysql_fetch_assoc($rs))
	{   
        $diana=strcmp($row_Recordset1['apartat'], $profe['apartat']) ?>
          <option value="<?php  echo $profe['apartat']?>"  <?php  if (!($diana)) {echo " SELECTED";}?>><?php  echo $profe['nom_cs']?></option>
          <?php  }?>
       </select>
      
      </td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF">&nbsp;</td>
      <td colspan="2"><input name="submit" type="submit" value="Actualizar registro"></td>
    </tr>


    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#9999FF"><a name="texto"></a><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
            <?php                 
            $oFCKeditor = new FCKeditor('text_cs') ;
            $oFCKeditor->BasePath = 'fckeditor/' ;
            $oFCKeditor->Width = 690 ;
            $oFCKeditor->Value = $row_Recordset1['text_cs']; ;
            $oFCKeditor->Create() ;
            ?>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
            <?php                 
            $oFCKeditor2 = new FCKeditor('text_ct') ;
            $oFCKeditor2->BasePath = 'fckeditor/' ;
            $oFCKeditor2->Width = 690 ;
            $oFCKeditor2->Value = $row_Recordset1['text_ct']; ;
            $oFCKeditor2->Create() ;
            ?>
      </td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
            <?php                 
            $oFCKeditor3 = new FCKeditor('text2_cs') ;
            $oFCKeditor3->BasePath = 'fckeditor/' ;
            $oFCKeditor3->Width = 690 ;
            $oFCKeditor3->Value = $row_Recordset1['text2_cs']; ;
            $oFCKeditor3->Create() ;
            ?>
       </td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
            <?php                 
            $oFCKeditor4 = new FCKeditor('text2_ct') ;
            $oFCKeditor4->BasePath = 'fckeditor/' ;
            $oFCKeditor4->Width = 690 ;
            $oFCKeditor4->Value = $row_Recordset1['text2_ct']; ;
            $oFCKeditor4->Create() ;
            ?>
      </td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
            <?php                 
            $oFCKeditor5 = new FCKeditor('text3_cs') ;
            $oFCKeditor5->BasePath = 'fckeditor/' ;
            $oFCKeditor5->Width = 690 ;
            $oFCKeditor5->Value = $row_Recordset1['text3_cs']; ;
            $oFCKeditor5->Create() ;
            ?>
      </td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
            <?php                 
            $oFCKeditor6 = new FCKeditor('text3_ct') ;
            $oFCKeditor6->BasePath = 'fckeditor/' ;
            $oFCKeditor6->Width = 690 ;
            $oFCKeditor6->Value = $row_Recordset1['text3_ct']; ;
            $oFCKeditor6->Create() ;
            ?>
      </td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
            <?php                 
            $oFCKeditor7 = new FCKeditor('text4_cs') ;
            $oFCKeditor7->BasePath = 'fckeditor/' ;
            $oFCKeditor7->Width = 690 ;
            $oFCKeditor7->Value = $row_Recordset1['text4_cs']; ;
            $oFCKeditor7->Create() ;
            ?>
      </td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
            <?php                 
            $oFCKeditor8 = new FCKeditor('text4_ct') ;
            $oFCKeditor8->BasePath = 'fckeditor/' ;
            $oFCKeditor8->Width = 690 ;
            $oFCKeditor8->Value = $row_Recordset1['text4_ct']; ;
            $oFCKeditor8->Create() ;
            ?>
      </td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF">&nbsp;</td>
      <td colspan="2"><input name="submit" type="submit" value="Actualizar registro"></td>
    </tr>


    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td>
      <td colspan="2">
            <?php                 
            $oFCKeditor9 = new FCKeditor('subtitol_cs') ;
            $oFCKeditor9->BasePath = 'fckeditor/' ;
            $oFCKeditor9->Width = 690 ;
            $oFCKeditor9->Value = $row_Recordset1['subtitol_cs']; ;
            $oFCKeditor9->Create() ;
            ?>
      </td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td>
      <td colspan="2">
            <?php                 
            $oFCKeditor10 = new FCKeditor('subtitol_ct') ;
            $oFCKeditor10->BasePath = 'fckeditor/' ;
            $oFCKeditor10->Width = 690 ;
            $oFCKeditor10->Value = $row_Recordset1['subtitol_ct']; ;
            $oFCKeditor10->Create() ;
            ?>
      </td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF">&nbsp;</td>
      <td colspan="2"><input name="submit" type="submit" value="Actualizar registro"></td>
    </tr>


    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><a name="imagenes"></a><?php  echo $camps[$n]['nom']?>:</td> 
      <td width="273"> 
        <?php  if (isset($row_Recordset1['img_fons'])){?><img src="../css/<?php  echo $row_Recordset1['img_fons']?>" width="200" /><?php }?>
        <select name="img_fons" >
          <option value=""></option>
          <?php  $files=scan_Dir('../css/backgrounds/',"gif;jpg;jpeg;swf");
	
	foreach ($files as $kay => $val)
	{
        $diana=strcmp($row_Recordset1['img_fons'], $val) ?>
          <option value="<?php  echo $val?>"  <?php  if (!($diana)) {echo " SELECTED";}?>><?php  echo $val?></option>
          <?php  }?>
        </select></td>
      <td width="102"><a href="fotos.php" target="_blank">Ver im&aacute;genes</a> </td>
    </tr>
 <?php  }$n++; if ($camps[$n]['visible']){?>
   <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td> 
        <div align="left">
        <?php  if (isset($row_Recordset1['img'])){?><img src="../css/backgrounds/<?php  echo $row_Recordset1['img']?>" width="200" /><?php }?>
          <select name="img" >
            <option value=""></option>
          <?php  $files=scan_Dir('../css/backgrounds/',"gif;jpg;jpeg;swf");
	
	foreach ($files as $kay => $val)
	{
        $diana=strcmp($row_Recordset1['img'], $val) ?>
            <option value="<?php  echo $val?>"  <?php  if (!($diana)) {echo " SELECTED";}?>><?php  echo $val?></option>
            <?php  }?>
          </select>
        </div></td>
      <td>&nbsp;</td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td> 
        <?php  if (isset($row_Recordset1['img2'])){?><img src="../css/<?php  echo $row_Recordset1['img2']?>" width="200" /><?php }?>
        <select name="img2" >
          <option value=""></option>
          <?php  $files=scan_Dir('../css/backgrounds/',"gif;jpg;jpeg;swf");
	
	foreach ($files as $kay => $val)
	{
        $diana=strcmp($row_Recordset1['img2'], $val) ?>
          <option value="<?php  echo $val?>"  <?php  if (!($diana)) {echo " SELECTED";}?>><?php  echo $val?></option>
          <?php  }?>
        </select></td>
      <td>&nbsp;</td>
    </tr>
<?php  } $n++;if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF">&nbsp;</td>
      <td colspan="2"><input name="submit" type="submit" value="Actualizar registro"></td>
    </tr>


    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td> 
        <?php  if (isset($row_Recordset1['img3'])){?><img src="../css/backgrounds/<?php  echo $row_Recordset1['img3']?>" width="200" /><?php }?>
        <select name="img3" >
          <option value=""></option>
          <?php  $files=scan_Dir('../css/backgrounds/',"gif;jpg;jpeg;swf");
	
	foreach ($files as $kay => $val)
	{
        $diana=strcmp($row_Recordset1['img3'], $val) ?>
          <option value="<?php  echo $val?>"  <?php  if (!($diana)) {echo " SELECTED";}?>><?php  echo $val?></option>
          <?php  }?>
        </select></td>
      <td>&nbsp;</td>
    </tr>
 <?php  } $n++;if ($camps[$n]['visible']){?>
   <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td> 
        <?php  if (isset($row_Recordset1['img4'])){?><img src="../css/backgrounds/<?php  echo $row_Recordset1['img4']?>" width="200" /><?php }?>
        <select name="img4" >
          <option value=""></option>
          <?php  $files=scan_Dir('../css/backgrounds/',"gif;jpg;jpeg;swf");
	
	foreach ($files as $kay => $val)
	{
        $diana=strcmp($row_Recordset1['img4'], $val) ?>
          <option value="<?php  echo $val?>"  <?php  if (!($diana)) {echo " SELECTED";}?>><?php  echo $val?></option>
          <?php  }?>
        </select></td>
      <td>&nbsp;</td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
        <input type="text" name="linkprofe" value="<?php  echo $row_Recordset1['linkprofe']; ?>" size="32"></td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF">&nbsp;</td>
      <td colspan="2"><input name="submit" type="submit" value="Actualizar registro"></td>
    </tr>


    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><a name="link"></a><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
        <input type="text" name="link" value="<?php  echo $row_Recordset1['link']; ?>" size="32"></td>
    </tr>
<?php  } $n++;if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
        <input type="text" name="link2" value="<?php  echo $row_Recordset1['link2']; ?>" size="32"></td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
        <input type="text" name="link3" value="<?php  echo $row_Recordset1['link3']; ?>" size="32"></td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
        <input type="text" name="link4" value="<?php  echo $row_Recordset1['link4']; ?>" size="32"></td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
        <input type="text" name="color" value="<?php  echo $row_Recordset1['color']; ?>" size="32"></td>
    </tr>
<?php  }$n++; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
        <input type="text" name="n_fitxes" value="<?php  echo $row_Recordset1['n_fitxes']; ?>" size="32"></td>
    </tr>
<?php  }$n=30; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
        <input type="checkbox" name="calendario" value="calendario" <?php  if ($row_Recordset1['calendario']) echo 'checked="checked"' ?> size="32"></td>
    </tr>
<?php  }$n=32; if ($camps[$n]['visible']){?>
    <tr valign="baseline" class="data-toggle">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
        <input class="datepicker" type="text" name="data" value="<?php  echo $row_Recordset1['data']?>" size="32"></td>
    </tr>
<?php  }$n=33; if ($camps[$n]['visible']){?>
    <tr valign="baseline" class="data-toggle">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
                   <?php                 
            $oFCKeditor = new FCKeditor('text_calendari_cs') ;
            $oFCKeditor->BasePath = 'fckeditor/' ;
            $oFCKeditor->Width = 690 ;
            $oFCKeditor->Value = $row_Recordset1['text_calendari_cs']; 
            $oFCKeditor->Create() ;
            ?>
      </td>
    </tr>
<?php  }$n=34; if ($camps[$n]['visible']){?>
    <tr valign="baseline" class="data-toggle">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
                   <?php                 
            $oFCKeditor = new FCKeditor('text_calendari_ct') ;
            $oFCKeditor->BasePath = 'fckeditor/' ;
            $oFCKeditor->Width = 690 ;
            $oFCKeditor->Value = $row_Recordset1['text_calendari_ct']; 
            $oFCKeditor->Create() ;
            ?>
      </td>
    </tr>
<?php  }$n=31; if ($camps[$n]['visible']){?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF"><?php  echo $camps[$n]['nom']?>:</td> 
      <td colspan="2"> 
        <input type="checkbox" name="publicado" value="publicado" checked="checked" size="32"></td>
    </tr>
<?php  } ?>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#9999FF">&nbsp;</td> 
      <td colspan="2"> 
        <input type="submit" value="Actualizar registro">        </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
<!--  <input type="hidden" name="apartat" value="<?php  echo $row_Recordset1['apartat']; ?>">        -->
</form>

</body>
</html>
<?php 





function camps($tipus='F')
{
   for ($k=0;$k++;$k<30) $camps[$k]['nom']="xxx";$camps[$k]['visible']=0;
 
    $camps[99]['nom']="../css/backgrounds";

    switch ($tipus)
    {
        case 'L':
            $i=0;$camps[$i]['nom']="Apartat";$camps[$i]['visible']=1;
            $i=1;$camps[$i]['nom']="Títol enllaç";$camps[$i]['visible']=1;
            $i=24;$camps[$i]['nom']="Link<br>Dentro de ALAS: alas.php?fitxa=FXXXX<br>Fuera de ALAS: http://";$camps[$i]['visible']=1;
            $i=31;$camps[$i]['nom']="publicado";$camps[$i]['visible']=1;
            $i=32;$camps[$i]['nom']="Fecha";$camps[$i]['visible']=1;
            $i=33;$camps[$i]['nom']="Texto calendario_CS";$camps[$i]['visible']=1;
            $i=34;$camps[$i]['nom']="Texto calendario_CT";$camps[$i]['visible']=1;

        break;
    
    
         case 'F99':
            $i=0;$camps[$i]['nom']="Apartat";$camps[$i]['visible']=1;
            $i=3;$camps[$i]['nom']="Nom_CS";$camps[$i]['visible']=1;
            $i=4;$camps[$i]['nom']="Nom_CT";$camps[$i]['visible']=1;
            $i=8;$camps[$i]['nom']="Text_CS";$camps[$i]['visible']=1;
            $i=9;$camps[$i]['nom']="Text_CT";$camps[$i]['visible']=1;
            $i=31;$camps[$i]['nom']="publicado";$camps[$i]['visible']=1;
            $i=32;$camps[$i]['nom']="Fecha";$camps[$i]['visible']=1;
            $i=33;$camps[$i]['nom']="Texto calendario_CS";$camps[$i]['visible']=1;
            $i=34;$camps[$i]['nom']="Texto calendario_CT";$camps[$i]['visible']=1;

        break;
            
    
        case 'F98':
            $i=0;$camps[$i]['nom']="Apartat";$camps[$i]['visible']=1;
            $i=2;$camps[$i]['nom']="Plantilla";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Nom_CS";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Nom_CT";$camps[$i]['visible']=1;
            $i=16;$camps[$i]['nom']="Títol video_CS";$camps[$i]['visible']=1;
            $i=17;$camps[$i]['nom']="Títol video_CT";$camps[$i]['visible']=1;
            $i=8;$camps[$i]['nom']="Esquerra-CS";$camps[$i]['visible']=1;
            $i=9;$camps[$i]['nom']="Esquerra-CT";$camps[$i]['visible']=1;
            $i=10;$camps[$i]['nom']="Dreta1_CS";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Dreta1_CT";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Dreta2_CS";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Dreta2_CT";$camps[$i]['visible']=1;
            $i=14;$camps[$i]['nom']="Text principal_CS";$camps[$i]['visible']=1;
            $i=15;$camps[$i]['nom']="Text principal_CT";$camps[$i]['visible']=1;
            $i=24;$camps[$i]['nom']="Enllaç YouTube";$camps[$i]['visible']=1;
            $i=30;$camps[$i]['nom']="calendario";$camps[$i]['visible']=1;
            $i=31;$camps[$i]['nom']="publicado";$camps[$i]['visible']=1;
            $i=32;$camps[$i]['nom']="Fecha";$camps[$i]['visible']=1;
            $i=33;$camps[$i]['nom']="Texto calendario_CS";$camps[$i]['visible']=1;
            $i=34;$camps[$i]['nom']="Texto calendario_CT";$camps[$i]['visible']=1;
        break;
        
        case 'F':
        case 'F0':
        default:
            $i=0;$camps[$i]['nom']="Apartat";$camps[$i]['visible']=2;
            $i=1;$camps[$i]['nom']="Descripcio";$camps[$i]['visible']=1;
            $i=2;$camps[$i]['nom']="Plantilla";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Nom_CS";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Nom_CT";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Profe";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Profe 2";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Profe 3";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Text_CS";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Text_CT";$camps[$i]['visible']=1;
            $i=10;$camps[$i]['nom']="DATES_CS";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="DATES_CT";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="SUBTITULO_CS";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="SUBTITULO_CS";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="HORARIO_CS";$camps[$i]['visible']=0;
            $i++;$camps[$i]['nom']="HORARIO_CT";$camps[$i]['visible']=0;
            $i++;$camps[$i]['nom']="PIE DE PAG_CS";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="PIE DE PAG_CT";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Imagen de Fondo";$camps[$i]['visible']=1;
            $i++;$camps[$i]['nom']="Imagen 1";$camps[$i]['visible']=1;
            $i=20;$camps[$i]['nom']="Imagen 2";$camps[$i]['visible']=0;
            $i++;$camps[$i]['nom']="Imagen 3";$camps[$i]['visible']=0;
            $i++;$camps[$i]['nom']="Imagen 4";$camps[$i]['visible']=0;
            $i++;$camps[$i]['nom']="Link Profe";$camps[$i]['visible']=0;
            $i++;$camps[$i]['nom']="Link";$camps[$i]['visible']=0;
            $i=25;$camps[$i]['nom']="Link 2";$camps[$i]['visible']=0;
            $i++;$camps[$i]['nom']="Link 3";$camps[$i]['visible']=0;
            $i++;$camps[$i]['nom']="Link 4";$camps[$i]['visible']=0;
            $i++;$camps[$i]['nom']="Color";$camps[$i]['visible']=0;
            $i++;$camps[$i]['nom']="n_fitxes";$camps[$i]['visible']=0;
            $i=30;$camps[$i]['nom']="calendario";$camps[$i]['visible']=1;
            $i=31;$camps[$i]['nom']="publicado";$camps[$i]['visible']=1;
            $i=32;$camps[$i]['nom']="Fecha";$camps[$i]['visible']=1;
            $i=33;$camps[$i]['nom']="Texto calendario_CS";$camps[$i]['visible']=1;
            $i=34;$camps[$i]['nom']="Texto calendario_CT";$camps[$i]['visible']=1;
        break;
    
    }   
    



    return $camps;

}


?>