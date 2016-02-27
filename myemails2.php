<?php require_once('includes/config.php'); ?>
<?php
include('includes/sc-includes.php');
$pagetitle = 'MyEmail';

$whois = $row_userinfo['user_id'];

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

$sorder = "ORDER BY email_date ASC";


//SORTING
$date = "date_up";
if (isset($_GET['date_up'])) {
$sorder = "ORDER BY email_date ASC";
$date = "date_down";
} elseif (isset($_GET['date_down'])) {
$sorder = "ORDER BY email_date DESC";
}


//END SORTING




if ($row_userinfo['user_level'] == 1) {
mysql_select_db($database_follows, $follows);
$query_emails = "SELECT follows_contacts.*, follows_email.* 
   		 FROM follows_contacts 
		 INNER JOIN follows_email ON follows_contacts.contact_id = follows_email.followup_id 
		 WHERE follows_contacts.contact_stage <> 9 ORDER BY email_id";
//AND follows_contact.stage_id <>  9 $sorder";

//$query_emails = "SELECT * FROM follows_email $sorder";
$follows = mysql_query($query_emails, $follows) or die ("Query failed: " . mysql_error() . " Actual query: " . $query_emails);
$row_emails = mysql_fetch_assoc($follows);
$totalRows_emails = mysql_num_rows($follows);


if ($totalRows_emails < 1) { 
header('Location: myemails.php');
}
}


if ($row_userinfo['user_level'] != 1) {
mysql_select_db($database_follows, $follows);
$query_contacts = "SELECT * FROM follows_email WHERE worker_id = $whois $sorder" ;
$follows = mysql_query($query_contacts, $follows) or die(mysql_error());
$row_emails = mysql_fetch_assoc($follows);
$totalRows_emails = mysql_num_rows($follows);



if ($totalRows_emails < 1) { 
$noassign = "You do not have any outstanding emails";
}
}


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
    <h2><?php echo MINISTRY . " Email Notifications";?></h2> for <?php echo $row_userinfo['user_name']; ?>
<?php if ($totalRows_emails > 0) { ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td colspan="4"><span class="notices" id="notice" style="display:<?php echo $dis; ?>"><?php display_msg(); ?></span></td>
      </tr>

		<tr>
		  <th  style="padding-left:5px"><a href="?<?php echo $date; ?>">Notification Date</a></th>
		  <th>FollowUp Name</a></th>
          <th>From:</a></th>
          <th>To:</a></th>
          <th>Status:</a></th>
          <th>ID</a></th>
          <th>&nbsp;</th>
	  </tr>
      
<?php do { $row_count++; ?>

<?php

$whobefore =  $row_emails['followup_id'];
$query_emailss = "SELECT * FROM follows_contacts WHERE contact_id = $whobefore";
$followss = mysql_query($query_emailss) or die("1" . mysql_error());
$row_emailss = mysql_fetch_assoc($followss);
$totalRows_emailss = mysql_num_rows($followss);

$fromwho =  $row_emails['sender_id'];
$query_emailss = "SELECT * FROM follows_users WHERE user_id = $fromwho";
$whos = mysql_query($query_emailss) or die("2" . mysql_error());
$fromwhois = mysql_fetch_assoc($whos);
$totalRows_fromwhois = mysql_num_rows($whos);

$forwho =  $row_emails['worker_id'];
$query_emailss = "SELECT * FROM follows_users WHERE user_id = $forwho";
$forwhos = mysql_query($query_emailss) or die("3" . mysql_error());
$forwhois = mysql_fetch_assoc($forwhos);
$totalRows_forwho = mysql_num_rows($forwhos);


$query_notes = "SELECT * FROM follows_notes WHERE note_contact = $whobefore";
$notes = mysql_query($query_notes) or die("4" . mysql_error());
$row_notes = mysql_fetch_assoc($notes);
$totalRows_notes = mysql_num_rows($notes);

$nonotes = 0; // No FollowUp
if ($totalRows_notes < 1) { 
$nonotes = 1; // Follow-Up Started
}


?>
          <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td style="padding-left:5px" width="20%"><?php echo date('F d, Y', $row_emails['email_date']); ?></td>
          <td width="20%"><a href="contact-details.php?id=<?php echo $row_emailss['contact_id']; ?>"><?php echo $row_emailss['contact_first']; ?> <?php echo $row_emailss['contact_last']; ?></a></td>
          <td width="20%"><?php echo $fromwhois['user_name']; ?></td>
          <td width="20%"><?php echo $forwhois['user_name']; ?></td>
          <td width="20%"><?php if($nonotes == 0){ echo "Follow-Up Started";} else { echo "Waiting";} ?></td>
          <td width="20%"><?php echo $row_emails['email_id']; ?></td>
          <td width="7%"><?php if ($row_userinfo['user_level'] == 1) { ?><a href="delete.php?email=<?php echo $row_emails['email_id']; ?>" onclick="javascript:return confirm('Are you sure you want to delete email concerning: <?php echo $row_emailss['contact_first']; ?> <?php echo $row_emailss['contact_last']; ?>?')">Delete</a><?php }?></td>
        </tr>
        <?php } while ($row_emails = mysql_fetch_assoc($follows)); ?>
    </table>
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

mysql_free_result($history);
?>
