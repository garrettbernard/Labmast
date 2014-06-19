<?php
session_start();

# /cp_labs.php

$session_courses = explode("|",$_SESSION['affiliated_courses'],-1);

if ($_SESSION['is_teacher'] != '1') {
	print("You must be logged in as a lab instructor to access this page.");
	$allowed = 'no';
}

if (@$_GET['act'] != NULL && $_SESSION['is_teacher'] == '1') {
	if (!in_array($_GET['act'],$session_courses)) {
		print("You are not listed as a lab instructor for this course.");
		$allowed = 'no';
	}
} else if (@$_GET['act'] == NULL) {
	print("You have not selected a lab.");
	$allowed = 'no';
}

	
class cp_labs {

	function list_labs() {
		global $sql,$result,$cp_labs_template,$html,$base_url;
		$sql->select("labs","lid,cid,lab_title","cid",$_GET['act']);
		
		$i=0;
		while ($i < mysql_num_rows($result)) {
			$row = mysql_fetch_assoc($result);
			$lab_names[$i] = "<a href='" . $base_url . "/labs/" . $row['lid'] . "'>" . $row['lab_title'] . "</a> ( <a href='" . $base_url . "/cp/labs/" . $_GET['act'] . "/edit/" . $row['lid'] . "/objectives'>Edit</a> )";
			$i++;
		}
		
		$lab_names = implode("<br />\r\n",$lab_names);
		
		$cp_labs_template->edit_labs();
		
		$html = str_replace("%LIST_LABS%",$lab_names,$html);
		print($html);
	
	}
	
	function edit_labs() {
		global $sql,$result,$cp_labs_template,$html,$base_url;
		
		if ($_POST['create_lab'] != NULL) {

		$a = array(
			"'" . mysql_real_escape_string($_GET['act']) . "'",
			"'" . mysql_real_escape_string($_POST['create_lab']) . "'",
			"'" . $_SESSION['name'] . "'"
		);
		
		$b = array(
			"cid",
			"lab_title",
			"author"
		);
		
		$sql->insert("labs",$b,$a);
		}
		
		$sql->select("labs","lid,cid,lab_title","cid",$_GET['act']);
		
		$i=0;
		while ($i < mysql_num_rows($result)) {
			$row = mysql_fetch_assoc($result);
			$lab_names[$i] = "<a href='" . $base_url . "/cp/labs/" . $_GET['act'] . "/edit/" . $row['lid'] . "/objectives'>" . $row['lab_title'] . "</a>";
			$i++;
		}
			
		$lab_names = implode("<br />\r\n",$lab_names);
		
		$cp_labs_template->edit_labs();
		
		$html = str_replace("%LIST_LABS%",$lab_names,$html);
		print($html);
	}
	
	function edit_single_lab() {
		global $sql,$result,$cp_labs_template,$html;

		
		$cp_labs_template->edit_single_lab_menu();
		
		$db_tables = array(
			'objectives',
			'safety',
			'supplies',
			'background',
			'introduction',
			'methods',
			'prelab',
			'setup',
			'procedures',
			'postlab',
			'report'
		);
		
		$d_values = array(
			'objectives',
			'safety',
			'supplies',
			'background',
			'introduction',
			'methods',
			'prelab',
			'setup',
			'procedures',
			'postlab',
			'report'
		);
		
		$arraykey = array_keys($d_values, $_GET['d']);
		$to_select = $arraykey[0];
		$to_select = $db_tables[$to_select];
		$value = $to_select;
		
		if ($_POST['textarea_edit'] != NULL) {

			$textarea_edit = mysql_real_escape_string($_POST['textarea_edit']);
			$sql->update("labs",$to_select,$textarea_edit,"lid",$_GET['c']);
			// header("location: ".$_SERVER["HTTP_REFERER"]);
			// exit();
		}
		
		if ($to_select != NULL) {
			$to_select = $to_select . ",lab_title,author,lid";
		} else {
			$to_select = "lab_title,author,lid";
		}
		
		$sql->select("labs",$to_select,"lid",$_GET['c']);
		$row = mysql_fetch_array($result);
		
		$selected = explode(",",$value);
		
		foreach ($selected as $key => $value) {
			$text[$key] = $row[$value];
		}

		$text = implode("<br />\r\n",$text);
		
		$a = array(
			"%CID%",
			"%LID%",
			"%LAB_TITLE%",
			"%AUTHOR%",
			"%TEXT%",
			"%SECTION%"
		);
		
		$b = array(
			$_GET['act'],
			$_GET['c'],
			$row['lab_title'],
			$row['author'],
			$text,
			ucfirst($value)
		);
		
		
		
		$html = str_replace($a,$b,$html);
		print($html);
		
				include_once "../ckeditor/ckeditor.php";
		$CKEditor = new CKEditor();
		$CKEditor->basePath = '/ckeditor/';
		$CKEditor->replaceAll();
		
	}
		
}


$cp_labs = new cp_labs;


if ($allowed != 'no') {

include("./header.php");
switch (@$_GET['make']) {

	case "edit":
		if (!$_GET['c']) {
			$cp_labs->edit_labs();
		} else if ($_GET['d']) {
			$cp_labs->edit_single_lab();
		} else {
			$cp_labs->list_labs();
		}
	break;

	default:
		$cp_labs->list_labs();
	break;
	
}
}
include("./footer.php");