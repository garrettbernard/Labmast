<?php
session_start();
include("./header.php");
# /cp_assignments.php

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
}
	
class cp_assignments {
	
	function list_students() {
		global $global_functions,$name,$base_url,$sql,$result,$html,$cp_assignments_template;
		
		$sql->select("courses","cid,course_name,students","cid",$_GET['act']);
		$row = mysql_fetch_array($result);
		$course_name = $row['course_name'];
		
		$student_uid_list = explode("|",$row['students'],-1);
		
		$i=0;
		while ($i < count($student_uid_list)) {
			$sql->select("users","uid,name","uid",$student_uid_list[$i]);
			$row = mysql_fetch_assoc($result);
			$name = $row['name'];
			$global_functions->lastnamefirst($row['name']);
			$student_names[$i] = $name . "|" . $row['uid'];
			// $student_names[$i][$uid] = $row['uid'];
			// $student_names .= "<a href='" . $base_url . "/cp/courses/" . $cid . "/student/" . $row['uid'] . "'>" . $name . "</a><br />";
			$i++;
		}
		
		if (count($student_names) != '0') { sort($student_names); }
		
		$i=0;
		$students_value = '';
		while ($i < count($student_names)) {
			$values = explode("|",$student_names[$i]);
			$students_value .= "<a href='" . $base_url . "/cp/assignments/" . $_GET['act'] . "/" . $values[1] . "'>" . $values[0] . "</a><br />\r\n";
				$i++;
		}
		
		print($students_value);
	}
	
	function student_page() {
		global $sql,$result,$cp_assignments_template,$base_url;
		
		$sql->select("users","uid,name","uid",$_GET['make']);		
		$row = mysql_fetch_array($result);		
		$name = $row['name'];
		
		$sql->select("labs","lid,cid,lab_title","cid",$_GET['act']);
		
		$i=0;
		while ($i < mysql_num_rows($result)) {
			$row = mysql_fetch_assoc($result);
			$lab_names[$i] = "<a href='" . $base_url . "/cp/assignments/" . $_GET['act'] . "/" . $_GET['make'] . "/" . $row['lid'] . "'>" . $row['lab_title'] . "</a>";
			$i++;
		}
			
		
		@$lab_names = implode("<br />\r\n",$lab_names);
		
		print($lab_names);
	}
	
	function student_for_single_lab() {
		global $sql,$result,$cp_assignments_template;
		
		$sql->select("labs","lid,prelab,report,postlab","lid",$_GET['c']);
		$row = mysql_fetch_array($result);
		
		$lab_data = array(
			$row['prelab'],
			$row['report'],
			$row['postlab']
		);
		
		$sql = "SELECT uid,lid,prelab,postlab,report FROM assignments WHERE lid='" . $_GET['c'] . "' AND uid='" . $_GET['make'] . "'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		
		$assignment_data = array(
			explode("|",$row['prelab'],-1),
			explode("|",$row['report'],-1),
			explode("|",$row['postlab'],-1)
		);
		
	//	($lab_data);
	// print_r($assignment_data);
	
$a = 0;
while ($a < 3) {
	$i = 0;
	$j = 0;
	$count = substr_count($lab_data[$a],"%TEXTBOX%");
	while ($i < $count) {
	$pattern = array();
	$pattern[0] = '/%TEXTBOX%/';
	$replacement = array();
	$replacement[0] = "<span class='assignment_response' style='color:red;'>" . htmlspecialchars($assignment_data[$a][$i], ENT_QUOTES) . "</span>";
	$lab_data[$a] = preg_replace($pattern, $replacement, $lab_data[$a], 1);
	$i++;
	}
	
	$countt = substr_count($lab_data[$a],"%TEXTAREA%");
	while ($j < $countt) {
	$pattern = array();
	$pattern[0] = '/%TEXTAREA%/';
	$replacement = array();
	$replacement[0] = "<span class='assignment_response' style='color:red;'>" . htmlspecialchars($assignment_data[$a][$i], ENT_QUOTES) . "</span>";
	$lab_data[$a] = preg_replace($pattern, $replacement, $lab_data[$a], 1);
	$j++;
	$i++;
	}
	$a++;
}

	print("<h2>Prelab</h2>");
	print($lab_data[0]);
	print("<h2>Report</h2>");
	print($lab_data[1]);
	print("<h2>Postlab</h2>");
	print($lab_data[2]);
	
	}
}

$cp_assignments = new cp_assignments;

if ($allowed != 'no') {
	if (is_numeric(@$_GET['make']) && $_GET['c'] == NULL) {
		$cp_assignments->student_page();
	} else if (is_numeric(@$_GET['make']) && is_numeric($_GET['c'])) {
		$cp_assignments->student_for_single_lab();
	} else {	
		$cp_assignments->list_students();	
	}
}

include("./footer.php");