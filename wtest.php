<?php 
require_once('includes/config.php');
include('includes/sc-includes.php');

//Looks inside follows_group table and reads leader_id field matches against logged in users user_id from follows_user table - Creates array for this group
$groupinfo =  $database->getUserGroup($whois);
$groupis = $groupinfo['group_id']; //This groups id
$groupnameis = $groupinfo['group_name']; //This groups name

// Get Worker Information

$workerinfo = $database->getUserInfo($_GET['wid']);
$workeris = $workerinfo['user_name'];
$workerid = $workerinfo['user_id'];


 
if (isset($_POST['options'])) {
    $worker2assign = $_GET['wid'];    
    $options = array_filter($_POST['options'], "is_numeric");
    
  foreach($options as $option){
  $inquery = "UPDATE follows_contacts SET contact_user = '$worker2assign', contact_wait = '0' WHERE contact_id = '$option'";
  $delwait = "DELETE FROM follows_wait WHERE follows_wait.contact_id = '$option'";
  mysql_select_db($database_follows, $follows);
  
  $Result1 = mysql_query($inquery, $follows) or die(mysql_error());
  $Result2 = mysql_query($delwait, $follows) or die(mysql_error());
  
  $notification = 0;
  include('sendnotification2.php');
  $dis = "block";
  set_msg('FollowUp Assigned - You may now close this window and refresh previous screen with F5');
   }
  }
  
Headerinfo();

echo "<center> <h1> Assign FollowUp to " . $workeris . "</h1></center>"; 
?>  


<form action="<?php $_SERVER['php_self'];?>" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="close_window()"> 

<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td colspan="4">
        <span class="notices" id="notice" style="display:<?php echo $dis; ?>">
        
        <?php 
        echo $_SESSION['msg'];
        unset($_SESSION['msg']); 
        ?>
        
        </span>
        
        </td>
      </tr>     


<?php
echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
echo "<tr><td><b>Name</b></td><td><b>Marital Status</b></td><td><b>Service Attended</b></td><td><b>Age</b></td><td><b>Group</b></td><td><b>Date Added</b></td></tr>\n";

if($currentlevel==1){
$sql = "SELECT follows_contacts.contact_id, contact_first, contact_last, contact_mstatus, contact_stime, contact_age, follows_wait.group_id, follows_wait.contact_id, wait_updated 
        FROM follows_contacts 
		INNER JOIN follows_wait ON follows_contacts.contact_id = follows_wait.contact_id 
		WHERE follows_contacts.contact_wait = 1";
}
else if($currentlevel==3){
$sql = "SELECT follows_contacts.*, follows_wait.* 
   		 FROM follows_contacts 
		 INNER JOIN follows_wait ON follows_contacts.contact_id = follows_wait.contact_id 
		 WHERE follows_contacts.contact_wait = 1
		 AND follows_wait.group_id = $groupis ";
}

$res = mysql_query($sql,$follows) or die(mysql_error());
$i=0;
$fields = array("contact_profile");

while($r = mysql_fetch_assoc($res)){
  echo create_div($fields, "follows_contacts", "contact_id", $r['contact_id'], $i);
  
?>

  <tr>
    <td><input type='checkbox' name='options[]' value="<?php echo $r['contact_id'];?>"><a onMouseOver="ShowContent('data<?php echo $i; ?>'); return true;" onMouseOut="HideContent('data<?php echo $i; ?>'); return true;" href="javascript:ShowContent('data<?php echo $i; ?>')"><?php echo $r['contact_first'] . " " . $r['contact_last']; ?></a></td>
    <td><?php echo $r['contact_mstatus'];?></td>
    <td><?php echo $r['contact_stime']; ?></td>
    <td><?php echo $r['contact_age']; ?></td>
    <td><?php if($currentlevel==3){ 
	          echo $groupnameis;
			  }else if ($currentlevel==1){ // Here I get the groupname that this person is wating in //
			  $thisisit = $r['group_id'];  
			  $sqlis = "SELECT * FROM follows_group WHERE group_id = $thisisit ";
			  $dd = mysql_query($sqlis);
			  $fetchit = mysql_fetch_assoc($dd);
			  echo $fetchit['group_name'];
			  }
			  
			  ?></td>
    <td><?php echo date("m-d-y",$r['wait_updated']); ?></td>
  </tr>
<?php
$i++;
}
?>

</table> 

<input type="submit" name="Submit" value="Assign FollowUps"/>
</form>


</body>
</html>

 