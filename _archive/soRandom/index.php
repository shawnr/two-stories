<?PHP
	include("includes.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>So Random by Shawn Rider || a dynamic short fiction</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: medium;
	color: #333333;
	padding: 0px;
	margin-top: 0px;
	margin-right: 10px;
	margin-bottom: 0px;
	margin-left: 150px;
	background-color: #999999;
}
a:link {
	color: #333333;
	text-decoration: none;
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: dotted;
	border-left-style: none;
	border-top-color: #999999;
	border-right-color: #999999;
	border-bottom-color: #999999;
	border-left-color: #999999;
}
a:visited {
	color: #666666;
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: dotted;
	border-left-style: none;
	border-top-color: #999999;
	border-right-color: #999999;
	border-bottom-color: #999999;
	border-left-color: #999999;
}
a:hover {
	color: #666666;
	text-decoration: none;
}
a:active {
	color: #FFFFFF;
	text-decoration: none;
}
.style3 {font-size: small; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="600" border="0" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
  <tr align="left" valign="top">
    <td width="75"><div align="right">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><br>
        </p>
      </div></td>
    <td width="500">
	
	<?PHP
		if(($_GET['page'] == "") || ($_GET['page'] == 1)){
		//if reading page 1, then display the title and author info
	?>	<h2 align="center">&quot;So Random&quot;</h2>
      <p align="center">a dynamic short fiction<br>
  by Shawn Rider</p>
      <p align="center">created for you just now:<br>
          <?PHP echo date("M d, Y"); ?> </p>
      <hr width="100">  
	  <?PHP 
	  	} else {//if page two or three, then format header
	  ?>      <table width="480" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left"><p class="style3">&quot;So Random&quot;</p>          </td>
          <td><div align="right" class="style3">Rider</div></td>
        </tr>
      </table>	  
	  <hr align="center">
	  <br>
	  <p>
        <?PHP
		}//end header setting conditional
		//read proper text
		if(($_GET['page'] == "") || ($_GET['page'] == 1)){
			displayText("p1");
			displayText("p2");
			displayText("p3");
			displayText("p4");
			$pageNum = 1;
			} elseif ($_GET['page'] == 2){
			displayText("p5");
			displayText("p6");
			displayText("p7");
			displayText("p8");
			$pageNum = 2;
			} elseif ($_GET['page'] == 3){
			displayText("p9");
			displayText("p10");
			displayText("p11");
			displayText("p12");
			$pageNum = 3;
			} elseif ($_GET['page'] == "t"){
			displayText("t", $_GET['keyword']);
			
			$pageNum = "t";
			}
			//end displaying main page text
	
	
	?>
      </p>      
	  <br>
	  <hr>
      <div align="right">
	    <strong>
	    <?PHP
	  	if($pageNum != "t") {
			echo "page " .  $pageNum . " of 3 || ";
		}
			  
	  ?>
        <a href="index.php?page=1">1</a> <a href="index.php?page=2">2</a> <a href="index.php?page=3">3</a></strong></div></td>
    <td width="25">&nbsp;</td>
  </tr>
</table>
</body>
</html>
