<?php
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=\"".$this->NM_AREA." HOURLY ".$this->input->post("TANGGAL").".xls\"");
header("Pragma: no-cache");
header("Expires: 0");

$data = json_decode($this->data); 


$tab = '<table border=1>';
$tab .= '<tr>';
$tab .= '<th>Date</th>';
$tab .= '<th>Time</th>';
$jth = 1;

#var_dump($data->th); 

#var_dump($data->tr);

foreach($data->header->colHeader as $r){
	$tab .= '<th>'.$r->title.'</th>';
	$jth++;
}
$tab .= '</tr>';
$jth .= 2;

$ltr = 0;



foreach($data->data as $i => $r){
	$tab .= "<tr><td>".$this->input->post("TANGGAL")."</td><td>".$i."</td>";
	
	foreach($r as $x => $y){
		$tab .= "<td>".$y."</td>";
	}

	$tab .= "</tr>";
	$ltr = 1;
	
}

if($ltr == 0){
	$tab .= "<tr><td colspan="+$jth+"><i>(Empty Data)</i></td></tr>";
}

$tab .= '</table>';

echo "<h1>".$this->NM_AREA." HOURLY ".$this->input->post("TANGGAL")."</h1>";
echo $tab;