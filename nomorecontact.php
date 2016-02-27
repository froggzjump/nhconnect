<?php require_once('includes/config.php'); ?>
<?php
include('includes/sc-includes.php');
$pagetitle = FollowUp;

$whois = $row_userinfo['user_id'];
$whobe = $row_userinfo['user_name'];

	
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

$sorder = "ORDER BY contact_id DESC";


//SORTING
$name = "name_up";
if (isset($_GET['name_up'])) {
$sorder = "ORDER BY contact_first ASC";
$name = "name_down";
} elseif (isset($_GET['name_down'])) {
$sorder = "ORDER BY contact_first DESC";
}

$email = "email_up";
if (isset($_GET['email_up'])) {
$sorder = "ORDER BY contact_email ASC";
$email = "email_down";
} elseif (isset($_GET['email_down'])) {
$sorder = "ORDER BY contact_email DESC";
}

$phone = "phone_up";
if (isset($_GET['phone_up'])) {
$sorder = "ORDER BY contact_phone ASC";
$phone = "phone_down";
} elseif (isset($_GET['phone_down'])) {
$sorder = "ORDER BY contact_phone DESC";
}

$userassigned = "userassigned_up";
if (isset($_GET['userassigned_up'])) {
$sorder = "ORDER BY contact_user ASC";
$userassigned = "userassigned_down";
} elseif (isset($_GET['userassigned_down'])) {
$sorder = "ORDER BY contact_user DESC";
}


$countdays = "countdays_up";
if (isset($_GET['countdays_up'])) {
$sorder = "ORDER BY contact_date ASC";
$countdays = "countdays_down";
} elseif (isset($_GET['countdays_down'])) {
$sorder = "ORDER BY contact_date DESC";
} 


//END SORTING




if ($row_userinfo['user_level'] == 1) {
mysql_select_db($database_follows, $follows);
$query_contacts = "SELECT * FROM follows_contacts WHERE contact_stage = 18 $sorder";
$follows = mysql_query($query_contacts, $follows) or die(mysql_error());
$row_contacts = mysql_fetch_assoc($follows);
$totalRows_contacts = mysql_num_rows($follows);


if ($totalRows_contacts < 1) { 
header('Location: contact.php');
}
}


if ($row_userinfo['user_level'] == 2) {
mysql_select_db($database_follows, $follows);
$query_contacts = "SELECT * FROM follows_contacts WHERE contact_user = $whois AND contact_stage = 18 $sorder" ;
$follows = mysql_query($query_contacts, $follows) or die(mysql_error());
$row_contacts = mysql_fetch_assoc($follows);
$totalRows_contacts = mysql_num_rows($follows);

$whoam = $row_contacts['contact_user'];

if ($totalRows_contacts < 1) { 
$noassign = "You do not have any assignments as of yet";
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
    <h2><?php echo MINISTRY . " Follow-Ups";?></h2> for <?php echo $row_userinfo['user_name']; ?>
<?php if ($totalRows_contacts > 0) { ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td colspan="4"><span class="notices" id="notice" style="display:<?php echo $dis; ?>">
        <?php display_msg(); ?>
        </span></td>
      </tr>

		<tr>
		  <th  style="padding-left:5px"><a href="?<?php echo $name; ?>">Name</a></th>
		  <th><a href="?<?php echo $phone; ?>">Phone</a></th>
		  <!--- <th><a href="?<?php // echo $email; ?>">Email</a></th> --->
          <th><a href="?<?php echo $userassigned; ?>">NHCF Staff</a></th>
          <th><a href="?<?php echo $countdays; ?>">Days</a></th>
          
		  <th>&nbsp;</th>
	  </tr>


<?php do { $row_count++; ?>

<?php // This piece of Code gets the username (worker that has the followup) //
$getmyname = $row_contacts['contact_user'];
$query_users = "SELECT user_name FROM follows_users WHERE user_id = $getmyname";
$follows2 = mysql_query($query_users) or die(mysql_error());
$row_users = mysql_fetch_assoc($follows2);
// end of Code that gets username - Creates Array $row_users ?> 


<?php
//For Counting days from followup start
	      $time_A = strtotime($row_contacts['follow_date']);
          $time_B=strtotime(now);
		  $numdays=intval(($time_B-$time_A)/86400)+1;
?>	



		<tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td style="padding-left:5px" ><a href="contact-details.php?id=<?php echo $row_contacts['contact_id']; ?>"><?php echo $row_contacts['contact_first']; ?> <?php echo $row_contacts['contact_last']; ?></a></td>
          <td ><?php echo $row_contacts['contact_phone']; ?></td>
   
          <td ><?php if ($row_userinfo['user_level'] == 1) { echo $row_users['user_name'];} else {echo $whobe;} ?></td>
          <td ><?php echo $numdays; ?></td>
         
          <td > <?php if ($row_userinfo['user_level'] == 1) { ?><a href="delete.php?contact=<?php echo $row_contacts['contact_id']; ?>" class="button" onclick="javascript:return confirm('Are you sure you want to delete the FollowUp for: <?php echo $row_contacts['contact_first']; ?> <?php echo $row_contacts['contact_last']; ?>?')"><span class="del">Delete</span></a><?php } ?></td>
        </tr>
        <?php } while ($row_contacts = mysql_fetch_assoc($follows)); ?>
    </table>
<?php } ?>

    <p>&nbsp; </p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
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
