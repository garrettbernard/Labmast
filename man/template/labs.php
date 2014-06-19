<?php

# /template/labs.php

class labs_template {
	
	function header($labtitle) {
		global $base_url;
		
		$lid = $_GET['act'];
		$cid = $_GET['make'];
		
		if (is_numeric($_GET['make'])) {
echo <<<EOM

	<div id="lab_container" style="min-height:420px;">
	<!--
		<a href="$base_url/labs/$lid">Entirety</a> | 
		<a href="$base_url/labs/$lid/basics">The Basics</a> | 
		<a href="$base_url/labs/$lid/introduction">Introduction</a> | 
		<a href="$base_url/labs/$lid/methods">Methods</a> | 
		<a href="$base_url/labs/$lid/procedure">Procedure</a><br /><br />
		To Submit: <a href="$base_url/assignments/$lid/prelab">Pre-Lab</a> | <a href="$base_url/assignments/$lid/report">Lab Report</a> | <a href="$base_url/assignments/$lid/postlab">Post-Lab</a>
	-->
	<h2 style="text-align:center;">$labtitle</h2>
		<p>
			<div id="labheader">
				<p><a class="sub1" href="$base_url/labs/$lid/safety"><img src="$base_url/images/safety.png" /></a></p>
				<p><a class="sub1" href="$base_url/labs/$lid/objectives"><img src="$base_url/images/objectives.png" /></a></p>
				<p><a class="sub1" href="$base_url/labs/$lid/supplies"><img src="$base_url/images/supplies.png" /></a></p>
				<p><a class="sub1" href="$base_url/labs/$lid/introduction"><img src="$base_url/images/introduction.png" /></a></p>
				<p><a class="sub1" href="$base_url/labs/$lid/methods"><img src="$base_url/images/method.png" /></a></p>
				<p><a class="sub1" href="$base_url/labs/$lid/procedures"><img src="$base_url/images/procedure.png" /></a></p>
				<p style="float:none;text-align:center;align:auto;"><a href="$base_url/inlab/$lid/$cid"><img src="$base_url/images/rigging.png" /></a></p>
			</div>
		</p><p>&nbsp;</p>
	</div><p>&nbsp;</p>
EOM;

	}
	}

	function display() {
		global $html;
		
$html = <<<EOM
<div id="courses">
	<div id="lab_title">%LAB_TITLE%</div>
	<div id="lab_author">%AUTHOR%</div>
	<div id="lab_container">
		<div id="lab_objectives_supplies">
			<h3>Objectives</h3>			
			%OBJECTIVES%
			<h3>Supplies</h3>
			%SUPPLIES%
		</div>
		<div id="lab_safety_background">
			<h3>Safety</h3>
			%SAFETY%
			<h3>Background</h3>
			%BACKGROUND%
		</div>
	<div id="lab_container">
		<div class="lab_left_title"><h3>Introduction</h3></div>
		<div class="lab_right_article">%INTRODUCTION%</div>
	</div>
	<div id="lab_container">
		<div class="lab_left_title"><h3>Methods</h3></div>
		<div class="lab_right_article">%METHODS%</div>	
	</div>
	<div id="lab_container">
		<div class="lab_left_title"><h3>Procedure</h3></div>
		<div class="lab_right_article">%PROCEDURE%</h3></div>
	</div>
	<div id="lab_container">&nbsp;</div>


</div>
EOM;

	}
	
	function floatbox() {
		global $base_url;

		
}
	
	function prelab() {
		
echo <<<EOM
<div id="prelab_header">	
	<h3>Pre-Laboratory Assignment</h3>
</div>

EOM;

	}

	function report() {
		
echo <<<EOM
<div id="prelab_header">	
	<h3>Laboratory Report</h3>
</div>

EOM;

	}
	
	function postlab() {
		
echo <<<EOM
<div id="prelab_header">	
	<h3>Post-Laboratory Assignment</h3>
</div>

EOM;

	}
	

	function display_end() {
echo <<<EOM
</div>
EOM;
	}

}





$labs_template = new labs_template;

?>