<?php

//include('includes/session.php');
$pagetitle = 'Login';

//SET SUCCESS NOTICES



?>

<?php //HeaderInfo();
?>
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
<?php

if($form->num_errors > 0){
   echo "<font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
}
?>
<form action="process.php" method="POST"> 
<table align="left" border="0" cellspacing="0" cellpadding="3">
<tr><td>Username:</td><td><input type="text" name="user" maxlength="30" value="<?php echo $form->value("user"); ?>"></td><td><?php echo $form->error("user"); ?></td></tr>
<tr><td>Password:</td><td><input type="password" name="pass" maxlength="30" value="<?php echo $form->value("pass"); ?>"></td><td><?php echo $form->error("pass"); ?></td></tr>
<tr><td colspan="2" align="left"><input type="checkbox" name="remember" <?php if($form->value("remember") != ""){ echo "checked"; } ?>>
<font size="2">Remember me next time     
<input type="hidden" name="sublogin" value="1">
<input type="submit" value="Login"></td></tr>
<tr><td colspan="2" align="left"><br><font size="2">[<a href="forgotpass.php">Forgot Password?</a>]</font></td><td align="right"></td></tr>
<tr><td colspan="2" align="left">&nbsp;</td>
</tr>
</table>
</form>
					<script type="text/javascript">
						var valid2 = new Validation('form1', {useTitles:true});
					</script>
					<div><a href="http://www.mozilla.com/en-US/firefox/">This site is best viewed with Firefox <img src="images/fox.png" width="60" height="60" border="0" /></a></div>

</div></div>
</body>
</html>