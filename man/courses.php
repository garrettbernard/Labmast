<?php
session_start();
include("./header.php");

// courses.php

if ($_GET['act'] == 'add') {
	
	if ($_POST != NULL) {
			$coursecode = mysql_real_escape_string($_POST['coursecode']);
			$sqlhere = "SELECT cid,course_name FROM courses";
			$result = mysql_query($sqlhere);
			$i=0;
			while ($i < mysql_num_rows($result)) {
				$row = mysql_fetch_array($result);
				
				$source_coursecode = substr(md5("transy" . $row['cid']),0,6);
				
				if ($coursecode == $source_coursecode) {
					$i = mysql_num_rows($result);
					$cid = $row['cid'];
					$course_name = $row['course_name'];
				}
				$i++;
			}
			
			if ($cid == NULL) {
				print("<h4>You have not entered a valid Course Code.</h4>");
				$courses_template->add_course();
			} else {
	
					$sql->select("users","uid,affiliated_courses","uid",$_SESSION['uid']);
					$row = mysql_fetch_array($result);
					$uid = $row['uid'];
					$affiliated_courses = explode("|",$row['affiliated_courses'],-1);
					$affiliated_courses[count($affiliated_courses)] = $cid;
					$affiliated_courses = array_unique($affiliated_courses);
					$affiliated_courses = implode("|",$affiliated_courses) . "|";
					$sql->update("users","affiliated_courses",$affiliated_courses,"uid",$uid);
					
					$sql->select("courses","students,cid","cid",$cid);
					$row = mysql_fetch_array($result);
					$students = explode("|",$row['students'],-1);
					$students[count($students)] = $uid;
					$students = array_unique($students);
					$students = implode("|",$students) . "|";
					
					$sql->update("courses","students",$students,"cid",$cid);
					$html .= "You have successfully added a course.";
					$html .= "<br />Your course is: " . $course_name;
			}
		print(@$html);
		} else {
	$courses_template->add_course();
		}
	
} else if (is_numeric($_GET['act'])) {
	
	$sql->select("courses","cid,course_name","cid",$_GET['act']);
	$row = mysql_fetch_assoc($result);
	$course_name = $row['course_name'];
	$courses_template->course_labs($course_name);
	$sql->select("labs","lid,cid,lab_title","cid",$_GET['act']);

	$i = 0;
	
	while ($i < mysql_num_rows($result)) {
		$row = mysql_fetch_assoc($result);
		$lid = $row['lid'];
		$lab_title = $row['lab_title'];
		$courses_template->list_course_labs($lid,$lab_title);
		$i++;
		}
		
	$courses_template->display_end();
} else { 

$courses_template->display();
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
$courses_template->display_list($course_name,$cid);
$i++;
}
$courses_template->display_end();
}


include("./footer.php");
?>