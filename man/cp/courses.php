<?php
include("../header.php");
# /cp/courses.php

class cp_courses {
	
	function list_current_courses() {
		
	}

	function create_course() {
		$cp_courses_template->create_course();
		
		
	}
	
	function create_course_update() {
		global $sql,$link;
		
		$a = array(
			"'" . mysql_real_escape_string($_POST['uid']) . "'",
			"'" . mysql_real_escape_string($_POST['course_name']) . "'"
		);
		
		$b = array(
			"iid",
			"course_name"
		);
		
		$sql->insert("courses",$b,$a);
		
		$sql->select("courses","*","iid",$_SESSION['id']);
		
		$sql = "SELECT * FROM courses DESC LIMIT 1";
		$result = mysql_query($sql, $link);
		$row = mysql_fetch_array($result);
		$cid = $row['cid'];
		
		$sql->select("users","uid,affiliated_courses","uid",$_SESSION['uid']);
		$row = mysql_fetch_array($result);

		$affiliated_courses = $row['affiliated_courses'];
		$affiliated_courses = explode("|",$affiliated_courses,-1);
		$count = count($affiliated_courses);
		$affiliated_courses[$count + 1] = $cid;
		$affiliated_courses = implode("|",$affiliated_courses);	
		
		$sql->update("users","affiliated_courses",$affiliated_courses,"uid",$_SESSION['uid']);
		
		$this->list_current_courses();
	}
	
	
	function select_course() {
		
	}
	
}

$cp_courses = new cp_courses;

switch (@$_GET['act']) {
	case "create": 
		$cp_courses->create_course();
	break;
	case "update": 
		$cp_courses->create_course_update();
	break;

	default:
		$cp_courses->list_current_courses();
	break;
    }