<?php

// /template/homepage.php

echo <<<EOM

	<div id="container">
		<div id="bodytext">
			<div id="easyslider_container">
				<section>
				
					<div id="slider">
					
						<ul>
							<li><img src="/img/homepagescroll-4.png" alt="slide_01" width="850" height="300" /></li>
							<li><img src="/img/homepagescroll-2.png" alt="slide_02" width="850" height="300" /></li>
							<li><img src="/img/homepagescroll-3.png" alt="slide_03" width="850" height="300" /></li>
							<!-- <li><img src="/img/homepagescroll-1.png" alt="slide_04" width="850" height="300" /></li> -->
						
						</ul>
					
					
					</div>
					
					
				
				</section>
				
			</div>
		
			<div id="homepage-text">
				<h1>We're currently beta testing Labmast.</h1>
				<h3>Interested in learning more or testing out Labmast?<br />Subscribe now to stay informed!</h3>
				<div style="display:block;margin-left:130px;font-size:16px;width:560px;">
					If you'd like to receive development updates or you're interested in testing out Labmast as the beta trial expands, use the form below to subscribe!
				</div>
				<div id="homepage-signup-form">
				<br />&nbsp;<br />
					<!-- <iframe src='http://labmast.us4.list-manage.com/subscribe?u=2e613a3dcbcd2fc6e7995d26b&id=80a6869c48' frameborder='0' width='650px' height='700px' ></iframe> -->
					<iframe src='/mc_betasignup.php' frameborder='0' width='650px' height='500px' ></iframe>
				</div>
			</div>
		</div>
			
	</div>
	
EOM;

?>