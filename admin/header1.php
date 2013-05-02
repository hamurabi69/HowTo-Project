<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../includes/main.css" type="text/css">
<link rel="stylesheet" href="../css/bootstrap.css">




<title>Daily Living ToolKit</title>
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>

<?php
//Create session variables
session_destroy();
session_set_cookie_params();
session_start();
//Set session URI
$_SESSION['URI'] = $_SERVER['REQUEST_URI'];
//Import DB credentials
include('../includes/db.php');
?>
</head>
<body class = "mainbody">
  <div class="container"> 
    <div class="span3">
        <a href="admin/index.php"><img src="../images/admin-button.png" width="92" height="40" alt="admin" /></a>
     </div> 
      <div class="navbar-static-top">
       
        <img src="../images/header.png" width="100%" height="100%" alt="headerpic" />
       
       <a href="http://www.211-broward.org/" target="blank">
          <img class="img-rounded" src="../images/211banner.png" width="100%" height="100%" />
       </a>

      <div id='cssmenu'>
        <ul>
         <li class='active'><a href='../index.php'><span>Home</span></a></li>
         <li class='has-sub'><a href='#'><span>Living Toolkit</span></a>
            <ul>
    <?php
    //Retrieve required information from DB and display on page
          $tresults = mysqli_query($db, "SELECT * FROM tbl_dept WHERE status='1' ORDER BY sort_order");
                                            if( $trow = mysqli_fetch_array($tresults)){
                                                    do{
                $name=$trow['name'];
                $id=$trow['id'];
    ?>
        <li class="has-sub"><a><?php  echo $name ?></a>
                <ul>
    <?php
          $sresults = mysqli_query($db, "SELECT p_title, id FROM tbl_pages WHERE status='1' AND dept_id='$id' ORDER BY p_sort");
                                            if( $srow = mysqli_fetch_array($sresults)){
                                                    do{
                $p_name=$srow['p_title'];
                $p_id=$srow['id'];
    ?>        
      <li><a href="../page.php?id=<?php echo $p_id ?>"><?php  echo $p_name ?></a></li> 
    <?php
                            }while($srow = mysqli_fetch_array($sresults));
                                            }
    ?>          
                </ul>
    <?php
                                                    }while($trow = mysqli_fetch_array($tresults));
                                            }
    ?>        
              </li>
            </ul>
   </li>
   <li><a href='../links.php'><span>Links</span></a></li>
   <li><a href='../contact.php'><span>Contact Us</span></a></li>
   <li><a href='../about.php'><span>About Us</span></a></li>
   <li class='last'><a href="../page.php?id=111"><span>The Bean Game</span></a></li>

</ul>
</div>
    </div>
  </div>
</div>
</body>
</html>
