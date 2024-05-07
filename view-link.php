<?php
require_once("includes/include.php");
include_once("class/tbl_audition_job_client_url.php");

$objAudUrl					=	new tbl_audition_job_client_url();

$token						=	post_value_check($_GET['token']);
$getUrlDet					=	$objAudUrl->getRow("URL_TOKEN='".$token."'");
if (strpos($getUrlDet['URL'], "youtube")!==false){
  $getUrlDet['URL'] = str_replace('watch?v=', 'embed/', $getUrlDet['URL']);
}else if(strpos($getUrlDet['URL'], "vimeo")!==false){
	
	$getUrlDet['URL'] = str_replace('vimeo.com', 'player.vimeo.com/video', $getUrlDet['URL']);
	}	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CASTING SERVICES</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>

   
   <script type="text/javascript" src="js/ajax.js"></script> 

<link href="font/arkona-medium.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<iframe id="frame" src="<?php echo $getUrlDet['URL'];?>" style="background-image:url(images/bg.jpg)" scrolling="yes" width="100%" height="1000"></iframe>
</body>
</html>