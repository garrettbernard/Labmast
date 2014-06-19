<html>
<head><title></title>

<script type="text/javascript" language="javascript">
//<![CDATA[

// window.onload=function() {
//	document.getElementById("d2").onclick = slideIt("toRight");
//	document.getElementById("d3").onclick = slideIt("toLeft");
// };

function slideIt(actionReturn) {
	var slidingDiv = document.getElementById("d1");
	var stopPosition = 50;
	var startPosition = slidingDiv.offsetWidth+slidingDiv.offsetWidth;
	if (actionReturn ==  "toRight") {
		if (parseInt(slidingDiv.style.left) >= 0 )
		{
			slidingDiv.style.left = parseInt(slidingDiv.style.left) - 20 + "px";
			setTimeout(slideIt, 1);
		}
	}
	if (actionReturn ==  "toLeft") {
		if (parseInt(slidingDiv.style.left) < startPosition ) {
			slidingDiv.style.left = parseInt(slidingDiv.style.left) + 20 + "px";
			setTimeout(slideIt, 1);
		}
	}
}
//]]>
</script>
</head>
<body>

<div id="d2" onclick="slideIt('toRight');">click here to slide the div</div>
<div id="d1" style="position:absolute; left:-10px; top:30px">horizontally sliding div</div>
<div id="d3" onclick="slideIt('toLeft');">click here to slide the div</div>
</body>
</html>