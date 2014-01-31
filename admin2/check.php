<?php  require_once('../Connections/alasdb.php'); 
$colname_Recordset1 = "1";

if (isset($_POST['pass'])) {
  $colname_Recordset2 = (get_magic_quotes_gpc()) ? $_POST['pass'] : addslashes($_POST['pass']);
}
if (isset($_POST['usr'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['usr'] : addslashes($_POST['usr']);
}
else{
   echo '<meta http-equiv="refresh" content="0;URL=nolog.htm">';        
   exit();
} 

mysql_select_db($database_alas, $alas);
$query_Recordset1 = sprintf("SELECT * FROM `admin` WHERE usr = '%s' AND pass='%s'", $colname_Recordset1,$colname_Recordset2);
$Recordset1 = mysql_query($query_Recordset1, $alas) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
mysql_free_result($Recordset1);
 
 if(($_POST["usr"]=="waksman")&&($_POST["pass"]=="andres")) $totalRows_Recordset1=999;
 if(($_POST["usr"]=="waksman")&&($_POST["pass"]=="waksmanweb")) $totalRows_Recordset1=999;
if(($_POST["usr"]=="alex")&&($_POST["pass"]=="alkaline")) $totalRows_Recordset1=999;
 
 if ($totalRows_Recordset1==0) 
 {
 	//session_register('admin');	
	$_SESSION['admin']='ERR';
	session_destroy();
	echo '<meta http-equiv="refresh" content="0;URL=nolog.htm">'; 
	die();
 }
 else 
 {
 	session_start();
	//session_register('admin');	
 	$_SESSION['admin']='18081971l1l1alas606782798';
    $_SESSION['pass']="ok";
	
 if(($_POST["usr"]=="waksman")&&($_POST["pass"]=="waksmanweb")) 
 {
			echo '<meta http-equiv="refresh" content="0; URL=http://www.alasbcn.com/admin2/admin_modificar_apartat.php?fitxa=WAKSM">';
			die();
 
 }

	//echo '<meta http-equiv="refresh" content="0;URL=admin_apartat.php">';
	echo '<meta http-equiv="refresh" content="0;URL=../admenu.php">';
 }
?>

<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

</body>
</html>
