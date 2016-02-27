<?php require_once('includes/config.php'); ?>
<?php
include('includes/sc-includes.php');
$pagetitle = FollowUp;
$whois = $row_userinfo['user_id'];

$update = 0;
if (isset($_GET['id'])) {
$update = 1;
}

?>
<?php

if (!function_exists("GetSQLValueString")) {
	GetSQLValueString();
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



//
if ($update==1) {
mysql_select_db($database_follows, $follows);
$query_contact = "SELECT * FROM follows_contacts WHERE contact_id = ".$_GET['id']."";
$contact = mysql_query($query_contact, $follows) or die(mysql_error());
$row_contact = mysql_fetch_assoc($contact);
$totalRows_contact = mysql_num_rows($contact);
}
//

// Here I pull the value of contact_user and create a variable of row_contactJ with that value
if ($update==1) {
mysql_select_db($database_follows, $follows);
$query_contact_join = "SELECT contact_user FROM follows_contacts WHERE contact_id = ".$_GET['id']."";
$contactJ = mysql_query($query_contact_join, $follows) or die(mysql_error());
$row_contactJ = mysql_fetch_assoc($contactJ);
}


// Here I pull the value of user_id using the previous variable of row_conactJ
if ($update==1) {
mysql_select_db($database_follows, $follows);
$query_contact_join2 = "SELECT user_name FROM follows_users WHERE user_id = ".$row_contactJ['contact_user']."";
$contactJ2 = mysql_query($query_contact_join2, $follows) or die(mysql_error());
$row_contactJ2 = mysql_fetch_assoc($contactJ2);
}
//

//UPLOAD PICTURE
	$picture = $_POST['image_location'];
	$time = substr(time(),0,5);	
   if($_FILES['image'] && $_FILES['image']['size'] > 0){
	$ori_name = $_FILES['image']['name'];
	$ori_name = $time.$ori_name;
	$tmp_name = $_FILES['image']['tmp_name'];
	$src = imagecreatefromjpeg($tmp_name);
	list($width,$height)=getimagesize($tmp_name);
	$newwidth=95;
	$newheight=($height/$width)*95;
	$tmp=imagecreatetruecolor($newwidth,$newheight);
	imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
	$filename = "images/". $ori_name;
	imagejpeg($tmp,$filename,100);
	$picture = $ori_name;
	imagedestroy($src);
	imagedestroy($tmp);	
}
//END UPLOAD PICTURE

//Do Google Geocode
if ($update==0) {
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
   
   $street=$_POST['contact_street'];
   $city=$_POST['contact_city'];
   $zip=$_POST['contact_zip'];
   $state=$_POST['contact_state'];
   $name=$_POST['contact_first'] . " " . $_POST['contact_last'];
   $fulladdress=$_POST['contact_street'] . ", " . $_POST['contact_city'] . ", " . $_POST['contact_state'] . ", " . $_POST['contact_zip'];
   
   
   $mapaddress = urlencode("$street $city $state $zip");
   
   // Desired address
  // $address = "http://maps.google.com/maps/geo?q=$mapaddress&output=xml&key=" . GKEY;
    //209.85.173.104
    //64.233.167.147
   // Retrieve the URL contents

   // $page = fopen($address, "r");
     //   if($page){
       // $data = fread($page, 4096);
       // $xml = new SimpleXMLElement($data);
        // Retrieve the desired XML node
       // $coordinates = $xml->Response->Placemark->Point->coordinates;
       // $coordinatesSplit = split(",", $coordinates);
  //              }
   // fclose($page);

   // Parse the returned XML file
   
   // Format: Longitude, Latitude, Altitude
   $lat = $coordinatesSplit[1];
   $lng = $coordinatesSplit[0];

  $insertSQL = sprintf("INSERT INTO follows_contacts (address, name, contact_first, contact_last, contact_date, contact_user, contact_image, contact_age, contact_profile, contact_method, contact_mstatus, contact_stime, contact_street, contact_unit, contact_city, contact_state, contact_zip, contact_stage, lat, lng, contact_phone, contact_email, contact_updated, follow_date) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($fulladdress, "text"),
					   GetSQLValueString($name, "text"),
					   GetSQLValueString(trim($_POST['contact_first']), "text"),
					   GetSQLValueString(trim($_POST['contact_last']), "text"),
                       GetSQLValueString(time(), "date"),
					   GetSQLValueString(trim($_POST['contact_user']), "text"),
                       GetSQLValueString($picture, "text"),
					   GetSQLValueString(trim($_POST['contact_age']), "int"),
                       GetSQLValueString(trim($_POST['contact_profile']), "text"),
                       GetSQLValueString(trim($_POST['contact_method']), "text"),
                       GetSQLValueString(trim($_POST['contact_mstatus']), "text"),
                       GetSQLValueString(trim($_POST['contact_stime']), "text"),
                       GetSQLValueString(trim($_POST['contact_street']), "text"),
					   GetSQLValueString(trim($_POST['contact_street2']), "text"),
                       GetSQLValueString(trim($_POST['contact_city']), "text"),
                       GetSQLValueString(trim($_POST['contact_state']), "text"),
                       GetSQLValueString(trim($_POST['contact_zip']), "text"),
					   GetSQLValueString(trim($_POST['contact_stage']), "text"),
                       GetSQLValueString($lat, "text"),
                       GetSQLValueString($lng, "text"),
                       GetSQLValueString(trim($_POST['contact_phone']), "text"),
                       GetSQLValueString(trim($_POST['contact_email']), "text"),
                       GetSQLValueString($_POST['contact_updated'], "int"),
					   GetSQLValueString($_POST['date3'], "text"));

  mysql_select_db($database_follows, $follows);
  $Result1 = mysql_query($insertSQL, $follows) or die(mysql_error());
  
   if($_POST['notify_user']=="yes"){
    $notification = 0;
	include('sendnotification.php');
}
	set_msg('Follow-Up Added');
	$cid = $followid;
	$redirect = "contact-details.php?id=$cid";
	header(sprintf('Location: %s', $redirect)); die;
}
}

if ($update==1) {
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

   $street=$_POST['contact_street'];
   $city=$_POST['contact_city'];
   $zip=$_POST['contact_zip'];
   $state=$_POST['contact_state'];
   $name=$_POST['contact_first'] . " " . $_POST['contact_last'];
   $fulladdress=$_POST['contact_street'] . ", " . $_POST['contact_city'] . ", " . $_POST['contact_state'] . ", " . $_POST['contact_zip'];
   $mapaddress = urlencode("$street $city $state $zip");
   
    // Desired address
   $address = "http://maps.google.com/maps/geo?q=$mapaddress&output=xml&key=" . GKEY;
    //209.85.173.104

//   Retrieve the URL contents
//   $page = file_get_contents($address);
//
//   // Parse the returned XML file
//   $xml = new SimpleXMLElement($page);
//
//   // Retrieve the desired XML node
//   $coordinates = $xml->Response->Placemark->Point->coordinates;
//   $coordinatesSplit = split(",", $coordinates);
    //$page = fopen($address, "r");
      //  if($page){
       // $data = fread($page, 4096);
       // $xml = new SimpleXMLElement($data);
        // Retrieve the desired XML node
       // $coordinates = $xml->Response->Placemark->Point->coordinates;
       // $coordinatesSplit = split(",", $coordinates);
         //       }
   // fclose($page);
   // Format: Longitude, Latitude, Altitude
   $lat = $coordinatesSplit[1];
   $lng = $coordinatesSplit[0];

  $updateSQL = sprintf("UPDATE follows_contacts SET address=%s, name=%s, contact_first=%s, contact_last=%s, contact_user=%s, contact_image=%s, contact_age=%s, contact_profile=%s, contact_mstatus=%s, contact_stime=%s, contact_method=%s, contact_street=%s, contact_unit=%s, contact_city=%s, contact_state=%s, contact_zip=%s, contact_stage=%s, lat=%s, lng=%s, contact_phone=%s,contact_email=%s, contact_updated=%s, follow_date=%s WHERE contact_id=%s",
                       GetSQLValueString($fulladdress, "text"),
					   GetSQLValueString($name, "text"),					   
					   GetSQLValueString(trim($_POST['contact_first']), "text"),
                       GetSQLValueString(trim($_POST['contact_last']), "text"),
                       GetSQLValueString(trim($_POST['contact_user']), "text"),
                       GetSQLValueString($picture, "text"),
					   GetSQLValueString(trim($_POST['contact_age']), "int"),
                       GetSQLValueString(trim($_POST['contact_profile']), "text"),
                       GetSQLValueString(trim($_POST['contact_mstatus']), "text"),
                       GetSQLValueString(trim($_POST['contact_stime']), "text"),
                       GetSQLValueString(trim($_POST['contact_method']), "text"),
                       GetSQLValueString(trim($_POST['contact_street']), "text"),
					   GetSQLValueString(trim($_POST['contact_street2']), "text"),
                       GetSQLValueString(trim($_POST['contact_city']), "text"),
                       GetSQLValueString(trim($_POST['contact_state']), "text"),
                       GetSQLValueString(trim($_POST['contact_zip']), "text"),
					   GetSQLValueString(trim($_POST['contact_stage']), "text"),
                       GetSQLValueString($lat, "text"),
                       GetSQLValueString($lng, "text"),
                       GetSQLValueString(trim($_POST['contact_phone']), "text"),
                       GetSQLValueString(trim($_POST['contact_email']), "text"),
                       GetSQLValueString(trim($_POST['contact_updated']), "int"),
					   GetSQLValueString(trim($_POST['date3']), "text"),
                       GetSQLValueString(trim($_POST['contact_id']), "int"));

  mysql_select_db($database_follows, $follows);
  $Result1 = mysql_query($updateSQL, $follows) or die(mysql_error());
  
  if($_POST['notify_user']=="yes"){
    $notification = 1;
	include('sendnotification.php');
}
  
	set_msg('Follow-Up Updated');
	$cid = $_GET['id'];
	$redirect = "contact-details.php?id=$cid";
	header(sprintf('Location: %s', $redirect)); die;
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if ($update==0) { echo "Add Contact"; } ?><?php echo $row_contact['contact_first']; ?> <?php echo $row_contact['contact_last']; ?></title>
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

<link rel="alternate stylesheet" type="text/css" media="all" href="calendar-blue.css" id="defaultTheme" title="winter"  />
<script type="text/javascript" src="calendar.js"></script>

<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">
    <h2><?php if ($update==1) { echo Update; } else { echo Add; } ?> FollowUp </h2>
  
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="28%">First Name<br />
            <input name="contact_first" type="text" class="required" title="First name required" id="contact_first" value="<?php echo $row_contact['contact_first']; ?>" size="25" /></td>
          <td width="72%">Last Name<br />
                <input name="contact_last" type="text" class="required" title="Last name required" id="contact_last" value="<?php echo $row_contact['contact_last']; ?>" size="25" />
            </p></td>
        </tr>
        <tr>
          <td>Phone/Cell<br /> <input name="contact_phone" type="text" id="contact_phone" value="<?php echo $row_contact['contact_phone']; ?>" size="35" /> </td>
          
        </tr>
        <tr>
          <td>Email <br />
            <input name="contact_email" type="text" class="validate-email" id="contact_email" value="<?php echo $row_contact['contact_email']; ?>" size="35" /></td>
         <td>Contacted via<br />
            <select name="contact_method" id="contact_method" class="validate-selection">
<option value="">Select</option>
                           <?php //This is the method in which the user was contacted or met
	$link1 = "SELECT * FROM category ORDER BY cat ASC";
	$res1 = mysql_query($link1);
	$cur = $row_contact['contact_method'];
	$x = 0;
	while ($row1 = mysql_fetch_row($res1))
	{	
		$cat = $row1[0];
		if ($cat == $cur && $x != 1)
		{
		echo '<option value="' . $cat . '" selected>' . $cat;
		$x = 1;		
		}
		else
		echo '<option value="' . $cat . '">' . $cat;
	}	
	?>
            </select></td>
         </tr>
         <tr>
         <td width="27%" valign="top">Marital Status<br />
                          <select name="contact_mstatus" id="contact_mstatus" class="validate-selection">
							<option value="">Select</option>
							<option value="Single"   <?php if (!(strcmp("Single", $row_contact['contact_mstatus'])))   {echo "selected=\"selected\"";} ?>>Single</option>
                            <option value="Married"  <?php if (!(strcmp("Married", $row_contact['contact_mstatus'])))  {echo "selected=\"selected\"";} ?>>Married</option>
                            <option value="Divorced" <?php if (!(strcmp("Divorced", $row_contact['contact_mstatus']))) {echo "selected=\"selected\"";} ?>>Divorced</option>
                            <option value="Unknown"  <?php if (!(strcmp("Unknown", $row_contact['contact_mstatus'])))  {echo "selected=\"selected\"";} ?>>Unknown</option>
                        </select></td>
<td>Service Attended<br />
            <select name="contact_stime" id="contact_stime" class="validate-selection">
<option value="">Select</option>
                           <?php //This is the method in which the user was contacted or met
	$link1 = "SELECT * FROM follows_services ORDER BY service_name ASC";
	$res1 = mysql_query($link1);
	$cur = $row_contact['contact_stime'];
	$x = 0;
	while ($row1 = mysql_fetch_row($res1))
	{	
		$cat = $row1[3];
		$cat2 = $row1[1];
		if ($cat == $cur && $x != 1)
		{
		echo '<option value="' . $cat . '" selected>' . $cat;
		$x = 1;		
		}
		else
		echo '<option value="' . $cat . '">' . $cat;
	}	
	?>
            </select></td>                        
                        
         </tr>
         
         
        <tr>
          <td colspan="2">
        
            <table  width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>Street<br />
                    <input name="contact_street" type="text" id="contact_street" value="<?php echo $row_contact['contact_street']; ?>" size="35" /></td></tr>
                    <tr><td>Unit/Apt<br />
                    <input name="contact_street2" type="text" id="contact_street2" value="<?php echo $row_contact['contact_unit']; ?>" size="17" /></td></tr>
              
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="39%">City<br />
                          <input name="contact_city" type="text" id="contact_city" value="<?php echo $row_contact['contact_city']; ?>" size="35" /></td>
                      <td width="27%" valign="top">State<br />
                          <select name="contact_state" id="contact_state">
<option value="CA" <?php if (!(strcmp("CA", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>California</option>
                            <option value="AL" <?php if (!(strcmp("AL", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Alabama</option>
                            <option value="AK" <?php if (!(strcmp("AK", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Alaska</option>
                            <option value="AZ" <?php if (!(strcmp("AZ", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Arizona</option>
                            <option value="AR" <?php if (!(strcmp("AR", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Arkansas</option>
                            <option value="CA" <?php if (!(strcmp("CA", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>California</option>
                            <option value="CO" <?php if (!(strcmp("CO", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Colorado</option>
                            <option value="CT" <?php if (!(strcmp("CT", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Connecticut</option>
                            <option value="DE" <?php if (!(strcmp("DE", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Delaware</option>
                            <option value="DC" <?php if (!(strcmp("DC", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>District of Columbia</option>
                            <option value="FL" <?php if (!(strcmp("FL", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Florida</option>
                            <option value="GA" <?php if (!(strcmp("GA", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Georgia</option>
                            <option value="HI" <?php if (!(strcmp("HI", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Hawaii</option>
                            <option value="ID" <?php if (!(strcmp("ID", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Idaho</option>
                            <option value="IL" <?php if (!(strcmp("IL", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Illinois</option>
                            <option value="IN" <?php if (!(strcmp("IN", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Indiana</option>
                            <option value="IA" <?php if (!(strcmp("IA", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Iowa</option>
                            <option value="KS" <?php if (!(strcmp("KS", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Kansas</option>
                            <option value="KY" <?php if (!(strcmp("KY", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Kentucky</option>
                            <option value="LA" <?php if (!(strcmp("LA", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Louisiana</option>
                            <option value="ME" <?php if (!(strcmp("ME", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Maine</option>
                            <option value="MD" <?php if (!(strcmp("MD", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Maryland</option>
                            <option value="MA" <?php if (!(strcmp("MA", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Massachusetts</option>
                            <option value="MI" <?php if (!(strcmp("MI", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Michigan</option>
                            <option value="MN" <?php if (!(strcmp("MN", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Minnesota</option>
                            <option value="MS" <?php if (!(strcmp("MS", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Mississippi</option>
                            <option value="MO" <?php if (!(strcmp("MO", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Missouri</option>
                            <option value="MT" <?php if (!(strcmp("MT", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Montana</option>
                            <option value="NE" <?php if (!(strcmp("NE", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Nebraska</option>
                            <option value="NV" <?php if (!(strcmp("NV", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Nevada</option>
                            <option value="NH" <?php if (!(strcmp("NH", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>New Hampshire</option>
                            <option value="NJ" <?php if (!(strcmp("NJ", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>New Jersey</option>
                            <option value="NM" <?php if (!(strcmp("NM", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>New Mexico</option>
                            <option value="NY" <?php if (!(strcmp("NY", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>New York</option>
                            <option value="NC" <?php if (!(strcmp("NC", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>North Carolina</option>
                            <option value="ND" <?php if (!(strcmp("ND", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>North Dakota</option>
                            <option value="OH" <?php if (!(strcmp("OH", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Ohio</option>
                            <option value="OK" <?php if (!(strcmp("OK", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Oklahoma</option>
                            <option value="OR" <?php if (!(strcmp("OR", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Oregon</option>
                            <option value="PA" <?php if (!(strcmp("PA", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Pennsylvania</option>
                            <option value="RI" <?php if (!(strcmp("RI", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Rhode Island</option>
                            <option value="SC" <?php if (!(strcmp("SC", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>South Carolina</option>
                            <option value="SD" <?php if (!(strcmp("SD", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>South Dakota</option>
                            <option value="TN" <?php if (!(strcmp("TN", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Tennessee</option>
                            <option value="TX" <?php if (!(strcmp("TX", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Texas</option>
                            <option value="UT" <?php if (!(strcmp("UT", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Utah</option>
                            <option value="VT" <?php if (!(strcmp("VT", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Vermont</option>
                            <option value="VA" <?php if (!(strcmp("VA", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Virginia</option>
                            <option value="WA" <?php if (!(strcmp("WA", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Washington</option>
                            <option value="WV" <?php if (!(strcmp("WV", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>West Virginia</option>
                            <option value="WI" <?php if (!(strcmp("WI", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Wisconsin</option>
                            <option value="WY" <?php if (!(strcmp("WY", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>Wyoming</option>
                        </select></td>
                      <td width="34%">Zip<br />
                          <input name="contact_zip" type="text" id="contact_zip" value="<?php echo $row_contact['contact_zip']; ?>" size="10" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="40%">Assign to Ministry Member<br />
                        <select name="contact_user" id="contact_user" <?php if ($update == 0){ ?>class="validate-selection"<?php }?> title="Please assign to worker">
                        <option value="<?php if ($update==1) { echo $row_contact['contact_user']; } else { echo $row_userinfo['user_id']; } ?>">
						<?php if (($update==1) && ($row_contactJ2['user_name'])) { echo "Currently Assigned to: " . $row_contactJ2['user_name']; } else { echo "Select"; } ?>
                        </option>
                        
<?php if ($row_userinfo['user_level'] != 2) {
   //$query_userassign = "SELECT user_id,user_name,user_email FROM follows_users ORDER BY user_name";
   $query_userassign = "SELECT * FROM follows_users INNER JOIN follows_group ON member_group_id = group_id WHERE leader_id = $whois ORDER BY user_name ASC ";
   $userassign = mysql_query($leadersql, $follows);
     if(mysql_num_rows($userassign)) {
	   while($row_userassign = mysql_fetch_row($userassign))
       {
	   print("<option value=\"$row_userassign[0]\">$row_userassign[6]</option>");
       }
     } else {
       print("<option value=\"\">No users created yet</option>");
     } 
	 }
?>   

     <?php if(($row_userinfo['user_level']!=1) && ($update == 0) ) { ?>
                     <option value="<?php echo $row_userinfo['user_id'];?>"><?php echo $row_userinfo['user_name'];?></option>
     <?php } ?>
     
</select>
                          </td><td width="60%">
                          <?php if ($update == 1){ ?>
                          <input name="notify_user" type="checkbox" value="yes" /> 
                          <?php } ?>
                          <?php if ($update == 0){ ?>
                          <input name="notify_user" type="checkbox" checked="checked" value="yes" /> 
                          <?php } ?>
                          
                          Send Email Notification to Worker</td>
                      
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td>Image<br />
                    <input name="image" type="file" id="image" /><?php if ($row_contact['contact_image']) { ?>
                <br />
                <img src="images/<?php echo $row_contact['contact_image']; ?>" width="95" />
<?php } ?>
</td>
              </tr>
              <tr>
              <td>Age<br /><input name="contact_age" type="text" id="contact_age" value="<?php echo $row_contact['contact_age']; ?>" size="1"/></td>
              </tr>
              <tr>
                <td><?php if ($update==1) { echo "FollowUp Started"; } else { echo "Add FollowUp Date"; } ?><br /><input type="text" class="validate-date" name="date3" id="sel3" size="10" value="<?php echo $row_contact['follow_date'];?>">
<input type="reset" value="Date Select"onclick="return showCalendar('sel3', 'mm/dd/y');"></td></tr>

             <tr>
             <td>
             
             FollowUp Stage<br />
            <select name="contact_stage" id="contact_stage" class="validate-selection">
<option value="">Select</option>
                           <?php //This is the followups current stage
	$link1 = "SELECT * FROM follows_stages ORDER BY stage ASC";
	$res1 = mysql_query($link1);
	$cur = $row_contact['contact_stage'];
	$x = 0;
	while ($row1 = mysql_fetch_row($res1))
	{	
		$cat = $row1[0];
		$catn = $row1[1];
		if ($cat == $cur && $x != 1)
		{
		echo '<option value="' . $cat . '" selected>' . $catn;
		$x = 1;		
		}
		else
		echo '<option value="' . $cat . '">' . $catn;
	}	
	?>
            </select>
             
             </td>
             </tr>


                <td>Background/Profile<br />
                    <textarea name="contact_profile" cols="50" rows="3" id="contact_profile"><?php echo $row_contact['contact_profile']; ?></textarea></td>
              </tr>
            </table>  
</div>          
          <p>&nbsp;</p></td>
        </tr>

        <tr>
          <td colspan="2"><p>
            <input type="submit" name="Submit2" value="<?php if ($update==1) { echo Update; } else { echo Add; } ?> FollowUp" />
            <input name="contact_updated" type="hidden" id="contact_updated" value="<?php echo time(); ?>" />
            <input type="hidden" name="MM_insert" value="form1" />
            <input name="contact_id" type="hidden" id="contact_id" value="<?php echo $row_contact['contact_id']; ?>" />
            <input name="image_location" type="hidden" id="image_location" value="<?php echo $row_contact['contact_image']; ?>" />
          </p></td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <input type="hidden" name="MM_update" value="form1">
    </form><script type="text/javascript">
						var valid2 = new Validation('form1', {useTitles:true});
	</script>
  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
