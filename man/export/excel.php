<html>
<head>
<script language="javascript">
function download()
{
	window.location='report.xls';
}
</script>
</head>
<body alink="#00FF66" link="#00CC00">
<h1 align="center"><a href="javascript:void(0);" onClick="download();">Download Excel Report</a></h1>
<?php
/*
	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* Developed By : www.smartcoderszone.com [ Amit Kumar Paliwal ] *
	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/

require_once("config.php");
require_once("excelwriter.class.php");
require_once("./config.php");

$sql->select("labs","lid,lab_title,prelab,postlab,report","lid",$_GET['make']);
$row = mysql_fetch_array($result);
$active = $_GET['c'];
$active = explode("|",$active,-1);


$excel=new ExcelWriter("report.xls");
if($excel==false)	
echo $excel->error;



$myArr=array("S.No.","Company Name","Email","City","Username","Reg. Date");
$excel->writeLine($myArr);

$qry=mysql_query("select * from customer");
if($qry!=false)
{
	$i=1;
	while($res=mysql_fetch_array($qry))
	{
		$myArr=array($i,$res['company_name'],$res['email'],$res['city'],$res['username'],$res['regdate']);
		$excel->writeLine($myArr);
		$i++;
	}
}
?>
</body>
</html>