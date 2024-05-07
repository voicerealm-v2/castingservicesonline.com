<?php
include_once("includes/include.php");
include("class/tbl_audition_job_files.php");

$objAuditionFile		=   new tbl_audition_job_files();
$type					=	trim($_REQUEST['type']);
switch($type){
	case "addToFav":
		$fav_id							=		trim($_REQUEST['fav_id']);
		$objAudFile						=		$objAuditionFile->getRow("AUD_JOB_FILE_ID='".$fav_id."'");
		$objAudFileArray['AUD_LIKES']	=		$objAudFile['AUD_LIKES']+1;
		$objError1						=		$objAuditionFile->update($objAudFileArray,"AUD_JOB_FILE_ID='".$fav_id."'");
		
		if($objError1)
		echo '<div align="center" id="fav-box"><img src="images/fav.gif" width="16" title="Add to favorite" />&nbsp;Favorite</div>';
		else
		echo '<div align="center" class="red">Some errors occured</div>';
	break;
	
	case "changeHearStatus":
		$file_id		=	$_POST['file_id'];
		if((strlen($file_id)<8)&&(strlen($file_id)>0)){
		$update		=	$objAuditionFile->update(array("AUD_CLIENT_VIEW"=>'Y'),"AUD_JOB_FILE_ID='".$file_id."'");
		}
	break;
	}
?>