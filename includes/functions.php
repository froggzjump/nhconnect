<?php

function confirm_query($result_set) {
	
	if(!$result_set) {
                	die("Could not run query" . mysql_error());
		}
	}

function get_all_rows($what){
			
			if ($_GET['mn']){
			$monthyr=$_GET['mn'];
			$query = "SELECT * FROM follows_contacts Where contact_stage = '$what' AND contact_wait <> 1 AND FROM_UNIXTIME( contact_date, '%m%y' ) = $monthyr ORDER BY contact_id";
			} else {
                        $query =  "SELECT *  FROM follows_contacts Where contact_stage = '$what' AND contact_wait <> 1 AND contact_date > unix_timestamp(now() - interval 180 day) ORDER BY contact_id ";				
			}
			
            $subjectset = mysql_query($query);
			
            confirm_query($subjectset);
						   
			while($subjects = mysql_fetch_array($subjectset)){
			echo "<a href=\"contact-details.php?id={$subjects['contact_id']}\">{$subjects['contact_first']} {$subjects['contact_last']}<br />";
			 }
		}

function get_all_rows_w($what,$whois){
			
			if ($_GET['mn']){
			$monthyr=$_GET['mn'];
			$query = "SELECT * FROM follows_contacts Where contact_stage = '$what' AND contact_wait <> 1 AND contact_user = '$whois' AND FROM_UNIXTIME( contact_date, '%m%y' ) = $monthyr ORDER BY contact_id";
			} else {
            $query = "SELECT * FROM follows_contacts Where contact_stage = '$what' AND contact_wait <> 1  AND contact_date > unix_timestamp(now() - interval 180 day) AND contact_user = '$whois' ORDER BY contact_id ";		
			}
			
			
			 
            $subjectset = mysql_query($query);
            confirm_query($subjectset);
						   
			while($subjects = mysql_fetch_array($subjectset)){
			echo "<a href=\"contact-details.php?id={$subjects['contact_id']}\">{$subjects['contact_first']} {$subjects['contact_last']}<br />";
			 }
		}

function bed_time(){
		$time_A = strtotime($row_contact['bed_time']);
          	$time_B=strtotime(now);
		$numdays=intval(($time_B-$time_A)/86400)+1;
	        echo $numdays;
}

function ifnotadmin($currentlevel) {
	if ($currentlevel != 1) {
	header ("Location: indexw.php");
	}
}


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



function displayUsers($getitgroup){
   global $database , $groupnameis;
   //$q = "SELECT * FROM follows_contacts WHERE ";
   //$q = "SELECT follows_contacts.contact_id, contact_first, contact_mstatus, contact_stime, contact_age follows_wait.contact_id, wait_updated FROM follows_contacts INNER JOIN follows_wait ON follows_contacts.contact_id = follows_wait.contact_id WHERE follows_contacts.contact_wait = 1 AND follows_wait.group_id = $getitgroup";
   $q = "SELECT follows_contacts.*, follows_wait.* 
   		 FROM follows_contacts 
		 INNER JOIN follows_wait ON follows_contacts.contact_id = follows_wait.contact_id 
		 WHERE follows_contacts.contact_wait = 1
		 AND follows_wait.group_id = $getitgroup";
   
   
   $result = $database->query($q);
  /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if(!$result || ($num_rows < 0)){
      echo "Error displaying info";
      return;
   }
   if($num_rows == 0){
      echo "No followups to assign for your group.";
      return;
   }
   /* Display table contents */
   echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Name</b></td><td><b>Marital Status</b></td><td><b>Service Attended</b></td><td><b>Age</b></td><td><b>Group</b></td><td><b>Date Added</b></td></tr>\n";
   
   
   for($i=0; $i<$num_rows; $i++){
      $fname  = mysql_result($result,$i,"contact_first");
      $lname = mysql_result($result,$i,"contact_last");
      $cid = mysql_result($result,$i,"contact_id");
      $updated = mysql_result($result,$i,"wait_updated");
      $mstatis = mysql_result($result,$i,"contact_mstatus");
      $sstime = mysql_result($result,$i,"contact_stime");
      $cage = mysql_result($result,$i,"contact_age");
	  
echo "<tr bgcolor=\"F4F4F4\">";
echo "<td>";
echo "<input type='checkbox' name='options[]' value=" . $cid . ">" . "&nbsp;" . $fname . " " . $lname;  
echo "</td>";
echo "<td>";
echo $mstatis;
echo "</td>";
echo "<td>";
echo $sstime;
echo "</td>";
echo "<td>";
echo $cage;
echo "</td>";
echo "<td>";
echo $groupnameis;
echo "</td>";
echo "<td>";
echo date("m-d-y",$updated);
echo "</td>";
echo "</tr>";
     
   }
   echo "</table><br>\n";
}


function displayUsersA(){
   global $database, $groupnameis;
   //$q = "SELECT * FROM follows_contacts WHERE ";
   $q = "SELECT follows_contacts.contact_id, contact_first, contact_last, contact_mstatus, contact_stime, contact_age, follows_wait.contact_id, wait_updated FROM follows_contacts INNER JOIN follows_wait ON follows_contacts.contact_id = follows_wait.contact_id WHERE follows_contacts.contact_wait = 1";
   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if(!$result || ($num_rows < 0)){
      echo "Error displaying info";
      return;
   }
   if($num_rows == 0){
      echo "No FollowUps Waiting";
      return;
   }
   /* Display table contents */
   echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Name</b></td><td><b>Marital Status</b></td><td><b>Service Attended</b></td><td><b>Age</b></td><td><b>Group</b></td><td><b>Date Added</b></td></tr>\n";
   
   for($i=0; $i<$num_rows; $i++){
      $fname  = mysql_result($result,$i,"contact_first");
      $lname = mysql_result($result,$i,"contact_last");
      $cid = mysql_result($result,$i,"contact_id");
      $updated = mysql_result($result,$i,"wait_updated");
      $mstatis = mysql_result($result,$i,"contact_mstatus");
      $sstime = mysql_result($result,$i,"contact_stime");
      $cage = mysql_result($result,$i,"contact_age");
	  
echo "<tr bgcolor=\"F4F4F4\">";
echo "<td>";
echo "<input type='checkbox' name='options[]' value=" . $cid . ">" . "&nbsp;" . $fname . " " . $lname;  
echo "</td>";
echo "<td>";
echo $mstatis;
echo "</td>";
echo "<td>";
echo $sstime;
echo "</td>";
echo "<td>";
echo $cage;
echo "</td>";
echo "<td>";
echo $groupnameis;
echo "</td>";
echo "<td>";
echo date("m-d-y",$updated);
echo "</td>";
echo "</tr>";
     
   }
   echo "</table><br>\n";
}



function displayUsers_n($getitgroup){
   global $database , $groupnameis;
   //$q = "SELECT * FROM follows_contacts WHERE ";
   //$q = "SELECT follows_contacts.contact_id, contact_first, contact_mstatus, contact_stime, contact_age follows_wait.contact_id, wait_updated FROM follows_contacts INNER JOIN follows_wait ON follows_contacts.contact_id = follows_wait.contact_id WHERE follows_contacts.contact_wait = 1 AND follows_wait.group_id = $getitgroup";
   
   $q = "SELECT follows_contacts.*, follows_wait.* 
   		 FROM follows_contacts 
		 INNER JOIN follows_wait ON follows_contacts.contact_id = follows_wait.contact_id 
		 WHERE follows_contacts.contact_wait = 1
		 AND follows_wait.group_id = $getitgroup";

   $result = $database->query($q);
  /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if(!$result || ($num_rows < 0)){
      echo "Error displaying info";
      return;
   }
   if($num_rows == 0){
      echo "No followups to assign for your group.";
      return;
   }
   /* Display table contents */
   echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Name</b></td><td><b>Marital Status</b></td><td><b>Service Attended</b></td><td><b>Age</b></td><td><b>Group</b></td><td><b>Date Added</b></td></tr>\n";
   
   
   for($i=0; $i<$num_rows; $i++){
      $fname  = mysql_result($result,$i,"contact_first");
      $lname = mysql_result($result,$i,"contact_last");
      $cid = mysql_result($result,$i,"contact_id");
      $updated = mysql_result($result,$i,"wait_updated");
      $mstatis = mysql_result($result,$i,"contact_mstatus");
      $sstime = mysql_result($result,$i,"contact_stime");
      $cage = mysql_result($result,$i,"contact_age");
	  
echo "<tr bgcolor=\"F4F4F4\">";
echo "<td>";
echo $fname . " " . $lname;  
echo "</td>";
echo "<td>";
echo $mstatis;
echo "</td>";
echo "<td>";
echo $sstime;
echo "</td>";
echo "<td>";
echo $cage;
echo "</td>";
echo "<td>";
echo $groupnameis;
echo "</td>";
echo "<td>";
echo date("m-d-y",$updated);
echo "</td>";
echo "</tr>";
     
   }
   echo "</table><br>\n";
}


function displayUsers_nA(){
   global $database, $groupnameis;
   //$q = "SELECT * FROM follows_contacts WHERE ";
   $q = "SELECT follows_contacts.contact_id, contact_first, contact_last, contact_mstatus, contact_stime, contact_age, follows_wait.contact_id, wait_updated FROM follows_contacts INNER JOIN follows_wait ON follows_contacts.contact_id = follows_wait.contact_id WHERE follows_contacts.contact_wait = 1";
   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if(!$result || ($num_rows < 0)){
      echo "Error displaying info";
      return;
   }
   if($num_rows == 0){
      echo "No FollowUps Waiting";
      return;
   }
   /* Display table contents */
   echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Name</b></td><td><b>Marital Status</b></td><td><b>Service Attended</b></td><td><b>Age</b></td><td><b>Group</b></td><td><b>Date Added</b></td></tr>\n";
   
   for($i=0; $i<$num_rows; $i++){
      $fname  = mysql_result($result,$i,"contact_first");
      $lname = mysql_result($result,$i,"contact_last");
      $cid = mysql_result($result,$i,"contact_id");
      $updated = mysql_result($result,$i,"wait_updated");
      $mstatis = mysql_result($result,$i,"contact_mstatus");
      $sstime = mysql_result($result,$i,"contact_stime");
      $cage = mysql_result($result,$i,"contact_age");
	  
echo "<tr bgcolor=\"F4F4F4\">";
echo "<td>";
echo $fname . " " . $lname;  
echo "</td>";
echo "<td>";
echo $mstatis;
echo "</td>";
echo "<td>";
echo $sstime;
echo "</td>";
echo "<td>";
echo $cage;
echo "</td>";
echo "<td>";
echo $groupnameis;
echo "</td>";
echo "<td>";
echo date("m-d-y",$updated);
echo "</td>";
echo "</tr>";
     
   }
   echo "</table><br>\n";
}



function HeaderInfo(){
	
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
<title>SomeTitle</title>
<script src=\"includes/lib/prototype.js\" type=\"text/javascript\"></script>
<script src=\"includes/src/effects.js\" type=\"text/javascript\"></script>
<script src=\"includes/validation.js\" type=\"text/javascript\"></script>
<script src=\"includes/src/scriptaculous.js\" type=\"text/javascript\"></script>
<script src=\"includes/src/hoverover.js\" type=\"text/javascript\"></script>

<link href=\"includes/style.css\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"includes/simplecustomer.css\" rel=\"stylesheet\" type=\"text/css\" />
</head>
<body>";

}


function getIdLast(){
	global $database_follows, $follows, $database;
	$lasidused = mysql_insert_id();
	return $lastidused;
}



//This is the function used to send sms text to the workers - Company Clickatell
//function send_sms($towhom,$txtmsg){ 
//$user = "nhcfsd";
//$password = "grecia94";
//$api_id = "3212708";
//$baseurl ="http://api.clickatell.com";
//$text = urlencode($txtmsg);
//$to = "0123456789";
//$to = "1" . $towhom;
// auth call
//$url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id";
// do auth call
//$ret = file($url);
// split our response. return string is on first line of the data returned
//$sess = split(":",$ret[0]);

//if ($sess[0] == "OK") {
//$sess_id = trim($sess[1]); // remove any whitespace
//$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";
// do sendmsg call
//$ret = file($url);
//$send = split(":",$ret[0]);

//if ($send[0] == "ID")
//set_msg('Text message success, ID:' . $send[1]);
//echo "success message ID: ". $send[1];
//else
//echo "send message failed";
//} 

//else {
//echo "Authentication failure: ". $ret[0];
//exit();
//}
//}
// end sms function

//this function is used in the waitqueues area t
function create_div($fields, $table, $w_field, $w_value, $unique){
$f = implode("`, `", $fields);
$sql = "SELECT `$f` FROM `$table` WHERE `$w_field` = '$w_value'";
$res = mysql_query($sql) or die(mysql_error());



$div = "
<div class=\"spiffyfg\" id=\"data".$unique."\" >\n";
  while($r = mysql_fetch_assoc($res)){
    foreach($fields as $name){
    $div .= $r[$name]." ";
    }
  $div .= "<br />";
  }
$div .= "</div>\n";
return $div;
}



?>