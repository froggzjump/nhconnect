<?php
include "includes/config.php";
include('includes/sc-includes.php');
$pagetitle = FollowUp;

if (isset($_GET['tid']) && ($_GET['fid'])) {
$emailto = $_GET['tid'];
$fromsender = $_GET['fid'];

mysql_select_db($database_follows, $follows);
$query_contacts = "SELECT * FROM follows_contacts WHERE contact_id = $emailto";
$follows = mysql_query($query_contacts, $follows) or die(mysql_error());
$row_contacts = mysql_fetch_assoc($follows);
$totalRows_contacts = mysql_num_rows($follows);

$query_userss = "SELECT * FROM follows_users WHERE user_id = $fromsender";
$followss = mysql_query($query_userss) or die(mysql_error());
$row_userss = mysql_fetch_assoc($followss);
$totalRows_userss = mysql_num_rows($followss);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $pagetitle; ?></title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>
<script language="javascript">
function toggleLayer(whichLayer)
{
if (document.getElementById)
{
// this is the way the standards work
var style2 = document.getElementById(whichLayer).style;
style2.display = style2.display? "":"block";
}
else if (document.all)
{
// this is the way old msie versions work
var style2 = document.all[whichLayer].style;
style2.display = style2.display? "":"block";
}
else if (document.layers)
{
// this is the way nn4 works
var style2 = document.layers[whichLayer].style;
style2.display = style2.display? "":"block";
}
}
</script>

<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">
    <h2><?php echo "Send email To: " . $row_contacts['contact_first'] . " " . $row_contacts['contact_last']; ?></h2>
        <?php echo "email address: " . $row_contacts['contact_email']; ?>
    <p>&nbsp;</p>
    <h2><?php echo "Message From: " . $row_userss['user_name']; ?></h2>
        <?php echo "email address: " . $row_userss['user_email']; ?>
    <p>&nbsp;</p><br />



<form method="POST" action="mailer.php">
  Subject <br />  
  <p><input type="text" name="subjectis"><br /> <br />
  Message <br />
  <p><textarea rows="6" name="messageis" cols="40"></textarea>
       
  </p><br />
  
  <input type="hidden" name="sendersemail" value="<?php echo $row_userss['user_email'];?>" />
  <input type="hidden" name="sendersname"  value="<?php echo $row_userss['user_name']; ?>" />
  <input type="hidden" name="tois" value="<?php echo $row_contacts['contact_email'];?>" />
  <input type="hidden" name="toid" value="<?php echo $emailto;?>" />
  
  <p><input type="submit" value="Submit" name="B1">
     <input type="reset" value="Reset" name="B2"></p>
  
  
</form>
<br />

</div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>