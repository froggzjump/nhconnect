<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
<div class="rightcolumn">
<?php if ($contactcount > 0) { ?>
Search in Notes<br />
<form id="form3" name="form3" method="GET" action="index.php">
      <input name="s" type="text" id="s" size="15" />
        <input type="submit" name="Submitf" value="Go" />
  </form>
Search in Names<br />
<form id="form3" name="form3" method="GET" action="index.php">
      <input name="n" type="text" id="n" size="15" />
        <input type="submit" name="Submitf" value="Go" />
  </form>
<?php } ?>
    <p>&nbsp;</p>
    <?php if ($row_userinfo['user_level'] == 1) { 
     print ("<p><a class=\"addcontact\" href=\"user.php\">+ Add Worker</a></p>");
	 }
	 ?>
    
    <?php if ($row_userinfo['user_level'] == 1) { 
     print ("<p><a class=\"addcontact\" href=\"contact.php\">+ Add Follow-Up</a></p>");
	 }
	 ?>
    
    
    <?php if ($pagetitle==ContactDetails) { ?>
    <br /><br /><hr />
    <p><strong><span style="color : #f00;">Follow-Up Information</span></strong><br />
    
    <hr />
  <strong>This Follow-Up was started via</strong><br />
<?php if ($row_contact['contact_method']) { echo $row_contact['contact_method']  ."<br>"; } ?>
<?php echo date('F d, Y', $row_contact['contact_date']) . "<br>" ; ?>
    <hr />
	  <?php if ($row_contact['contact_first']) { echo $row_contact['contact_first'] . " " . $row_contact['contact_last'] . "<br>"; } ?>
      <?php if ($row_contact['contact_street']) { echo $row_contact['contact_street']  ."<br>"; } ?>
    <?php if ($row_contact['contact_city']) { echo $row_contact['contact_city'] .","; } ?> <?php if ($row_contact['contact_state']) { echo $row_contact['contact_state']; } ?> <?php if ($row_contact['contact_zip']) { echo $row_contact['contact_zip']; } ?></p>
    <?php if ($row_contact['contact_street'] && $row_contact['contact_city'] && $row_contact['contact_state']) { ?><p><a href="http://maps.google.com/maps?f=q&amp;hl=en&amp;q=<?php echo $row_contact['contact_street']; ?>,+<?php echo $row_contact['contact_city']; ?>,+<?php echo $row_contact['contact_state']; ?>+<?php echo $row_contact['contact_zip']; ?>&gt;" target="_blank">+ View Map </a></p>
    <?php } ?>
    <hr />
    <p>
	<?php if ($row_contact['contact_phone']) { ?><strong>Phone:</strong> <?php echo $row_contact['contact_phone']; ?><br /><?php } ?>
<?php if ($row_contact['contact_email']) { ?>
      <a href="mailto:<?php echo $row_contact['contact_email']; ?>"><?php echo $row_contact['contact_email']; ?></a>        
<?php } ?>
</p>
<?php if ($row_contact['contact_profile']) { ?>   
 <hr />
  <strong>Background</strong><br />
  <?php echo $row_contact['contact_profile']; ?>  
<?php } ?> 
<hr />
<?php if ($row_contactJ2['user_name']) { echo "Currently assigned to: " . $row_contactJ2['user_name']  ."<br>"; } ?>
<?php } ?>  </div>