<?php

include "includes/config.php";
include('includes/sc-includes.php');


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

$name = $_POST['sendersname'];
$senderemail = $_POST['sendersemail'];
$recipient = $_POST['tois'];
$toid = $_POST['toid'];
$subject = $_POST['subjectis'];
$message = $_POST['messageis']; 
$header = "From: ". $name . " <" . $senderemail . ">\r\n"; 

$emessage = "Email. " . "(Subject)". $subject . "     " .  "(Message)" . $message;
$num = 1;

mail($recipient, $subject, $message, $header);

//mysql_query("INSERT INTO follows_notes (note_contact, note_addedby, note_text, note_date, note_status) VALUES (".$toid.", '".addslashes($_POST['sendersname'])."', ".$toid.", ".time().",	1)");

$insertSQL = sprintf("INSERT INTO follows_notes (note_contact, note_addedby, note_text, note_date, note_status) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($toid, "int"),
                       GetSQLValueString($name, "text"),
					   GetSQLValueString($emessage, "text"),
                       GetSQLValueString(time(), "date"),
					   GetSQLValueString($num, "int"));

  mysql_select_db($database_follows, $follows);
  $Result1 = mysql_query($insertSQL, $follows) or die(mysql_error());


set_msg('Email Sent and Note added ');
header ("Location: contact-details.php?id=$toid");



?>