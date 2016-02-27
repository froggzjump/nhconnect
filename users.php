<?php require_once('includes/config.php'); ?>
<?php
include('includes/sc-includes.php');
$pagetitle = 'Workers';


//SORTING

$sorder = "ORDER BY user_name ASC";

$userid = "userid_up";
if (isset($_GET['userid_up'])) {
$sorder = "ORDER BY user_id ASC";
$userid = "userid_down";
} elseif (isset($_GET['userid_down'])) {
$sorder = "ORDER BY user_id DESC";
}

$name = "name_up";
if (isset($_GET['name_up'])) {
$sorder = "ORDER BY user_name ASC";
$name = "name_down";
} elseif (isset($_GET['name_down'])) {
$sorder = "ORDER BY user_name DESC";
}

$email = "email_up";
if (isset($_GET['email_up'])) {
$sorder = "ORDER BY user_email ASC";
$email = "email_down";
} elseif (isset($_GET['email_down'])) {
$sorder = "ORDER BY user_email DESC";
}

$phone = "phone_up";
if (isset($_GET['phone_up'])) {
$sorder = "ORDER BY user_phone ASC";
$phone = "phone_down";
} elseif (isset($_GET['email_phone'])) {
$sorder = "ORDER BY user_phone DESC";
}

$level = "level_up";
if (isset($_GET['level_up'])) {
$sorder = "ORDER BY user_level ASC";
$level = "level_down";
} elseif (isset($_GET['level_down'])) {
$sorder = "ORDER BY user_level DESC";
}
//END SORTING




//Security - Only Admins allowed Here

if ($row_userinfo['user_level'] == 1) {
$sqlworkers = "SELECT * FROM follows_users $sorder";
}

if ($row_userinfo['user_level'] == 2) {
header ("Location: contacts.php");
}


if ($row_userinfo['user_level'] == 3) {
mysql_select_db($database_follows, $follows);
$query_groups = "SELECT leader_id, group_id FROM follows_group WHERE leader_id = $whois";
$followss = mysql_query($query_groups, $follows) or die(mysql_error());
$row_groups = mysql_fetch_assoc($followss);
$totalRows_groups = mysql_num_rows($followss);

$ileadg	= $row_groups['group_id'];
$sqlworkers = "SELECT * FROM follows_users WHERE member_group_id = $ileadg $sorder";
}

// end Security

?>
<?php



mysql_select_db($database_follows, $follows);
$follows = mysql_query($sqlworkers, $follows) or die(mysql_error());
$row_users = mysql_fetch_assoc($follows);
$totalRows_users = mysql_num_rows($follows);

if ($totalRows_users < 1) {
set_msg('Add some users to be added to your group');	
header('Location: user.php');

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

<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include('includes/header.php'); ?>
  
  <div class="container">
  <div class="leftcolumn">
    <h2><?php echo MINISTRY . " Workers (". $totalRows_users .")"   ;?></h2>
<?php if ($totalRows_users > 0) { ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td colspan="4"><span class="notices" id="notice" style="display:<?php echo $dis; ?>">
        <?php display_msg(); ?><?php echo print_r($row_groups); ?>
        </span></td>
      </tr>

		<tr>
		  <th  style="padding-left:5px"><a href="?<?php echo $userid; ?>">ID</a></th>
          <th><a href="?<?php echo $name; ?>">Name</a></th>
		  <th><a href="?<?php echo $phone; ?>">Phone</a></th>
		  <th><a href="?<?php echo $email; ?>">Email</a></th>
          <th><a href="?<?php echo $level; ?>">Level</a></th>
          <th>Assign Followup</th>
          
		  <th>&nbsp;</th>
	  </tr>


<?php do { $row_count++; ?>
		<tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td style="padding-left:5px" width="5%"><?php echo $row_users['user_id']; ?></td>
          <td width="24%"><a href="user.php?id=<?php echo $row_users['user_id']; ?>"><?php echo $row_users['user_name']; ?> </a></td>
          <td width="22%"><?php echo $row_users['user_phone']; ?></td>
          <td width="35%"><a href="mailto:<?php echo $row_users['user_email']; ?>"><?php echo $row_users['user_email']; ?></a></td>
          <td width="7%"><?php echo $row_users['user_level']; ?></td>
          <td><input type=button onClick=window.open("wtest.php?wid=<?php echo $row_users['user_id']; ?>","Ratting","width=550,location=no,height=375,left=150,top=200,toolbar=0,status=0,scrollbars=1"); value="Make Assignment"></td> 
          <?php if ($row_userinfo['user_level'] == 1) { ?> <td width="7%"><a href="delete.php?user=<?php echo $row_users['user_id']; ?>" onclick="javascript:return confirm('Are you sure you want to delete the Worker <?php echo $row_users['user_name'] ; ?>?')">Delete</a></td><?php }?>
        </tr>
        <?php } while ($row_users = mysql_fetch_assoc($follows)); ?>
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
