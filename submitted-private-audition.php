<?php

//changes by aparna on 26-3-2019
$url = $_SERVER['REQUEST_URI'];
$url1= explode('/',$url);

if(isset($url1[2])){
	die('Page not found.');
}
//changes end

require_once("includes/include.php");
include_once("class/tbl_audition_jobs_share_links.php");
include_once("class/tbl_audition_jobs.php");
include_once("class/tbl_advertisers.php");

$objShareLinks		    =   new tbl_audition_jobs_share_links();
$objAudition			=   new tbl_audition_jobs();
$objAdvertiser			=   new tbl_advertisers();


$token						=	post_value_check($_GET['token']);
$shareLinks					=	$objShareLinks->getRow("SHARE_TOKEN='".$token."'");
$fileId 					= 	$shareLinks['SHARE_FILE_ID'];
$sql						=	"SELECT
audition_job_files.AUD_FILE_NAME,
audition_job_files.UPLOAD_DATE,
audition_job_files.AUD_JOB_ID,
artists.ARTIST_ID,
artists.ARTIST_NAME,
artists.ARTIST_GENDER
FROM
audition_job_files
LEFT JOIN artists ON audition_job_files.AUD_UPLOADER_ID = artists.ARTIST_ID
WHERE audition_job_files.AUD_JOB_FILE_ID='".$fileId ."'";
$arrayMail 		= 	$objShareLinks ->getRowBySql($sql);
$path			=	'http://www.thevoicerealm.com/userfiles/jobs/';

//////

$audJobs		=	$objAudition->getRow("AUD_JOB_ID='".$arrayMail['AUD_JOB_ID']."'");
$advDet			=	$objAdvertiser->getRow("ADVERTISER_ID='".$audJobs['AUD_JOB_FROM_ID']."'");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CASTING SERVICES</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>

   <script type="text/javascript" src="js/ajax.js"></script> 
  <link rel="stylesheet" type="text/css" href="html5/orange/style.css" />
<link href="font/arkona-medium.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
  body {
  font-family:Arial, Helvetica, sans-serif;
  }
  .voiceName{
  font-family:Arial, Helvetica, sans-serif;
  color:#333333;
  }
  .voiceName a{
  font-family:Arial, Helvetica, sans-serif;
  color:#333333;
  text-decoration:none;
  }
  </style>
<!-- required -->
<link rel="stylesheet" type="text/css" href="360player/360player.css" />
<link rel="stylesheet" type="text/css" href="360player/flashblock.css" />
<!-- special IE-only canvas fix -->
<!--[if IE]><script type="text/javascript" src="360player/excanvas.js"></script><![endif]-->
<!-- Apache-licensed animation library -->
<script type="text/javascript" src="360player/berniecode-animator.js"></script>
<!-- the core stuff -->
<script type="text/javascript" src="360player/soundmanager2.js"></script>
<script type="text/javascript" src="360player/360player.js"></script>

<script type="text/javascript">
soundManager.setup({
  // path to directory containing SM2 SWF
url: '360player/swf/'
});
</script>
</head>

<body>
<div class="wrapper-new"> 
  <!--logo-->
  <?php
  if($advDet['ADVERTISER_COMPANY_LOGO']!=''){
  echo '<div class="logo"> <img src="'.$advDet['ADVERTISER_COMPANY_LOGO'].'" height="70" /> </div>';
  echo '<div class="logo1"> <img src="images/logo.png" width="467" height="50" /> </div>';
  }else{
  echo '<div class="logo"> <img src="images/logo.png" width="467" height="50" /> </div>';
  }
  ?>
  <div class="content-section">
    <div class="content-pad">
      <p>Audition from voice talent. If you cannot see the audio player, please try another browser.</p>
   
      <div align="center"><table width="80%" border="0" cellspacing="0" cellpadding="0" class="listing-new">

         <tr>
          <th  width="50%">Audio</th>
          <th width="50%">Voice Talent</th>
        </tr>
<?php
if($arrayMail['AUD_FILE_NAME']){
?>
          <tr>
          	<td align="center">          
            <div class="ui360" style="margin:0 auto;width:60px;"><a href="<?php echo $path.$arrayMail['AUD_FILE_NAME']?>"></a></div>
     		</td>

            <td><?php echo $arrayMail['ARTIST_NAME']." ".substr($arrayMail['ARTIST_LAST_NAME'],0,1); ?></td>
            
          </tr>
         <?php
		 }else{
		 echo '<tr><td colspan="2">Sorry....... URL expired</td></tr>';
		 }
		 ?>
      </table></div>
	  

	  Casting Services Online helps clients around the globe source and audition the world's best voice talent.<br />
      <br />
      We work with the world's biggest advertising agencies and marketing companies to provide voice over actors in many languages and dialects.<br />
      <br />
      Our dedicated team prides itself on client satisfaction and utilization of the latest technology to assist in casting the world's greatest voice overs.
      </form>
    </div>
  </div>
<div class="bottom-box"> <img src="images/pic1.jpg" width="170" height="94" /> <img src="images/pic2.jpg" width="171" height="94" /> <img src="images/pic3.jpg" width="170" height="94" /> <img src="images/pic4.jpg" width="171" height="94" /> <img src="images/pic5.jpg" width="170" height="94" /></div>
</div>

<!--footer-->
<div class="footer">
  <div class="wrapper-new"> Copyright &copy; <?php echo date("Y"); ?> castingservicesonline.com </div>
</div>
</body>
</html>