<?php
require_once('includes/config.php'); 
include('includes/sc-includes.php');
$pagetitle = 'Wait Queue';




// I get the groupname that the current group leader is a memeber of//
$groupinfo =  $database->getUserGroup($whois);
$groupis = $groupinfo['group_id'];
$groupnameis = $groupinfo['group_name'];

HeaderInfo();

include('includes/header.php'); ?>
  
  <div class="container">
  <div class="leftcolumn">
  
    <h2><?php echo MINISTRY . " Follow-Ups";?></h2> for <?php echo $row_userinfo['user_name']; ?>

    <br /><br /><br />

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
$sql = "SELECT follows_contacts.contact_id, contact_first, contact_last, contact_mstatus, contact_stime, contact_age, follows_wait.contact_id, wait_updated 
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
    <td><a onMouseOver="ShowContent('data<?php echo $i; ?>'); return true;" onMouseOut="HideContent('data<?php echo $i; ?>'); return true;" href="javascript:ShowContent('data<?php echo $i; ?>')"><?php echo $r['contact_first'] . " " . $r['contact_last']; ?></a></td>
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
<br />

<div class="nhcfsd">
<?php echo "<a class=\"button\" href=\"users.php\"><span class=\"cmethod\">Make Assignment</span></a>"; ?>


</div>
</div>
  
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />

</div>

<?php include('includes/footer.php'); ?>

</body>
</html>