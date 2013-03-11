<?php 

//require("template.inc");     
include("template.inc");     

//require_once('../plantilles/Connections/alasdb.php'); 


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
// Pel tema de register globals
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
getpost_ifset(array('image_root','filtre','ck'));
//extract($_GET);                 r
//extract($_POST,EXTR_SKIP);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
// Idiomes
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
$extensio_lang=array('_cs','_ct','_gl','_eu','_en','_fr','_it','_po','_ar');
$extensio_lang['cast']='_cs';
$extensio_lang['cat']='_ct';
$extensio_lang['gal']='_gl';
$extensio_lang['eus']='_eu';
$extensio_lang['eng']='_en';
$extensio_lang['fr']='_fr';
$extensio_lang['cs']='_cs';
$extensio_lang['ct']='_ct';
$extensio_lang['gl']='_gl';
$extensio_lang['eu']='_eu';
$extensio_lang['en']='_en';


$root_plantilles='./plantilles/';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
// Retorna el seg�ent Id Autonum per insertar un registre 
// rs �s recordset
// camp �s el camp
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
function autonum($rs,$camp='Id')
{


}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
// Diu true si el fitxer compleix les restriccions de filtre. Filtre es algo aixi: jpg;gif;swf  (separador ;)
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77

function filtre_file($file,$filtre)
{
  if ((!isset($filtre))||(empty($filtre))||(!$filtre)) return true;


  $tipus=explode(';',$filtre);
    $ast=array_search('*',$tipus);
    $dr=is_Dir($file);
  if ($ast && $dr)
    return true; 
  
  $ok=false;
  foreach ($tipus as $key => $val)
  {
                  
    $ok=($ok || (!strcmp(extensio_file($file),$val)));
  }

  return $ok;
    
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
// Retorna l'string de l'extensio d'un file. p.ex:  extensio_file("aaaa.bbb") retorn "bbb" 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77

function extensio_file($file)
{
  $tipus=explode('.',$file);
  end($tipus);
  $tip=pos($tipus);
  return $tip;
    

}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
// Retorna un array amb elements del directori. Si recurse=true inclou subdirs. Si full_nom=true fa tot el path.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
function scan_Dir($dir,$filtre=false,$recurse=false,$full_nom=false) {
  $arrfiles = array();
  
  $onsom=getcwd();
  if (is_dir($dir)) {
      if ($handle = opendir($dir)) {
          chdir($dir);
          while (false !== ($file = readdir($handle))) {
              if ($file != "." && $file != "..") {
                  if (is_dir($file)&&$recurse) {
                      $arr = scan_Dir($file,$filtre,$recurse,$full_nom);
                      foreach ($arr as $value) {
                          if ($full_nom) $arrfiles[] = $dir."/".$value;
						  else $arrfiles[] = $value;
                      }
                  } else {
				  		  if (filtre_file($file,$filtre))
				  			{
                            	//$arrfiles[] = $dir."/".$file;						
                				if (!(is_dir($file))||($recurse)) {
						  			if ($full_nom) $arrfiles[] = $dir."/".$file;
						  			else $arrfiles[] = $file;       
								}
                            }           
						  }
              }
          }
          chdir("../");
      }
      closedir($handle);
  }
  chdir($onsom);
  return $arrfiles;
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
/////  Valida si estem en sessio admin comparant amb clave. La clave t� un valor per defecte.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77

function valida_admin($nolog="nolog.htm")
	{
		// Per evitar validarse quan es depura	
	  // return true;               //___ALEX
        session_start();
		if ($_SESSION['pass']=="ok") return true;		
		header("location: ".$nolog);


	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
///// Parsea una plantilla (nom) amb l'array valors i en idoma lang
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77

function load_plantilla($nom="plantilla.lbi",$valors=null,$lang=0)
 {
    global $extensio_lang;
    global $root_plantilles;
 	 
     	
 	if (!strstr($nom,'/')) $nom=$root_plantilles.$nom;
	$t=new Template();
	$t->set_file("page",$nom);
	
    if (is_array($valors))
    {
        $t=set_valors($t,$valors,$lang);
		$t->parse("OUT","page");
			
	}
	
	return $t;
 }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
///// afegeix una plantilla a $t. pren els valors que li passo i busca el camp 'plantilla'. Si no hi �s decideix que �s
///// 'plantilla.lbi'
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77

function add_plantilla($t,$valors=null,$lang=0)
 {
    global $extensio_lang;
    global $root_plantilles;
    $plantilla='plantilla.lbi';    
    if (!isset($t)) {      $t=new Template();      //$t->debug=true;    
	}	
	
	if (!empty($valors['plantilla'])) 
	{
		$plantilla=$valors['plantilla'];
		if (substr($plantilla,strlen($plantilla)-4)!='.lbi') $plantilla=$plantilla.'.lbi';
	}
 	if (!strstr($plantilla,'/')) $plantilla=$root_plantilles.$plantilla;
	$t->set_file($plantilla,$plantilla);
    if (is_array($valors))
    {
       $t=set_valors($t,$valors,$lang);       $t->set_var("");        $t->parse("OUT",$plantilla,true);	
	}       	
	   
	return $t;
 }

 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
///// afegeix una plantilla a t utilitzant el bloc 'caixa'
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
function add_caixa_plantilla($t,$valors=null,$lang=0)
 {

    global $root_plantilles;     	 
    $plantilla='plantilla.lbi';

    
	if (!empty($valors['plantilla'])) 
	{
		$plantilla=$valors['plantilla'];
		if (substr($plantilla,strlen($plantilla)-4)!='.lbi') $plantilla=$plantilla.'.lbi';
	}
 	if (!strstr($plantilla,'/')) $plantilla=$root_plantilles.$plantilla;
    	
	
    if (is_array($valors))
    {
        $t=set_valors($t,$valors,$lang);
		$t->parse("c","caixa",true);		
	}
	
	return $t;
 }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
///// Parsea una plantilla (nom) amb valors de return d'un query en idoma lang i la treu per pantalla
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
function print_plantilla($nom="plantilla.lbi",$valors=null,$lang=0)
{
  $t=load_plantilla($nom,$valors,$lang);
  $t->p("OUT");
  
  return $t;
}
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
///// treu per pantalla el template t que ja est� parseat.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
function print_t_plantilla($t)
{
  $t->p("OUT");
  return $t;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
///// treu per pantalla el tots els registres de rs a partir d'un bloc de plantilla
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
function load_caixa_plantilla($rs=null,$lang=0)
{
    global $root_plantilles;
    $plantilla='plantilla.lbi';
    if (!isset($rs)) return null;   
    $row = mysql_fetch_assoc($rs);
	if (!empty($row['plantilla'])) 
	{
		$plantilla=$row['plantilla'];
		if (substr($plantilla,strlen($plantilla)-4)!='.lbi') $plantilla=$plantilla.'.lbi';
        if (!strstr($plantilla,'/')) $plantilla=$root_plantilles.$plantilla;
	}       
    
	$t=new Template();
	$t->set_file("page",$plantilla);
  $t->set_block("page","caixa","c");
    do{
	    $t=add_caixa_plantilla($t,$row,$lang);                      
    }while ($row = mysql_fetch_assoc($rs));              
    $t->parse("OUT","page");
//    $t->p("OUT");       return $t;

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
///// treu per pantalla el tots els registres de rs
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
function load_recordset_plantilla($rs=null,$lang=0,$plantilla='plantilla.lbi')
{
    if (!isset($rs)) return null;    $row = mysql_fetch_assoc($rs);    do{	    if (!empty($row['plantilla'])) 
	    {
		    $plantilla=$row['plantilla'];		    if (substr($plantilla,strlen($plantilla)-4)!='.lbi') $plantilla=$plantilla.'.lbi';
	    }
		else
		{
			$row['plantilla']=$plantilla;
		}
    $t=add_plantilla($t,$row,$lang);
 }
 while ($row = mysql_fetch_assoc($rs));    
 
 return $t;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
///// Carrega plantilla donada a row i li casca les columnes amb dades de cols
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
function cols_plantilla($row,$cols,$lang=0)
{
    if (!isset($row)) return null;
    if (!isset($cols)) return null;
	    if (!empty($row['plantilla'])) 
	    {
		    $plantilla=$row['plantilla'];
		    if (substr($plantilla,strlen($plantilla)-4)!='.lbi') $plantilla=$plantilla.'.lbi';
	    } 
        foreach($cols as $k => $v)
        {           $cajetines=load_recordset_plantilla($v);
            $columna=$cajetines->get_var("OUT");
            $row['COL'.$k]=$columna;
        }
        $t=add_plantilla($t,$row,$lang);        
		return $t;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
///// Assigna els valors de l'array valors a t. Utilitza l'idioma lang.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
function set_valors($t,$valors,$lang)
{
    global $extensio_lang;
    $sufix_idioma="_".$lang;    if (is_numeric($lang)) $sufix_idioma=$extensio_lang[$lang];	while(list($k,$v)=each($valors))	{
        $comp=strcmp(substr($k,0,3),'COL');
        if ($comp!=0) $v=nl2brk($v);
	// selecciona el text en l'idioma correcte
		$l=strlen($k)-3;
		$var_lang=substr($k,$l,3);					if ($var_lang==$sufix_idioma)
			$k=substr($k,0,$l);	// si �s una imatge gif o jpg la carrega
		$var_ext=strtolower(substr($v,$l,3));
		if ($var_ext=="gif"||$var_ext=="jpg")		$v='<img src="'.$v.'">';	// si �s flash	
		if ($var_ext=="swf")
			$v=flash($v);		$t->set_var($k,$v);	}	   
			return $t;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
// Genera el codi per presentar flash. 
// Si no passem les mides s'adapta al 100% de la quadr�cula
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
 function flash($file,$width=false,$height=false,$ver='6,0,29')
// Genera el codi per presentar flash. 
// Si no passem les mides s'adapta al 100% de la quadr�cula
 {
    if (!(is_file($file))) return; 
     
    $mida=getimagesize($file); 
    if (!$width) $width=$mida[0];
    if (!$height) $height=$mida[1];
  
 	if ($width) $mida=' width="'.$width.'" ';
	if ($height) $mida.=' height="'.$height.'" ';
 	
    $codi= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version='.$ver.',0"'.$mida.'>';
    $codi.= '<param name="movie" value="'.$file.'">';
	$codi.= '<param name="quality" value="high">';
    $codi.= '<embed src="'.$file.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" ></embed></object>';

	return $codi;
 }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
//  treu una imatge 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77 
 function mostra_imatge($file,$w=false,$h=false)
{

    $mida=getimagesize($file); 
    if (!$w) $w=$mida[0];
    if (!$h) $h=$mida[1];

    
    if (filtre_file($file,'gif;jpg;jpeg'))
    {
     echo '<img src="'.$file.'" border="0" width="'.$w.'" height="'.$h.'">';   
    }
    if (filtre_file($file,'swf')) 
    {
      echo flash($file);
    }
    


} 

//////////////////////////////////////////////////////
//  recupera idioma de la sessi�, si no de la cookie i 
//  si no lo posa el perdefecte
/////////////////////////////////////////////////////
function recupera_idioma($lang, $perdefecte="cs")
{     $pang=$lang;    session_start();     $browser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);    switch ($browser){        case "ca":        		$browser='ct';            break;        case "es":        		$browser='cs';            break;                default:          /* PROVEM AMB LA COOKIE */            if (isset($_COOKIE['idiomax']))              {                 $browser=$pang=$_COOKIE['idiomax'];                 $_SESSION['idioma']=$pang;               }              else	$browser=$perdefecte;            break;    }

    if(isset($pang)&&(!isset($ck)))
       { 
            $_SESSION["idioma"]=$pang;
            $_COOKIE["idiomax"]=$pang;
           header("Location: $PHP_SELF?ck=1&fitxa=".$_GET['fitxa']);  // ponemos cookie_set  
           exit;                                        // como true 
       }                     // podriamos haber redireccionado a otra pagina    
	   if(isset($_SESSION['idioma']))
        {
           $pang=$_SESSION['idioma']; 
           $_COOKIE["idiomax"]=$pang;          
		} 
    else 
        { 
            $pang=$_SESSION['idioma']=$_COOKIE['idiomax']=$browser;        
		}
		
    if (!$pang)
    {
       $pang=$browser;
        $_COOKIE["idioma"]=$pang;
       $_SESSION['idioma']=$pang;    
   }    
	   
	   return $pang;  
}
//////////////////////////////////////////////////// 
//Convierte fecha de mysql a normal 
//////////////////////////////////////////////////// 
function cambiaf_a_normal($fecha){ 
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha); 
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]; 
    return $lafecha; 
} 
//////////////////////////////////////////////////// 
//Convierte fecha de normal a mysql 
//////////////////////////////////////////////////// 
function cambiaf_a_mysql($fecha){ 
    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha); 
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]; 
    return $lafecha; 
} 
//////////////////////////////////////////////////// 
// retorna el fitxer adequat que acaba amb _lang
// si no retorna el mateix que li passo
//////////////////////////////////////////////////// 


function fitxer_idioma($fitxer,$lang='cat')
{
    $file=pathinfo($fitxer);
    $path=$file['dirname'].'/';
    $arr=explode('.',$file['basename']);
	$nom=$arr[0];//echo 'nom-'.$nom;
    $p=strrpos($nom,'_');
    $base=substr($nom,0,$p);
    $idioma=substr($nom,$p);
	$ext=$file['extension'];//echo 'ext-'.$ext."<br>";
 	$f_idioma=$path.$base."_".$lang.".".$ext;
	//echo $f_idioma."-->";
	if (is_file($f_idioma)) return ($f_idioma);
  	$f_idioma=$path.$base.".".$ext;
   
	if (is_file($f_idioma)) return ($f_idioma);
	
	return($fitxer);
}

//////////////////////////////////////////////////// 
// GENERA UN NOM PER UN FITXER DE FOTO PETITA
// donat un fitxer path/file.ext
// retorn path/file"_peque".ext
//////////////////////////////////////////////////// 

function nom_peque($fitxer)
{
    $file=pathinfo($fitxer);
    $path=$file['dirname'].'/';
    $arr=explode('.',$file['basename']);
	$nom=$arr[0];//echo 'nom-'.$nom;
    $p=strrpos($nom,'_');
    $base=substr($nom,0,$p);
    $idioma=substr($nom,$p);
	$ext=$file['extension'];//echo 'ext-'.$ext."<br>";
 	$f_idioma=$path.$base."_peque.".$ext;
    return($f_idioma);

}


//////////////////////////////////////////////////// /////////////////
// Fa globals les variables amb valor passades com a GET o  POST
//////////////////////////////////////////////////////////////////////

function getpost_ifset($test_vars)
{
    if (!is_array($test_vars)) {
        $test_vars = array($test_vars);
    }

    foreach($test_vars as $test_var) {
        if (isset($_POST[$test_var])) {
            global $$test_var;
            $$test_var = $_POST[$test_var];
        } elseif (isset($_GET[$test_var])) {
            global $$test_var;
            $$test_var = $_GET[$test_var];
        }
   }
}


//////////////////////////////////////////////////// /////////////////
// Retorna un recordset del registres corresponentes a la p�gina $pag 
// a recpag registres per p�gina.
// $query passa la consluta i, per referencia, torna les fletxetes del control.
//////////////////////////////////////////////////////////////////////

function paginacio(&$query,$pag=1,$recpag=5)
{
       // ALEX CENCELA PAGINACIO
       if (true) $recpag=100000;
 
 
       if ($recpag==0) $recpag=100000;
       $recpags=$recpag;
       global $database, $alas;


       if ($pag<1) $pag=1;
       $ini=($pag-1)*$recpag;
       $limit=" LIMIT $ini,$recpags";
       
       mysql_select_db($database, $alas);
       $Recordset1 = mysql_query($query, $alas) or die(mysql_error());
       $totalRows_Recordset1 = mysql_num_rows($Recordset1);
       $fipag=($totalRows_Recordset1)/ $recpag;
       $fipag=ceil($fipag);
       //$fipag++;
       $query.=$limit;
       $Recordset1 = mysql_query($query, $alas) or die(mysql_error());
       $totalRows_Recordset1 = mysql_num_rows($Recordset1);
 
       $ref=$_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"]."&pag=";
       $p=$pag-1;
       $refx="<a href='".$ref.$p."'>[<<] </a>";
       $rev=$pag>1?$refx:"";
 
       $p=$pag+1;
       $refx="<a href='".$ref.$p."'>[>>]</a>";
       $av=$pag<$fipag?$refx:"";
       for ($i=1;$i<=$fipag;$i++)
       {
         if ($i!=$pag)
         {
             $refx="<a href='".$ref.$i."'>$i</a>";
           $pagines.=$refx." ";
         }
         else
         {
             if ($fipag>1)
             {
                  $refx="<span class='fitxa'>$i</a>";
                  $pagines.=$refx." ";
             
             }
          
         }
         
       }
       $query=$rev." ".$pagines." ".$av;
 
        return $Recordset1;
}


function nl2brk($text)
{
    return ($text);
}

?>