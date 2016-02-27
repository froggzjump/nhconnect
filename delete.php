<?php require_once('includes/config.php'); 
include('includes/sc-includes.php');

mysql_select_db($database_follows, $follows);

//DELETE CONTACT
if (isset($_GET['contact'])) {
mysql_query("DELETE FROM follows_contacts WHERE contact_id = ".$_GET['contact']."");
mysql_query("DELETE FROM follows_history WHERE history_contact = ".$_GET['contact']."");
mysql_query("DELETE FROM follows_notes WHERE note_contact = ".$_GET['contact']."");
mysql_query("DELETE FROM follows_email WHERE followup_id = ".$_GET['contact']."");
mysql_query("DELETE FROM follows_wait WHERE contact_id = ".$_GET['contact']."");
set_msg('FollowUp Deleted');
header('Location: contacts.php'); die;
}
//

//Delete Workder
if (isset($_GET['user'])) {

//Check if group leader is being deleted    
$chquery = "SELECT * FROM follows_users WHERE user_id = ".$_GET['user']."";
$chuser = mysql_query($chquery, $follows) or die(mysql_error());
$row_chuser = mysql_fetch_assoc($chuser);
    if ($row_chuser['user_level'] == 3){
    set_msg("This user is a gorup leader, cannot delete group leaders, please change level.   ");
    header('Location: users.php'); die;
    }
//not a group leader then move on, next check to see if this user has followUps assigned.
//verify this user has no followups assigned.
//$gotfollow = mysql_query("SELECT * FROM follows_contacts WHERE contact_user = ".$_GET['user']."") or die(mysql_error());
//$row_foll = mysql_fetch_assoc($gotfollow);
//$totalRows_foll = mysql_num_rows($gotfollow);
  //  if ($totalRows_foll > 1){
    //set_msg("This worker still has followups assigned.  Please reassing those followups before deleting this worker.   ");
    //header('Location: users.php'); die;
    //}   
// no followups assinged so move on   
mysql_query("DELETE FROM follows_users WHERE user_id = ".$_GET['user']."");

set_msg('Worker Deleted');
header('Location: users.php');
die;

}
//////////// END DELETE WORKER

//DELETE NOTE
if (isset($_GET['note'])) {
mysql_query("DELETE FROM follows_notes WHERE note_id = ".$_GET['note']."");
set_msg('Note Deleted');
$cid = $_GET['id'];
$redirect = "contact-details.php?id=$cid";
header(sprintf('Location: %s', $redirect)); die;
}
//

//Delete Contact Method from Category table
if (isset($_GET['cat'])) {
mysql_query("DELETE FROM category WHERE id = ".$_GET['cat']."");
set_msg('Contact Method Deleted');
header('Location: cmethod.php'); die;
}
//

//Delete Notification
if (isset($_GET['email'])) {
mysql_query("DELETE FROM follows_email WHERE email_id = ".$_GET['email']."");
set_msg('Email log Deleted');
header('Location: myemails.php'); die;
}

//Delete stage from stages table
if (isset($_GET['st'])) {
mysql_query("DELETE FROM follows_stages WHERE id = ".$_GET['st']."");
set_msg('Stage Deleted');
header('Location: stages.php'); die;
}

//Delete group from group table
if (isset($_GET['grp'])) {
//check if group empty first    

$chgrp = mysql_query("SELECT * FROM follows_users WHERE member_group_id = ".$_GET['grp']."") or die(mysql_error());
$row_chgrp = mysql_fetch_assoc($chgrp);
$totalRows_chgrps = mysql_num_rows($chgrp);
    if ($totalRows_chgrps > 1){
    set_msg("This group still has ministry workers in it, cannot delete until they are all moved from this group.   ");
    header('Location: groups2.php'); die;
    }
// delete if group is empty   
mysql_query("DELETE FROM follows_group WHERE group_id = ".$_GET['grp']."");
set_msg('Group Deleted');
header('Location: groups2.php'); die;
}


?>