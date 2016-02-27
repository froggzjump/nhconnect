<?php 
require_once('includes/config.php');
include('includes/sc-includes.php');

$l2_grp_sql = "SELECT `user_email`, `user_level`, `user_id`, `member_group_id`, `user_name`, `group_id`, `leader_id`, `group_name` FROM follows_users LEFT OUTER JOIN follows_group ON group_id=member_group_id WHERE user_level=2";


if (isset($_POST['options'])) {
    $groupis = $_GET['grp'];    
    $options = array_filter($_POST['options'], "is_numeric");
    
  foreach($options as $option){
  $inquery = "UPDATE follows_users SET member_group_id = $groupis WHERE user_id = $option";
  mysql_select_db($database_follows, $follows);
  $Result1 = mysql_query($inquery, $follows) or die(mysql_error());
  $dis = "block";
  set_msg('Group Updated - User Added, You may now close this window and refresh previous screen with F5');
   }
  }
          
mysql_select_db($database_follows, $follows);
$query_users = $l2_grp_sql;
$sys_users = mysql_query($query_users, $follows) or die(mysql_error());

//$row_users = mysql_fetch_assoc($sys_users, MYSQL_ASSOC);   -- put back if missing first worker from the list generated.

$row_users = mysql_fetch_assoc($sys_users);
$totalRows_users = mysql_num_rows($sys_users);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>
<script type="text/javascript" src="calendar.js"></script>

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
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
<link href="includes/tables.css" rel="stylesheet" type="text/css" />  

<style type="text/css">
.round-a-error{
        background:#CC0000 url(../images/round_red-left.png) left top no-repeat;
        color:#FFFFFF;
        text-align:center;
    }
        .round-a-error div{
            background:url(../images/round_red-right.png) right bottom no-repeat;
            padding:4px;
        }
</style>
<head>


<title>Group Add Popout</title>
</head>
<body>   
<?php $groupis = $_GET['grp'];   
echo "<center> <h1> Adding Users to Group" . $groupis . "</h1></center>";

?>  
<form action="<?php $_SERVER['php_self'];?>" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="close_window()"> 

<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td colspan="4">
        <h2>Scroll to bottom to hit "Add to Group" button</h2>
        <span class="notices" id="notice" style="display:<?php echo $dis; ?>">
        
        <?php 
        echo $_SESSION['msg'];
        unset($_SESSION['msg']); 
        ?>
        
        </span>
        
        </td>
      </tr>
      <tr>
        <th>Worker Name</th>
        <th>Email</th>
        <th>Current Group</th> 

      </tr>

        
<?php 
while ($row = mysql_fetch_array($sys_users)) 
        {
echo "<tr bgcolor=\"F4F4F4\">";
echo "<td>";
echo "<input type='checkbox' name='options[]' value=" . $row['user_id'] . ">" . "&nbsp;" . $row['user_name']; 
echo "</td>";
echo "<td>";
echo $row['user_email'];
echo "</td>";
echo "<td>";
echo $row['group_name'];
echo "</td>";
echo "</tr>";
       }
?> 
        
</table> 
<input type="submit" name="Submit" value="Add to group"/>
</form>


</body>
</html>

 