<?php

# /template/courses.php

class courses_template {

	function add_course() {
		global $site_url;
echo <<<EOM
<form name="register" method="post" action="$site_url/courses/add">
	<p>Course Code: <input type="text" name="coursecode"/ ></p>
	<input type="submit" value="Add Course" />
EOM;
	}

	function display() {
		
echo <<<EOM

<div id="courses">
	<h2 style="text-align:center;">My Courses</h2>
	
EOM;
	
	}
	
	function display_list($course_name,$cid) {
			global $base_url;
		
echo <<<EOM
		<p style="align:auto;text-align:center;width:99%;"><a href="$base_url/courses/$cid"><img style="margin-bottom:15px;" src="/txttoimg.php?text=$course_name" /></a></p>
EOM;

	}
	
	function display_end() {
echo <<<EOM
<!-- </ol> -->
</div>
EOM;
}
	
	function course_labs($course_name) {
		
echo <<<EOM
<div id="courses">
		<h2 style="text-align:center;">My Labs</h2><br />
		<h4 style="text-align:center;">$course_name</h4>
<!--		<ol> -->
EOM;
}

	function list_course_labs($lid,$lab_title) {
		global $base_url;
		
		$courseid = $_GET['act'];
		
echo <<<EOM
		<p style="align:auto;text-align:center;width:99%;"><a href="$base_url/labs/$lid/$courseid"><img style="margin-bottom:15px;" src="/txttoimg.php?text=$lab_title" /></a></p>
EOM;
}
}
$courses_template = new courses_template;

?>