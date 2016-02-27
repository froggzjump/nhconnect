<?php require_once('includes/config.php'); ?>
<?php
include('includes/sc-includes.php');

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
    <h2>Bible Studies</h2> 
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td colspan="4"><span class="notices" id="notice" style="display:<?php echo $dis; ?>"><?php display_msg(); ?></span></td>
      </tr>

		<tr>
		  <th>Chapter</th>
		  <th>Bible Lesson</th>
          <th>Link</th>
          
      </tr>
      

      <tr>
    <td>1</td>
    <td>Welcome to the Family</td>
    <td><a href="http://www.newharvestconnect.com/sd/docs/bs/1.pdf" target="_blank">Open / Download</a></td>
  </tr>
  <tr>
    <td>2</td>
    <td>Communicating with God</td>
   <td><a href="http://www.newharvestconnect.com/sd/docs/bs/2.pdf" target="_blank">Open / Download</a></td>
  </tr>
  <tr>
    <td>3</td>
    <td>God's Love letter to us</td>
   <td><a href="http://www.newharvestconnect.com/sd/docs/bs/3.pdf" target="_blank">Open / Download</a></td>
  </tr>
  <tr>
    <td>4</td>
    <td>We need each other</td>
    <td><a href="http://www.newharvestconnect.com/sd/docs/bs/4.pdf" target="_blank">Open / Download</a></td>
  </tr>
  <tr>
    <td>5</td>
    <td>God has Wonderful plans for us</td>
   <td><a href="http://www.newharvestconnect.com/sd/docs/bs/5.pdf" target="_blank">Open / Download</a></td>
  </tr>
  <tr>
    <td>6</td>
    <td>Steps for Continued Growth</td>
   <td><a href="http://www.newharvestconnect.com/sd/docs/bs/6.pdf" target="_blank">Open / Download</a></td>
  </tr>
    </table>


  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>


</body>
</html>
