<?php

# /template/cp_courses.php

class cp_courses_template {
	
	function list_current_courses() {
			global $html;

		
$html = <<<EOM
<p>Courses you are currently affiliated with (click to edit):</p>
<table>
%MY_COURSES%
</table>
EOM;

	}
	
	function create_course() {
		global $html,$base_url;		
		
		$uid = $_SESSION['uid'];
$html = <<<EOM
<hr />
<div class="form">
<form name="create_course" action="$base_url/cp/courses" method="post">
<input type="hidden" name="uid" value="$uid" />
<h3>Add New Course</h3><br />
Course Name: <input type="text" name="course_name" length="30" />
<input type="submit" value="Submit" />
</form>
<br />
</div>

EOM;

	}
	
	function view_course($cid) {
		global $html,$base_url;
		
$html = <<<EOM

<div id="cp-courses">
	<div id="cp-courses-heading">
		<span class="editbutton">( <a href="$base_url/cp/courses/$cid/edit">Edit</a> )</span>
		<h2>%COURSE_NAME%</h2>
		<h3><a href='$base_url/cp/assignments/$cid'>View Course Assignments</a></h3>
	</div>
	<div id="cp-courses-studentlist">
		<span class="editbutton">( <a href="$base_url/cp/students/edit/$cid">Edit</a> )</span>
		<h2>This Course's Students</h2>
		%STUDENT_LIST%
	</div>
	<hr />
	<div id="cp-courses-lablist">
		<span class="editbutton">( <a href="$base_url/cp/labs/$cid/edit">Edit</a> )</span>
		<h2>This Course's Labs</h2>
		%LAB_LIST%
	</div>

</div>

EOM;
	}
	
	function edit_course() {
		global $html,$base_url;
		
$html = <<<EOM

<div style='margin:auto;text-align:center;'>
<form name="edit_course" action="{$_SERVER['REQUEST_URI']}" method="post">
<h3>Edit Course Name</h3><br />
Course Name: <input type="text" name="course_name" size="60" value="%COURSE_NAME%" />
<input type="submit" value="Submit" />
<p>
( <a href='$base_url/cp/courses/%CID%'>Cancel</a> )
</p>
</form>
</div>
<br />

EOM;
	}
}

$cp_courses_template = new cp_courses_template;