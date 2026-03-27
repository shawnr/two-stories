<?PHP
//include information for So Random story
//April 2005
				//db connection info
				  $dbHost = "db475590294.db.1and1.com";
				  $dbUser = "dbo475590294";
				  $dbPassword = "FutU2kWXmNnhM6x";
				  $dbName = "db475590294";

//function getText gets the text for a given type
function getStoryText($type){
		global $dbHost, $dbUser, $dbPassword, $dbName;
		$link = @mysql_connect($dbHost, $dbUser,$dbPassword);
		 if (!$link)
		    die("Cannot connect : " . mysql_error());
			
		if (!@mysql_select_db($dbName,$link))
		    die("Cannot find database : " . mysql_error());
			
		$result = mysql_query("SELECT sr_text FROM soRandom WHERE sr_type = '" . $type . "' ORDER BY sr_ID ASC;", $link);
		$tempCounter = 0;
		while ($row = mysql_fetch_assoc($result)) {
   		$text[$tempCounter] = stripslashes($row["sr_text"]);
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
			
		$result = mysql_query("SELECT sr_keywords, sr_text FROM soRandom WHERE sr_type = '" . $type . "' ORDER BY sr_ID ASC;", $link);
		$tempCounter = 0;
		while ($row = mysql_fetch_assoc($result)) {
		$pKey = "/".$keyword."/";
		$pos = preg_match($pKey, $row['sr_keywords']);
		//echo $pos . " is pos<br>";
		//echo $keyword;
		//echo " is keyword and this is the search return: " . $row['keywords'];
   		if($pos != 0){
		$text[$tempCounter] = stripslashes($row["sr_text"]);
		$tempCounter++;
		}
		}
		mysql_close($link);
		//$text=htmlentities($text);
		return($text);


}//end function getTangentText()

//function displayText() shows us a block of text given the type and keyword
function displayText($type, $keyword=''){
	//echo $type;
		if($type != "t"){
			$thisText = getStoryText($type);
			shuffle($thisText);
			$tempText = $thisText[0];
		} else {
			$thisText = getTangentText($type, $keyword);
			shuffle($thisText);
			$tempText = $thisText[0] . "</p><p>". $thisText[1] . "</p><p>". $thisText[2] . "</p><p>". $thisText[3];

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
