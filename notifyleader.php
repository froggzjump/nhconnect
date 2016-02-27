<?
include "includes/config.php";

$workerid = $_POST['leader_id'];

if ($notification==0){
$followid = mysql_insert_id();
} else {
$followid = $_GET['id'];
}


mysql_select_db($database_follows, $follows);
$query_contact_join2 = "SELECT * FROM follows_users WHERE user_id = $workerid";
$contactJ2 = mysql_query($query_contact_join2, $follows) or die(mysql_error());
$row_contactJ2 = mysql_fetch_assoc($contactJ2);

$worker_id = $row_contactJ2['user_id'];

//replaced by $whois global - 9/2/2009
//$sender_id = $row_userinfo['user_id'];

$name = $row_userinfo['user_name'];
$senderemail = $row_userinfo['user_email'];
$recipient = $row_qlead['user_email'];
$subject = "New Harvest Connect - " .MINISTRY;

if ($notification==1){
$message = "There has been an update to this group: " . $_POST['group_name'] . "." . " Please visit http://www.newharvestconnect.com/".SITEID." Today is " . date('F d, Y'); 
} else {
$message = "You have been assigned to this group: " . $_POST['group_name'] . "." . " Please visit http://www.newharvestconnect.com/".SITEID." Today is " . date('F d, Y'); 
}

$header = "From: ". $name . " <" . $senderemail . ">\r\n"; 

mail ($recipient, $subject, $message, $header);


//$insertemail = sprintf("INSERT INTO follows_email (sender_id, worker_id, followup_id, email_date, email_data) VALUES (%s, %s, %s, %s, %s)",
 //                      GetSQLValueString($sender_id, "int"),
//					   GetSQLValueString($worker_id, "int"),
//					   GetSQLValueString($followid, "int"),
//GetSQLValueString(time(), "date"),
	//				   GetSQLValueString($message, "text"));

//mysql_select_db($database_follows, $follows);
//$Result1 = mysql_query($insertemail, $follows) or die(mysql_error());


	
?>