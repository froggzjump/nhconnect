<?php

$addtogroup = $_POST['contact_user'];
$datehappen = $_POST['contact_updated'];


if (isset($_POST['options'])) {
    $options = array_filter($_POST['options'], "is_numeric");
    
foreach($options as $option){
  $inquery = "UPDATE follows_contacts SET contact_user = $addtogroup contact_wait = 0 WHERE contact_id = $option";
  mysql_select_db($database_follows, $follows);
  $Result1 = mysql_query($inquery, $follows) or die(mysql_error());
  
  $dis = "block";
  set_msg('Group Updated - User Added, You may now close this window and refresh previous screen with F5');
   }
  }
  
 echo $_POST['options'] . "<br />";
 echo $addtogroup . "<br />";
 echo $datehappen . "<br />";
 print_r($options); 
  
?>