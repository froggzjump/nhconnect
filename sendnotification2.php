<?
include "includes/config.php";
include_once('includes/bulksms.php');


if ($_POST['contact_user']){
$workerid = $_POST['contact_user'];
} else {
$workerid = $_GET['wid'];	
}


if ($notification==0){
$followid = mysql_insert_id();
} else {
$followid = $_GET['id'];
}

mysql_select_db($database_follows, $follows);
$query_contact_join2 = "SELECT * FROM follows_users WHERE user_id = $workerid";
$contactJ2 = mysql_query($query_contact_join2, $follows) or die(mysql_error());
$row_contactJ2 = mysql_fetch_assoc($contactJ2);

mysql_select_db($database_follows, $follows);
$query_contact_join3 = "SELECT * FROM follows_contacts WHERE contact_id = $option";
$contactJ3 = mysql_query($query_contact_join3, $follows) or die(mysql_error());
$row_contactJ3 = mysql_fetch_assoc($contactJ3);


$worker_id = $row_contactJ2['user_id'];
$worker_phone = $row_contactJ2['user_phone'];
$worker_sms = "1" . ereg_replace("[^A-Za-z0-9]", "", $worker_phone);
$worker_name = $row_contactJ2['user_name'];
$sender_id = $row_userinfo['user_id'];

$name = $row_userinfo['user_name'];
$senderemail = $row_userinfo['user_email'];
$recipient = $row_contactJ2['user_email'];
$subject = "New Harvest Connect - " .MINISTRY;

$cfirst = $row_contactJ3['contact_first'];
$clast = $row_contactJ3['contact_last'];
$followup_id = $row_contactJ3['contact_id'];


if ($notification==0){
$update1a = "A new assignment has been sent to you";
$update2a = "The person you have been assigned is";
} else {
$update1a = "A followup has been updated";
$update2a = "The person updated is";
}

$message = "<body bgcolor=\"black\">
<div id=\"mainContainer\">
  <div id=\"wrapper_NewHomePage\">
<!-- <div id=\"banner\"><img src=\"http://newharvestconnect.com/global/header1.jpg\" alt=\"\"></div>-->
<div id=\"content\" class=\"newHomePage\">
	<div id=\"introduction\">
		            </div>
   	   	<div id=\"bannerHome\" class=\"newHomePage\">
		<div id=\"bannerHomeText\">
			<h2>Hello " . $worker_name . "</h2>
<p>" . $update1a . "</p>
<p>" . $update2a .  ": " . $cfirst . " " . $clast . "</p>
<ul>
<li> Today is Date " . date('F d, Y') . "</li><br><br>
</ul>
   </div>
		<div id=\"homeButtons\">
			<ul id=\"promonav\">
                <li><a href=\"http://www.newharvestconnect.com/" .SITEID. " \">nhcf
<!--                <img src=\"http://newharvestconnect.com/global/2A.jpg\" class=\"freshout\" border=\"0\" alt=\"http://www.newharvestconnect.com/" . SITEID . "\">--></a></li>
			</ul>
			<h2>Thank you for your faithful service!</h2><br><br>
		</div>
		<div class=\"clear\"></div>
    </div>
   	  <div class=\"clear\"></div>
</div>
	<div class=\"clear\"></div>
  </div>
</div>

</body>";

$tmessage = $cfirst . " " . $clast . " has been assigned to your followups. Please visit http://www.newharvestconnect.com/".SITEID." Thank you for your faithful service. " . date('F d, Y'); 


$header = "MIME-Version: 1.0" . "\r\n";
$header .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$header .= 'From: ' . $name . '<' . $senderemail . '>' . "\r\n";



mail ($recipient, $subject, $message, $header);

//send_sms($worker_sms,$tmessage);

$sms = new bulksms;
$vars = array("message" => $tmessage, "msisdn"  => $worker_sms );

if($sms->send_sms($vars) == SUCCESS) {

    set_msg('Text message success');

} else {

    echo "There was an error, status code: ".$sms->get_status();

}

$insertemail = sprintf("INSERT INTO follows_email (sender_id, worker_id, followup_id, email_date, email_data) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($sender_id, "int"),
					   GetSQLValueString($worker_id, "int"),
					   GetSQLValueString($followup_id, "int"),
					   GetSQLValueString(time(), "date"),
					   GetSQLValueString($message, "text"));

mysql_select_db($database_follows, $follows);
$Result1 = mysql_query($insertemail, $follows) or die(mysql_error());


	
?>