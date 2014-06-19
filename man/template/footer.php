<?php

# /template/footer.php

class footer_template {

	function footer() {
	global $base_url;
	
echo <<<EOM
	<div id="footer">
		<a href="$base_url/about">About OLM</a> | <a href="$base_url/contact">Contact OLM</a>
	</div>
EOM;

	}
}

$footer_template = new footer_template;

?>
	