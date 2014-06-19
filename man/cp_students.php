<?php
session_start();
# /cp_students.php

class cp_students {

	function list_students() {
		global $course_code,$global_functions,$base_url,$sql,$result,$cp_students_template,$html,$name;

		
		$sql->select("courses","cid,students","cid",$_GET['make']);
		$row = mysql_fetch_assoc($result);
		$course_name = $row['course_name'];
		$student_uid_list = explode("|",$row['students'],-1);
		$course_code = substr(md5("transy" . $row['cid']),0,6);
		
		$i=0;

		while ($i < count($student_uid_list)) {
			$sql->select("users","uid,name,email,affiliated_courses,courses_paid","uid",$student_uid_list[$i]);
			$row = mysql_fetch_assoc($result);
			$name = $row['name'];
			$courses_paid = explode("|",$row['courses_paid'],-1);
			if (in_array($_GET['make'],$courses_paid)) {
				$courses_paid_value = "<span style='color:green;font-weight:bold;'>Yes</span>";
			} else {
				$courses_paid_value = "<span style='color:red;font-weight:bold;'>No</span>";
			}
			$affiliated_courses = explode("|",$row['affiliated_courses'],-1);
			if (in_array($_GET['make'],$affiliated_courses)) {
				$confirmed_class = "<span style='color:green;font-weight:bold;'>Yes</span>";
			} else {
				$confirmed_class = "<span style='color:red;font-weight:bold;'>No</span>";
			}
			
			$global_functions->lastnamefirst($name);
			$student_names[$i] = $name . "|" . $row['uid'] . "|" . $row['email'] . "|" . $confirmed_class . "|" . $courses_paid_value;
			$i++;
		}
		
		if (count($student_names) == '0') {
		print("<div style='text-align:center;'>There are currently no students in this course.</div><hr />");
		} else {
		$student_names = array_filter($student_names);
		$student_names = array_values($student_names);
		sort($student_names);
		

		$output = '';
		$i=0;
		while ($i < count($student_names)) {
			$values = explode("|",$student_names[$i]);
			$cp_students_template->students_table();
			
			if ($i % 2 == 0) {
				$values[5] = "#bbbbbb";
			} else {
				$values[5] = "#dddddd";
			}
			
			$values[6] = $_GET['make'];

			$a = array (
				"%STUDENT_NAME%",
				"%UID%",
				"%EMAIL_ADDRESS%",
				"%CONFIRMED_CLASS%",
				"%HAS_PAID%",
				"%BG_COLOR%",
				"%CID%"
			);
						$output .= str_replace($a,$values,$html);
			// $students_value .= "<a href='" . $base_url . "/cp/courses/" . $cid . "/student/" . $values[1] . "'>" . $values[0] . "</a><br />\r\n";
				$i++;
			}
			

			
			print("<table border=1 cellpadding=3px style='margin:auto;'>\r\n");
			print("<tr style='font-weight:bold;text-align:center;'><td>Name</td><td>E-Mail Address</td><td>Student Confirmed Course?</td><td>Has Paid?</td><td></td>\r\n");
			print($output);
			print("</table>\r\n");
			print("<hr />");
			}
			$this->add_user();

	}
	
	function add_user() {
		global $cp_students_template,$course_code,$html;
		$cp_students_template->add_user();
		$html = str_replace("%COURSE_CODE%",$course_code,$html);
		echo $html;
		
	 	
	}

	function manual_add_user() {
		global $sql,$link,$result;
		
		$a = array(
			"'" . mysql_real_escape_string($_POST['student_name']) . "'",
			"'" . mysql_real_escape_string($_POST['student_email']) . "'"
		);
		
		$emailaddress = trim($a[1],"\x22\x27");
		
		$sql->select("users","uid,name,email","email",$emailaddress);
		
		if (mysql_num_rows($result) == '0') {
		
			$b = array(
			"name",
			"email"
			);
			
			$sql->insert("users",$b,$a);
			mysql_close();
			
			$sql->select("users","uid,email","email",$emailaddress);
			$row = mysql_fetch_assoc($result);
			$newuser = $row['uid'];
			
			$sql->select("courses","cid,students","cid",$_GET['make']);
			$row = mysql_fetch_array($result);
			$students = $row['students'];
			$students = explode("|",$students,-1);
			$count = count($students);
			$students[$count + 1] = $newuser;
			$students = implode("|",$students);
			$students = $students . "|";
			
			$sql->update("courses","students",$students,"cid",$_GET['make']);
			
		} else if (mysql_num_rows($result) == '1') {
			$row = mysql_fetch_assoc($result);
			$newuser = $row['uid'];
			
			$sql->select("courses","cid,students","cid",$_GET['make']);
			$row = mysql_fetch_array($result);
			$students = $row['students'];
			$students = explode("|",$students,-1);
			$count = count($students);
			$students[$count + 1] = $newuser;
			$students = array_unique($students);
			$students = implode("|",$students);
			$students = $students . "|";
			
			$sql->update("courses","students",$students,"cid",$_GET['make']);
		}
	}
	
	function remove_user() {
		global $base_url,$sql,$result;

		$sql->select("courses","cid,students","cid",$_GET['make']);
		$row = mysql_fetch_assoc($result);
		$students = "|" . $row['students'];
		$students = str_replace("|" . $_GET['d'] . "|","|",$students);
		$students = substr($students,1);
		
		// print($students);
		$sql->update("courses","students",$students,"cid",$_GET['make']);
		
		$sql->select("users","uid,affiliated_courses","uid",$_GET['d']);
		$row = mysql_fetch_assoc($result);
		$affiliated_courses = "|" . $row['affiliated_courses'];
		$affiliated_courses = str_replace("|" . $_GET['make'] . "|","|",$affiliated_courses);
		$affiliated_courses = substr($affiliated_courses,1);
		$sql->update("users","affiliated_courses",$affiliated_courses,"uid",$_GET['d']);
		
	}
	

}

$cp_students = new cp_students;

if (@$_POST['student_name'] != NULL && @$_POST['student_email'] != NULL) {
	include("./config.php");
	$cp_students->manual_add_user();
	header("location: ".$_SERVER["REQUEST_URI"]);
	exit();

} else if (@$_GET['c'] == 'remove') {
	include("./config.php");
	$cp_students->remove_user();
	header("location: ".$_SERVER["HTTP_REFERER"]);
	exit();

} else if (@$_GET['act'] == 'edit' && @$_GET['make'] != NULL) {


	include("./header.php");

	$session_courses = explode("|",$_SESSION['affiliated_courses'],-1);
		if (in_array($_GET['make'],$session_courses)) {
			if ($_SESSION['is_teacher'] != '1') {
				print("Only lab instructors may access this area of the website.");
			} else {
				$cp_students->list_students();
			}
			include("./footer.php");
		} else {
			print("You are not listed as a lab instructor for this course.");
		}
	
} else {
	include("./config.php");
	header("location: " . $base_url . "/cp/courses");
}
?>