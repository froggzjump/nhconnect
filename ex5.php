<?php
require 'includes/class.eyemysqladap.inc.php';
require 'includes/class.eyedatagrid.inc.php';
include 'includes/config.php';
include('includes/sc-includes.php');

$pagetitle="FollowUp";

$db = new EyeMySQLAdap($hostname_follows, $username_follows, $password_follows,$database_follows);

// Load the datagrid class
$x = new EyeDataGrid($db);

// Set the query
$x->setQuery("contact_id, name, contact_phone, contact_email, follow_date, contact_user", "follows_contacts", "contact_id", "contact_wait <> 1", "ASC");

// Allows filters
$x->allowFilters();

// Change headers text
$x->setColumnHeader('name', 'Name');
$x->setColumnHeader('contact_user', 'Worker');
$x->setColumnHeader('contact_phone', 'Phone');
$x->setColumnHeader('follow_date', 'Date');
$x->setColumnHeader('contact_email', 'Email');
//$nameofworker = $x->getWorkerID('contact_user');

//$x->setColumnHeader('contact_user', $worker);


// Hide ID Column
$x->hideColumn('contact_id');
//$x->hideColumn('contact_user');
// Change column type
$x->setColumnType('name', EyeDataGrid::TYPE_HREF, 'contact-details.php?id=%contact_id%'); // Google Me!
$x->setColumnType('follow_date', EyeDataGrid::TYPE_DATE, 'M d, Y', true); // Change the date format
//$x->setColumnType('Gender', EyeDataGrid::TYPE_ARRAY, array('m' => 'Male', 'f' => 'Female')); // Convert db values to something better
//$x->setColumnType('Done', EyeDataGrid::TYPE_PERCENT, false, array('Back' => '#c3daf9', 'Fore' => 'black'));

// Show reset grid control
$x->showReset();

// Add custom control, order does matter
//$x->addCustomControl(EyeDataGrid::CUSCTRL_TEXT, "alert('%FirstName%\'s been promoted!')", EyeDataGrid::TYPE_ONCLICK, 'Promote Me');

// Add standard control
$x->addStandardControl(EyeDataGrid::STDCTRL_EDIT, 'contact.php?id=%contact_id%',TYPE_HREF, 'contact.php');
$x->addStandardControl(EyeDataGrid::STDCTRL_DELETE, "alert('Deleting %_P%')");


// Add create control
$x->showCreateButton("contact.php", 'contact.php');

// Show checkboxes
//$x->showCheckboxes();

// Show row numbers
$x->showRowNumber();

// Apply a function to a row
function returnSomething($lastname)
{
	return strrev($lastname);
}
//$x->setColumnType('name', EyeDataGrid::TYPE_FUNCTION, 'returnSomething', '%name%');

if (EyeDataGrid::isAjaxUsed())
{
	$x->printTable();
	exit;
}
?>
<title><?php echo $pagetitle; ?>s</title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>
<link href="includes/table.css" rel="stylesheet" type="text/css" />
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php include('includes/header.php'); ?>
<div class="Bigcontainer">
  <div class="leftcolumn">
    <h2><?php echo MINISTRY . " Follow-Ups";?></h2> for <?php echo $row_userinfo['user_name'] . $x->row_count ; ?><br /><br />

<?php 
   
   ?>
<?php


// Print the table
EyeDataGrid::useAjaxTable();
?>
<p>&nbsp; </p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>