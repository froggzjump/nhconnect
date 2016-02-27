<?php require_once('includes/config.php'); ?>
<?php
include('includes/sc-includes.php');
$pagetitle = Worker;

if ($row_userinfo['user_level'] == 2) {
set_msg('Thank you for all your help');
header ("Location: profile.php");
}
//ifnotadmin($currentlevel);


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



//
if ($update==1) {
mysql_select_db($database_follows, $follows);
$query_user = "SELECT * FROM follows_users WHERE user_id = ".$_GET['id']."";
$user = mysql_query($query_user, $follows) or die("1" . mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);

if ($row_user['member_group_id']){
$whoisthisuser = $row_user['member_group_id'];

$query_users = "SELECT * FROM follows_group INNER JOIN follows_users ON leader_id = user_id WHERE group_id = $whoisthisuser ";
$sys_users = mysql_query($query_users, $follows) or die("2" . mysql_error());
$row_users = mysql_fetch_assoc($sys_users);
$totalRows_users = mysql_num_rows($sys_users);
 }
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

if ($update==0) {
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

if ((isset($_POST["user_level"])) && ($_POST["user_level"] == 1)) {
   $homes = "index.php";
} else {
   $homes = "contacts.php";
}
 

   $street=$_POST['user_street'];
   $fullname=$_POST['user_name'];
   $city=$_POST['user_city'];
   $zip=$_POST['user_zip'];
   $state=$_POST['user_state'];
   $fulladdress=$_POST['user_street'] . ", " . $_POST['user_city'] . ", " . $_POST['user_state'] . ", " . $_POST['user_zip'];
   $mapaddress = urlencode("$street $city $state $zip");
   
   // Desired address
   $address = "http://maps.google.com/maps/geo?q=$mapaddress&output=xml&key=" . GKEY;

   // Retrieve the URL contents
//   $page = file_get_contents($address);
//
//   // Parse the returned XML file
//   $xml = new SimpleXMLElement($page);
//
//   // Retrieve the desired XML node
//   $coordinates = $xml->Response->Placemark->Point->coordinates;
//   $coordinatesSplit = split(",", $coordinates);
//
//
//
   // Format: Longitude, Latitude, Altitude

       $page = fopen($address, "r");
        if($page){
        $data = fread($page, 4096);
        $xml = new SimpleXMLElement($data);
        // Retrieve the desired XML node
        $coordinates = $xml->Response->Placemark->Point->coordinates;
        $coordinatesSplit = split(",", $coordinates);
                }
    fclose($page);

   $lat = $coordinatesSplit[1];
   $lng = $coordinatesSplit[0];

if ($_POST['user_password']) {
$password = $_POST['user_password'];
}

 $insertSQL = sprintf("INSERT INTO follows_users (name, address, lat, lng, user_street, user_city, user_state, user_zip, user_name, user_image, user_password, member_group_id, user_profile, user_phone, user_email, user_home, user_level, user_updated) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($fullname, "text"),
					   GetSQLValueString($fulladdress, "text"),
					   GetSQLValueString($lat, "text"),
					   GetSQLValueString($lng, "text"),
					   GetSQLValueString(trim($_POST['user_street']), "text"),
                       GetSQLValueString(trim($_POST['user_city']), "text"),
                       GetSQLValueString(trim($_POST['user_state']), "text"),
                       GetSQLValueString(trim($_POST['user_zip']), "text"),
					   GetSQLValueString(trim($_POST['user_name']), "text"),
                       GetSQLValueString($picture, "text"),
					   GetSQLValueString($password, "text"),
					   GetSQLValueString($_POST['member_group'], "int"),
                       GetSQLValueString(trim($_POST['user_profile']), "text"),
                       GetSQLValueString(trim($_POST['user_phone']), "text"),
                       GetSQLValueString(trim($_POST['user_email']), "text"),
					   GetSQLValueString($homes, "text"),
					   GetSQLValueString($_POST['user_level'], "int"),
                       GetSQLValueString($_POST['user_updated'], "int"));

  mysql_select_db($database_follows, $follows);
  $Result1 = mysql_query($insertSQL, $follows) or die(mysql_error());
	set_msg('User Added');
	$cid = mysql_insert_id();
	$redirect = "users.php";
	header(sprintf('Location: %s', $redirect)); die;
}
}

if ($update==1) {
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

if ((isset($_POST["user_level"])) && ($_POST["user_level"] == 1)) {
   $homes = "index.php";
} else {
   $homes = "contacts.php";
}

   
   $fullname=$_POST['user_name'];
   $street=$_POST['user_street'];
   $city=$_POST['user_city'];
   $zip=$_POST['user_zip'];
   $state=$_POST['user_state'];
   $fulladdress=$_POST['user_street'] . ", " . $_POST['user_city'] . ", " . $_POST['user_state'] . ", " . $_POST['user_zip'];
   $mapaddress = urlencode("$street $city $state $zip");
   
   // Desired address
   $address = "http://maps.google.com/maps/geo?q=$mapaddress&output=xml&key=" . GKEY;

   // Retrieve the URL contents
       $page = fopen($address, "r");
        if($page){
        $data = fread($page, 4096);
        $xml = new SimpleXMLElement($data);
        // Retrieve the desired XML node
        $coordinates = $xml->Response->Placemark->Point->coordinates;
        $coordinatesSplit = split(",", $coordinates);
                }
    fclose($page);
   // Format: Longitude, Latitude, Altitude
   $lat = $coordinatesSplit[1];
   $lng = $coordinatesSplit[0];

if ($_POST['user_password']) {
$password = $_POST['user_password'];
}

  $updateSQL = sprintf("UPDATE follows_users SET name=%s, address=%s, lat=%s, lng=%s, user_street=%s, user_city=%s, user_state=%s, user_zip=%s, user_name=%s, user_image=%s, user_password=%s, member_group_id=%s, user_profile=%s, user_phone=%s, user_email=%s,user_home=%s, user_level=%s, user_updated=%s WHERE user_id=%s",
                       GetSQLValueString($fullname, "text"),
					   GetSQLValueString($fulladdress, "text"),
					   GetSQLValueString($lat, "text"),
					   GetSQLValueString($lng, "text"),
					   GetSQLValueString(trim($_POST['user_street']), "text"),
                       GetSQLValueString(trim($_POST['user_city']), "text"),
                       GetSQLValueString(trim($_POST['user_state']), "text"),
                       GetSQLValueString(trim($_POST['user_zip']), "text"),
					   GetSQLValueString(trim($_POST['user_name']), "text"),
                       GetSQLValueString($picture, "text"),
					   GetSQLValueString($password, "text"),
					   GetSQLValueString(trim($_POST['member_group']), "int"),
                       GetSQLValueString(trim($_POST['user_profile']), "text"),
                       GetSQLValueString(trim($_POST['user_phone']), "text"),
                       GetSQLValueString(trim($_POST['user_email']), "text"),
					   GetSQLValueString($homes, "text"),
                       GetSQLValueString(trim($_POST['user_level']), "text"),
                       GetSQLValueString(trim($_POST['user_updated']), "int"),
                       GetSQLValueString(trim($_POST['user_id']), "int"));

  mysql_select_db($database_follows, $follows);
  $Result1 = mysql_query($updateSQL, $follows) or die(mysql_error());
	set_msg('User Updated');
	$cid = $_GET['id'];
	$redirect = "users.php";
	header(sprintf('Location: %s', $redirect)); die;
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if ($update==0) { echo "Add Contact"; } ?><?php echo $row_user['user_name']; ?></title>
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
    <h2><?php if ($update==1) { echo "Update " . $row_user['user_name']; } else { echo "Add Worker"; } ?> </h2>
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="28%">Name<br />
            <input name="user_name" type="text" class="required" id="user_name" value="<?php echo $row_user['user_name']; ?>" size="25" />
            <br />Email <br />
            <input name="user_email" type="text" class="required validate-email" id="user_email" value="<?php echo $row_user['user_email']; ?>" size="35" /></td>
          <td width="72%">
		  
		  <?php if($currentlevel == 1) {?> User Level<br />
          <select name="user_level" id="user_level">
	      <option value="<?php echo $row_user['user_level'];?>">
		  <?php if ($update==1){
                      
                     if ($row_user['user_level'] == 1){
                         $thii = "Admin Control";
                     }
                     if ($row_user['user_level'] == 2){
                         $thii = "FollowUp Worker";
                     }
                     if ($row_user['user_level'] == 3){
                         $thii = "Group Leader";
                     }
                      echo $thii; 
                      }else
                        { echo "Select"; 
                          }?> 
          </option>
          <option value="1">Admin Control</option>
          <option value="2">FollowUp Worker</option>
          <option value="3">Group Leader</option>
          </select>
		  <?php }?>
            
		  
		  
		  <?php if($currentlevel == 3) {?> User Level<br />
          <select name="user_level" id="user_level">
		  
          <?php if($update==1){?>
          <option value="<?php echo $row_user['user_level']; ?>">
		  FollowUp Worker
          </option>
		  <?php }?>
          
          <?php if($update==0){?>
          <option value="2">FollowUp Worker</option>
          </select>
		  <?php }?>
          
		  <?php }?>
          
          
            
          </td>
       </tr>
       
       <tr> 
          <td><br />       
          <input name="user_password" type="password" id="user_password" value="<?php echo $row_user['user_password']; ?>" />Password
          </td>
          
    
          
          
          <td>
		  <?php if(($currentlevel == 1) || ($currentlevel == 3)) {?>
		  
		  <?php if ($update==1) { echo "Current Group"; } else { echo "Add to Group";} ?><br />
          
          <select name="member_group" id="member_group">
          
          <option value="<?php if ($update==1) { echo $row_user['member_group_id']; } else { echo $row_userinfo['member_group_id']; } ?>">
		  <?php if ($update==1) { echo $row_users['group_name']; } else { echo "Select"; } ?>
          </option>
                        
<?php 
    if($currentlevel == 1) {
	$query_userassign = "SELECT group_id,group_name,leader_id FROM follows_group ORDER BY group_id";
	} else {
		$query_userassign = "SELECT group_id,group_name,leader_id FROM follows_group WHERE leader_id = $myidis";
		}
		
		$userassign = mysql_query($query_userassign, $follows);
    if(mysql_num_rows($userassign)) {
	 while($row_userassign = mysql_fetch_row($userassign)){
	   print("<option value=\"$row_userassign[0]\">$row_userassign[1]</option>");
       }
     } else {
       print("<option value=\"\">No Groups to Select</option>");
     } 
?>   
</select>
<?php } ?>



          </td>
        </tr>
        <tr>
          <td width="39%">Phone<br />
                          <input name="user_phone" type="text" class="validate-phone-us" id="user_phone" value="<?php echo $row_user['user_phone']; ?>" size="35" /></td>
        </tr>
        <tr>
          <td colspan="2">
            <table  width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td></td>
              </tr>
              <tr>
                <td>Street<br />
                    <input name="user_street" type="text" id="user_street" value="<?php echo $row_user['user_street']; ?>" size="35" /><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="39%">City<br />
                    <input name="user_city" type="text" id="user_city" value="<?php echo $row_user['user_city']; ?>" size="35" /></td>
                                           
                      <td width="27%" valign="top">State<br />
                          <select name="user_state" id="user_state">
<option value="CA" <?php if (!(strcmp("CA", $row_contact['contact_state']))) {echo "selected=\"selected\"";} ?>>California</option>
                            <option value="AL" <?php if (!(strcmp("AL", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Alabama</option>
                            <option value="AK" <?php if (!(strcmp("AK", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Alaska</option>
                            <option value="AZ" <?php if (!(strcmp("AZ", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Arizona</option>
                            <option value="AR" <?php if (!(strcmp("AR", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Arkansas</option>
                            <option value="CA" <?php if (!(strcmp("CA", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>California</option>
                            <option value="CO" <?php if (!(strcmp("CO", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Colorado</option>
                            <option value="CT" <?php if (!(strcmp("CT", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Connecticut</option>
                            <option value="DE" <?php if (!(strcmp("DE", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Delaware</option>
                            <option value="DC" <?php if (!(strcmp("DC", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>District of Columbia</option>
                            <option value="FL" <?php if (!(strcmp("FL", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Florida</option>
                            <option value="GA" <?php if (!(strcmp("GA", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Georgia</option>
                            <option value="HI" <?php if (!(strcmp("HI", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Hawaii</option>
                            <option value="ID" <?php if (!(strcmp("ID", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Idaho</option>
                            <option value="IL" <?php if (!(strcmp("IL", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Illinois</option>
                            <option value="IN" <?php if (!(strcmp("IN", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Indiana</option>
                            <option value="IA" <?php if (!(strcmp("IA", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Iowa</option>
                            <option value="KS" <?php if (!(strcmp("KS", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Kansas</option>
                            <option value="KY" <?php if (!(strcmp("KY", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Kentucky</option>
                            <option value="LA" <?php if (!(strcmp("LA", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Louisiana</option>
                            <option value="ME" <?php if (!(strcmp("ME", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Maine</option>
                            <option value="MD" <?php if (!(strcmp("MD", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Maryland</option>
                            <option value="MA" <?php if (!(strcmp("MA", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Massachusetts</option>
                            <option value="MI" <?php if (!(strcmp("MI", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Michigan</option>
                            <option value="MN" <?php if (!(strcmp("MN", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Minnesota</option>
                            <option value="MS" <?php if (!(strcmp("MS", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Mississippi</option>
                            <option value="MO" <?php if (!(strcmp("MO", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Missouri</option>
                            <option value="MT" <?php if (!(strcmp("MT", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Montana</option>
                            <option value="NE" <?php if (!(strcmp("NE", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Nebraska</option>
                            <option value="NV" <?php if (!(strcmp("NV", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Nevada</option>
                            <option value="NH" <?php if (!(strcmp("NH", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>New Hampshire</option>
                            <option value="NJ" <?php if (!(strcmp("NJ", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>New Jersey</option>
                            <option value="NM" <?php if (!(strcmp("NM", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>New Mexico</option>
                            <option value="NY" <?php if (!(strcmp("NY", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>New York</option>
                            <option value="NC" <?php if (!(strcmp("NC", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>North Carolina</option>
                            <option value="ND" <?php if (!(strcmp("ND", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>North Dakota</option>
                            <option value="OH" <?php if (!(strcmp("OH", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Ohio</option>
                            <option value="OK" <?php if (!(strcmp("OK", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Oklahoma</option>
                            <option value="OR" <?php if (!(strcmp("OR", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Oregon</option>
                            <option value="PA" <?php if (!(strcmp("PA", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Pennsylvania</option>
                            <option value="RI" <?php if (!(strcmp("RI", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Rhode Island</option>
                            <option value="SC" <?php if (!(strcmp("SC", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>South Carolina</option>
                            <option value="SD" <?php if (!(strcmp("SD", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>South Dakota</option>
                            <option value="TN" <?php if (!(strcmp("TN", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Tennessee</option>
                            <option value="TX" <?php if (!(strcmp("TX", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Texas</option>
                            <option value="UT" <?php if (!(strcmp("UT", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Utah</option>
                            <option value="VT" <?php if (!(strcmp("VT", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Vermont</option>
                            <option value="VA" <?php if (!(strcmp("VA", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Virginia</option>
                            <option value="WA" <?php if (!(strcmp("WA", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Washington</option>
                            <option value="WV" <?php if (!(strcmp("WV", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>West Virginia</option>
                            <option value="WI" <?php if (!(strcmp("WI", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Wisconsin</option>
                            <option value="WY" <?php if (!(strcmp("WY", $row_user['user_state']))) {echo "selected=\"selected\"";} ?>>Wyoming</option>
                        </select></td>
                      <td width="34%"></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    <td colspan="2">
                    Zipcode<br />
                    <input name="user_zip" type="text" id="user_zip" value="<?php echo $row_user['user_zip']; ?>" size="35" />
                    
                    
                    </td> 
                      <td width="61%"></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td>Image<br />
                    <input name="image" type="file" id="image" /><?php if ($row_user['user_image']) { ?>
                <br />
                <img src="images/<?php echo $row_user['user_image']; ?>" width="95" />
<?php } ?>
</td>
              </tr>
              <tr>
                <td>
                 </td>
              </tr>
              <tr>
                <td>Background/Profile<br />
                    <textarea name="user_profile" cols="60" rows="3" id="user_profile"><?php echo $row_user['user_profile']; ?></textarea></td>
              </tr>
            </table>  
</div>          
          <p>&nbsp;</p></td>
        </tr>

        <tr>
          <td colspan="2"><p>
            <input type="submit" name="Submit2" value="<?php if ($update==1) { echo Update; } else { echo Add; } ?> Worker" />
            <input name="user_updated" type="hidden" id="user_updated" value="<?php echo time(); ?>" />
            <input type="hidden" name="MM_insert" value="form1" />
            <input name="user_id" type="hidden" id="user_id" value="<?php echo $row_user['user_id']; ?>" />
            <input name="image_location" type="hidden" id="image_location" value="<?php echo $row_user['user_image']; ?>" />
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
