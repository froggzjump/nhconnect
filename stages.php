<?php require_once('includes/config.php'); ?>
<?php
include('includes/sc-includes.php');
$pagetitle = Stages;

$add = 0;
if (isset($_POST['stages'])) {
$add = 1;
}

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

if ($add==1) {
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO follows_stages (stage, color) VALUES (%s, %s)",
                        GetSQLValueString(trim($_POST['stages']), "text"),
						GetSQLValueString(trim($_POST['input0']), "text"));

  mysql_select_db($database_follows, $follows);
  $Result1 = mysql_query($insertSQL, $follows) or die(mysql_error());
	set_msg('Stage Added');
	$cid = mysql_insert_id();
	$redirect = "stages.php";
	header(sprintf('Location: %s', $redirect)); die;
}
}




//SORTING

$sorder = "ORDER BY stage ASC";

$name = "name_up";
if (isset($_GET['name_up'])) {
$sorder = "ORDER BY stage ASC";
$name = "name_down";
} elseif (isset($_GET['name_down'])) {
$sorder = "ORDER BY stage DESC";
}



//END SORTING


mysql_select_db($database_follows, $follows);
$query_users = "SELECT * FROM follows_stages $sorder";
$sys_users = mysql_query($query_users, $follows) or die(mysql_error());
$row_users = mysql_fetch_assoc($sys_users);
$totalRows_users = mysql_num_rows($sys_users);


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
<script language=JavaScript src="includes/src/picker.js"></script>

<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include('includes/header.php'); ?>
  
  <div class="container">
  <div class="leftcolumn">
    <h2><?php echo "Manage Stages";?></h2>
    
<?php if ($totalRows_users >= 0) { ?>




<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
             <td width="100%">Stage to add<br />
                <input name="stages" type="text" class="required" id="stages" value="" size="25" /><br />Color<br />
                
                <input type="text" name="input0" class="required">
			<a href="javascript:TCP.popup(document.forms['form1'].elements['input0'])">
            <img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a>
                
               
                
                
                
            </p></td>
        </tr>
      

        <tr>
          <td colspan="2"><p>
            <input type="submit" name="Submit2" value="Add Stage" />
            <input type="hidden" name="MM_insert" value="form1" />
          
          </p></td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <input type="hidden" name="MM_update" value="form1">
    </form>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td colspan="4"><span class="notices" id="notice" style="display:<?php echo $dis; ?>">
        <?php display_msg(); ?>
        </span></td>
      </tr>

		<tr>
		   <th><a href="?<?php echo $name; ?>">Stages</a></th>
	       <th><a href="?<?php echo $name; ?>">Color</a></th>
    	   <th>&nbsp;</th>
	  </tr>

<?php if ($totalRows_users < 1) { 
echo "<span class=\"bar_artwork\"><strong>" . "Please add a stage" . "<br />" . "These are used for the \"FollowUp Stage\" drop down select box when adding or updating a followup. </strong></span>";
}
?>
<?php do { $row_count++; ?>
		<tr bgcolor="<?php echo $row_users['color']; ?>">
          <td width="5%"><a href="editst.php?st=<?php echo $row_users['id']; ?>"><?php echo $row_users['stage']; ?></a></td>
          <td width="5%"><?php echo $row_users['color']; ?></td>
          <td width="7%"><a href="delete.php?st=<?php echo $row_users['id']; ?>" onclick="javascript:return confirm('Are you sure you want to delete stage <?php echo $row_users['stage']; ?>?')">Delete</a></td>
        </tr>
        <?php } while ($row_users = mysql_fetch_assoc($sys_users)); ?>
    </table>
<?php } ?>

    <p>&nbsp; </p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    
    
  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>


</body>
</html>
<?php
mysql_free_result($sys_users);

mysql_free_result($history);
?>
