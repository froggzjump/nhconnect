<?php require_once('includes/config.php');

include('includes/sc-includes.php');
$pagetitle = 'Dashboard';

ifnotadmin($currentlevel);

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

$cwhere = "WHERE history_status = 1";
if (isset($_GET['n'])) {
$cwhere = "WHERE history_status = 1 AND (contact_first LIKE '%".addslashes($_GET['n'])."%' OR contact_last LIKE '%".addslashes($_GET['n'])."%' OR name LIKE '%".addslashes($_GET['n'])."%' OR contact_email LIKE '%".addslashes($_GET['n'])."%' OR contact_method LIKE '%".addslashes($_GET['n'])."%')";
}

if (isset($_GET['s'])) {
$cwhere = "WHERE history_status = 1 AND (contact_first LIKE '%".addslashes($_GET['s'])."%' OR contact_last LIKE '%".addslashes($_GET['s'])."%' OR name LIKE '%".addslashes($_GET['s'])."%' OR contact_email LIKE '%".addslashes($_GET['s'])."%' OR contact_method LIKE '%".addslashes($_GET['s'])."%')";
}

$nwhere = "AND contact_stage <> 18";
if (isset($_GET['n'])) {
$search = 1;	
$nwhere = "WHERE name LIKE '%".addslashes($_GET['n'])."%' ";
}

if (isset($_GET['s'])) {
$search = 1;
$nwhere = "WHERE note_text LIKE '%".addslashes($_GET['s'])."%' ";
} 

mysql_select_db($database_follows, $follows);
$query_notes = "SELECT * FROM follows_notes INNER JOIN follows_contacts ON note_contact = contact_id $nwhere ORDER BY note_date DESC LIMIT 0, 25";
$notes = mysql_query($query_notes, $follows) or die(mysql_error());
$row_notes = mysql_fetch_assoc($notes);
$totalRows_notes = mysql_num_rows($notes);

mysql_select_db($database_follows, $follows);
$query_contacts = "SELECT * FROM follows_history INNER JOIN follows_contacts ON contact_id = history_contact $cwhere AND contact_stage <> 18 ORDER BY history_date DESC LIMIT 0, 25";
$follows = mysql_query($query_contacts, $follows) or die(mysql_error());
$row_contacts = mysql_fetch_assoc($follows);
$totalRows_contacts = mysql_num_rows($follows);

if ($totalRows_contacts < 1) { header('Location: contact.php'); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $pagetitle; ?>s</title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>

<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">
<?php if ($search==1) { ?>
Search results<em><?php echo $_GET['n']; ?></em><br />
<br />
<?php } ?>
<?php if ($totalRows_contacts > 0) { ?>
<div id="map" style="width: 625px; height: 400px"></div>
<?php //echo "<a href=\"../../norwalk/map/mapdata.php\" target=\"_blank\">View Large Map</a>" ?>
  
  </div><div><?php include('includes/right-column.php'); ?></div>
    <h2>Recent Follow-Ups Added</h2>
    <?php $i = 1; do { ?>
        <a href="contact-details.php?id=<?php echo $row_contacts['contact_id']; ?>"><?php echo $row_contacts['contact_first']; ?> <?php echo $row_contacts['contact_last']; ?></a><?php if ($totalRows_contacts!=$i) { ?>,<?php } ?> 
      <?php $i++; } while ($row_contacts = mysql_fetch_assoc($follows)); ?>
<hr />
<?php } ?>
<br /><br />

<?php if ($totalRows_notes > 0) { ?>

      <h2>Recent Notes</h2>

    <?php $i = 1; do { ?>
<div <?php if ($row_notes['note_date'] > time()-1) { ?>id="newnote"<?php } ?>>
        <span class="datedisplay"><a href="contact-details.php?id=<?php echo $row_notes['note_contact']; ?>&note=<?php echo $row_notes['note_id']; ?>"><?php echo date('F d, Y', $row_notes['note_date']); ?></a></span> for <a href="contact-details.php?id=<?php echo $row_notes['note_contact']; ?>"><?php echo $row_notes['contact_first']; ?> <?php echo $row_notes['contact_last']; ?></a> - Added by: <?php echo $row_notes['note_addedby']; ?><br />
          <?php echo $row_notes['note_text']; ?>
</div>
          <?php if ($totalRows_notes!=$i) { ?><hr /><?php } ?>
              <?php $i++;  } while ($row_notes = mysql_fetch_assoc($notes)); ?>
<?php } ?>
 
  
  <br clear="all" />

<?php include('includes/footer.php'); ?>

</body>
</html>
<?php
mysql_free_result($follows);

mysql_free_result($notes);
?>
