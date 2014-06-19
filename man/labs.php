<?php
session_start();


// labs.php

if (@$_GET['act'] == NULL) {
	print("Direct access to this script is not allowed.");
	include("./footer.php");
	exit();
}




if (@is_numeric($_GET['make']) && @!$_GET['a']) {
include("./header.php");
$sql->select("labs","*","lid",$_GET['act']);
$row = mysql_fetch_array($result);
$labs_template->header($row['lab_title']);

} else if (@$_GET['make'] == "all") {
include("./header.php");
$lid = $_GET['act'];
$sql->select("labs","*","lid",$_GET['act']);
$row = mysql_fetch_array($result);

$labs_template->display();

$a = array(
	$row['lab_title'],
	$row['author'],
	$row['objectives'],
	$row['safety'],
	$row['supplies'],
	$row['background'],
	$row['introduction'],
	$row['methods'],
	$row['prelab'],
	$row['setup'],
	$row['procedures'],
	$row['postlab']
);

$b = array(
	"%LAB_TITLE%",
	"%AUTHOR%",
	"%OBJECTIVES%",
	"%SAFETY%",
	"%SUPPLIES%",
	"%BACKGROUND%",
	"%INTRODUCTION%",
	"%METHODS%",
	"%PRELAB%",
	"%SETUP%",
	"%PROCEDURE%",
	"%POSTLAB%",
);

$html = str_replace($b,$a,$html);
print($html);


	
} else if ($_GET['make'] != NULL && $_GET['make'] != "all" && !is_numeric($_GET['make'])) {
include("./config.php");
	$acceptable = array (
		"safety",
		"objectives",
		"supplies",
		"introduction",
		"methods",
		"procedures"
	);
	
	if (in_array($_GET['make'], $acceptable)) {
	$sql->select("labs","*","lid",$_GET['act']);
	$row = mysql_fetch_array($result);
	$make = $_GET['make'];
		print("<div style='width:650px;'>");
		print($row[$make]);
		print("</div>");
	} else {
		print("Error");
	}
	die();


} else {
	include("./header.php");
	print("You haven't selected a correct link.");
}



$labs_template->display_end();
include("./footer.php");

?>