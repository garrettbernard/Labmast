<?php
session_start();
// assignments.php

if (!$_SESSION) {
	// include("./config.php");
	// header("location: " . $site_url;
	include("./header.php");
	print("You must be logged in to submit an assignment.");
	include("./footer.php");
	exit();
}

if (!$_POST) {
include("./header.php");


if (@$_GET['act'] == NULL && @$_GET['make'] != NULL) {
	$assignments_template->display_assigments-all();
// } else if (@$_GET['act'] != NULL && @$_GET['make'] == NULL) {
//	$assigments_template->display_single_lab();
} else if (@$_GET['act'] != NULL && (@$_GET['make'] == "prelab" | @$_GET['make'] == "report" | @$_GET['make'] == "postlab")) {
		$assignments_template->header();
	
		$sql->select("labs","lid,lab_title","lid",$_GET['act']);
		$row = mysql_fetch_assoc($result);
		$assignments_template->display_list($row['lid'],$row['lab_title']);
	
	$sql->select("labs","lid," . $_GET['make'],"lid",$_GET['act']);
	$row = mysql_fetch_assoc($result);
	$data = $row[$_GET['make']];
	
	$sql = "SELECT * FROM assignments WHERE uid='" . $_SESSION['uid'] . "' AND lid='" . $_GET['act'] . "'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$typeofdoc = $_GET['make'];
	// print($row['prelab']);
	//if (mysql_num_rows($result) != 0) {
		$old_values = explode("|",$row[$typeofdoc],-1);
		// print_r($old_values);
	//}

	$i = 0;
	$count = substr_count($data,"%TEXTBOX%");
	while ($i < $count) {
	$name = "textbox[" . $i . "]";
	$data = preg_replace('/\%TEXTBOX%/',"<input type='text' name='" . $name . "' value='" . htmlspecialchars($old_values[$i], ENT_QUOTES) . "' />", $data, 1);
	$i++;
	}
	
	$j = 0;
	$count = substr_count($data,"%TEXTAREA%");
	while ($j < $count) {
	$name = "textarea[" . $i . "]";
	$data = preg_replace('/\%TEXTAREA%/',"<textarea rows=5 cols=40 name='" . $name . "'>" . htmlspecialchars($old_values[$i], ENT_QUOTES) . "</textarea>", $data, 1);
	$i++;
	$j++;
	}
	
	$assignments_template->form_sheet($_GET['make'],$_GET['act']);
	$html = str_replace("%FORM_SHEET%",$data,$html);
	print($html);
		

} else {
main();	
}
	
function main() {
	global $assignments_template, $sql, $result;
	
	$assignments_template->header();
	$assignments_template->display();
	$sql->select("users","uid,affiliated_courses","uid",$_SESSION['uid']);
	$row = mysql_fetch_assoc($result);
	$affiliated_courses = $row['affiliated_courses'];
	$count = substr_count($affiliated_courses,"|");
	$affiliated_courses = explode("|",$affiliated_courses,-1);
	
	$i = 0;
	$j = 0;
	
	while($i < $count) {
		$sql->select("labs","lid,cid,lab_title","cid",$affiliated_courses[$i]);
		$count1 = mysql_num_rows($result);
		
		if ($count1 > 0) {
			$row = mysql_fetch_assoc($result);
			$assignments_template->display_list($row['lid'],$row['lab_title']);
		}
		
		$i++;
	}
}


$assignments_template->display_end();

include("./footer.php");

} else if ($_POST != NULL && $_GET['act'] == 'update') {
include("./config.php");

function mres($q) {
    if(is_array($q))
        foreach($q as $k => $v)
            $q[$k] = mres($v); //recursive
    elseif(is_string($q))
        $q = mysql_real_escape_string($q);
    return $q;
}


$_POST = mres($_POST);

// print_r($_POST);

if (is_array($_POST['textbox'])) {
$textbox = implode("|",$_POST['textbox']);
} else {
$textbox = '';
}

if (is_array($_POST['textarea'])) {
$textarea = implode("|",$_POST['textarea']);
} else {
$textarea = '';
}

if ($textbox != NULL) {
	$textbox = $textbox . "|";
}

if ($textarea != NULL) {
$textarea = $textarea . "|";
}


//	$text = substr($textbox . $textarea . "|",1);
$text = $textbox . $textarea;

$a = array(
	"'" . $_SESSION['uid'] . "'",
	"'" . $_POST['lid'] . "'",
	"'" . $text . "'"
	);
	
$b = array(
	'uid',
	'lid',
	"'" . $_POST['type'] . "'"
	);

	$sql = "SELECT * FROM assignments WHERE uid='" . $_SESSION['uid'] . "' AND lid='" . $_POST['lid'] . "'";
	$result = mysql_query($sql);
	
	if (mysql_num_rows($result) == 0) {
		$sql->insert("assignments",$b,$a);
		
	} else {
		
		// $sql = "UPDATE assignments SET " . $_POST['type'] . "='" . $text . "' WHERE uid='" . $_SESSION['uid'] . "' AND lid='" . $_POST['lid'] . "'";
		$sql = "UPDATE assignments SET " . $_POST['type'] . "='$text' WHERE uid='" . $_SESSION['uid'] . "' AND lid='" . $_POST['lid'] . "'";
		// print($sql);
		mysql_query($sql);
	}
	
	header("location: " . $_SERVER['HTTP_REFERER']);

	
}

 