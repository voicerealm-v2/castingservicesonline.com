<?php

//changes by aparna on 26-3-2019
$url = $_SERVER['REQUEST_URI'];
$url1= explode('/',$url);

if(isset($url1[2])){
	die('Page not found.');
}
//changes end

require_once("includes/include.php");
include_once("class/tbl_advertiser_favorites.php");
include_once("class/tbl_advertiser_fav_share_link.php");
include_once("class/tbl_advertisers.php");
include_once("class/tbl_artists.php");


$objAdvertiser				=   new tbl_advertisers();
$objAdvFavorites			=   new tbl_advertiser_favorites();
$objShareLinks		    	=   new tbl_advertiser_fav_share_link();
$objArtists		    		=   new tbl_artists();
$objDemoAudiosClass			=	new tbl_demo_audios();
$token						=	post_value_check($_GET['token']);
if(!($token)||(strlen($token)>100)){
	header("location:index.php");
	exit;
}
$shareLinks					=	$objShareLinks->getRow("SHARE_TOKEN='".$token."'");
if(!is_array($shareLinks)){
	header("location:index.php");
	exit;
}
$adv_id 					= 	$shareLinks['ADVERTISER_ID'];

$order_by					=	"ORDER BY RAND(".$rand_id.")";

if(isset($_GET['pre_audition'])){
		$cond_initial				=	"advertiser_id='".$adv_id."' AND job_id='".$_GET['pre_audition']."' AND fav_type='P'";
		$qry				=	"FROM advertiser_temp_favourite INNER JOIN artists ON   advertiser_temp_favourite.artist_id=artists.ARTIST_ID WHERE $cond_initial AND artists.ARTIST_STATUS NOT IN(4,5) $order_by ";
		$sql						=	"SELECT advertiser_temp_favourite.artist_id $qry";
}else{
	$cond_initial				=	"FAV_ADVERTISER_ID='".$adv_id."' AND FAV_TYPE='P'";
	$qry						=	"FROM advertiser_favorites
									INNER JOIN artists ON  advertiser_favorites.FAV_ARTIST_ID=artists.ARTIST_ID				
									WHERE $cond_initial AND artists.ARTIST_STATUS NOT IN(4,5) $order_by ";
	$sql						=	"SELECT FAV_ARTIST_ID $qry";
}
$arrayMail 					= 	$objAdvFavorites ->getAllBySql($sql);
$path						=	'http://www.thevoicerealm.com/userfiles/mp3/';

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
     
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listing-new">

         
        
          <tr>
            <td colspan="3" class="red" align="center"><?php echo $msg;?></td>
          </tr>
         <tr>
          <th width="28%">Audio</th>
          <th width="61%">Voice Talent</th>
          
        </tr>
      
          <?php
		  					$i=0;
							if(count($arrayMail)){
								foreach($arrayMail as $mailDetails){
							$i++;
	if(!isset($_GET['pre_audition'])){
	$sql				=  "ARTIST_ID ='".$mailDetails['FAV_ARTIST_ID']."'";
	$artist_det			=  $objArtists->getRow($sql);
	$demo_file_array	=	$objDemoAudiosClass->getRow("ARTIST_ID='".$artist_det['ARTIST_ID']."'","DEMO_TYPE");
	$demo_audio_file	=	$demo_file_array['DEMO_FILE'];	
	}else{
		$sql				=  "ARTIST_ID ='".$mailDetails['artist_id']."'";
	$artist_det			=  $objArtists->getRow($sql);
	$demo_file_array	=	$objDemoAudiosClass->getRow("ARTIST_ID='".$artist_det['artist_id']."'","DEMO_TYPE");
	$demo_audio_file	=	$demo_file_array['DEMO_FILE'];
	}	
						?>
          
          <tr>
            <td align="center">
            
          
       
            
           
            <div class="ui360" style="margin:0 auto;width:60px;"><a href="<?php echo $path.$demo_audio_file;?>"></a></div>
                         </td>
          
            <td><?php echo $artist_det['ARTIST_NAME']." ".substr($artist_det['ARTIST_LAST_NAME'],0,1); ?></td>
           
          </tr>
          <?php    

		 }
	     }else{
		 echo '<tr ><td colspan="3">Currently no voice talent in this list. </td> </tr>';
		 }
?>
      </table>  
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
function addToFavoriteAadvertiser(id,replaceDiv){
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
	var parameters="fav_id=" + id + "&type=addToAdvertiserFav";
	mypostrequest.open("POST", "ajax.php", true);
	mypostrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	mypostrequest.send(parameters);
}
</script>
<!-- Placed at the end of the document so the pages load faster --> 
<!--changes by aparna on 2-2-2019 http to https-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<!--changes end-->
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