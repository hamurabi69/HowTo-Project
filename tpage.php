<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Nobile' rel='stylesheet' type='text/css'>

<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>

<?php
// Report all PHP errors
error_reporting(-1);

//Create session variables

 $s_id=session_id(); 
 
//Include db details and credentials
include('../includes/db.php');
		
//Import Header file
require('header.php');
//Get session details
        $url=$_SERVER['REQUEST_URI'];
        $ip=$_SERVER['REMOTE_ADDR'];

//added php-mysql security
        $id = mysqli_real_escape_string($db, strip_tags($_GET['id']));
		$encoded_id=$id;
		$decoded_id=urldecode($id);
		
			$wresults = mysqli_query($db, "SELECT id FROM tbl_topic WHERE name='$decoded_id' ");
                $wrow = mysqli_fetch_array($wresults);
					$id=$wrow['id'];
					$topic_id=$wrow['id'];
					
		//Retrieve required information from DB and display on page
			$tresults = mysqli_query($db, "SELECT description, name, sort FROM tbl_topic WHERE id='$topic_id'");
                                        if( $trow = mysqli_fetch_array($tresults)){
						$name=$trow['name'];
						$description=$trow['description'];
						$sort=$trow['sort'];
						$c=0;
?>
<title><?php echo $name ?></title>
</head>

<body>
<div class="container" >
<table class="well-blue table1">
<?php

						
	$prev_topic_id='';
	$next_topic_id='';
	$prev='';
	$next='';
	$t_count='';
	$cresults = mysqli_query($db, "SELECT count(id) FROM tbl_topic WHERE status='1' ");
		$crow = mysqli_fetch_array($cresults);
		$t_count=$crow['count(id)'];
		if($t_count==1){
			$prev_topic_id=urlencode($decoded_id);
			$next_topic_id=urlencode($decoded_id);
		}else{
	$presults = mysqli_query($db, "SELECT id, name FROM tbl_topic WHERE STATUS = '1' AND sort < '$sort' ORDER BY sort DESC LIMIT 0 , 1");
		$prow = mysqli_fetch_array($presults);	
			if (empty($prow['id'])){
				$zresults = mysqli_query($db, "SELECT id, name FROM tbl_topic WHERE STATUS = '1' ORDER BY sort DESC LIMIT 0 , 1");
				$zrow = mysqli_fetch_array($zresults);
				$prev_topic_id=urlencode($zrow['name']);
			}else{
				$prev_topic_id=urlencode($prow['name']);
			}
			
	$nresults = mysqli_query($db, "SELECT id, name FROM tbl_topic WHERE id!='$topic_id' AND STATUS = '1' AND sort > '$sort' ORDER BY sort LIMIT 0 , 1");
		$nrow = mysqli_fetch_array($nresults);
			if (empty($nrow['id'])){
				$yresults = mysqli_query($db, "SELECT id, name FROM tbl_topic WHERE STATUS = '1' ORDER BY sort LIMIT 0 , 1");
				$yrow = mysqli_fetch_array($yresults);
				$next_topic_id=urlencode($yrow['name']);
			}else{
				$next_topic_id=urlencode($nrow['name']);
			}

		}
?>
<tr style="text-align: center;">
<td><a href="tpage.php?id=<?php echo $prev_topic_id ?>"><h2 style="font-family:'Nobile';"><<span class="font40">PREVIOUS</span></h2></a></td>
<td></td>
<td><a href="tpage.php?id=<?php echo $next_topic_id ?>"><h2 style="font-family:'Nobile';"><span class="font40">NEXT</span>></h2></a></td></tr>
<tr style="text-align: center;">
<td class="fifteen"></td>
<td class="seventy"> 
						
			<h2><?php  echo $name ?></h2> 
</td>
<td class="fifteen"> 
</td></tr>
			<tr>
			<td></td>
			<td style="padding-left:40px;"><?php  echo $description ?></td>
			<td></td>
			</tr>
<?php			
	$qresults = mysqli_query($db, "SELECT name, id FROM tbl_dept WHERE topic='$topic_id' AND STATUS = '1' ORDER BY sort_order");
		$qrow = mysqli_fetch_array($qresults);
						do{
						$cat_name=$qrow['name'];
						$cat_name_encoded=urlencode($qrow['name']);
						$cat_id=$qrow['id'];
?>
					<tr><td style="padding:0px;"></td>
					<td style="padding:0px 40px 0px 40px;text-align:left;"><a href="cpage.php?id=<?php echo $cat_name_encoded ?>"><b><?php echo $cat_name ?></b></a></td>
					<td style="padding:0px;"></td></tr>
<?php
                                                }while($qrow = mysqli_fetch_array($qresults));
                                        }
?>

<tr style="text-align: center;">
<td><a href="tpage.php?id=<?php echo $prev_topic_id ?>"><h2 style="font-family:'Nobile';"><<span class="font40">PREVIOUS</span></h2></a></td>
<td></td>
<td><a href="tpage.php?id=<?php echo $next_topic_id ?>"><h2 style="font-family:'Nobile';"><span class="font40">NEXT</span>></h2></a></td></tr>
</table>
</div> 
</body>
<?php
//Import Footer file
require('footer.html');
?>
</html>


