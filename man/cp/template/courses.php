<?php

# /cp/template/courses.php

class cp_courses_template {
	
	function create_course() {
		
$html = <<<EOM

<div class="form">
<form name="create_course" action="$base_url/cp/courses/update" method="post">
<input type="hidden" name="uid" value="$_SESSION['uid']" />>
Course Name: <input type="text" name="course_name" length="30" />
<input type="submit" value="Submit" />
</form>
<br />
</div>

EOM;

	}
	
}

$cp_courses_template = new cp_courses_template;