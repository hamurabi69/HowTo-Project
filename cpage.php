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
		
			$wresults = mysqli_query($db, "SELECT id FROM tbl_dept WHERE name='$decoded_id' ");
                $wrow = mysqli_fetch_array($wresults);
					$id=$wrow['id'];
					$dept_id=$wrow['id'];
					
//Retrieve required information from DB and display on page
			$tresults = mysqli_query($db, "SELECT description, name, sort_order, topic FROM tbl_dept WHERE id='$dept_id'");
                                        if( $trow = mysqli_fetch_array($tresults)){
						$name=$trow['name'];
						$description=$trow['description'];
						$sort=$trow['sort_order'];
						$topic_id=$trow['topic'];
						$c=0;		
?>
<title><?php echo $name ?></title>
</head>

<body>
<div class="container" >
<table class="well-blue table1">
<?php
						
	$prev_cat_id='';
	$next_cat_id='';
	$prev='';
	$next='';
	$t_count='';
	$cresults = mysqli_query($db, "SELECT count(id) FROM tbl_dept WHERE status='1' AND topic='$topic_id'");
		$crow = mysqli_fetch_array($cresults);
		$c_count=$crow['count(id)'];
		if($c_count==1){
			$prev_cat_id=urlencode($decoded_id);
			$next_cat_id=urlencode($decoded_id);
		}else{
	$presults = mysqli_query($db, "SELECT id, name FROM tbl_dept WHERE STATUS = '1' AND sort_order < '$sort' AND topic='$topic_id' ORDER BY sort_order DESC LIMIT 0 , 1");
		$prow = mysqli_fetch_array($presults);	
			if (empty($prow['id'])){
				$zresults = mysqli_query($db, "SELECT id, name FROM tbl_dept WHERE STATUS = '1' AND topic='$topic_id' ORDER BY sort_order DESC LIMIT 0 , 1");
				$zrow = mysqli_fetch_array($zresults);
				$prev_cat_id=urlencode($zrow['name']);
			}else{
				$prev_cat_id=urlencode($prow['name']);
			}
			
	$nresults = mysqli_query($db, "SELECT id, name FROM tbl_dept WHERE id!='$dept_id' AND STATUS = '1' AND sort_order > '$sort' AND topic='$topic_id' ORDER BY sort_order LIMIT 0 , 1");
		$nrow = mysqli_fetch_array($nresults);
			if (empty($nrow['id'])){
				$yresults = mysqli_query($db, "SELECT id, name FROM tbl_dept WHERE STATUS = '1' AND topic='$topic_id' ORDER BY sort_order LIMIT 0 , 1");
				$yrow = mysqli_fetch_array($yresults);
				$next_cat_id=urlencode($yrow['name']);
			}else{
				$next_cat_id=urlencode($nrow['name']);
			}

		}
?>
<tr style="text-align: center;">
<td><a href="cpage.php?id=<?php echo $prev_cat_id ?>"><h2 style="font-family:'Nobile';"><<span class="font40">PREVIOUS</span></h2></a></td>
<td></td>
<td><a href="cpage.php?id=<?php echo $next_cat_id ?>"><h2 style="font-family:'Nobile';"><span class="font40">NEXT</span>></h2></a></td></tr>
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
	$qresults = mysqli_query($db, "SELECT p_title, id FROM tbl_pages WHERE dept_id='$dept_id' AND STATUS = '1' ORDER BY p_sort");
		$qrow = mysqli_fetch_array($qresults);
						do{
						$p_title=$qrow['p_title'];
						$page_name_encoded=urlencode($qrow['p_title']);
						$p_id=$qrow['id'];
?>
					<tr><td style="padding:0px;"></td>
					<td style="padding:0px 40px 0px 40px;text-align:left;"><a href="page.php?id=<?php echo $page_name_encoded ?>"><b><?php echo $p_title ?></b></a></td>
					<td style="padding:0px;"></td></tr>
<?php
                                                }while($qrow = mysqli_fetch_array($qresults));
                                        }
?>

<tr style="text-align: center;">
<td><a href="cpage.php?id=<?php echo $prev_cat_id ?>"><h2 style="font-family:'Nobile';"><<span class="font40">PREVIOUS</span></h2></a></td>
<td></td>
<td><a href="cpage.php?id=<?php echo $next_cat_id ?>"><h2 style="font-family:'Nobile';"><span class="font40">NEXT</span>></h2></a></td></tr>
</table>
</div> 
</body>
<?php
//Import Footer file
require('footer.html');
?>
</html>


