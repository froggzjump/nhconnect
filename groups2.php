<?php require_once('includes/config.php'); ?>
<?php
include('includes/sc-includes.php');

ifnotadmin($currentlevel);
$pagetitle = 'Groups';
$update = 0;

if (isset($_GET['id'])) {
$update = 1;
}

?>
<?php


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


mysql_select_db($database_follows, $follows);
$query_users = "SELECT * FROM follows_group INNER JOIN follows_users ON leader_id = user_id ";
$sys_users = mysql_query($query_users, $follows) or die(mysql_error());
$row_users = mysql_fetch_assoc($sys_users);
$totalRows_users = mysql_num_rows($sys_users);

$query_forlead = "SELECT * FROM follows_users WHERE user_level = 3";
$sys_forlead = mysql_query($query_forlead, $follows) or die(mysql_error());
$row_leadusers = mysql_fetch_assoc($sys_forlead);
$totalRows_leadusers = mysql_num_rows($sys_forlead);



//mysql_select_db($database_follows, $follows);
//$query_notes = "SELECT * FROM follows_group INNER JOIN follows_users ON leader_id = user_id ";
//$notes = mysql_query($query_notes, $follows) or die(mysql_error());
//$row_notes = mysql_fetch_assoc($notes);
//$totalRows_notes = mysql_num_rows($notes);



//
if ($update==1) {
mysql_select_db($database_follows, $follows);
$query_contact = "SELECT * FROM follows_group WHERE group_id = ".$_GET['id']."";
$contact = mysql_query($query_contact, $follows) or die(mysql_error());
$row_contact = mysql_fetch_assoc($contact);
$totalRows_contact = mysql_num_rows($contact);

$whoisthelead = $row_contact['leader_id'];

$query_contactl = "SELECT * FROM follows_users WHERE user_id = $whoisthelead";
$wholeads = mysql_query($query_contactl, $follows);
$row_qlead = mysql_fetch_assoc($wholeads);
 }

if ($update==1) {
mysql_select_db($database_follows, $follows);
$query_glist = "SELECT * FROM follows_users WHERE member_group_id = ".$_GET['id']."";
$contactg = mysql_query($query_glist, $follows) or die(mysql_error());
$row_glist = mysql_fetch_assoc($contactg);
$totalRows_glist = mysql_num_rows($contactg);
}


//


//ADDIONS - NEW
if ($update==0) {
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
   
   
  $insertSQL = sprintf("INSERT INTO follows_group (leader_id, group_name) VALUES (%s, %s)",
                       GetSQLValueString(trim($_POST['leader_id']), "int"),
                       GetSQLValueString(trim($_POST['group_name']), "text"));

  mysql_select_db($database_follows, $follows);
  $Result1 = mysql_query($insertSQL, $follows) or die(mysql_error());

	set_msg('Group Added');
	$cid = mysql_insert_id();
	$redirect = "groups2.php?id=$cid";
	header(sprintf('Location: %s', $redirect)); die;
}
}


//UPDATES
if ($update==1) {
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

   

  $updateSQL = sprintf("UPDATE follows_group SET leader_id=%s, group_name=%s WHERE group_id=%s",
                      				   
					   GetSQLValueString(trim($_POST['leader_id']), "int"),
                       GetSQLValueString(trim($_POST['group_name']), "text"),
					   GetSQLValueString(trim($_POST['group_id']), "int"));

  mysql_select_db($database_follows, $follows);
  $Result1 = mysql_query($updateSQL, $follows) or die(mysql_error());
  
  
	set_msg('Group Updated');
	$cid = $_GET['id'];
	$redirect = "groups2.php?id=$cid";
	header(sprintf('Location: %s', $redirect)); die;
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>
<script type="text/javascript" src="calendar.js"></script>

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

<link rel="alternate stylesheet" type="text/css" media="all" href="calendar-blue.css" id="defaultTheme" title="winter"  />
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />

<style type="text/css">
.round-a-error{
		background:#CC0000 url(../images/round_red-left.png) left top no-repeat;
		color:#FFFFFF;
		text-align:center;
	}
		.round-a-error div{
			background:url(../images/round_red-right.png) right bottom no-repeat;
			padding:4px;
		}
</style>

<title><?php if ($update==0) { echo "Add Group"; } ?></title> 
</head>

<body>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">
    <h2><?php if ($update==1) { echo "Update Group " . $row_contact['group_name']; } else { echo "Add Group"; } ?></h2>
  
  
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        
        <td colspan="4">
        <span class="notices" id="notice" style="display:<?php echo $dis; ?>">
        <?php display_msg(); ?></span>
        </td>
        
      </tr>
      
     <tr>
       <td width="28%">Group Name<br />
            <input name="group_name" type="text" class="required" id="group_name" value="<?php echo $row_contact['group_name']; ?>" size="25" />
       </td>
       <td width="72%"><?php if ($update==1) { echo "Group Leader ";} else { echo "Select Group Leader"; } ?><br />
                <select name="leader_id" id="leader_id">
                        <option value="<?php if ($update==1) { echo $row_contact['leader_id']; }?>">
						<?php if ($update==1) { echo $row_qlead['user_name']; } else { echo "Select"; } ?>
                        </option>
  <?php 
   $query_userassign = "SELECT user_id,user_name,user_email FROM follows_users WHERE user_level = 3 ORDER BY user_name";
   $userassign = mysql_query($query_userassign, $follows);
   
     if(mysql_num_rows($userassign)) {
	   while($row_userassign = mysql_fetch_row($userassign))
	   
       {
		   
      $totalRows_leaders = mysql_num_rows($userassign);
	   print("<option value=\"$row_userassign[0]\">$row_userassign[1]</option>");
       }
     } else {
       print("<option value=\"\">No Leaders Available</option>");
     } 
	 
 ?>   

     <?php if (($row_userinfo['user_level']!=1) && ($update == 0) ) { ?>
                     <option value="<?php echo $row_userinfo['user_id'];?>"><?php echo $row_userinfo['user_name'];?></option>
     <?php } ?>
     
</select>
        </td>
     </tr>
     
     <tr>
        <td colspan="2">            
          <p>&nbsp;</p>
        </td>
     </tr>
		
</table>		
        <?php if($totalRows_leadusers < 1) { ?>

        <div class="round-a-error"><div>Step 1:  There are no Group Leaders Defined</div></div><br />
        <div class="round-a-error"><div>
        <strong>You need to go into the Workers Tab</strong><br />
        In the workers tab select the user/worker that you want to be a group leader and then make sure you set them to user level 3 (Group Leader).
        </div></div>
        <?php }?>	
        

<?php if($update == 1) {?>

<table>
<h2>Current Members in Group <?php echo $row_contact['group_name']; ?></h2>
       <tr>
       
		   <th><a href="?<?php echo $name; ?>"> Worker Name</a></th>
	       <th><a href="?<?php echo $name; ?>"> Worker ID</a></th>
           <th>&nbsp;</th>
	  </tr>

<?php if ($totalRows_glist < 1) { 
echo "<span class=\"bar_artwork\"><strong> No Members in this group </strong></span>";
}
?>
<?php do { $row_count++; ?>
		<tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td width="50%"><a href="user.php?id=<?php echo $row_glist['user_id']; ?>"> <?php echo $row_glist['user_name']; ?></a></td>
    	  <td width="50%"><?php echo $row_glist['user_id']; ?></td>
        </tr>
        <?php } while ($row_glist = mysql_fetch_assoc($contactg)); ?>
    
<?php }?>




        <tr><br />
          <td colspan="2"><p>
            <input type="submit" name="Submit2" value="<?php if ($update==1) { echo "Update"; } else { echo 'Add'; } ?> Group" />
			<input name="group_id" type="hidden" id="group_id" value="<?php echo $row_contact['group_id']; ?>" />
            <input type="hidden" name="MM_insert" value="form1" />
          
          </p></td>
        </tr>
      </table>
      
      
      <p>&nbsp;</p>
      <input type="hidden" name="MM_update" value="form1">
    </form>
    
    
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      

		<tr>
		   <th><a href="?<?php echo $name; ?>">Group Name</a></th>
	       <th><a href="?<?php echo $name; ?>">Leader Name</a></th>
           <th><a href="?<?php echo $name; ?>">Leader ID</a></th>
           <th><a href="?<?php echo $name; ?>">Add Worker to Group</a></th>
    	 
	  </tr>

<?php if ($totalRows_users < 1) { 

echo "<div class=\"round-a-error\"><div>Step 2:  There are no groups defined</div></div><br />
        <div class=\"round-a-error\"><div>
        <strong>You need to create a group.</strong><br />
        Remember to add a group leader while creating the group.
        </div></div>"; } ?>
        
<?php do { $row_count++; ?>
		<tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td width="5%"><a href="groups2.php?id=<?php echo $row_users['group_id']; ?>"><?php echo $row_users['group_name']; ?></a></td>
          <td width="5%"><?php echo $row_users['user_name']; ?></td>
		  <td width="5%"><?php echo $row_users['leader_id']; ?></td>
          <td width="6%"> 
          <input type=button onClick=window.open("gtest4.php?grp=<?php echo $row_users['group_id'];?>","Ratting","width=550,location=no,height=375,left=150,top=200,toolbar=0,status=0,scrollbars=yes"); value="Add Worker"></td> 
          <td width="7%"><a href="delete.php?grp=<?php echo $row_users['group_id']; ?>" onclick="javascript:return confirm('Are you sure you want to delete group <?php echo $row_users['group_name']; ?>?')">Delete Group</a></td>
        </tr>
        <?php } while ($row_users = mysql_fetch_assoc($sys_users)); ?>
    </table>
    
    
    
    
  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>