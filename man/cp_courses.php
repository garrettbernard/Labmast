<?php
session_start();

if(!$_POST) {
include("./header.php");
} else if ($_POST) {
include("./config.php");
}

# /cp_courses.php

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

class cp_courses {
	
	function list_current_courses() {
		global $base_url,$sql,$result,$cp_courses_template,$html;	

		if ($_POST['uid'] != NULL) {
			$this->create_course_update();
			header("location: ".$_SERVER["REQUEST_URI"]);
			exit();
		}
		
		if ($_GET['act'] != NULL) {
			$this->view_course($_GET['act']);
		} else {
		
		$sql->select("users","uid,affiliated_courses","uid",$_SESSION['uid']);
		$row = mysql_fetch_assoc($result);

		$courses = $row['affiliated_courses'];
		$courses  = explode("|",$courses,-1);

		$i = 0;

		while ($i < count($courses)) {
			$sql->select("courses","*","cid",$courses[$i]);
			$row = mysql_fetch_assoc($result);
			$course_name = $row['course_name'];
			$cid = $row['cid'];
			$data .= "<tr><td><a href='" . $base_url . "/cp/courses/" . $cid . "'>" . $course_name . "</a> (<a href='" . $base_url . "/cp/assignments/" . $cid . "'>View Completed Assignments</a>)</td></tr>";
			$i++;
		}
		$cp_courses_template->list_current_courses();
		$html = str_replace("%MY_COURSES%",$data,$html);
		print($html);
		
		$cp_courses_template->create_course();
		print("<p>" . $html . "</p>");
		
		}

	}

	function create_course() {
		global $cp_courses_template, $html;
		
		$cp_courses_template->create_course();
		print($html);
		
		
	}
	
	function create_course_update() {
		global $sql,$link,$result;
		
		$a = array(
			"'" . mysql_real_escape_string($_POST['uid']) . "'",
			"'" . mysql_real_escape_string($_POST['course_name']) . "'"
		);
		
		$b = array(
			"iid",
			"course_name"
		);
		
		$sql->insert("courses",$b,$a);
		mysql_close();
		
		$sqlgo = "SELECT * FROM courses ORDER BY cid DESC LIMIT 1";
		$resultgo = mysql_query($sqlgo, $link);
		$rowgo = mysql_fetch_array($resultgo);
		$cid = $rowgo['cid'];
		
		$sql->select("users","uid,affiliated_courses","uid",$_SESSION['uid']);
		$row = mysql_fetch_array($result);
		$affiliated_courses = $row['affiliated_courses'];
		$affiliated_courses = explode("|",$affiliated_courses,-1);
		$count = count($affiliated_courses);
		$affiliated_courses[$count + 1] = $cid;
		$affiliated_courses = implode("|",$affiliated_courses);	
		$affiliated_courses = $affiliated_courses . "|";
		unset($_SESSION['affiliated_courses']);
		$_SESSION['affiliated_courses'] = $affiliated_courses;
		
		$sql->update("users","affiliated_courses",$affiliated_courses,"uid",$_SESSION['uid']);
		

	}
	
	
	function view_course($cid) {
		global $global_functions,$name,$base_url,$sql,$result,$html,$cp_courses_template;
		
		$sql->select("courses","cid,course_name,students","cid",$cid);
		$row = mysql_fetch_array($result);
		$course_name = $row['course_name'];
		
		$student_uid_list = explode("|",$row['students'],-1);
		
		// $lab_names = 'LAB NAMESSSSS';
		
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
			$students_value .= "<a href='" . $base_url . "/profile/" . $values[1] . "'>" . $values[0] . "</a><br />\r\n";
				$i++;
			}
			
		$sql->select("labs","lid,cid,lab_title","cid",$cid);
		
		$i=0;
		while ($i < mysql_num_rows($result)) {
			$row = mysql_fetch_assoc($result);
			$lab_names[$i] = "<a href='" . $base_url . "/labs/" . $row['lid'] . "'>" . $row['lab_title'] . "</a>  ";
			// $lab_names[$i] .= "( Download Submitted Data: <a href='" . $base_url . "/export/excel/" . $row['lid'] . "/prelab'>Prelab</a> | <a href='" . $base_url . "/export/excel/" . $row['lid'] . "/postlab'>Postlab</a> | <a href='" . $base_url . "/export/excel/" . $row['lid'] . "/report'>Lab Report</a> )";
			$i++;
		}
			
		
		@$lab_names = implode("<br />\r\n",$lab_names);	
		
		$cp_courses_template->view_course($cid);
		
		$a = array(
			"%COURSE_NAME%",
			"%STUDENT_LIST%",
			"%LAB_LIST%"
			);
			
		$b = array(
			$course_name,
			"<div style='text-align:left;padding-left:30px;'>" . $students_value . "</div>",
			$lab_names
			);
		
		$html = str_replace($a,$b,$html);
		print($html);
		
	}
	
	function edit_course() {
		global $sql,$cp_courses_template,$html,$base_url,$result;
		
		if (@$_POST['course_name'] != NULL) {
			// print($_POST['course_name']);
			$course_name = mysql_real_escape_string($_POST['course_name']);
			$sql->update("courses","course_name",$course_name,"cid",$_GET['act']);
			header("location: " . $base_url . "/cp/courses/" . $_GET['act']);
			exit();
		} else {
		
		$sql->select("courses","cid,course_name","cid",$_GET['act']);
		$row = mysql_fetch_assoc($result);
				
		$cp_courses_template->edit_course();
		
		$html = str_replace('%COURSE_NAME%',$row['course_name'],$html);
		$html = str_replace('%CID%',$_GET['act'],$html);
		print($html);
		
		}
		
	}
	
}

$cp_courses = new cp_courses;


if ($allowed != 'no') {
switch (@$_GET['make']) {

	case "edit":
		$cp_courses->edit_course();
	break;

	default:
		$cp_courses->list_current_courses();
	break;
	
}
}	
	include("./footer.php");