<?php require_once('includes/config.php'); ?><?php require_once('includes/config.php'); 
include('includes/sc-includes.php');
$pagetitle = 'Dashboard';

//if ($row_userinfo['user_level'] == 1) {
//set_msg('Welcome Admin');
//header ("Location: index.php");
//
//}


?>
<?php


$cwhere = "WHERE history_status = 1";
if (isset($_GET['s'])) {
$cwhere = "WHERE history_status = 1 AND (contact_first LIKE '%".addslashes($_GET['s'])."%' OR contact_last LIKE '%".addslashes($_GET['s'])."%' OR contact_email LIKE '%".addslashes($_GET['s'])."%' OR contact_method LIKE '%".addslashes($_GET['s'])."%')";
}
$nwhere = "WHERE contact_user = $whois AND contact_stage <> 18";
//$nwhere = "WHERE contact_user LIKE '%".addslashes($row_userinfo['user_id'])."%' AND contact_stage <> 18";
if (isset($_GET['s'])) {
$search = 1;

$nwhere = "WHERE note_text LIKE '%".addslashes($_GET['s'])."%' AND WHERE contact_user LIKE '%".addslashes($row_userinfo['user_id'])."%'  ";
}


mysql_select_db($database_follows, $follows);
$query_notes = "SELECT * FROM follows_notes INNER JOIN follows_contacts ON note_contact = contact_id $nwhere ORDER BY note_date DESC LIMIT 0, 7";
$notes = mysql_query($query_notes, $follows) or die(mysql_error());
$row_notes = mysql_fetch_assoc($notes);
$totalRows_notes = mysql_num_rows($notes);

mysql_select_db($database_follows, $follows);
$query_contacts = "SELECT * FROM follows_history INNER JOIN follows_contacts ON contact_id = history_contact $cwhere AND contact_stage <> 18 ORDER BY history_date DESC LIMIT 0, 7";
$follows = mysql_query($query_contacts, $follows) or die(mysql_error());
$row_contacts = mysql_fetch_assoc($follows);
$totalRows_contacts = mysql_num_rows($follows);

if ($totalRows_contacts < 1) { header('Location: contact.php'); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $pagetitle; ?></title>
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
 
    <script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo GKEY;?>" type="text/javascript">
    </script>
    <script type="text/javascript" src="map/googlemap.js">
    </script>

</head>

<body onload="load()" onunload="GUnload()">

<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">
<?php if ($search==1) { ?>
Search results for <em><?php echo $_GET['s']; ?></em>.<br />
<br />
<?php } ?>

<?php if ($totalRows_contacts > 0) { ?>
<div id="map" style="width: 625px; height: 400px"></div>
<!---<div><a href="http://newharvestsandiego.com/follows/map/mapdata.html" target="_blank">View Large Map</a></div>    --->
<?php } ?>

<br /><br />

<?php if ($totalRows_notes > 0) { ?>

      <h2>Recent Notes  </h2>

    <?php $i = 1; do { ?>
<div <?php if ($row_notes['note_date'] > time()-1) { ?>id="newnote"<?php } ?>>
        <span class="datedisplay"><a href="contact-details.php?id=<?php echo $row_notes['note_contact']; ?>&note=<?php echo $row_notes['note_id']; ?>"><?php echo date('F d, Y', $row_notes['note_date']); ?></a></span> for <a href="contact-details.php?id=<?php echo $row_notes['note_contact']; ?>"><?php echo $row_notes['contact_first']; ?> <?php echo $row_notes['contact_last']; ?></a> - Added by: <?php echo $row_notes['note_addedby']; ?><br />
          <?php echo $row_notes['note_text']; ?>
</div>
          <?php if ($totalRows_notes!=$i) { ?><hr /><?php } ?>
              <?php $i++;  } while ($row_notes = mysql_fetch_assoc($notes)); ?>
<?php } ?>
  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
<?php
mysql_free_result($follows);

mysql_free_result($notes);
?>
