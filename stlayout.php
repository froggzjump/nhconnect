<?php require_once('includes/config.php'); ?><?php require_once('includes/config.php'); 
include('includes/sc-includes.php');

$pagetitle = 'Stage';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $pagetitle; ?>s</title>
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>
</head>
<body>

<?php 
$querys1 =  "SELECT * FROM follows_stages";
$subjectset1 = mysql_query($querys1);
$id=1;

while($subject1 = mysql_fetch_array($subjectset1)){
$st[$id] = $subject1[0];
$color[$id] = $subject1[2];
$id++;
}
?>


<?php include('includes/header.php'); ?>
<div class="tcontainer">


<center>
<table width="200" border="1">
  <tr>
   <td>2010</td>
    <td><a href="stlayout.php?mn=110">January</a></td>
    <td><a href="stlayout.php?mn=210">Febuary</a></td>
    <td><a href="stlayout.php?mn=310">March</a></td>
    <td><a href="stlayout.php?mn=410">April</a></td>
    <td><a href="stlayout.php?mn=510">May</a></td>
    <td><a href="stlayout.php?mn=610">June</a></td>
    <td><a href="stlayout.php?mn=710">July</a></td>
    <td><a href="stlayout.php?mn=810">August</a></td>
    <td><a href="stlayout.php?mn=910">September</a></td>
    <td><a href="stlayout.php?mn=1010">October</a></td>
    <td><a href="stlayout.php?mn=1110">November</a></td>
    <td><a href="stlayout.php?mn=1210">December</a></td>
  </tr>
</table>


<table width="200" border="1">
  <tr>
   <td>2011</td>
    <td><a href="stlayout.php?mn=111">January</a></td>
    <td><a href="stlayout.php?mn=211">Febuary</a></td>
    <td><a href="stlayout.php?mn=311">March</a></td>
    <td><a href="stlayout.php?mn=411">April</a></td>
    <td><a href="stlayout.php?mn=511">May</a></td>
    <td><a href="stlayout.php?mn=611">June</a></td>
    <td><a href="stlayout.php?mn=711">July</a></td>
    <td><a href="stlayout.php?mn=811">August</a></td>
    <td><a href="stlayout.php?mn=911">September</a></td>
    <td><a href="stlayout.php?mn=1011">October</a></td>
    <td><a href="stlayout.php?mn=1111">November</a></td>
    <td><a href="stlayout.php?mn=1211">December</a></td>
  </tr>
</table>


<table width="200" border="1">
  <tr>
   <td>2012</td>
    <td><a href="stlayout.php?mn=112">January</a></td>
    <td><a href="stlayout.php?mn=212">Febuary</a></td>
    <td><a href="stlayout.php?mn=312">March</a></td>
    <td><a href="stlayout.php?mn=412">April</a></td>
    <td><a href="stlayout.php?mn=512">May</a></td>
    <td><a href="stlayout.php?mn=612">June</a></td>
    <td><a href="stlayout.php?mn=712">July</a></td>
    <td><a href="stlayout.php?mn=812">August</a></td>
    <td><a href="stlayout.php?mn=912">September</a></td>
    <td><a href="stlayout.php?mn=1012">October</a></td>
    <td><a href="stlayout.php?mn=1112">November</a></td>
    <td><a href="stlayout.php?mn=1212">December</a></td>
  </tr>
</table>

<table width="200" border="1">
  <tr>
   <td>2013</td>
    <td><a href="stlayout.php?mn=113">January</a></td>
    <td><a href="stlayout.php?mn=213">Febuary</a></td>
    <td><a href="stlayout.php?mn=313">March</a></td>
    <td><a href="stlayout.php?mn=413">April</a></td>
    <td><a href="stlayout.php?mn=513">May</a></td>
    <td><a href="stlayout.php?mn=613">June</a></td>
    <td><a href="stlayout.php?mn=713">July</a></td>
    <td><a href="stlayout.php?mn=813">August</a></td>
    <td><a href="stlayout.php?mn=913">September</a></td>
    <td><a href="stlayout.php?mn=1013">October</a></td>
    <td><a href="stlayout.php?mn=1113">November</a></td>
    <td><a href="stlayout.php?mn=1213">December</a></td>
  </tr>
</table>
<table width="200" border="1">
  <tr>
   <td>2014</td>
    <td><a href="stlayout.php?mn=114">January</a></td>
    <td><a href="stlayout.php?mn=214">Febuary</a></td>
    <td><a href="stlayout.php?mn=314">March</a></td>
    <td><a href="stlayout.php?mn=414">April</a></td>
    <td><a href="stlayout.php?mn=514">May</a></td>
    <td><a href="stlayout.php?mn=614">June</a></td>
    <td><a href="stlayout.php?mn=714">July</a></td>
    <td><a href="stlayout.php?mn=814">August</a></td>
    <td><a href="stlayout.php?mn=914">September</a></td>
    <td><a href="stlayout.php?mn=1014">October</a></td>
    <td><a href="stlayout.php?mn=1114">November</a></td>
    <td><a href="stlayout.php?mn=1214">December</a></td>
  </tr>
</table>
    
    

<table>
        <tr>
            <?php
			$queryss =  "SELECT * FROM follows_stages";
			$subjectset = mysql_query($queryss);
			$totalRows_stages = mysql_num_rows($subjectset);
            confirm_query($subjectset);
						   
			while($subjects = mysql_fetch_array($subjectset)){
				for($cnt=1; $cnt <= $id; $cnt++){
			    if(($subjects[0]) == $st[$cnt]){
			echo "<td style=\"padding-left:5px\" class=\"row_stat\" bgcolor=\"{$color[$cnt]}\"><a href=\"stspecific.php?stspecific={$subjects[0]}&stname={$subjects[1]}\">{$subjects[1]}</a></td>";
			     }
			   }
			 }
			?>	 
     
     </tr>
     
     
     <tfoot>
    	<tr>
        	<td colspan="<?php echo $totalRows_stages; ?>" ><em>The above stages can be edited directly in the users edit section </em></td>
        </tr>
    </tfoot>
    
	 <tr>
         <ul>
            
            <?php for($cnt=1; $cnt <= $id; $cnt++) {?>
            <td style="padding-left:5px" class="rowres">
			
	    <?php if($row_userinfo['user_level'] == 1){?>
            <?php get_all_rows($st[$cnt],$whois); ?> 
	    <? }?>
            <?php if($row_userinfo['user_level'] != 1){?>
	    <?php get_all_rows_w($st[$cnt],$whois); ?> 
            <? }?>        

            </td>
            <?php }?>
                    
        </ul>
     
     </tr>
     
  </table>
</center>

  <?php // include('includes/right-column.php'); ?>
</div>

</body>
</html>

