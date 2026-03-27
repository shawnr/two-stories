<?PHP
	include("includes.php");
	header('Content-Type: text/xml');
echo '<?xml version="1.0"?>';
echo '<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN"
"http://www.wapforum.org/DTD/wml_1.1.xml">';
?>
<wml>
<card title="Page One"> 
	<?PHP
		if(($_GET['page'] == "") || ($_GET['page'] == 1)){
		//if reading page 1, then display the title and author info
	?>	<p><b>So Random</b></p>
      <p>a dynamic short fiction<br></br>
  by Shawn Rider</p>
      <p align="center">created for you just now:<br></br>
          <?PHP echo date("M d, Y"); ?> </p>
 
	  <?PHP 
	  	}
	
		
		//read proper text
		if($_GET['page'] != "t"){
			displayText("p1");
			displayText("p2");
			displayText("p3");
			displayText("p4");
			
			} elseif ($_GET['page'] == "t"){
			displayText("t", $_GET['keyword']);
			
			$pageNum = "t";
			}
			//end displaying main page text
	
	
	?>
       
	  
</card>
<card title="Page Two"> 
	<p>
	<?PHP
		
		//read proper text
		
			displayText("p5");
			displayText("p6");
			displayText("p7");
			displayText("p8");
			
			
			//end displaying main page text
	
	
	?>
      </p>      
	  
</card>
<card title="Page Three"> 
	<p>
	<?PHP
		
		//read proper text
		
			displayText("p9");
			displayText("p10");
			displayText("p11");
			displayText("p12");
			
			
			//end displaying main page text
	
	
	?>
      </p>      
	  
</card>

	    
</wml>	