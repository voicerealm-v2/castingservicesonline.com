<?php
require_once("includes/include.php");
include_once("class/tbl_audition_many_jobs.php");
include_once("class/tbl_audition_many_jobs_share_links.php");

$objAuditionMany		=   new tbl_audition_many_jobs();
$objShareLinks		    =   new tbl_audition_many_jobs_share_links();

$token						=	$_GET['token'];
$shareLinks					=	$objShareLinks->getRow("SHARE_TOKEN='".$token."'");
$manyJobId 					= 	$shareLinks['SHARE_JOB_ID'];
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
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CASTING SERVICES</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script type="text/javascript" src="html5/deploy/jquery.ui.widget.min.js"></script>
   <script type="text/javascript" src="html5/deploy/AudioPlayerV1.js"></script> 
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
</head>

<body>
<div class="wrapper-new"> 
  <!--logo-->
  <div class="logo"> <img src="images/logo.png" width="467" height="50" /> </div>
  <div class="content-section">
    <div class="content-pad">
      <p>We've auditioned some really great voices and here's some we think you may like.</p>
      <p>Just select the voice or voices that you like best and we can then discuss before securing the voice to record.</p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listing-new">

         
        
          <tr>
            <td colspan="3" class="red" align="center"><?php echo $msg;?></td>
          </tr>
         <tr>
          <th>Audio</th>
          <th>Voice Talent</th>
          <th>Select Your Favorite(s)</th>
        </tr>
      
          <?php
		  					$i=0;
							if(count($arrayMail)){
								foreach($arrayMail as $mailDetails){
							$i++;
									
						?>
          
          <tr>
            <td align="center">
                <audio id="audio1" class="AudioPlayerV1" width="98">
                  <source src="<?php echo $path.$mailDetails['AUD_FILE_NAME']?>" type="audio/mpeg" />
                </audio>            </td>
            <!-- <td> 

			 &nbsp;&nbsp;&nbsp;&nbsp;<a href="download1.php?uId=<?php //echo $mailDetails['AUD_FILE_NAME'] ?>" style="text-decoration:none"> <img src="images/Download.png" width="25" title="Download voice over demo file" /></a>
                   </td> -->
            <td><?php echo $mailDetails['ARTIST_NAME'].substr($mailDetails['ARTIST_LAST_NAME'],1); ?></td>
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
</body>
</html>