<?php

# /template/profile.php

class profile_template {
	
	function my_profile() {
		global $base_url,$html;
		
$html = <<<EOM

<div id="lab_container">
		<div class="lab_left_title">
				<span style="text-decoration:underline;">Courses</span> ( <a href="$base_url/courses/add">Add Course</a> )<br />
				%COURSES%<br />
		</div>
		<div class="lab_right_article">
				<p>Name: %NAME%</p>
				<p>E-Mail Address: %EMAIL% (<a href="$base_url/user/emailchange">Change</a>)</p>
				<p>Password: (hidden) (<a href="$base_url/user/passwordchange">Change</a>)</p>
		</div>
</div>
EOM;
				
	}
	
	function view_profile() {
		global $base_url,$html;
		
$html = <<<EOM

<div id="lab_container">
		<div class="lab_left_title">
				<span style="text-decoration:underline;">Courses</span><br />
				%COURSES%<br />
		</div>
		<div class="lab_right_article">
				<p>Name: %NAME%</p>
		</div>
</div>
EOM;
				
	}

	
}

$profile_template = new profile_template;