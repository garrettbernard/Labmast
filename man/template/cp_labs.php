<?php

// /template/cp_labs.php

class cp_labs_template {

	function list_labs() {
		global $html,$base_url;
		
$html = <<<EOM

		<div id="cp-labs">
		Current Labs<br />
			%LIST_LABS%
		</div>
EOM;

	}
	
	function edit_labs() {
		global $html,$base_url;
		
$html = <<<EOM

		<div id="cp-labs">
			%LIST_LABS%
		<hr />

			<div id="cp-editlabs-addnewlab">
						<h3>Add New Lab</h3>
				<p>
					You may <a href="$base_url/cp/labs/3/search">Search Labs</a> within our database or add your own below.
				</p>
				<p>
					<form name="create_lab" action="{$_SERVER['REQUEST_URI']}" method="post">
						Lab Name: <input type="text" length="20" name="create_lab" /><br />						
						<input type="submit" value="Submit" />
					</form>
				</p>

			</div>
					
		</div>
		
		
EOM;

	}
	
	function edit_single_lab_menu() {
		global $html,$base_url;
		
$html = <<<EOM

		<div id="cp-labs">
			<div id="cp-labs_section_menu">
					<p>%LAB_TITLE%<br />(Written by %AUTHOR%)</p>
			[ <a href="$base_url/cp/labs/%CID%/edit/%LID%/objectives">Objectives</a> | 
				<a href="$base_url/cp/labs/%CID%/edit/%LID%/safety">Safety</a> | 
				<a href="$base_url/cp/labs/%CID%/edit/%LID%/supplies">Supplies and Chemicals</a> | 
				<a href="$base_url/cp/labs/%CID%/edit/%LID%/background">Background</a> | 
				<a href="$base_url/cp/labs/%CID%/edit/%LID%/introduction">Introduction</a> | 
				<a href="$base_url/cp/labs/%CID%/edit/%LID%/methods">Methods</a> | 
				<a href="$base_url/cp/labs/%CID%/edit/%LID%/setup">Setup</a> | 
				<a href="$base_url/cp/labs/%CID%/edit/%LID%/procedures">Procedure</a> ]<br /> 
				[ <a href="$base_url/cp/labs/%CID%/edit/%LID%/prelab">Prelab Assignment</a> | 
				<a href="$base_url/cp/labs/%CID%/edit/%LID%/report">Lab Report</a> | 
				<a href="$base_url/cp/labs/%CID%/edit/%LID%/postlab">Postlab Assignment</a> ]
				<br />
				<h3>%SECTION%</h3>
			</div>
			<div id="cp-labs_showdata">
				%TEXT%
			</div>
			<hr />
			<div id="cp-labs_form">
				<form name="create_user" action="{$_SERVER['REQUEST_URI']}" method="post">
					<input type="hidden" name="lid" value="%LID%" />
					<h4 style='text-align:center;'>Edit %SECTION%</h4>
						<textarea name="textarea_edit">%TEXT%</textarea><br />
					<input type="submit" value="Submit" />
				</form>
			</div>
		</div>
			
EOM;
		}
		
	
}

$cp_labs_template = new cp_labs_template;

?>