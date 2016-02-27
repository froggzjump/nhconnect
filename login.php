<?php require_once('includes/config.php'); 

session_start();
if (isset($_SESSION['user'])) {
header('Location: index.php');
}
mysql_select_db($database_follows, $follows);
$pagetitle = 'Login';

//SET SUCCESS NOTICES
function set_msg($msg) 
	{
	$_SESSION['msg'] = $msg;
	}

function display_msg() {
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}

$dis = 'none';
if (isset($_SESSION['msg'])) {
$dis = block;
}
//


if ($_POST['email']  && $_POST['password']) {
mysql_select_db($database_follows, $follows);
$query_logincheck = "SELECT * FROM follows_users WHERE user_email = '".$_POST['email']."' AND user_password = '".$_POST['password']."'";
$logincheck = mysql_query($query_logincheck, $follows) or die(mysql_error());
$row_logincheck = mysql_fetch_assoc($logincheck);
$totalRows_logincheck = mysql_num_rows($logincheck);

if ($totalRows_logincheck==1) { 
	$_SESSION['user'] = $_POST['email'];
	$_SESSION['username'] = $_POST['email'];
	$_SESSION['qadmin']=0;
if (($_POST['email']=="mikeandkesia@gmail.com") || ($_POST['email']=="rags@newharvestoneighty.com") || ("cyn9902@gmail.com")){
	$_SESSION['qadmin']=1;
}	
	$redirect = $row_logincheck['user_home'];
	header(sprintf('Location: %s', $redirect)); die;	
}

if ($totalRows_logincheck < 1) { 
set_msg('Incorrect Username or Password');
header('Location: login.php'); die;
}

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $pagetitle; ?></title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />

<style type="text/css">
*
{
	margin: 0px;
	padding: 0px;
}

body
{
	font-family: arial, helvetica, sans-serif;
	font-size: 11px;
	background: #C3C39D url('../images/bg2.jpg');
	color: #91936E;
}

a
{
	color: #5C6240;
	background: inherit;
}

#main
{
	position: absolute;
	top: 0px;
	left: 0px;
	z-index: 1;
	background-image: url('../images/main.jpg'); width: 730px; height: 522px; background-repeat: no-repeat;
}

#bg
{
	position: absolute;
	top: 0px;
	left: 0px;
	z-index: 0;
	background-image: url('../images/bg1.jpg'); width: 100%; height: 522px; background-repeat: repeat-x;
}

#bgsmile
{
	position: absolute;
	top: 48px;
	right: -607px;
	z-index: 0;
	background-image: url('../images/smiles_on.png');
	width: 588px;
	height: 424px;
	background-repeat:no-repeat;
}

.titlo
{
color:#8A4117;
}

#bgr
{
	position: absolute;
	top: 320px;
	right: 0px;
	z-index: 0;
	height: 259px;
	width: 586px;
	}

#footer
{
	position: absolute;
	z-index: 2;
	left: 150px;
	top: 465px;
}

A:link {text-decoration: none}
A:visited {text-decoration: none}
A:active {text-decoration: none}
A:hover {font-size:24; font-weight:bold; color: white;}

</style>


</head>

<body>
<div id="bg"></div>


<div id="main"><div id="bgsmile"></div><div id="bgr">



  <h1><span class="titlo"><?php echo MINISTRY;?> - Follow-Up System </span></h1>
  <form id="form1" name="form1" method="post" action="">
  <span class="notices" style="display:<?php echo $dis; ?>"><?php display_msg(); ?></span>
    <span class="titlo">
    Email Address <br />
    <input name="email" type="text" size="35" class="required validate-email" title="You must enter your email address." />
    <br />
    <br />
    Password<br /></span>
    <input type="password" name="password" class="required" title="Please enter your password." />
    <br />
    <br />
    <input type="submit" name="Submit" value="Login" />
    <a href="password.php">Forget password?</a>
  </form>
					<script type="text/javascript">
						var valid2 = new Validation('form1', {useTitles:true});
					</script>
					<div><a href="http://www.mozilla.com/en-US/firefox/">This site is best viewed with Firefox <img src="images/fox.png" width="60" height="60" border="0" /></a></div>

</div></div>
</body>
</html>