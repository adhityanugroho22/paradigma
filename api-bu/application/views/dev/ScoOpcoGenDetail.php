<?php
$user = "DEVSD";
$pass = "gresik45";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';


if(!empty($_GET['tahun'])){
	$tahun = $_GET['tahun'];}else{$tahun = date('Y');}

if(!empty($_GET['company'])){
	switch($_GET['company']){
		case 1 :
			$company = 3000;
			break;
		case 2 :
			$company = 4000;
			break;
		case 3 :
			$company = 5000;
			break;
		case 4 :
			$company = 6000;
			break	;
		case 5 :
			$company = 7000;
			break	;
		default :
		$company = "";
		}
}else{
	$company = "";
}
$conn = oci_connect($user, $pass,$_ora_sco);
$sql = "SELECT BULAN,
	SUM (target_rkap) AS RKAP,
	SUM (realto) AS RIIL
FROM
	ZREPORT_RPTREAL_RESUM
WHERE
COM = ".$company."
AND tahun = ".$tahun."
GROUP BY BULAN
ORDER BY BULAN";

$queryOracle = oci_parse($conn,$sql);
		oci_execute($queryOracle);
		while ($rowID=oci_fetch_array($queryOracle)){
		
			//$company = $rowID['BULAN'];		
			$target_val = $rowID['RKAP'];
			$real_val = $rowID['RIIL'];
			
			$text["s".$rowID['BULAN']]= array(
						"target"=> $target_val,
						"real"=>$real_val);
		}
		echo json_encode($text);
?>