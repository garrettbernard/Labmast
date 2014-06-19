<?php

# /template/assignments.php

class assignments_template {
	
	function header() {
echo <<<EOM
<div id="courses">

EOM;

	}
	
	function display() {
echo <<<EOM
<h3>Assignments</h3>
<p>Below you will find archived and current assignments.</p>
<table border=0 cellspacing=6px>
EOM;
	}
	
	function display_list($lid,$lab_title) {
			global $base_url;
echo <<<EOM
	<tr>
		<td>$lab_title</td>
		<td><a href="$base_url/assignments/$lid/report">Lab Report</a></td>
		<td><a href="$base_url/assignments/$lid/prelab">Pre-Lab</a></td>
		<td><a href="$base_url/assignments/$lid/postlab">Post-Lab</a></td>
	</tr>
EOM;

	}
	
	function form_sheet($formname,$lid) {
		global $base_url, $html;
$html = <<<EOM
<div class="form">
<form name="$formname" action="$base_url/assignments/update" method="post">
<input type="hidden" name="lid" value="$lid" />
<input type="hidden" name="type" value="$formname" />
%FORM_SHEET%
<input type="submit" value="Submit" />
</form>
<br />
</div>
EOM;
	}
	
		function display_end() {
echo <<<EOM
</table>
</div>
EOM;

	}
	
	function update() {
		
	}		
}

$assignments_template = new assignments_template;