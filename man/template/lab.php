<?php

# /template/lab.php



class template_lab {

	function display_lab() {

echo <<<EOM

<div>
	<h1>%LAB_TITLE%</h1>
	<h4>%AUTHOR%</h4>
	<div>
		<div id="objectives">
			<h3>Objectives</h3>
			%OBJECTIVES%
		</div>
		<div id="supplies">
			<h3>Supplies and Reagents</h3>
			%SUPPLIES%
		</div>
	</div>
	<div>
		<div id="safety">
			<h3>Safety and Disposal</h3>
			%SAFETY%
		</div>
	</div>
	<div>
		<div id="background">
			<h3>Background</h3>
			%BACKGROUND%
		</div>
		<div id="introduction">
			<h2>Introduction</h2>
			%INTRODUCTION%
		</div>
		<div id="methods">
			<h2>Methods</h2>
			%METHODS%
		</div>
		<div id="setup">
			<h2>Setup</h2>
			%SETUP%
		</div>
		<div id="procedure">
			<h2>Procedure</h2>
			%PROCEDURE%
		</div>
		<div id="prelab">
			<h2>Prelab</h2>
			%PRELAB%
		</div>
		<div id="postlab">
			<h2>Postlab</h2>
			%POSTLAB%
		</div>
	</div>
</div>

EOM;

	}
}

$template_lab = new template_lab;
$template_lab->display_lab();
		
		