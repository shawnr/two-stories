<?PHP
//include information for So Random story
//April 2005
				//db connection info
				  $dbHost = "db475590294.db.1and1.com";
                                  $dbUser = "dbo475590294";
                                  $dbPassword = "FutU2kWXmNnhM6x";
                                  $dbName = "db475590294";

function fixText(){

global $dbHost, $dbUser, $dbPassword, $dbName;
		$link = @mysql_connect($dbHost, $dbUser,$dbPassword);
		 if (!$link)
		    die("Cannot connect : " . mysql_error());
			
		if (!@mysql_select_db($dbName,$link))
		    die("Cannot find database : " . mysql_error());
			
		$result = mysql_query("SELECT sr_text, sr_ID FROM soRandom ORDER BY sr_ID ASC LIMIT 1", $link);
		
		while($row=mysql_fetch_assoc($result)){
			$testText=all_ascii($row['sr_text']);
			$testText = str_replace("'","\'",$testText);
			$testText = str_replace('"','\"',$testText);
			//echo all_ascii( $testText ). "<br /><br />";
			echo $row['id'] . " : " . $testText . "<br /><br />";
			$sql2="UPDATE `soRandom` SET `sr_text`='" . $testText . "' WHERE `sr_ID`='" . $row['sr_ID'] . "'";
	
			echo $sql2;
			$sqlWipe="UPDATE `soRandom` SET `sr_text`='temp' WHERE `sr_ID`='" . $row['sr_ID'] . "'";
			$resultWipe=mysql_query($sqlWipe);
			echo "wipe: " . $sqlWipe . "<br />";
			$result2=mysql_query($sql2, $link);
			if($result2){echo " | " . $row['sr_ID'] . " updated.<br /><hr />";}
		}


}


function all_ascii( $stringIn ){
   $final = '';
   $search = array(chr(145),chr(146),chr(147),chr(148),chr(150),chr(151));
   $replace = array("'","'",'"','"','-','-');

   $hold = str_replace($search[0],$replace[0],$stringIn);
   $hold = str_replace($search[1],$replace[1],$hold);
   $hold = str_replace($search[2],$replace[2],$hold);
   $hold = str_replace($search[3],$replace[3],$hold);
   $hold = str_replace($search[4],$replace[4],$hold);
   $hold = str_replace($search[5],$replace[5],$hold);

   if(!function_exists('str_split')){
       function str_split($string,$split_length=1){
           $count = strlen($string);
           if($split_length < 1){
               return false;
           } elseif($split_length > $count){
               return array($string);
           } else {
               $num = (int)ceil($count/$split_length);
               $ret = array();
               for($i=0;$i<$num;$i++){
                   $ret[] = substr($string,$i*$split_length,$split_length);
               }
               return $ret;
           }
       }
   }

   $holdarr = str_split($hold);
   foreach ($holdarr as $val) {
       if (ord($val) < 128) $final .= $val;
   }
   return $final;
}

//function getText gets the text for a given type
function getStoryText($type){
		global $dbHost, $dbUser, $dbPassword, $dbName;
		$link = @mysql_connect($dbHost, $dbUser,$dbPassword);
		 if (!$link)
		    die("Cannot connect : " . mysql_error());
			
		if (!@mysql_select_db($dbName,$link))
		    die("Cannot find database : " . mysql_error());
			
		$result = mysql_query("SELECT text FROM soRandom WHERE type = '" . $type . "' ORDER BY ID ASC;", $link);
		$tempCounter = 0;
		while ($row = mysql_fetch_assoc($result)) {
   		$text[$tempCounter] = stripslashes($row["text"]);
   		//$text[$tempCounter] = htmlentities($text[$tempCounter], ENT_QUOTES);

		$tempCounter++;
		}
		mysql_close($link);
		return($text);


}//end function getText()

//function getTangentText gets the text for a given type and keyword
function getTangentText($type, $keyword){
		global $dbHost, $dbUser, $dbPassword, $dbName;
		$link = @mysql_connect($dbHost, $dbUser,$dbPassword);
		 if (!$link)
		    die("Cannot connect : " . mysql_error());
			
		if (!@mysql_select_db($dbName,$link))
		    die("Cannot find database : " . mysql_error());
			
		$result = mysql_query("SELECT keywords, text FROM soRandom WHERE type = '" . $type . "' ORDER BY ID ASC;", $link);
		$tempCounter = 0;
		while ($row = mysql_fetch_assoc($result)) {
		$pKey = "/".$keyword."/";
		$pos = preg_match($pKey, $row['keywords']);
		//echo $pos . " is pos<br>";
		//echo $keyword;
		//echo " is keyword and this is the search return: " . $row['keywords'];
   		if($pos != 0){
		$text[$tempCounter] = stripslashes($row["text"]);
		$tempCounter++;
		}
		}
		mysql_close($link);
		//$text=htmlentities($text);
		return($text);


}//end function getTangentText()

//function displayText() shows us a block of text given the type and keyword
function displayText($type, $keyword){
	//echo $type;
		if($type != "t"){
			$thisText = getStoryText($type);
			shuffle($thisText);
			$tempText = htmlentities($thisText[0], ENT_QUOTES);
		} else {
			$thisText = getTangentText($type, $keyword);
			shuffle($thisText);
			$tempText = htmlentities($thisText[0], ENT_QUOTES) . "</p><p>". htmlentities($thisText[1], ENT_QUOTES) . "</p><p>". htmlentities($thisText[2], ENT_QUOTES) . "</p><p>". htmlentities($thisText[3], ENT_QUOTES);

		}// end getting the text, now treat and/or display the text
		
		
		$tempText = findKeywords($tempText);
		$tempText = nl2br($tempText);
		//$tempText=htmlentities($tempText);
		echo $tempText . "</p><p>";
		
}


//function findKeywords() accepts a text string and compares it against a set of keywords
function findKeywords($string){
		//define keywords
		$keywords = array(
			'bus',
			'guy',
			'drive',
			'morning',
			'ride',
			'hospice',
			'nurse',
			'Nurse',
			'chuckie',
			'retard',
			'school',
			'Kenmore',
			'Colvin',
			'headphones',
			'pretending',
			'stop',
			'signs',
			'bother',
			'aisle',
			'boy',
			'Elmwood',
			'Delaware',
			'fare',
			'yellow',
			'Niagara',
			'girl',
			'window',
			'quiet',
			'Goodwill',
			'scream',
			'first',
			'ambulance',
			'paramedics',
			'heart',
			'attack',
			'brain',
			'bad',
			'god',
			'disgusting',
			'nastiness',
			'shit',
			'piss',
			'night',
			'fuck',
			'home',
			'quarter',
			'job',
			'kids',
			'life',
			'teeth',
			'hurt'
			
		
		);//finish writing keywords array
		
				
		//sort keywords and replacements
		ksort($keywords);
		
		
		//replace keywords with strings
		foreach($keywords as $thisKeyword){
		$findThis = "/" . $thisKeyword . "/";
		$replace = "<a href='index.php?page=t&keyword=" . $thisKeyword . "'>" . $thisKeyword . "</a>";
		$string = preg_replace($findThis, $replace, $string);
		}//end loop to replace keywords
		return($string);

}

?>
