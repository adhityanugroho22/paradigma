<title>Json</title>
<?php
header('Access-Control-Allow-Origin: *');

$servername = "10.15.3.146";
$username = "par4digma";
$password = "S3menGres1k";
$dbname = "logfeedtuban";
   
   $conn = mysql_connect($servername, $username, $password);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
   
   $sql = 'SELECT DateTime, TNS2_KL1, TNS3_KL1 FROM logfeedtuban.feed_tonasa23';
   mysql_select_db($dbname);
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
		$minutes = substr($row['DateTime'], 11, 5);
		
		$KL2_Feed =  number_format($row['TNS2_KL1'],2);
		$KL3_Feed =  number_format($row['TNS3_KL1'],2);
		
		$text2 = 'kl2';
		$text3 = 'kl3';
		
	   $toProd['Feed_KL'][$minutes] = array(
					$text2 => $KL2_Feed,
					$text3 => $KL3_Feed
	   );
   }
   $toProd = 'null';
   echo '{"4000":'.json_encode($toProd).'}';
?>