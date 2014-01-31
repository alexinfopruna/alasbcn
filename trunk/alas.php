<?php 
header('Content-Type: text/html; charset=UTF-8');
    require_once('Connections/alasdb.php'); 
    require_once('script/alex100.inc');//if (!valida_admin()) $fitxa='777';
 
    if (isset($_GET["fitxa"])) $fitxa=$_GET["fitxa"];
 
    if ($fitxa=="000") $fitxa="F0000";
    if (!$fitxa) $fitxa="F0000";
    if (!$fitxa_peu) $fitxa_peu="F9999";
	
	$title="Alas. Artes en movimiento";
	if ($lang=="ct") $title="Alas. Arts en moviment";
      
     $refitxa=$fitxa; 
     $lang=recupera_idioma($_GET['lang']);
     $fitxa =$refitxa;
    
    $plana="fitxa.php?fitxa=$fitxa&lang=$lang";
    $apartat=substr($fitxa,1,2);
    $subapartat=substr($fitxa,3,2);
    $plantilla="alas08.lbi";
    $imag_fons="imatges/fons_fitxa.jpg";
    $fons_menu="imatges/fons10.jpg";
    $titol="";

    $menu=menu($alas,$lang);
    $textscroll=peu($alas,$fitxa_peu,$lang);
    $row["sobre"]=$sobre=sobre();
 
 
/*******************************************/
/************      CONFIG    ***************/
defined('ALAS_MAIL_SUBSCRIPCIO') or define('ALAS_MAIL_SUBSCRIPCIO', 'info@alasbcn.com');
defined('ALAS_MAIL_SUBSCRIPCIO_SUBJECT') or define('ALAS_MAIL_SUBSCRIPCIO_SUBJECT', 'Nueva subscripción al mail-list');

$translate['ALAS_SUBSCRIPCIO_OK']['ct']="<h1>Subscripció a ALAS</h1>Hem incorporat les teves dades per mantenir-te informat de les activitats que organitza ALAS.<br/><br/>Gràcies per utilitzar aquest servei";
$translate['ALAS_SUBSCRIPCIO_OK']['cs']="<h1>Subscripción a ALAS</h1>Hemos incorporado tus datos para mantenerte informado de las actividades que organice ALAS.<br/><br/>Gracias por utilizar este servicio";
$translate['ALAS_SUBSCRIPCIO_KO']['ct']="OPS!!. S´ha produït un error al servidor. <br/><br/>Intenta-ho més tard";
$translate['ALAS_SUBSCRIPCIO_KO']['cs']="OPS!!. Se ha producido un error en el servidor. <br/><br/>Intentalo más tarde";

/*******************************************/
/*******************************************/
 
   
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
////  
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////

// CARREGA LES DADES DE LA FITXA        
  $query_menu = "SELECT * FROM $TABLE_APARTATS WHERE apartat='$fitxa' AND publicado=1";
  //echo $query_menu;die();	
  $rs = mysql_query($query_menu, $alas);
    
  
    if ($row = mysql_fetch_assoc($rs))
    {
        $row["submenu"]=submenu($alas,$lang);
        if ($row["submenu"]) 
        {
            $plantilla="submenu08.lbi";
            $imag_fons=$fons_menu;
        }  
        
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
        if ($row["submenu"]) 
        {
 
             $class_submenu="submenu";
            $plantilla="submenu08.lbi";
            $imag_fons=$fons_menu;
        }
   
   }
    mysql_free_result($rs); 
    
    // LINKS
    $row["links"]=links($alas);    
    
    //CREACIONES    
    if ($row["nom_cs"]=="CREACIONES") {      
      $row["COL0"]=creaciones();           
    }
    
    //CALENDARIO  
    elseif ($row["nom_cs"]=="CALENDARIO") {
     $row["COL0"]=calendario();           
    }
    
    //DETALL CREACIONES
    elseif ($row["descripcio"]=="CREACIONES") 
    {
        $row=detall_creaciones($row);
        $plantilla=$row["plantilla"]="detall_creaciones.lbi";
    }
	
    //GALERIA
    elseif ($row["nom_cs"]=="GALERIA")
    {
        if ($row["link"]!="") $row["text_cs"]=$row["text_cs"].galeria('galeria/'.$row["link"]);
        if ($row["link"]!="") $row["text_ct"]=$row["text_ct"].galeria('galeria/'.$row["link"]);
		if ($row["link2"]!="") $row["text2_cs"]=$row["text2_ct"].galeria('galeria/'.$row["link2"]);
		if ($row["link2"]!="") $row["text2_ct"]=$row["text2_ct"].galeria('galeria/'.$row["link2"]);
		if ($row["link3"]!="") $row["text3_cs"]=$row["text3_cs"].galeria('galeria/'.$row["link3"]);
 		if ($row["link3"]!="") $row["text3_ct"]=$row["text3_ct"].galeria('galeria/'.$row["link3"]);
      $row["video"]=videos();
    }
	
    //GALERIA PETROLEO
    elseif (substr($row["descripcio"],0,8)=="GALERIA:")
    {
		  $gale=substr($row["descripcio"],8)."/";
       $row["galeria"]=galeria('galeria/'.$gale);
       $row["video"]=videos();
    }
    
    //ES UNA FITXA NORMAL
    else{
      if (!empty($row["text4"])) $row["text4"]=$row["text4"];
      
    }
    
    if (isset($_REQUEST['maillist']) && isset($_REQUEST['ne'])){
      $nom=$_REQUEST['nn'];
      $mail=$_REQUEST['ne'];
      $text_mail_subscripcio="Hemos recibido una solicitud de subscripción a la lista de correo:<br/><br/>      
        Nombre: $nom
        <br/>
        Email:$mail
      ";
      
      
      $headers = "From: " . strip_tags($_REQUEST['ne']) . "\r\n";
      $headers .= "Reply-To: ". strip_tags($_REQUEST['ne']) . "\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
      $mail_result=mail(ALAS_MAIL_SUBSCRIPCIO,ALAS_MAIL_SUBSCRIPCIO_SUBJECT,$text_mail_subscripcio,$headers,"-f $mail");
      
      $resposta= $mail_result?$translate['ALAS_SUBSCRIPCIO_OK'][$lang]:$translate['ALAS_SUBSCRIPCIO_KO'][$lang];
      //echo htmlentities($resposta);
      echo $resposta;
      die();
    }

function printr($var){echo "<pre>";print_r($var);echo "</pre>";}

           
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

<title><?php  echo $title?></title>
<style type="text/css">
	div.horizontal_scroller{
		position:relative;
		height:24px;
		display:block;
		overflow:hidden;
		margin-top:25px;
	}
	div.scrollingtext{
	color:white;
		position:absolute;
		white-space:nowrap;
		font-family:"Century Gothic", "AvantGarde Bk BT", Arial;
		font-size:18px;
		/*font-weight:bold;*/
	}
</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script>
<script src="script/jquery.Scroller-1.0.min.js" type="text/javascript"></script> 
<script src="javascript/jquery.validate.min.js" type="text/javascript"></script> 
<script src="javascript/jquery.form.js" type="text/javascript"></script> 
<script src="javascript/messages_<?php  echo ($lang==ct?'ca':'es'); ?>.js" type="text/javascript"></script> 
<script type="text/javascript">
	jQuery.noConflict();
	jQuery(function() {
	//create scroller for each element with "horizontal_scroller" class...
	jQuery('.horizontal_scroller').SetScroller({	velocity: 60});
	/*
		All possible values for options...
		
		velocity: 		from 1 to 99 								[default is 50]						
		direction: 		'horizontal' or 'vertical' 					[default is 'horizontal']
		startfrom: 		'left' or 'right' for horizontal direction 	[default is 'right']
						'top' or 'bottom' for vertical direction	[default is 'bottom']
		loop:			from 1 to n+, or set 'infinite'				[default is 'infinite']
		movetype:		'linear' or 'pingpong'						[default is 'linear']
		onmouseover:	'play' or 'pause'							[default is 'pause']
		onmouseout:		'play' or 'pause'							[default is 'play']
		onstartup: 		'play' or 'pause'							[default is 'play']
		cursor: 		'pointer' or any other CSS style			[default is 'pointer']
	*/

  jQuery("#subscripcio").validate({
    rules: {
      nn: {
        required: true,
        minlength: 2
      },
      ne: {
        required: true,
        email: true
      }
    },

  });
      var lang='<?php  echo ($lang==ct?'ca':'es'); ?>';
     var options = { 
        target:        '#subscripcio',   // target element(s) to be updated with server response 
        beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
 
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
 
    // bind form using 'ajaxForm' 
    jQuery("#subscripcio").ajaxForm(options); 

});

// pre-submit callback 
function showRequest(formData, jqForm, options) { 
    if (!jQuery("#subscripcio").valid()) return false;   
   
      jQuery("#subscripcio").html('<img src="images/ajax-loading.gif" />');
     return true; 
} 
 
// post-submit callback 
function showResponse(responseText, statusText, xhr, $form)  { 
    // for normal html responses, the first argument to the success callback 
    // is the XMLHttpRequest object's responseText property 
 
    // if the ajaxForm method was passed an Options Object with the dataType 
    // property set to 'xml' then the first argument to the success callback 
    // is the XMLHttpRequest object's responseXML property 
 
    // if the ajaxForm method was passed an Options Object with the dataType 
    // property set to 'json' then the first argument to the success callback 
    // is the json data object returned by the server 
 /*
    alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
        '\n\nThe output div should have already been updated with the responseText.');
 */ 
} 

</script>

<?php  if (($row["nom_cs"]=="GALERIA")||($apartat=="98")||(substr($row["descripcio"],0,4)=="GALE")){//echo "-------------AAAAAAAA>>>>";?>
	<script type="text/javascript" src="script/prototype.js"></script>
	<script type="text/javascript" src="script/scriptaculous.js?load=effects,builder"></script>
	<script type="text/javascript" src="script/lightbox.js"></script>
	<script type="text/javascript" src="javascript/lightwindow.js"></script>
	<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/lightwindow.css" />
<?php  } ?>

<link rel="shortcut icon" href="css/favicon.ico"> 
<link href="css/alas08.css<?php  echo "?".time();?>" rel="stylesheet" type="text/css">
</head>

<body>
<div id="container" class="apartat-<?php  echo $apartat?> <?php  echo $class_submenu; ?> fitxa-<?php  echo $fitxa?> plantilla-<?php  $class_plantilla=explode(".lbi",$plantilla);echo $class_plantilla[0]; ?>">
  <div id="menu_isqui">
  	<div id="logo">
  	<!--  
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="186" height="54" title="ALAS">
			  <param name="movie" value="css/logo_animat.swf" />
			  <param name="quality" value="high" />
			  <param name="wmode" value="transparent">
			  <embed src="css/logo_animat.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent" width="186" height="54"></embed>
		</object>
		-->
		
		<a href="alas.php?fitxa=F0000"><img src="imatges/logo_alas.png"/></a>
	</div>

    <?php   echo $menu; ?> 
  </div>
  <div id="col_dere" style="background-image:url(<?php  echo $imag_fons ?>);background-repeat: no-repeat;">	
      
        <div id="sobre">
            <?php 
                echo $sobre;
            ?>
        </div>
      <div class="titol-submenu"><?php  if ($class_submenu=="submenu") echo $title;?></div>
            <?php 
            //echo $imag_fons;
           // echo ucfirst($row['nom_'.$lang]);
                 $row["fitxa"]=$fitxa;
                 print_plantilla($plantilla,$row,$lang);
            ?>
    <div class="cb" style="clear:both"></div>
</div>
    

<div class="horizontal_scroller corredera" id="no_mouse_events">
	<div class="scrollingtext">
		<?php  echo $textscroll ?>
	</div>
</div>


	
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
    global $TABLE_APARTATS,$apartat,$fons_menu,$plantilla,$title;
    
    if (is_numeric($lang)) $sufix_idioma=$extensio_lang[$lang];

	$query_menu = "SELECT * FROM $TABLE_APARTATS WHERE apartat LIKE 'M%' AND SUBSTRING(apartat,4,2)='00' ORDER BY n_fitxes";
$rs = mysql_query($query_menu, $alas);
    $n=mysql_num_rows($rs);
    
    $base_fitxa="alas.php?fitxa=";
    
    while ($row = mysql_fetch_assoc($rs))
    {
        $class="mnu";
        $fitxa="F".substr($row["apartat"],1,4);
		//////////////////////
		//$fitxa="F0101";
        $titol=$row["nom_".$lang];
        
       if ($row['link']>0) $fitxa=$row['link']; 
        if (substr($row["apartat"],1,2)==$apartat) {
              $title=$titol;
          
            $class="mnu select";
            $torna.='<div class="'.$class.'"><a href="'.$base_fitxa.$fitxa.'">'.$titol.'</a></div>';      
            
            if (!empty($row["img_fons"]))$fons_menu="imatges/".$row["img_fons"];    
            if (!empty($row["plantilla"]))$plantilla=$row["plantilla"];
        }
        else
        {
           $torna.='<div class="'.$class.'"><a href="'.$base_fitxa.$fitxa.'">'.$titol.'</a></div>';          
        }
        

    }
    mysql_free_result($rs);   
    
   return $torna;
}

//************************************************
//************************************************
//************************************************

function submenu($alas=null,$lang)
{
    global $TABLE_APARTATS,$apartat,$fitxa;

    if(substr($fitxa, 3,2)!="00") return;

    if (is_numeric($lang)) $sufix_idioma=$extensio_lang[$lang];

	$query_menu = "SELECT * FROM $TABLE_APARTATS WHERE LEFT(apartat,3)='M$apartat' AND SUBSTRING(apartat,4,2)<>'00' ORDER BY n_fitxes";
	$rs = mysql_query($query_menu, $alas);
	
    $base_fitxa="alas.php?fitxa=";
    //unset($torna);
    //$torna=null;
    
    while ($rou = mysql_fetch_assoc($rs))
    {
        $class="mn2x";
        
        
        if (!empty($rou["link"])) 
        {
            $fitxa=$rou["link"];
        }
        else
        {
            $fitxa="F".substr($rou["apartat"],1,4);
        }
        
        $titol=$rou["nom_".$lang];
       
        $rou["link"]=$fitxa;
        $rou["nom"]=$titol;
        
        //$s=load_plantilla("barra_menu08.lbi",$rou,$lang);        
        //$torna.=$s->OUT;
        
       //FALTA PADDING!!  $torna.='<div class="mn3 transOFF" onmouseover="this.className='."'mn4 transON'".'" onmouseout="this.className='."'mn3 transOFF'".'"><a href="'.$base_fitxa.$fitxa.'">'.$titol.'</a></div>';          
       $torna.='<div class="mn3 transOFF" onmouseover="this.className='."'mn4 transON'".'" onmouseout="this.className='."'mn3 transOFF'".'" style="padding:0 45px 0 15px">
			<div >
				<a href="'.$base_fitxa.$fitxa.'">'.$titol.'</a>
			</div>
</div>'; 
 
    }
    mysql_free_result($rs);   
    return $torna;
}

//************************************************
//************************************************
//************************************************

function links($alas=null)                
{
    global $TABLE_APARTATS,$apartat;
    
    $class="linc";

	$query_menu = "SELECT * FROM $TABLE_APARTATS WHERE apartat LIKE 'L%' ORDER BY apartat";
	$rs = mysql_query($query_menu, $alas);
    
    $base_fitxa="http://";
    
    while ($row = mysql_fetch_assoc($rs))
    {
			if (substr($row["descripcio"],0,20)=="Escuela de Arterapia") $row["descripcio"]="Escuela de Arterapia del Mediterraneo";
	
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
	  <a href="mailto:oficina@alasbcn.com"  title="Contacte" ><img src="css/sobre.gif" alt="contacte" width="29" height="25" border="0" />
	  </a>&nbsp;
	  </div>
	  
	  <div id="isobre" class="TransOFF" onmouseover="this.className='."'transON'".'" onmouseout="this.className='."'transOFF'".'">&nbsp;
	  <a href="alas.php?fitxa=F1500" title="Informació" onmouseover="this.className='."'transON'".'" onmouseout="this.className='."'transOFF'".'">
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
    global $TABLE_APARTATS,$lang;
        if (isset($row['profe']))  
        {
            $profe=$row['profe'];
	        $query_menu = "SELECT * FROM $TABLE_APARTATS WHERE apartat LIKE '$profe'";
	        $rs = mysql_query($query_menu, $alas);
            if ($prof = mysql_fetch_assoc($rs))
            {
                $prof['nom_cs'] = str_replace(" ", "&nbsp;", $prof['nom_cs']);
                $row['profe']="<a href='alas.php?fitxa=".$row['profe']."'>".$prof['nom_cs']."</a>";
            }
            
            
        }
        if (isset($row['profe3']))  
        {
            $profe=$row['profe3'];
	        $query_menu = "SELECT * FROM $TABLE_APARTATS WHERE apartat LIKE '$profe'";
	        $rs = mysql_query($query_menu, $alas);
            if ($prof = mysql_fetch_assoc($rs))
            {
                $row['yprofe3']=$lang=='ct'?' i ':' y ';     
                $prof['nom_cs'] = str_replace(" ", "&nbsp;", $prof['nom_cs']);
                $row['profe3']="<a href='alas.php?fitxa=".$row['profe3']."'>".$prof['nom_cs']."</a>";
            }
            
            
         }
        if (isset($row['profe2']))  
        {
            $profe=$row['profe2'];
	        $query_menu = "SELECT * FROM $TABLE_APARTATS WHERE apartat LIKE '$profe'";
	        $rs = mysql_query($query_menu, $alas);
            if ($prof = mysql_fetch_assoc($rs))
            {
                $row['yprofe2']=$lang=='ct'?' i ':' y ';     
                $prof['nom_cs'] = str_replace(" ", "&nbsp;", $prof['nom_cs']);
                $row['profe2']="<a href='alas.php?fitxa=".$row['profe2']."'>".$prof['nom_cs']."</a>";
            }
            
        }
        
        if (isset($row['profe3']))  $row['yprofe2']=", ";

		
		$row['profes']=$row['profe'].$row['yprofe2'].$row['profe2'].$row['yprofe3'].$row['profe3'];
        
        //$row['profes'] = htmlentities($row['profes'], null, 'utf-8');
        
        return $row['profes'];
}

//************************************************
//************************************************
//************************************************

function peu($alas=null,$fitxa_peu=null,$lang)
{
    global $TABLE_APARTATS,$lang;
//	require_once('Connections/alasdb.php'); 
	if (!$fitxa_peu) $fitxa_peu="999";
	
	//mysql_select_db($database_alas, $alas);
	$query_alas = "SELECT * FROM $TABLE_APARTATS WHERE apartat ='".$fitxa_peu."'";
	$rs = mysql_query($query_alas, $alas) or die(mysql_error());
	$row_alas = mysql_fetch_assoc($rs);
	$totalRows_alas = mysql_num_rows($rs);
	
	$textscroll= ($lang=="ct")?$row_alas['text_ct']:$row_alas['text_cs']; 
	if (substr($textscroll,strlen($textscroll)-1,1)=="\n") $textscroll=substr($textscroll,0,strlen($textscroll)-2);
	//$textscroll="Un espacio de crecimiento art�stico y personal";
	 
	return $textscroll; 
	mysql_free_result($rs);    
}

//************************************************
//************************************************
//************************************************
function calendario()
{
    
	global $TABLE_APARTATS,$alas,$lang;
	
	
 	$query_apartat = "SELECT * FROM $TABLE_APARTATS WHERE apartat='F0402'";
	$apartat = mysql_query($query_apartat, $alas) or die(mysql_error());
	$row_apartat=mysql_fetch_array($apartat);
	
	$query_calendario="SELECT *,'cajetin_calendario.lbi' as plantilla,MONTH(data) as month FROM $TABLE_APARTATS WHERE apartat LIKE 'F%' AND calendario=1  AND data >= NOW() ORDER BY data ASC";
 	$calendario[0]=mysql_query($query_calendario, $alas) or die(mysql_error());             
  
	$locale=$lang=='ct'?'catalan':'es_ES';
	//$locale=$lang=='ct'?'"ca_ES.utf8"':'es_ES.utf8';
	setlocale(LC_ALL, $locale);
  //setlocale(LC_TIME, 'ca_ES', 'Catalan_Spain', 'Catalan');
	$out="";
	$mes=0;
 while ($row = mysql_fetch_assoc($calendario[0]))
 {
    if (!empty($row['profe'])){
      $row['profes']=profes($row,$alas);
      $row['sep']='/';      
    }
   
    //$row['nom_'.$lang]=strtoupper($row['nom_'.$lang]);
    $row['text2_'.$lang]=str_replace('<br/>','',$row['text2_'.$lang]);
    $row['text2_'.$lang]=str_replace('<br>','',$row['text2_'.$lang]);
   
    $nommes=strtoupper(strftime("%B",strtotime($row['data'])));
    $nommes=utf8_encode($nommes);
    
    $row['mes']=ucfirst(strftime("%b",strtotime($row['data'])));
//    $row['dia']=strftime("%#d",strtotime($row['data']));
    $row['dia']=strftime("%e",strtotime($row['data']));
    
    if (empty($row['dia'])) $row['dia']=strftime("%#d",strtotime($row['data']));
    /*
    */   
     if ($row['month']!=$mes) $out.='<h3 class="mesos">'. $nommes.'</h3>';
    else  $out.='<hr/>';

    $row['data']=cambiaf_a_normal($row['data']);
    $mes=$row['month'];
    $t=load_plantilla('plantilles/cajetin_calendario.lbi',$row,$lang);
    $out.=$t->get("OUT");
 }
 
  //$row_apartat['COL0']=$out;
  //$t2=load_plantilla($row_apartat['plantilla'],$row_apartat);


	mysql_free_result($apartat);
	mysql_free_result($calendario[0]);
	//$torna=$t->get("COL0"); #000000
  //return $torna;
  return $out;
	
}

//************************************************
//************************************************
//************************************************
function creaciones()
{
    
	global $TABLE_APARTATS,$alas,$lang;
	
	$lang=0;
	
	$query_apartat = "SELECT * FROM $TABLE_APARTATS WHERE apartat='F0502'";
	$apartat = mysql_query($query_apartat, $alas) or die(mysql_error());
	$row_apartat=mysql_fetch_array($apartat);
	
	$query_creaciones="SELECT * FROM $TABLE_APARTATS WHERE apartat LIKE 'F98%' AND nom_cs<>'' ORDER BY apartat DESC";
	$creaciones[0]=mysql_query($query_creaciones, $alas) or die(mysql_error());             
  
	$t=cols_plantilla($row_apartat,$creaciones);
	mysql_free_result($apartat);
	mysql_free_result($creaciones[0]);
	$torna=$t->get("COL0"); #000000
    return $torna;
	
}

function galeria($dir)
{
	global $TABLE_APARTATS,$alas,$lang;
	if (!isset($dir)) $dir='galeria/';
    $files=scan_Dir($dir,"gif;jpg;JPG;jpeg;swf");
	   $torna='<div class="galeria-fotos">';
	    foreach ($files as $kay => $val)
	    {
 			$c++;
			$br="";
			//if (($c%15)==0) $br="<br>";
          $l=strlen($val);
          $smal=substr($val,$l-9,9);
          $nom=substr($val,0,$l-10);
		  
          //$edicio="08/";
		  $exten=substr($val,$l-4,$l);  
          if (strtolower($smal)!="small.jpg")  $exten=substr($val,$l-4,$l); 
          if (strtolower($smal)=="small.jpg")
          {
           // lightbox //		   
		   $torna.='<div class="fotogal"><a href="'.$dir.$edicio.$nom.$exten.'" class="fotogal fotoborde"  rel="lightbox[a]" ><img src="'.$dir.$edicio.$val.'"  border="0" class="seixanta"></a></div>'; 
       }
            
      } 
     $torna.='<div class="fotogal" style="float:none">&nbsp;</div>';
     $torna.='</div>';
      return $torna;
}

function fotos_creaciones($id,$tipo="F")
{
		global $TABLE_APARTATS,$lang;

        $id=str_replace("F",$tipo,$id);
        $files=scan_Dir('img_creaciones/',"gif;jpg;jpeg;swf");
		
		$images="imágenes";
		if ($lang=="ct") $images="imatges";//$lang=0;

	   // $torna='<div class="fotovideo">'.$images.'<br></div>';
     $torna.='<div class="galeria-fotos">';
        
	    foreach ($files as $kay => $val)
	    {
			$br="";
          $l=strlen($val);
          $smal=substr($val,$l-9,9);
          $nom=substr($val,0,$l-10); 
          
          $fit=substr($val,0,5);  
          
          if ($fit!=$id) continue;
            $c++;
          		  
		  $exten=substr($val,$l-4,$l);  
          if ($smal!="small.jpg")  $exten=substr($val,$l-4,$l); 
          if ($smal=="small.jpg")
          {
			 $torna.='<div class="fotogal"><a href="img_creaciones/'.$edicio.$nom.$exten.'" class="fotogal fotoborde"  rel="lightbox[a]" ><img src="img_creaciones/'.$edicio.$val.'"  border="0" class="seixanta"></a></div>'; 
          } 
            
      } 
      
     $torna.='<div class="fotogal" style="float:none">aaaaaaaa&nbsp;</div>';
      if ($c<=0) $torna="";
           $torna.='<div style="clear:both">&nbsp;</div>';
     $torna.='</div>';
                 return $torna;
    
}

function detall_creaciones($rou)
{
	global $TABLE_APARTATS,$alas,$lang;
	

    $video='<div class="fotovideo" style="">video<br></div>';
	
	$query_apartat = "SELECT * FROM $TABLE_APARTATS WHERE apartat='".$rou['apartat']."'";
	$qvideo = mysql_query($query_apartat, $alas) or die(mysql_error());	
	$row_apartat=mysql_fetch_array($qvideo);
        
    if ($row_apartat['link']!="")
    {
		$fotovid=substr($row_apartat['link'],0,-4).".jpg";
		if (file_exists("img_creaciones/".$fotovid))
		{
			$nom=$fotovid;
		}else{
		   $nom="V9808_01";
		   $exten="_small.jpg";
	   }
		 $video.='<div class="fotogal fotoborde" style="margin-left:5px;height:65px;width:95px;background-image:url(img_creaciones/'.$fotovid.')"><br><br><div style="background-color:#222222;height:33px;"><a href="video.php?file='.$row_apartat['link'].'" class="lightwindow" params="lightwindow_width=480,lightwindow_height=360,lightwindow_loading_animation=true,lightwindow_type=external" title="video: '.$row_apartat['subtitol_'.$lang].'">'.$row_apartat['subtitol_'.$lang].'</a></div></div>';  

       $rou['video']=$video."<br><br>&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    
    
	mysql_free_result($qvideo);
    
    $rou['fotos']=fotos_creaciones($rou['apartat']); 
    return $rou;
}

function videos($dir="img_creaciones/")
{
	global $TABLE_APARTATS,$alas,$lang;
	if (!isset($dir)) $dir='img_creaciones/';
    $files=scan_Dir($dir,"flv");
	
	    foreach ($files as $kay => $val)
	    {
 			$c++;
			$br="";
          $l=strlen($val);
          $nom=substr($val,0,$l-4);
		  
 		  $exten=substr($val,$l-4,$l);  
           if (true)
          {
		  $nomvideo=str_replace("_"," ",$nom);
		 $video.='<div class="fotogal fotoborde" style="margin-left:5px;height:65px;width:95px;background-image:url(img_creaciones/'.$nom.'.jpg)"><br><br><div style="background-color:#222222;height:33px;"><a href="video.php?file='.$nom.$exten.'" class="lightwindow" params="lightwindow_width=480,lightwindow_height=360,lightwindow_loading_animation=true,lightwindow_type=external" title="video: '.$nomvideo.'">'.$nomvideo.'</a></div></div>';  
          }
            
      } 
      
      return $video;
}


?>