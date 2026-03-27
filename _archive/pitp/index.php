<?
require_once('recaptcha/recaptchalib.php');

// Get a key from http://recaptcha.net/api/getkey
$publickey = "6LchMgAAAAAAAPjj60hxbKAM2v-iTBCZK1qXxm6O";
$privatekey = "6LchMgAAAAAAAH5v2Rw18SeoQN5uqLb71Qv9D2ZX";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

include('pitp.php');
$pitp=new pitp;
$pitp->debug=0;

# was there a reCAPTCHA response?
if ($_POST["recaptcha_response_field"]) {
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);

        if ($resp->is_valid) {
                $pitp->insert_junk();
        } else {
                # set the error code so that we can display it
                $error = $resp->error;
                die($error);
        }
}

$pitp->make_story();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PiTP || A Participatory Digital Fiction by Shawn Rider</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="pitp.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-color: #CCCCCC;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style1 {font-size: small}
body,td,th {
	color: #000000;
}
a:link {
	color: #006699;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #333333;
}
a:hover {
	text-decoration: underline;
	color: #003366;
}
a:active {
	text-decoration: none;
	color: #666666;
}
</style>
<script>
 var RecaptchaOptions = {
    theme : 'white'
 };
 </script>
</head>

<body>

<table width="740" border="0" cellspacing="0" cellpadding="15">
  <tr>
    <td width="300" align="left" valign="top" bgcolor="#CCCCCC"><p><strong>About this story:</strong></p>
    <p class="style1">You are reading a dynamic short fiction. You are invited to participate however you'd like. Thanks for your time. If you're interested in more work like this, please check out the <a href="http://shawnrider.com/written/">Writing</a> page on my site, <a href="http://shawnrider.com">shawnrider.com</a>. </p>
    <form name="form1" id="form1" method="post" action="?pg=<? echo $_GET['pg'];?>">
      <div align="left">
        <p>
          <textarea name="p" cols="20" rows="8" id="p" style="width:300px;"></textarea>
        </p>
        <p class="style1">
            <?php echo recaptcha_get_html($publickey, $error); echo $error;?>
        </p>
        <p>
          <input type="submit" name="Submit" value="Submit" />
        </p>
      </div>
    </form>
    <p class="style1"><? echo $pitp->lastEntry; ?></p>
    <p>
	<? if($_GET['c']!='1'){?>
	<a href="?c=1&pg=<?PHP echo $_GET['pg'];?>">Click here to clean the pool.</a>
	<? }else{?>
	<a href="?pg=<?PHP echo $_GET['pg'];?>">Click here to disable pool cleaner.</a>
	<? } ?>
	</p>    </td>
    <td width="440" align="left" valign="top" bgcolor="#FFFFFF"><div align="right">
      <h1>PiTP</h1>
      <p style="color:#ccc;">by Shawn Rider<br />
        <span>November 15, 2005</span></p>
      <hr />
     <? $pitp->pagination();?> <br />
      <p>&nbsp;</p>
      <p align="left"><? echo $pitp->story; ?></p>
      <hr />
      <? $pitp->pagination();?>
      <p>&nbsp;</p>
      <p align="center"><!--Creative Commons License--><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.5/"><img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.png"/></a><br/>
		<span class="style1">This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.5/">Creative Commons Attribution-NonCommercial-ShareAlike 2.5 License</a>.
        </span>		<!--/Creative Commons License--><!-- <rdf:RDF xmlns="http://web.resource.org/cc/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
		<Work rdf:about="">
			<license rdf:resource="http://creativecommons.org/licenses/by-nc-sa/2.5/" />
	<dc:title>PiTP</dc:title>
	<dc:date>2005</dc:date>
	<dc:description>PiTP is a dynamic short fiction. A "wiki-fiction". Users are invited to add to the story in a thematically appropriate way.</dc:description>
	<dc:creator><Agent><dc:title>Shawn Rider</dc:title></Agent></dc:creator>
	<dc:rights><Agent><dc:title>Shawn Rider</dc:title></Agent></dc:rights>
	<dc:type rdf:resource="http://purl.org/dc/dcmitype/InteractiveResource" />
	<dc:source rdf:resource="http://shawnrider.com/pitp" />
		</Work>
		<License rdf:about="http://creativecommons.org/licenses/by-nc-sa/2.5/"><permits rdf:resource="http://web.resource.org/cc/Reproduction"/><permits rdf:resource="http://web.resource.org/cc/Distribution"/><requires rdf:resource="http://web.resource.org/cc/Notice"/><requires rdf:resource="http://web.resource.org/cc/Attribution"/><prohibits rdf:resource="http://web.resource.org/cc/CommercialUse"/><permits rdf:resource="http://web.resource.org/cc/DerivativeWorks"/><requires rdf:resource="http://web.resource.org/cc/ShareAlike"/></License></rdf:RDF> --></p>
    </div></td>
  </tr>
</table>
</body>
</html>
