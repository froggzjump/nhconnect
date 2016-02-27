<?php require_once('includes/config.php'); ?>
<?php
include('includes/sc-includes.php');
$pagetitle = Categories;

$add = 0;
if (isset($_POST['service_name'])) {
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
  $insertSQL = sprintf("INSERT INTO follows_services (service_name, service_time, service_day) VALUES (%s, %s, %s)",
  						GetSQLValueString(trim($_POST['service_name']), "text"),
                       	GetSQLValueString(trim($_POST['service_time']), "text"),
                        GetSQLValueString(trim($_POST['service_day']), "text"));

  mysql_select_db($database_follows, $follows);
  $Result1 = mysql_query($insertSQL, $follows) or die(mysql_error());
	set_msg('Service Added');
	$cid = mysql_insert_id();
	$redirect = "services.php";
	header(sprintf('Location: %s', $redirect)); die;
}
}


//SORTING

$sorder = "ORDER BY service_name ASC";

$name = "name_up";
if (isset($_GET['name_up'])) {
$sorder = "ORDER BY service_name ASC";
$name = "name_down";
} elseif (isset($_GET['name_down'])) {
$sorder = "ORDER BY service_name DESC";
}



//END SORTING


mysql_select_db($database_follows, $follows);
$query_users = "SELECT * FROM follows_services $sorder";
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

<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include('includes/header.php'); ?>
  
  <div class="container">
  <div class="leftcolumn">
    <h2><?php echo "Manage Services";?></h2>
    
<?php if ($totalRows_users >= 0) { ?>




<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
             <td width="100%">Service name to add<br />
                <input name="service_name" type="text" id="service_name" value="" size="25" />
             </td>
        </tr>
       <tr> 
             <td width="100%">Service time of day<br />
                <select name="service_time" id="service_time">
                			<option value="9:00am" <?php if (!(strcmp("9:00am", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>9:00am</option>
                            <option value="10:00am" <?php if (!(strcmp("10:00am", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>10:00am</option>
<option value="11:00am" <?php if (!(strcmp("11:00am", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>11:00am</option>
                            <option value="12:00pm" <?php if (!(strcmp("12:00pm", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>12:00pm</option>
                            <option value="1:00pm" <?php if (!(strcmp("1:00pm", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>1:00pm</option>
                            <option value="2:00pm" <?php if (!(strcmp("2:00pm", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>2:00pm</option>
                            <option value="3:00pm" <?php if (!(strcmp("3:00pm", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>3:00pm</option>
                            <option value="4:00pm" <?php if (!(strcmp("4:00pm", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>4:00pm</option>
                            <option value="5:00pm" <?php if (!(strcmp("5:00pm", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>5:00pm</option>
                            <option value="6:00pm" <?php if (!(strcmp("6:00pm", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>6:00pm</option>
                            <option value="7:00pm" <?php if (!(strcmp("7:00pm", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>7:00pm</option>
                            <option value="8:00pm" <?php if (!(strcmp("8:00pm", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>8:00pm</option>
                            <option value="9:00pm" <?php if (!(strcmp("9:00pm", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>9:00pm</option>
                            <option value="10:00pm" <?php if (!(strcmp("10:00pm", $row_contact['service_time']))) {echo "selected=\"selected\"";} ?>>10:00pm</option>
                            
                        </select>
             </td>
        </tr> <tr> 
             <td width="100%">Service day of week<br />
                <select name="service_day" id="service_day">
                			<option value="Sunday" <?php if (!(strcmp("Sunday", $row_contact['service_day']))) {echo "selected=\"selected\"";} ?>>Sunday</option>
                            <option value="Monday" <?php if (!(strcmp("Monday", $row_contact['service_day']))) {echo "selected=\"selected\"";} ?>>Monday</option>
<option value="Tuesday" <?php if (!(strcmp("Tuesday", $row_contact['service_day']))) {echo "selected=\"selected\"";} ?>>Tuesday</option>
                            <option value="Wednesday" <?php if (!(strcmp("Wednesday", $row_contact['service_day']))) {echo "selected=\"selected\"";} ?>>Wednesday</option>
                            <option value="Thursday" <?php if (!(strcmp("Thursday", $row_contact['service_day']))) {echo "selected=\"selected\"";} ?>>Thursday</option>
                            <option value="Friday" <?php if (!(strcmp("Friday", $row_contact['service_day']))) {echo "selected=\"selected\"";} ?>>Friday</option>
                            <option value="Saturday" <?php if (!(strcmp("Saturday", $row_contact['service_day']))) {echo "selected=\"selected\"";} ?>>Saturday</option>
                        </select>
             </td>
        </tr>

        <tr>
          <td colspan="2"><p>
            <input type="submit" name="Submit2" value="Add Service" />
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
		   <th><a href="?<?php echo $name; ?>">Services</a></th>
	
    	   <th>&nbsp;</th>
	  </tr>

<?php if ($totalRows_users < 1) { 
echo "<span class=\"bar_artwork\"><strong>" . "Please add a Service" . "<br />" . "These are used for the \"Service Attended\" drop down select box when adding or updating a followup. </strong></span>";
}
?>
<?php do { $row_count++; ?>
		<tr>
          <td width="5%"><?php echo $row_users['service_name']; ?></td>
          <td width="5%"><?php echo $row_users['service_day']; ?></td>
          <td width="5%"><?php echo $row_users['service_time']; ?></td>
          
          <td width="7%"><a href="delete.php?serv=<?php echo $row_users['id']; ?>" onclick="javascript:return confirm('Are you sure you want to delete the service <?php echo $row_users['service_name']; ?>?')">Delete</a></td>
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
