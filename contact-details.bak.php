<?php require_once('includes/config.php'); ?>
<?php
include('includes/sc-includes.php');
$pagetitle = FollowUpDetails;

$update = 0;
if (isset($_GET['note'])) {
$update = 1;
}

//Security Check to verify the worker only has access to their follow ups
/////////////////////////////////////////////////////////////////////////
if ($row_userinfo['user_level'] == 2) {

$myidis = $row_userinfo['user_id'];
$theid = $_GET['id'];

mysql_select_db($database_follows, $follows);
$query_check = "SELECT * FROM follows_contacts WHERE contact_id = $theid AND contact_user= $myidis";
$check = mysql_query($query_check, $follows) or die(mysql_error());
$row_check = mysql_fetch_assoc($check);
$totalRows_check = mysql_num_rows($check);

if(empty($row_check)){
header ("Location: contacts.php");

}
}
/////////////////////////////////////////////////////////////////////////
// end Security check



?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


mysql_select_db($database_follows, $follows);
$query_contact = "SELECT * FROM follows_contacts WHERE contact_id = ".$_GET['id']."";
$contact = mysql_query($query_contact, $follows) or die(mysql_error());
$row_contact = mysql_fetch_assoc($contact);
$totalRows_contact = mysql_num_rows($contact);

mysql_select_db($database_follows, $follows);
$query_notes = "SELECT * FROM follows_notes WHERE note_contact = ".$_GET['id']." ORDER BY note_date DESC";
$notes = mysql_query($query_notes, $follows) or die(mysql_error());
$row_notes = mysql_fetch_assoc($notes);
$totalRows_notes = mysql_num_rows($notes);

if ($update==1) {
mysql_select_db($database_follows, $follows);
$query_note = "SELECT * FROM follows_notes WHERE note_id = ".$_GET['note']."";
$note = mysql_query($query_note, $follows) or die(mysql_error());
$row_note = mysql_fetch_assoc($note);
$totalRows_note = mysql_num_rows($note);
}


// Here I pull the value of contact_user and create a variable of row_contactJ with that value

mysql_select_db($database_follows, $follows);
$query_contact_join = "SELECT * FROM follows_contacts WHERE contact_id = ".$_GET['id']."";
$contactJ = mysql_query($query_contact_join, $follows) or die(mysql_error());
$row_contactJ = mysql_fetch_assoc($contactJ);



// Here I pull the value of user_id using the previous variable of row_conactJ
mysql_select_db($database_follows, $follows);
$query_contact_join2 = "SELECT * FROM follows_users WHERE user_id = ".$row_contactJ['contact_user']."";
$contactJ2 = mysql_query($query_contact_join2, $follows) or die(mysql_error());
$row_contactJ2 = mysql_fetch_assoc($contactJ2);


//



//INSERT NOTE FOR CONTACT
if ($update==0) {
if ($_POST['note_text']) {
mysql_query("INSERT INTO follows_notes (note_contact, note_addedby, note_text, note_date, note_status) VALUES 
	(
	".$row_contact['contact_id'].",
	'".addslashes($_POST['note_addedby'])."',
	'".addslashes($_POST['note_text'])."',
	".time().",
	1
	)
");
set_msg('Note Added');
$cid = $_GET['id'];
$goto = "contact-details.php?id=$cid";
header(sprintf('Location: %s', $goto)); die;
}
}
//

//UPDATE NOTE
if ($update==1) {
if ($_POST['note_text']) {
mysql_query("UPDATE follows_notes SET note_text = '".addslashes($_POST['note_text'])."' , note_addedby = '".addslashes($_POST['note_addedby'])."' , note_date = ".time()." WHERE note_id = ".$_GET['note']."");
$cid = $_GET['id'];
$goto = "contact-details.php?id=$cid";
set_msg('Note Updated');
header(sprintf('Location: %s', $goto)); die;
}
}
//


//UPDATE HISTORY

$query_checkhistory = "SELECT history_contact FROM follows_history WHERE history_contact = ".$_GET['id']."";
$checkhistory = mysql_query($query_checkhistory, $follows) or die(mysql_error());
$row_checkhistory = mysql_fetch_assoc($checkhistory);
$totalRows_checkhistory = mysql_num_rows($checkhistory);


if ($totalRows_checkhistory > 0) { 
mysql_query("UPDATE follows_history SET history_status = 2 WHERE history_contact = ".$_GET['id']."");
}

mysql_query("INSERT INTO follows_history (history_contact, history_date, history_status) VALUES
(
	".$row_contact['contact_id'].",
	".time().",
	1
)
");


//For Counting days from followup start

$start_ts = time();
$end_ts = $row_contact['contact_date'];
$numdays = dateDiffTs($start_ts, $end_ts);
//

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $row_contact['contact_first']; ?> <?php echo $row_contact['contact_last']; ?></title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>
<script src="includes/src/unittest.js" type="text/javascript"></script>
<script type="text/javascript">
function expandSection(id){
	var mySection = document.getElementById(id);
if(mySection.style.display=="none"){
	mySection.style.display="block";
	} else { 
		mySection.style.display="none";
	}
}
</script>

<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />

</head>

<body <?php if ($row_notes['note_date'] > time()-1) { ?>onload="new Effect.Highlight('newnote'); return false;"<?php } ?>>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">
<span class="notices" style="display:<?php echo $dis; ?>">
    <?php display_msg(); ?>
    </span>
<div style="display:block; margin-bottom:5px">
<?php if ($row_contact['contact_image']) { ?><img src="images/<?php echo $row_contact['contact_image']; ?>" width="95" height="71" class="contactimage" /><?php } ?>
<h2><?php echo $row_contact['contact_first']; ?> <?php echo $row_contact['contact_last']; ?><span style="color:#999999"> Currently assigned to: <?php echo $row_contactJ2['user_name'] . "<br>"; ?></span></h2><a href="contact.php?id=<?php echo $row_contact['contact_id']; ?>" class="button"><span class="edit">Edit Follow-Up info</span></a> <span class="numbers">Day <?php echo $numdays;?></span>   
<br clear="all" /> 
</div>

<p><br />
    </p>


    <form id="form1" name="form1" method="post" action="">
    <input type="hidden" name="note_addedby" value="<?php echo $row_userinfo['user_name']; ?>" />
<?php if ($update==0) { echo "Add a new note <br>"; } ?>
<textarea name="note_text" style="width:95% "rows="3" id="note_text" class="required"><?php echo $row_note['note_text']; ?></textarea>
        <br />
        <input type="submit" name="Submit2" value="<?php if ($update==1) { echo Update; } else { echo Add; } ?> note" />
      <?php if ($update==1) { ?>  <a href="delete.php?note=<?php echo $row_note['note_id']; ?>&amp;id=<?php echo $row_note['note_contact']; ?>" onclick="javascript:return confirm('Are you sure you want to delete the note?')">Delete Note</a><?php } ?>
<?php if ($totalRows_notes > 0) { ?>
        <hr />
        <?php do { ?>
<div <?php if ($row_notes['note_date'] > time()-1) { ?>id="newnote"<?php } ?>>
        <span class="datedisplay"><a href="?id=<?php echo $row_contact['contact_id']; ?>&note=<?php echo $row_notes['note_id']; ?>"><?php echo date('F d, Y', $row_notes['note_date']); ?>
		  <?php echo " - by " . $row_notes['note_addedby']; ?>
          </a></span><br />
          <?php echo $row_notes['note_text']; ?>
</div>
          <hr />
              <?php } while ($row_notes = mysql_fetch_assoc($notes)); ?></form>
<?php } ?>


    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
  <?php include('includes/right-column.php'); ?>
  
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
