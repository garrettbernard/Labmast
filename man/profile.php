<?php
session_start();
# profile.php

include("./header.php");

class profile {

	function my_profile() {
		global $sql,$profile_template,$affiliated_courses,$result,$html;
		$sql->select("users","*","uid",$_SESSION['uid']);
		$row = mysql_fetch_assoc($result);
		
		$courses = $row['affiliated_courses'];
		$courses = explode("|",$courses,-1);
		
		
		$i = 0;
		$course_html = '';
		while($i < count($courses)) {		
			$sql->select("courses","cid,course_name","cid",$courses[$i]);
			$crow = mysql_fetch_assoc($result);
			$course_html .= $crow['course_name'] . "<br />";
			$i++;
		}
		
		$a = array(
			"%NAME%",
			"%EMAIL%",
			"%COURSES%"
		);
		
		$b = array(
			$row['name'],
			$row['email'],
			// $row['affiliated_courses']
			$course_html
			);
			
		$profile_template->my_profile();
		
		$html = str_replace($a,$b,$html);
		print($html);
	}
	
	function view_profile() {
		global $sql,$profile_template,$affiliated_courses,$result,$html;
		$sql->select("users","*","uid",$_GET['act']);
		$row = mysql_fetch_assoc($result);
		
		$courses = $row['affiliated_courses'];
		$courses = explode("|",$courses,-1);
		
		
		$i = 0;
		$course_html = '';
		while($i < count($courses)) {		
			$sql->select("courses","cid,course_name","cid",$courses[$i]);
			$crow = mysql_fetch_assoc($result);
			$course_html .= $crow['course_name'] . "<br />";
			$i++;
		}
		
		$a = array(
			"%NAME%",
			"%COURSES%"
		);
		
		$b = array(
			$row['name'],
			$course_html
			);
			
		$profile_template->view_profile();
		
		$html = str_replace($a,$b,$html);
		print($html);
	}
	

}

$profile = new profile;

if (@$_GET['act'] == NULL) {
	$profile->my_profile();
} else if (@$_GET['act'] != NULL) {
	$profile->view_profile();
} else {
	print("Error");
}
		





include("./footer.php");