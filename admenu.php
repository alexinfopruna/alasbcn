<?php 
header('Content-Type: text/html; charset=UTF-8');

require_once('Connections/alasdb.php'); 
require_once('script/alex100.inc');

if (!valida_admin()) {
    header("Location: admin2/login.htm"); exit();
} 
   if (isset($_GET["fitxa"])) $fitxa=$_GET["fitxa"];
  
    if ($fitxa=="000") $fitxa="F0000";

    if (!$fitxa) $fitxa="F0000";
    if (!$fitxa_peu) $fitxa_peu="F9999";
    
     $refitxa=$fitxa; 
     $lang=recupera_idioma($lang);
     $fitxa =$refitxa;
    
    
    $plana="fitxa.php?fitxa=$fitxa&lang=$lang";
    $apartat=substr($fitxa,1,2);
    $subapartat=substr($fitxa,3,2);
    $plantilla="alas08.lbi";
    $imag_fons="imatges/fons_fitxa.jpg";
    $fons_menu="imatges/fons10.jpg";
   
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
////     ADMIN
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////

if (isset($_GET["del"]))
{
    $mitxa=$_GET["del"];
    $query="DELETE FROM apartats2013 WHERE apartat='$mitxa'";
    $rs = mysql_query($query, $alas) or die(mysql_error());
}

if ((isset($_POST["edit"]))&&(!empty($_POST["edit"])))
{
    $ap=$mn=$_POST["edit"];
    $edapartat=$_POST["apartat"];
    $ord=$_POST["ordre"];
    recalcula_ordre($mn,$ord);if (strlen($apartat)==3) $apartat.="00";
    $tcs=$_POST["text_cs"];
    $tct=$_POST["text_ct"];
    $lnk=$_POST["link"];if ($lnk=="alas.php?fitxa=F") $lnk=null;
    $img_fons =$_POST["img_fons"];if (!isset($img_fons)) $img_fons=null; 

    $query="UPDATE apartats2013 SET apartat='$edapartat' , nom_cs='$tcs', nom_ct='$tct' , link='$lnk' , n_fitxes=$ord, img_fons='$img_fons'  WHERE apartat='$ap'"; 
    $rs = mysql_query($query, $alas) or die(mysql_error());
	if (!$rs) echo "FALLO UPDATE";

}

if (isset($_GET["scroll"]))
{
 $tcs=htmlentities($_POST["scroll_cs"], ENT_QUOTES);
 $tct=htmlentities($_POST["scroll_ct"], ENT_QUOTES);
    $query='UPDATE apartats2013 SET text_cs="'.$tcs.'", text_ct="'.$tct.'" WHERE apartat="'.$fitxa_peu.'"';
    $rs = mysql_query($query, $alas) or die(mysql_error());
}


if ((isset($_POST["insert"]))&&(!empty($_POST["insert"])))
{
    $mn=$_POST["insert"];
    $descripcio="SUBMENU";if (substr($mn,3,2)=="00") $descripcio="MENU PRINCIPAL"; 
    $ord=$_POST["ordre"];
    $ap=autunum($mn);
    $tcs=$_POST["text_cs"];
    $tct=$_POST["text_ct"];
    $lnk=$_POST["link"];if ($lnk=="alas.php?fitxa=F") $lnk=null;
    $img_fons =$_POST["img_fons"];if (!isset($img_fons)) $img_fons=null; 

    
    $query="INSERT INTO apartats2013 (apartat,nom_cs,nom_ct,link,n_fitxes,descripcio, img_fons) VALUES ('$ap','$tcs','$tct','$lnk',$ord,'$descripcio','$img_fons')";
    $rs = mysql_query($query, $alas) or die(mysql_error());
	if (!$rs) echo "FALLO INSERT";
    
    $ap=recalcula_ordre($mn,$ord);if (strlen($apartat)==3) $apartat.="00";

}

function recalcula_ordre($menu,$ord)
{
    global $alas;

    $mn=substr($menu,1,2);
    $sub=substr($menu,3,2);  
    
   //////
    /////  REORDENA
    /////
                                                      
    $uere="WHERE LEFT(apartat,3)='M$mn' AND SUBSTRING(apartat,4,2)<>'00'" ;    
    if ($sub=="00") $uere="WHERE apartat LIKE 'M%' AND SUBSTRING(apartat,4,2)='00'";
    
    $query="UPDATE apartats2013 SET n_fitxes=n_fitxes+1 ".$uere." AND n_fitxes>=$ord"   ;
    $rs = mysql_query($query, $alas) or die(mysql_error());
    
    $query="UPDATE apartats2013 SET n_fitxes=$ord WHERE apartat='$menu'";
    $rs = mysql_query($query, $alas) or die(mysql_error());

        
     
    $qap="SELECT apartat FROM  apartats2013 ".$uere. "ORDER BY n_fitxes";
    $rap = mysql_query($qap, $alas) or die(mysql_error());
    $i=0;
    while($rou=mysql_fetch_array($rap))
    {
      $i++;  
      $query="UPDATE apartats2013 SET n_fitxes=$i WHERE apartat='".$rou["apartat"]."'"; 
      $rs = mysql_query($query, $alas) or die(mysql_error());     
    }

    
    
    return autunum($menu);
}    
    
    //////
    /////  AUTONUM
    /////
function autunum($menu)  
{  
    global $alas;

    $mn=substr($menu,1,2);
    $sub=substr($menu,3,2);  
    
    $query="SELECT * FROM apartats2013 WHERE LEFT(apartat,3)='M$mn' AND SUBSTRING(apartat,4,2)<>'00' ORDER BY apartat DESC" ;        
    if ($sub=="00") $query="SELECT * FROM apartats2013 WHERE apartat LIKE 'M%' AND SUBSTRING(apartat,4,2)='00' ORDER BY apartat DESC" ;
    $rs = mysql_query($query, $alas) or die(mysql_error());
    $rou=mysql_fetch_array($rs);
    

    $ultim=$rou["apartat"];
    if (!$rou) return $menu;
    
   $mn=substr($ultim,1,2);
   $sub=substr($ultim,3,2);
   if ($sub=="00") 
   {
      $mn=$mn+101;
      $mn=substr($mn,1,2);
   }
   else
   {
      $sub=$sub+101;
      $sub=substr($sub,1,2);    
   }
    
   return "M".$mn.$sub;
}
//////////////////////////////////////////////////
    $menu=menu($alas,$lang);
    $textscroll=peu($alas,$fitxa_peu,$lang);
    $row["sobre"]=$sobre=sobre();

//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
////     FITXA
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
        
// CARREGA LES DADES DE LA FITXA        
  	$query_menu = "SELECT * FROM apartats2013 WHERE apartat='$fitxa'";
	$rs = mysql_query($query_menu, $alas);
    
   
    if ($row = mysql_fetch_assoc($rs))
    {
        $row["submenu"]=submenu($alas,$lang);
        if (substr($row["submenu"],0,13)=="<div id='SM'>")  $sm=$row["submenu"];
        if (!isset($row["submenu"]))  $sm=true;
        if (!$sm) 
        {
            $plantilla="submenu08.lbi";
            $imag_fons=$fons_menu;
        }  
        
        // IMATGE DE FONS
        if (!empty($row["img_fons"])) $imag_fons="imatges/".$row["img_fons"];        
        // PLANTILLA
        if (!empty($row["plantilla"])) $plantilla=$row["plantilla"];
        // PROFES
		$row['profes']=profes($row,$alas);
		
   }
   else
   {
        // COMPROVA SI EXISTEIX SUBMENU
        $row["submenu"]=submenu($alas,$lang);
        if (!isset($row["submenu"]))  $sm=true;
       // if (substr($row["submenu"],0,13)=="<div id='SM'>")  $sm=$row["submenu"];
        if (!$sm) 
        {
            $plantilla="submenu08.lbi";
            $imag_fons=$fons_menu;
        }
   }
    mysql_free_result($rs); 
    
    // LINKS
    $row["links"]=links($alas);    
    
    //CREACIONES    
    if ($row["nom_cs"]=="CREACIONES") $row["COL0"]=creaciones();
	
    //GALERIA
    if ($row["nom_cs"]=="GALERIA") $row["text_ct"]=galeria();

           
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Alas. Un espacio de crecimiento art�stico y personal</title>
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache"> 

<link rel="shortcut icon" href="css/favicon.ico"> 


<link href="css/alas08.css" rel="stylesheet" type="text/css">

<script>
function oculta()
{
	document.getElementById('frm').style.display = 'none';
	document.getElementById('velat').style.display = 'none';
}
function mostra()
{
	document.getElementById('frm').style.display = 'block';
	document.getElementById('velat').style.display = 'block';
}

function editar(apartat,tcs,tct,link,ordre,img_fons)
{
    document.getElementById('apartat').value=apartat;
    document.getElementById('text_cs').value=tcs;
    document.getElementById('text_ct').value=tct;
    document.getElementById('link').value=link;
    document.getElementById('ordre').value=ordre;
    document.getElementById('img_fons').value=img_fons;

    document.getElementById('insert').value="";
    document.getElementById('edit').value=apartat;
    document.getElementById('img_fons').value = img_fons;

    mostra();     
}

function insert(apartat)
{
    document.getElementById('apartat').value=apartat;
    document.getElementById('text_cs').value="";
    document.getElementById('text_ct').value="";
    document.getElementById('link').value="";
    document.getElementById('ordre').value="";

    document.getElementById('insert').value=apartat;
    document.getElementById('edit').value="";

    mostra();     

}
</script>

<style type="text/css">
<!--
#frm {
margin:auto;
background-color:#333333;
position:absolute;
top:40px;
left:0;
margin:100px;
display:none;

}

#velat
{
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
background-color:#000000;
opacity:.50;filter: alpha(opacity=50); -moz-opacity: 0.50;
display:none;

}
-->
</style>
</ head>
<body onload="oculta()">
<div id="container">
  <div id="menu_isqui">
  	<div id="logo">
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="186" height="54" title="ALAS">
			  <param name="movie" value="css/logo_animat.swf" />
			  <param name="quality" value="high" />
			  <embed src="css/logo_animat.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="186" height="54"></embed>
		</object>
	</div>
    <?php   echo $menu; ?> 
  </div>
  
  <div id="col_dere" style="background-image:url(<?php  echo $imag_fons ?>);">	
        <div id="sobre">
            <?php 
                echo $sobre;
            ?>
        </div>
            <?php 
                //echo $row["links"];
                echo "<div style='background-color:#222222;text-align:center'><a href='admin2/admin_modificar_apartat.php?fitxa=$fitxa&like=F0&mnu=$fitxa'><strong>[Editar fitxa $fitxa]</strong></a> | <a href='admin2/admin_insert_apartat.php?fitxa=$fitxa&like=F0&mnu=$fitxa'><strong>[Crear nueva fitxa]</strong></a></div>";
               // echo $sm;
                print_plantilla($plantilla,$row,$lang);
            ?>
  </div>
    
	 
	<div id="peux" style="text-align:center;">
		<?php  //require ("script/scroll.js");?>
	    <form id="form2" name="form2" method="post" action="admenu.php?scroll=ed">
	      <input name="scroll_cs" type="text" value="<?php  echo $textscroll?>" size="60" style="text-align:center;	font-size:12px"/>
	      <input name="scroll_ct" type="text" value="<?php  echo $textscroll_ct?>" size="60" style="text-align:center;	font-size:12px"/>
                <input type="submit" name="Submit2" value="Cambiar scroll" />
	    </form>
    </div>
</div>

<div id="velat" name="velat"></div>

<div id="frm" name="frm" style="frm">
  <form id="form1" name="form1" method="post" action="admenu.php?fitxa=<?php echo $fitxa?>">
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr >
        <td class="nom" ><a href="javascript:oculta();">[cerrar]</a></td>
        <td>&nbsp;</td>
        <td class="nom"><strong>A&Ntilde;ADIR / MODIFICAR APARTADO MENU</strong></td>
      </tr>
      <tr >
        <td class="nom">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="nom">&nbsp;</td>
      </tr>
      <tr>
        <td class="nom"><div align="right" >Apartado </div></td>
        <td>&nbsp;</td>
        <td><input type="text" name="apartat" id="apartat" />
          <span class="select">Es aconsejable no cambiar este valor</span></td>
      </tr>
      <tr>
        <td class="nom"><div align="right" >Nombre CAST </div></td>
        <td>&nbsp;</td>
        <td><input type="text" name="text_cs" id="text_cs" size="110"/></td>
      </tr>
      <tr>
        <td class="nom"><div align="right">Nombre CAT_ </div></td>
        <td>&nbsp;</td>
        <td><input type="text" name="text_ct" id="text_ct" size="110"/></td>
      </tr>
      <tr>
        <td class="nom"><div align="right">Enlace </div></td>
        <td>&nbsp;</td>
        <td><input name="link" type="text" value="alas.php?fitxa=F" id="link" />
          <span class="select">Dentro de alas: alas.php?fitxa=Fxxxx / Fuera de alas: http:// </span></td>
      </tr>
      <tr>
        <td class="nom"><div align="right">Posici&oacute;n </div></td>
        <td>&nbsp;</td>
        <td><input name="ordre" type="text" size="2" maxlength="2" id="ordre" /></td>
      </tr>
<!--
      <tr>
        <td class="nom"><div align="right">Imagen de fondo </div></td>
        <td>&nbsp;</td>
        <td><input name="fons" type="text" size="2" maxlength="2" id="fons" value="<?php  echo $row['img_fons'] ?>"/></td>
      </tr>
-->
      <tr>
        <td class="nom"><div align="right">Imagen de fondo</div> </td>
        <td>&nbsp;</td>                       
        <td> 
        <select name="img_fons" id="img_fons">
          <option value="<?php  echo $row['img_fons'] ?>"></option>
          <?php  $files=scan_Dir('imatges/',"gif;jpg;jpeg;swf");
	
	foreach ($files as $kay => $val)
	{
        //$diana=strcmp($row['img_fons'], $val) ?>
          <option value="<?php  echo $val?>"><?php  echo $val?></option>
          <?php  }?>
        </select>
        </td>
      </tr>

      <tr>
        <td class="nom">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="nom">&nbsp;</td>
        <td>&nbsp;</td>
        <td>
        <input name="insert" type="hidden" id="insert" value="M0100" /> 
        <input name="edit" type="hidden" id="edit" value="" /> 
        <input type="submit" name="Submit" value="Guardar" action="admenu.php?add=mnu" style="width:145px" /></td>
      </tr>
      <tr>
        <td class="nom">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </form>
</div>

</body>
</html>
<?php 
//********************************************************************************************
//********************************************************************************************
//   FUNCIONS
//********************************************************************************************
//********************************************************************************************

function menu($alas=null,$lang)
{
    global $apartat,$fons_menu,$plantilla;
    
    
    if (is_numeric($lang)) $sufix_idioma=$extensio_lang[$lang];

	$query_menu = "SELECT * FROM apartats2013 WHERE apartat LIKE 'M%' AND SUBSTRING(apartat,4,2)='00' ORDER BY n_fitxes";
	//$query_menu = "SELECT * FROM admin";
	$rs = mysql_query($query_menu, $alas);
    
    $base_fitxa="admenu.php?fitxa=";
    
    while ($row = mysql_fetch_assoc($rs))
    {
        $class="mnu";
		
       $mitxa=$row["apartat"];
       $fitxa="F".substr($row["apartat"],1,4);

       if ($row['link']>0) $fitxa=$row['link']; 
		//////////////////////
	    	
        $titol=$row["nom_".$lang];
        
        $ed_params="'".$mitxa."', '".$row["nom_cs"]."', '".$row["nom_ct"]."', '".$row['link']."', ".$row["n_fitxes"].", '".$row["img_fons"]."'";
        
        if (substr($row["apartat"],1,2)==$apartat) {
            $class="mnu select";
            $torna.='<div class="'.$class.'">
            <a href="javascript:editar('.$ed_params.')" title="Editar este elemento" ><img src="css/edit.gif" style="margin-right:-5px" ></a>
            <a href="admenu.php?del='.$mitxa.'&fitxa='.$fitxa.'" title="Eliminar este elemento" onclick="if(!confirm('."'Eliminar apartado?'".'))return false"><img src="css/del.gif" style="margin-right:1px;width:13px;"></a>
            <a href="'.$base_fitxa.$fitxa.'">'.$titol.'</a>
            </div>';      
            
            if (!empty($row["img_fons"]))$fons_menu="imatges/".$row["img_fons"];    
            if (!empty($row["plantilla"]))$plantilla=$row["plantilla"];    
        }
        else
        {
           $torna.='<div class="'.$class.'">
            <a href="javascript:editar('.$ed_params.')" title="Editar este elemento" ><img src="css/edit.gif" style="margin-right:-5px" ></a>
            <a href="admenu.php?del='.$mitxa.'&fitxa='.$fitxa.'" title="Eliminar este elemento" onclick="if(!confirm('."'Eliminar apartado?'".'))return false"><img src="css/del.gif" style="margin-right:1px;width:13px;"></a>
           <a href="'.$base_fitxa.$fitxa.'">'.$titol.'</a>
           </div>';          
        }
        
    }
    
    $autunum=autunum($mitxa);
    $torna.='<div class="'.$class.'"><a href="javascript:insert('."'".$autunum."'".')" style="font-size:12px"><span style="color:#BB0000">[+]</span> Añadir menu</a></div>';          
    
    mysql_free_result($rs);   
    return $torna;
}

//************************************************
//************************************************
//************************************************

function submenu($alas=null,$lang)
{
       global $apartat,$fons_menu,$plantilla,$fitxa;
    
        if(substr($fitxa, 3,2)!="00") return;
    
    
    //if (is_numeric($lang)) $sufix_idioma=$extensio_lang[$lang];

//	$query_menu = "SELECT * FROM apartats2013 WHERE apartat LIKE 'M%' AND SUBSTRING(apartat,4,2)='00' ORDER BY n_fitxes";
	$query_menu = "SELECT * FROM apartats2013 WHERE LEFT(apartat,3)='M$apartat' AND SUBSTRING(apartat,4,2)<>'00' ORDER BY n_fitxes";
	$rs = mysql_query($query_menu, $alas);
    
    $base_fitxa="admenu.php?fitxa=";
    //unset($torna);
    //$torna=null;
    
    while ($row = mysql_fetch_assoc($rs))
    {
       $mitxa=$row["apartat"];
       $dest="F".substr($row["apartat"],1,4);

        $class="mn2x";
        
        
        if (!empty($row["link"])) 
        {
            $dest=$row["link"];
        }
        else                                  
        {
            $dest="F".substr($row["apartat"],1,4);
        }
        
        $titol=$row["nom_".$lang];
       
        $row["link"]=$dest;
        $row["nom"]=$titol;


       //if ($row['link']>0) $fitxa=$row['link']; 
		//////////////////////
	    	
        $titol=$row["nom_".$lang];
        
        $tcs=htmlentities($row["nom_cs"]);
        $tct=htmlentities($row["nom_ct"]);
        //$tcs=($row["nom_cs"]);
        //$tct=($row["nom_ct"]);
        
        $ed_params="'".$mitxa."', '".$tcs."', '".$tct."', '".$row['link']."', ".$row["n_fitxes"];
        
       $mnedit='<a href="javascript:editar('.$ed_params.')" title="Editar este elemento" ><img src="css/edit.gif" style="margin-right:-5px" ></a>
        <a href="admenu.php?del='.$mitxa.'&fitxa='.$fitxa.'" title="Eliminar este elemento" onclick="if(!confirm('."'Eliminar apartado?'".'))return false"><img src="css/del.gif" style="margin-right:1px;width:13px;"></a>';          
        

        
        $torna.='<div class="mn3 transOFF" onmouseover="this.className='."'mn4 transON'".'" onmouseout="this.className='."'mn3 transOFF'".'" style="padding:0 45px 0 15px">
                <div >'.$mnedit.'<a href="'.$base_fitxa.$dest.'">'.$titol.'</a> </div>
         </div>'; 
    }
    
    if (!isset($mitxa)) 
    {
        $mitxa="M".substr($fitxa,1,3)."1";   
        $sm="<div id='SM'></div>";           
    }
    
        $class="mnu";
    $autunum=autunum($mitxa);
    $torna.=$sm.'<div class="'.$class.'"><a href="javascript:insert('."'".$autunum."'".')" style="font-size:12px"><span style="color:#BB0000">[+]</span> Añadir menu</a></div>';          


    mysql_free_result($rs);   
    return $torna;
 
}

    


//************************************************
//************************************************
//************************************************

function links($alas=null)                
{
    global $apartat;
    
    $class="linc";

	$query_menu = "SELECT * FROM apartats2013 WHERE apartat LIKE 'L%'";
	$rs = mysql_query($query_menu, $alas);
    
    $base_fitxa="http://";
    
    while ($row = mysql_fetch_assoc($rs))
    {
            if (substr($row["link"],0,7)=="http://")  $base_fitxa="";
            if (substr($row["link"],0,7)=="alas.ph")  $base_fitxa="";
           $torna.='<div class="'.$class.'"><a href="'.$base_fitxa.$row["link"].'" target="_blank">'.$row["descripcio"].'</a></div>';          
        
    }
    mysql_free_result($rs);   
    return $torna;

}

//************************************************
//************************************************
//************************************************

function sobre()
{
	$sobre='<div id="isobre" class="TransOFF" onmouseover="this.className='."'transON'".'" onmouseout="this.className='."'transOFF'".'">
	  <a href="mailto:info@alasbcn.com"  title="Contacte"><img src="css/sobre.gif" alt="contacte" width="29" height="25" border="0" />
	  </a>&nbsp;
	  </div>
	  
	  <div id="isobre" class="TransOFF" onmouseover="this.className='."'transON'".'" onmouseout="this.className='."'transOFF'".'">&nbsp;
	  <a href="alas.php?fitxa=F0005" title="Informaci�" onmouseover="this.className='."'transON'".'" onmouseout="this.className='."'transOFF'".'">
	  <img src="css/info.gif" alt="info" width="25" height="25" border="0" />
	  </a>
	  </div>';

	
	return $sobre;
}

//************************************************
//************************************************
//************************************************

function profes($row,$alas)
{
    global $lang;
        if (isset($row['profe']))  
        {
            $profe=$row['profe'];
	        $query_menu = "SELECT * FROM apartats2013 WHERE apartat LIKE '$profe'";
	        $rs = mysql_query($query_menu, $alas);
            if ($prof = mysql_fetch_assoc($rs))
            {
                //$row['profe']=$prof["nom_cs"];
                $row['profe']="<a href='alas.php?fitxa=".$row['profe']."'>".$prof['nom_cs']."</a>";
            }
            
            
        }
        if (isset($row['profe3']))  
        {
            $profe=$row['profe3'];
	        $query_menu = "SELECT * FROM apartats2013 WHERE apartat LIKE '$profe'";
	        $rs = mysql_query($query_menu, $alas);
            if ($prof = mysql_fetch_assoc($rs))
            {
                $row['yprofe3']=$lang=='ct'?' i ':' y ';     
                $row['profe3']="<a href='alas.php?fitxa=".$row['profe3']."'>".$prof['nom_cs']."</a>";
            }
            
            
         }
        if (isset($row['profe2']))  
        {
            $profe=$row['profe2'];
	        $query_menu = "SELECT * FROM apartats2013 WHERE apartat LIKE '$profe'";
	        $rs = mysql_query($query_menu, $alas);
            if ($prof = mysql_fetch_assoc($rs))
            {
                $row['yprofe2']=$lang=='ct'?' i ':' y ';     
                $row['profe2']="<a href='alas.php?fitxa=".$row['profe2']."'>".$prof['nom_cs']."</a>";
            }
            
        }
        
        if (isset($row['profe3']))  $row['yprofe2']=", ";

		
		$row['profes']=$row['profe'].$row['yprofe2'].$row['profe2'].$row['yprofe3'].$row['profe3'];
        
        return $row['profes'];
}

//************************************************
//************************************************
//************************************************

function peu($alas=null,$fitxa_peu=null,$lang)
{
	global $textscroll_ct;
//	require_once('Connections/alasdb.php'); 
	if (!$fitxa_peu) $fitxa_peu="999";
	
	//mysql_select_db($database_alas, $alas);
	$query_alas = "SELECT * FROM apartats2013 WHERE apartat ='".$fitxa_peu."'";
	$rs = mysql_query($query_alas, $alas) or die(mysql_error());
	$row_alas = mysql_fetch_assoc($rs);
	$totalRows_alas = mysql_num_rows($rs);
	
	$textscroll= $row_alas['text_cs']; 
	$textscroll_ct= $row_alas['text_ct']; 
	if (substr($textscroll,strlen($textscroll)-1,1)=="\n") $textscroll=substr($textscroll,0,strlen($textscroll)-2);
	//$textscroll="Un espacio de crecimiento art�stico y personal";
	 
	return $textscroll; 
	mysql_free_result($rs);    
}

//************************************************
//************************************************
//************************************************
function creaciones()
{
    
	global $alas,$lang;
	
	$lang=0;
	
	$query_apartat = "SELECT * FROM apartats2013 WHERE apartat='F0502'";
	$apartat = mysql_query($query_apartat, $alas) or die(mysql_error());
	
	$query_creaciones="SELECT * FROM apartats2013 WHERE apartat LIKE 'F98%' AND nom_cs<>'' ORDER BY apartat DESC";
	$creaciones[0]=mysql_query($query_creaciones, $alas) or die(mysql_error());             
	
	$row_apartat=mysql_fetch_array($apartat);
	$t=cols_plantilla($row_apartat,$creaciones);
	
	//print_t_plantilla($t);
	
	mysql_free_result($apartat);
	mysql_free_result($creaciones[0]);
	
	//return "EEEEEEEEERRRRE<br>�gjlkgllfj";
	$torna=$t->get("COL0"); #000000
    //$torna=nl2br($torna);
    return $torna;
	
}

function galeria()
{
    $files=scan_Dir('galeria/',"gif;jpg;jpeg;swf");
	
	    foreach ($files as $kay => $val)
	    {
 			$c++;
			$br="";
			//if (($c%15)==0) $br="<br>";
          $l=strlen($val);
          $smal=substr($val,$l-9,9);
          $nom=substr($val,0,$l-10);
 
          if ($smal!="small.jpg")  $exten=substr($val,$l-4,$l); 
          if ($smal=="small.jpg")
          {
          
              $torna.='<div class="fotogal"><a href="galeria/'.$edicio.'/'.$nom.$exten.'" class="fotogal fotoborde"  rel="lightbox[a]" ><img src="galeria/'.$edicio.'/'.$val.'" alt="'.$nom.'" border="0" class="seixanta"></a></div>'; 
          }
            
      } 
      
      return $torna;
}




?>