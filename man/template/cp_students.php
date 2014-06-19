<?php

// /template/cp_students.php

class cp_students_template {

	function students_table() {
		global $base_url,$html;
$html = <<<EOM
	<tr bgcolor="%BG_COLOR%">
		<td>%STUDENT_NAME%</td><td>%EMAIL_ADDRESS%</td><td>%CONFIRMED_CLASS%</td><td>%HAS_PAID%</td><td>( <a href='$base_url/cp/students/edit/%CID%/remove/%UID%'>Delete</a> )</td>
	</tr>\r\n
EOM;

	
	}
	
	function add_user() {
		global $base_url,$html;
$html = <<<EOM
	<div id="cp-courses">
		There are two methods to add students to this course and both methods may be used at any time.
		<ul>
			<li>You can distribute the Course Code (<span style="font-weight:bold;">%COURSE_CODE%</span>) to the student, allowing the individual to access labdb.org and register him or herself with your course.</li>
			<li>You may add a student individually. Keep in mind that, even when adding individually, the student must confirm the registration before the new account is activated.</li>
		</ul>
		<hr />
		<div class="form">
			<form name="create_user" action="{$_SERVER['REQUEST_URI']}" method="post">
				<input type="hidden" name="cid" value="{$_GET['make']}" />
				<h4>Manually Add New Student</h4>
				<table cellpadding=5>
					<tr>
						<td>Student Name:</td><td><input type="text" name="student_name" length="30" /></td>
					</tr>
					<tr>
						<td>Student Email:</td><td><input type="text" name="student_email" length="30" /></td>
					</tr>
				</table>
				<input type="submit" value="Submit" />
			</form>
		<br />
		</div>
	</div>
EOM;
	}
}

$cp_students_template = new cp_students_template;

?>