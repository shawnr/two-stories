<?
///Class for "PiTP" by Shawn Rider
//Created November 1, 2005
//last modified: November 15, 2005
//////////////////////////////////

//////////////////////////////////
// read story from file
// insert junk from database
// fade junk after some time
// provide entry box for junk
//////////////////////////////////



class pitp {
	public $junk=array(); //junk to be inserted into story
	public $junkCount=""; //count of how many junk things are floating around
	public $story=""; //html formatted story to be put into the main page
	public $lastEntry=""; //last entry tag is stored here for use on display page
	public $debug=0; //turn debug on by setting to 1

function pagination(){
//make pagination
	$nextPage=$_GET['pg']+1;
	$prevPage=$_GET['pg']-1;
	switch($_GET['pg']){
		case "":
			$nextPage=$nextPage+1;
			$pre = "";
			$next = " | | <a href='?pg=" . $nextPage . "'>next</a>";
			for($i==1; $i<=8; $i++){
				if($i != $_GET['pg']){
					$mid.= " | <a href='?pg=" . $i . "'>" . $i . "</a>";
				}elseif($i==$_GET['pg']){
					$mid.= " | " . $i;
				}
			}
		break;
			case "1":
			$nextPage=$nextPage+1;
			$pre = "";
			$next = " | | <a href='?pg=" . $nextPage . "'>next</a>";
			for($i==1; $i<=8; $i++){
				if($i != $_GET['pg']){
					$mid.= " | <a href='?pg=" . $i . "'>" . $i . "</a>";
				}elseif($i==$_GET['pg']){
					$mid.= " | " . $i;
				}
			}
			break;
			case "2":
			$pre = "<a href='?pg=" . $prevPage . "'>previous</a>";
			$next = " | | <a href='?pg=" . $nextPage . "'>next</a>";
			for($i==1; $i<=8; $i++){
				if($i != $_GET['pg']){
					$mid.= " | <a href='?pg=" . $i . "'>" . $i . "</a>";
				}elseif($i==$_GET['pg']){
					$mid.= " | " . $i;
				}
			}
			break;
			case "3":
			$pre = "<a href='?pg=" . $prevPage . "'>previous</a>";
			$next = " | | <a href='?pg=" . $nextPage . "'>next</a>";
			for($i==1; $i<=8; $i++){
				if($i != $_GET['pg']){
					$mid.= " | <a href='?pg=" . $i . "'>" . $i . "</a>";
				}elseif($i==$_GET['pg']){
					$mid.= " | " . $i;
				}
			}
			break;
			case "4":
			$pre = "<a href='?pg=" . $prevPage . "'>previous</a>";
			$next = " | | <a href='?pg=" . $nextPage . "'>next</a>";
			for($i==1; $i<=8; $i++){
				if($i != $_GET['pg']){
					$mid.= " | <a href='?pg=" . $i . "'>" . $i . "</a>";
				}elseif($i==$_GET['pg']){
					$mid.= " | " . $i;
				}
			}
			break;
			case "5":
			$pre = "<a href='?pg=" . $prevPage . "'>previous</a>";
			$next = " | | <a href='?pg=" . $nextPage . "'>next</a>";
			for($i==1; $i<=8; $i++){
				if($i != $_GET['pg']){
					$mid.= " | <a href='?pg=" . $i . "'>" . $i . "</a>";
				}elseif($i==$_GET['pg']){
					$mid.= " | " . $i;
				}
			}
			break;
			case "6":
			$pre = "<a href='?pg=" . $prevPage . "'>previous</a>";
			$next = " | | <a href='?pg=" . $nextPage . "'>next</a>";
			for($i==1; $i<=8; $i++){
				if($i != $_GET['pg']){
					$mid.= " | <a href='?pg=" . $i . "'>" . $i . "</a>";
				}elseif($i==$_GET['pg']){
					$mid.= " | " . $i;
				}
			}
			break;
			case "7":
			$pre = "<a href='?pg=" . $prevPage . "'>previous</a>";
			$next = " | | <a href='?pg=" . $nextPage . "'>next</a>";
			for($i==1; $i<=8; $i++){
				if($i != $_GET['pg']){
					$mid.= " | <a href='?pg=" . $i . "'>" . $i . "</a>";
				}elseif($i==$_GET['pg']){
					$mid.= " | " . $i;
				}
			}
			break;
			case "8":
			$pre = "<a href='?pg=" . $prevPage . "'>previous</a>";
			$next = "";
			for($i==1; $i<=8; $i++){
				if($i != $_GET['pg']){
					$mid.= " | <a href='?pg=" . $i . "'>" . $i . "</a>";
				}elseif($i==$_GET['pg']){
					$mid.= " | " . $i;
				}
			}
			break;

	}
	echo $pre.$mid.$next;
}
function make_story(){
//make story and put it in variable

	switch($_GET['pg']){ //figure out what page we're on
		case "":
			$filename="story1.txt";
			$filesize=filesize($filename);
			$handle = fopen($filename, r);
			$plain_story = fread($handle, $filesize);
			fclose($handle);
		break;
		case "1":
			$filename="story1.txt";
			$filesize=filesize($filename);
			$handle = fopen($filename, r);
			$plain_story = fread($handle, $filesize);
			fclose($handle);
		break;
		case "2":
			$filename="story2.txt";
			$filesize=filesize($filename);
			$handle = fopen($filename, r);
			$plain_story = fread($handle, $filesize);
			fclose($handle);
		break;
		case "3":
			$filename="story3.txt";
			$filesize=filesize($filename);
			$handle = fopen($filename, r);
			$plain_story = fread($handle, $filesize);
			fclose($handle);
		break;
		case "4":
			$filename="story4.txt";
			$filesize=filesize($filename);
			$handle = fopen($filename, r);
			$plain_story = fread($handle, $filesize);
			fclose($handle);
		break;
		case "5":
			$filename="story5.txt";
			$filesize=filesize($filename);
			$handle = fopen($filename, r);
			$plain_story = fread($handle, $filesize);
			fclose($handle);
		break;
		case "6":
			$filename="story6.txt";
			$filesize=filesize($filename);
			$handle = fopen($filename, r);
			$plain_story = fread($handle, $filesize);
			fclose($handle);
		break;
		case "7":
			$filename="story7.txt";
			$filesize=filesize($filename);
			$handle = fopen($filename, r);
			$plain_story = fread($handle, $filesize);
			fclose($handle);
		break;
		case "8":
			$filename="story8.txt";
			$filesize=filesize($filename);
			$handle = fopen($filename, r);
			$plain_story = fread($handle, $filesize);
			fclose($handle);
		break;

	}//end of page switch
	if($_GET['c']!=1){
	$this->get_junk();
	}
	$work_story=$plain_story;

	$text_length=strlen($work_story);
	$word_count=str_word_count($work_story);
	$story_words=str_word_count($work_story, 2);
	$break_point=count($story_words)/($this->junkCount+1);
	$break_point=intval($break_point);
	if($break_point<=0){$break_point=1;}
	if($this->debug==1){echo $break_point;}

	$count=0;
	$junkCounter=0;
	$twoDay=48*60*60;
	$day=24*60*60;
	$halfDay=12*60*60;
	$quarterD=4*60*60;
	$recent=2*60*60;
	foreach($story_words as $key=>$data){
	//figure out char positions for inserting junk

		if($count==$break_point){
			//figure out what color it should be
			$difference=date("U")-$this->junk[$junkCounter]['date'];
			if($difference>$day){
				$temp_junk="<span class='yellow4'>" . $this->junk[$junkCounter]['comment'] . "</span>";
			}
			if(($difference<=$day)&&($difference>$quarterD)){
				$temp_junk="<span class='yellow3'>" . $this->junk[$junkCounter]['comment'] . "</span>";
			}
			if(($difference<=$quarterD)&&($difference>$recent)){
				$temp_junk="<span class='yellow2'>" . $this->junk[$junkCounter]['comment'] . "</span>";
			}
			if(($difference<=$recent)){
				$temp_junk="<span class='yellow1'>" . $this->junk[$junkCounter]['comment'] . "</span>";
			}

			$junkCounter=$junkCounter+1;
			$position=$key+$positionMod;
			$work_story= $this->str_inject($work_story, $temp_junk, $position);
			$count=0;
			$positionMod=$positionMod+strlen($temp_junk);
		}else{
			$count=$count+1;
		}
	}

	//if($this->debug==1){print_r($story_words);}
	$this->story=nl2br($work_story);

}

function str_inject($str, $injection, $pos){
     $a= substr($str, 0, $pos);
     $b= substr($str, $pos, strlen($str));
     $temp=$a.$injection.$b;
	 return($temp);
}

function get_junk(){
//grab junk for this reading
	include('dbConnect.php');
	$this->mysql_login($host, $user, $pass, $dbname);
	$thisDate=date("U")-48*60*60;
	$sql="SELECT * FROM pitp_comments
	WHERE pitp_timestamp >='" . $thisDate . "' ORDER BY RAND() LIMIT 50";
		if($this->debug==1){echo $sql;}
	$result=mysql_query($sql);
	$counter=0;
	$numJunk = mysql_num_rows($result);
	while($row=mysql_fetch_assoc($result)){
		$this->junk[$counter]['comment']=stripslashes($row['pitp_comment']);
		$this->junk[$counter]['date']=$row['pitp_timestamp'];
		$counter=$counter+1;
	}

	if($numJunk<'5'){
	//fill out with results from previously entered comments
		//echo "not enough junk";
	$sql="SELECT * FROM pitp_comments ORDER BY RAND() LIMIT 5";
	$result=mysql_query($sql);
		while($row=mysql_fetch_assoc($result)){
			$this->junk[$counter]['comment']=stripslashes($row['pitp_comment']);
			$this->junk[$counter]['date']=$row['pitp_timestamp'];
			$counter=$counter+1;
		}
	}


	$this->junkCount=count($this->junk);
	$this->last_entry();
	mysql_close();

}
function last_entry(){
	$this->lastEntry="";
 	$sql = 'SELECT * FROM `pitp_comments` ORDER BY `pitp_timestamp` DESC LIMIT 1';	$result=mysql_query($sql);
	$row=mysql_fetch_assoc($result);
	$this->lastEntry = "last contribution: " . date('m/d/y h:i a', $row['pitp_timestamp']);

}
function insert_junk(){
//insert junk into database with this function

	if(($_POST['Submit'])&&($_POST['p']!="")){
		include('dbConnect.php');
		$this->mysql_login($host, $user, $pass, $dbname);
		$junk=trim(addslashes(strip_tags($_POST['p'])));
		if(strlen($junk)>500){substr($junk, 0, 500);}
		$sql="INSERT INTO `pitp_comments` (`pitp_id`, `pitp_comment`, `pitp_timestamp`)
		VALUES('','" . $junk . "', '" . date("U") . "')";
		$result=mysql_query($sql);
		mysql_close();
	}

}

function mysql_login($host, $user, $pass, $dbname){

		define("CONNECTION", mysql_pconnect($host, $user, $pass));
		if (!CONNECTION)
		{
			 echo "The Mysql server is down please check again later.";
			 exit;
		}

		#make the connection to the specific database
		$db=mysql_select_db($dbname, CONNECTION);
		if (!$db)
		{
			 echo "The database server is missing please check again later.";
			 exit;
		}

}


}//end of class

?>
