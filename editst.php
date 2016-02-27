<?php require_once('includes/config.php'); 
include('includes/sc-includes.php');
$pagetitle = editSt;
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
$query_profile = "SELECT * FROM follows_stages WHERE id = '".$_GET['st']."'";
$profile = mysql_query($query_profile, $follows) or die(mysql_error());
$row_profile = mysql_fetch_assoc($profile);
$totalRows_profile = mysql_num_rows($profile);

//UPDATE PROFILE
if (($_POST['stage']) || ($_POST['input0'])){
$password = $row_profile['stage'];

if ($_POST['stage']) {
$password = $_POST['stage'];


}

mysql_query("UPDATE follows_stages SET 
	stage = '".trim($_POST['stage'])."',
	color = '".trim($_POST['input0'])."' WHERE id = '".$_GET['st']."'");
set_msg('Stage Updated');

header('Location: stages.php'); die;
}
//
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Update Profile</title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script language=JavaScript src="includes/src/picker.js"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">
    <h2>Stage Info</h2>
    
    <form id="form1" name="form1" method="post" action="">
      <p>Stage
        <br />
        <input name="stage" type="text" value="<?php echo $row_profile['stage']; ?>" class="required validate-email" size="35" />
      </p>
      <p><br />
      <p>Color
        <br />
                
        <input type="text" name="input0" class="required" value="<?php echo $row_profile['color']; ?>">
			<a href="javascript:TCP.popup(document.forms['form1'].elements['input0'])">
            <img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a>
        
        
      <p>
        <input name="Submit2" type="submit" id="Submit2" value="Update" /> 
        </p>
       
        
    </form>
    
    <p>&nbsp;</p>
  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
