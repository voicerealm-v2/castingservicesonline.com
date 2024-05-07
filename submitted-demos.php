<?php

//changes by aparna on 26-3-2019
$url = $_SERVER['REQUEST_URI'];
$url1= explode('/',$url);

if(isset($url1[2])){
	die('Page not found.');
}
//changes end

require_once("includes/include.php");
include_once("class/tbl_audition_many_jobs.php");
include_once("class/tbl_audition_many_jobs_share_links.php");
include_once("class/tbl_advertisers.php");

$objAdvertiser				=   new tbl_advertisers();
$objAuditionMany			=   new tbl_audition_many_jobs();
$objShareLinks		    	=   new tbl_audition_many_jobs_share_links();

$token						=	post_value_check($_GET['token']);
$shareLinks					=	$objShareLinks->getRow("SHARE_TOKEN='".$token."'");
$manyJobId 					= 	$shareLinks['SHARE_JOB_ID'];
$manyJobDet					=	$objAuditionMany->getRow("AUD_MANY_JOB_ID='".$manyJobId."'");

$advDet						=	$objAdvertiser->getRow("ADVERTISER_ID='".$manyJobDet['AUD_MANY_JOB_FROM_ID']."'");

$sql						=	"SELECT
audition_job_files.AUD_FILE_NAME,
audition_job_files.AUD_JOB_FILE_ID,
audition_job_files.UPLOAD_DATE,
artists.ARTIST_ID,
artists.ARTIST_NAME,
artists.ARTIST_GENDER,
audition_job_files.AUD_JOB_ID
FROM
audition_job_files
INNER JOIN audition_many_jobs ON audition_many_jobs.AUD_MANY_JOB_ID=audition_job_files.AUD_JOB_MANY_ID
LEFT JOIN artists ON audition_job_files.AUD_UPLOADER_ID = artists.ARTIST_ID
WHERE audition_many_jobs.AUD_MANY_JOB_ID='".$manyJobId ."' AND audition_job_files.AUD_JOB_SHORTLIST='2'";

$arrayMail 					= 	$objAuditionMany ->getAllBySql($sql);
$path						=	'http://www.thevoicerealm.com/userfiles/castings/';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Mirrored from castingservicesonline.com/submitted-demos.php?token=9b9ba841f4b308c241bec299ed00cf30 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Jun 2018 04:32:49 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CASTING SERVICES</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>

   
   <script type="text/javascript" src="js/ajax.js"></script> 

<link href="font/new/arkona-medium.css" rel="stylesheet" type="text/css" />
<link href="css/new/style.css" rel="stylesheet" type="text/css" />
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
  echo '<div class="logo"> <img src="'.$advDet['ADVERTISER_COMPANY_LOGO'].'"/> </div>';
  echo '<div class="logo1"> <img src="images/logo.png"/> </div>';
  }else{
  echo '<div class="logo"> <img src="images/logo.png"/> </div>';
  }
  ?>
  <div class="content-section">
    <div class="content-pad">
      <p>We've auditioned some really great voices and here's some we think you may like.</p>
      <p>Just select the voice or voices that you like best and we can then discuss before securing the voice to record.</p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listing-new">

         
        
          <tr>
            <td colspan="3" class="red" align="center"><?php echo $msg;?></td>
          </tr>
         <tr>
          <th width="28%">Audio</th>
          <th width="21%">Voice Talent</th>
          <th width="51%">Select Your Favorite(s)</th>
        </tr>
      
          <?php
		  					$i=0;
							if(count($arrayMail)){
								foreach($arrayMail as $mailDetails){
							$i++;
									
						?>
          
          <tr>
            <td align="center">
           
            <div class="ui360" style="margin:0 auto;width:60px;" onClick="changeHearStatus('<?php echo $mailDetails['AUD_JOB_FILE_ID'];?>')"><a href="<?php echo $path.$mailDetails['AUD_FILE_NAME']?>"></a></div>
                         </td>
            <!-- <td> 

			 &nbsp;&nbsp;&nbsp;&nbsp;<a href="download1.php?uId=<?php //echo $mailDetails['AUD_FILE_NAME'] ?>" style="text-decoration:none"> <img src="images/Download.png" width="25" title="Download voice over demo file" /></a>
                   </td> -->
            <td><?php echo $mailDetails['ARTIST_NAME']." ".substr($mailDetails['ARTIST_LAST_NAME'],0,1); ?></td>
            <td><div align="center" id="fav-box<?php echo $i;?>" ><a href="javascript:" onclick="return addToFavorite('<?php echo $mailDetails['AUD_JOB_FILE_ID'];?>','fav-box<?php echo $i;?>')"><img src="images/fav-gray.gif" width="16" title="Add to favorite" border="0" /></a></div> </td>
          </tr>
          <?php    

		 }
	     }else{
		 echo '<tr ><td colspan="3">Currently no audition shortlisted. </td> </tr>';
		 }
?>
      </table>
	  

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
  <div class="wrapper-new"> Copyright &copy; 2013 castingservicesonline.com </div>
</div>
<script language="javascript">
function addToFavorite(id,replaceDiv){
	var mypostrequest		=	new ajaxRequest();
	mypostrequest.onreadystatechange = function()
	{
		if (mypostrequest.readyState == 4)
		{
			if (mypostrequest.status==200 || window.location.href.indexOf("http") == -1)
			{
				document.getElementById(replaceDiv).innerHTML=mypostrequest.responseText;
			}
			else
			{
				alert("An error has occured making the request");
			}
		}
		else
		{
			document.getElementById(replaceDiv).innerHTML="Please wait...";
		}
	}
	var parameters="fav_id=" + id + "&type=addToFav";
	mypostrequest.open("POST", "ajax.php", true);
	mypostrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	mypostrequest.send(parameters);
}
</script>
<!-- Placed at the end of the document so the pages load faster --> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
    <script type="text/javascript" src="inc/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="inc/jquery.mb.miniPlayer.js"></script>
    <link rel="stylesheet" type="text/css" href="inc/css/miniplayer.css" title="style" media="screen"/>
   <script type="text/javascript">

        $(function () {

               $(".audio").mb_miniPlayer({
                width: 0,
                inLine: false
            });

            function playNext(player) {
                var players = $(".audio");
                document.playerIDX = (player.idx <= players.length - 1 ? player.idx : 0);
                console.debug(document.playerIDX, player.idx)
                players.eq(document.playerIDX).mb_miniPlayer_play();
            }
        });
    </script>
</body>
</html>