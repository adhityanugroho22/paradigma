<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Volproduksi4000 extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('stokpp&gudang/m_volproduksi4000');
		$this->load->model('stokpp&gudang/m_volproduksismig');
	}
	public function index_old()
	{
		$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
		$tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
		if($bulan==date('m')){
	      $hari=date('d');
	    }else{
	      $hari=$this->tgl_akhir($tahun,$bulan);
	    }
		$date=$tahun.$bulan;
		$tahunlalu=$tahun-1;
		$datelalu=$tahunlalu.$bulan;
		$hariawal=$datelalu.'01';

		$realisasi4000=$this->m_volproduksi4000->get_realisasi($tahun,$bulan,$hari,$date);
		$realisasilalu4000=$this->m_volproduksi4000->get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu);
		$realisasi_l4000=$this->m_volproduksi4000->get_realisasi_l($tahunlalu,$bulan,$hari,$datelalu,$hariawal);
		$realisasi_h4000=$this->m_volproduksi4000->get_realisasi_h($tahun,$bulan,$hari,$date);
		$prognose4000=$this->m_volproduksi4000->get_prognose($tahun,$bulan,$hari,$date);
		$prognoselalu4000=$this->m_volproduksi4000->get_prognoselalu($tahunlalu,$bulan,$hari,$datelalu);
		$ekspor4000=$this->m_volproduksi4000->get_ekspor($tahun,$bulan,$hari,$date);
		$eksporlalu4000=$this->m_volproduksi4000->get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu);


		//tahun sekarang
		$real4000='';
		foreach ($realisasi4000 as $r) {
			$real4000+=$r->REALISASI;
		}

		foreach ($realisasi_h4000 as $r) {
			$real_h4000=$r->REALISASI;
		}
		if($bulan==date('m')){
		$real_sdk4000=$real4000-$real_h4000;
		}else{
			$real_sdk4000=$real4000;
		}
		foreach ($prognose4000 as $p) {
			$rkap4000=$p->RKAP;
			$prog4000=$p->PROG;
			$prog_h4000=$p->PROGNOSE_HARIAN;
		}
		if($bulan==date('m')){
			$rkap_sdk4000=$rkap4000-($prog4000+$prog_h4000);
		}else{
			$rkap_sdk4000=$rkap4000;
		}

		if($ekspor4000->num_rows>0){
		foreach ($ekspor4000->result() as $e) {
			
			$real_ekspor_sm4000=$e->REAL_EKSPOR_SM;
			$real_ekspor_tr4000=$e->REAL_EKSPOR_TR;
			$rkap_ekspor4000=$e->RKAP_EKSPOR;
		
		}
		}else{
			$real_ekspor_sm4000=0;
			$real_ekspor_tr4000=0;
			$rkap_ekspor4000=0;
		}


		//tahun lalu
		$reallalu4000='';
		foreach ($realisasilalu4000 as $r) {
			$reallalu4000+=$r->REALISASI;
		}

		$real_l4000='';
		foreach ($realisasi_l4000 as $r) {
			$real_l4000+=$r->REALISASI;
		}

		foreach ($prognoselalu4000 as $p) {
			$rkaplalu4000=$p->RKAP;
			$proglalu4000=$p->PROGNOSE_HARIAN;
		}


		foreach ($eksporlalu4000 as $e) {
			$real_ekspor_smlalu4000=$e->REAL_EKSPOR_SM;
			$real_ekspor_trlalu4000=$e->REAL_EKSPOR_TR;
			$rkap_eksporlalu4000=$e->RKAP_EKSPOR;
		}

		$dom_real4000=($real4000-$real_l4000)*100/$real_l4000;
		$dom_prog4000=(($real4000+$prog4000)-$reallalu4000)*100/$reallalu4000;
		if(($real_ekspor_sm4000+$real_ekspor_tr4000)!=0){
		$ekspor_real4000=(($real_ekspor_sm4000+$real_ekspor_tr4000)-($real_ekspor_smlalu4000+$real_ekspor_trlalu4000))*100/($real_ekspor_smlalu4000+$real_ekspor_trlalu4000);
		}else{
		$ekspor_real4000=0;
		}
		if($ekspor_real4000!=0){
		$growth_selisih=(($real4000+($real_ekspor_sm4000+$real_ekspor_tr4000))-($real_l4000+($real_ekspor_smlalu4000+$real_ekspor_trlalu4000)))*100/($real_l4000+($real_ekspor_smlalu4000+$real_ekspor_trlalu4000));
		}else{
			$growth_selisih=$dom_real4000;
		}
		///json
		$data['s4000']['dom']=array('real_sdk'=>$real_sdk4000,
									'rkap_sdk'=>$rkap_sdk4000,
									'selisih'=>$real_sdk4000-$rkap_sdk4000);

		$data['ekspor']=array('real_sm'=>$real_ekspor_sm4000,
									'real_tr'=>$real_ekspor_tr4000,
									'rkap_eks'=>$rkap_ekspor4000);

		$data['growth']=array('dom_real'=>$dom_real4000,
							'dom_prog'=>$dom_prog4000,
							'ekspor_real'=>$ekspor_real4000,	
							'total'=>$growth_selisih

			);

		echo json_encode($data);

	}

	public function tgl_akhir($thn,$bln)
	  {
	    $bln1=str_replace(0, '', $bln);
	    $bulan[1]='31';
	    $bulan[2]='28';
	    $bulan[3]='31';
	    $bulan[4]='30';
	    $bulan[5]='31';
	    $bulan[6]='30';
	    $bulan[7]='31';
	    $bulan[8]='31';
	    $bulan[9]='30';
	    $bulan[10]='31';
	    $bulan[11]='30';
	    $bulan[12]='31';

	    if ($thn%4==0){
	    $bulan[02]=29;
	    }

	    return $bulan[$bln1];
	  }

	 function index(){
    	$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);

        $param['year'] = $tahun;
        $param['month'] = $bulan;
        $date = $tahun.$bulan;

        if ($bulan == date('m') && $tahun == date('Y')) {
        	# code...
        	$param['day'] = date('d');
      		$tanggal = date('Ymd');
            $hari = date('d', strtotime($tanggal . "-1 days"));


        	
        }else{
        	$day = date('t', strtotime($tahun . "-" . $bulan));
        	$param['day'] =$day;
      		$tanggal = $tahun.$bulan.$day;
      		$hari = $day;


        }

        $param['tanggal'] = $tanggal;
        $param['yesterday'] = $hari;
        $smi['real_sdh'] = 0;
        $smi['real_sdk'] = 0;
        $smi['rkap_sdk'] = 0;
        $smi['real_sdh_lalu'] = 0;
        $smi['real_eks'] = 0;
        $smi['real_eks_lalu'] = 0;
        $smi['real_lalu'] = 0;
        $smi['prognose'] = 0;

        $dataST = $this->m_volproduksismig->sumSales4000_rev('4000', $date);

        // $result = $this->m_volproduksismig->salesVolumeSMI($param, $tanggal, $hari);
        $eksporST = $this->m_volproduksismig->sumEksporST($date);

        $dataSMI = $dataST;

        $sumEkspor = 0;
        if (isset($eksporST['REAL_EKSPOR'])) {
        	# code...
        	// $sumEkspor = $eksporST['REAL_EKSPOR'];
        	
        }
        $dataSMI['REAL_SDK'] -= $sumEkspor;

        $dataSMI['REAL_SDH'] -= $dataSMI['REAL_EKSPOR_TAHUNINI'];

        if ($dataSMI['RKAP_SDK'] == 0) {
            $dataSMI['PERSEN'] = 0;
        } else {
            $dataSMI['PERSEN'] = round($dataSMI['REAL_SDK'] / $dataSMI['RKAP_SDK'] * 100);
        }

        $dataSMI['DEVIASI'] = $dataSMI['REAL_SDK'] - $dataSMI['RKAP_SDK'];

        if ($dataSMI['RKAP_EKSPOR'] == 0) {
            $dataSMI['PERSEN_EKSPOR'] = 0;
        } else {
            $dataSMI['PERSEN_EKSPOR'] = round(($dataSMI['REAL_SM_EKSPOR'] + $dataSMI['REAL_TR_EKSPOR']) / $dataSMI['RKAP_EKSPOR'] * 100);
        }
        
        ############## MENGHITUNG GROWTH ####################
        if ($dataSMI['REAL_SDH_TAHUNLALU'] == 0) {
            $dataSMI['GROWTH_DOM_REAL'] = 0;
        } else {
            $dataSMI['GROWTH_DOM_REAL'] = round((($dataSMI['REAL_SDH']-$dataSMI['REAL_SDH_TAHUNLALU'])/$dataSMI['REAL_SDH_TAHUNLALU'])*100,1);
        }
        if ($dataSMI['REAL_TAHUNLALU'] == 0) {
            $dataSMI['GROWTH_DOM_PROG'] = 0;
        } else {
            $dataSMI['GROWTH_DOM_PROG'] = round(((($dataSMI['REAL_SDH']+$dataSMI['PROGNOSE'])-$dataSMI['REAL_TAHUNLALU'])/$dataSMI['REAL_TAHUNLALU'])*100,1);
        }
        if ($dataSMI['REAL_EKSPOR_TAHUNLALU'] == 0) {
            $dataSMI['GROWTH_EKSPOR'] = 0;
        } else {
            $dataSMI['GROWTH_EKSPOR'] = round((($dataSMI['REAL_EKSPOR_TAHUNINI']-$dataSMI['REAL_EKSPOR_TAHUNLALU'])/$dataSMI['REAL_EKSPOR_TAHUNLALU'])*100,1);
        }
        if ($dataSMI['REAL_EKSPOR_TAHUNLALU'] == 0 && $dataSMI['REAL_TAHUNLALU'] == 0) {
            $dataSMI['GROWTH_TOTAL'] = 0;
        } else {
            $dataSMI['GROWTH_TOTAL'] = round(((($dataSMI['REAL_EKSPOR_TAHUNINI']+$dataSMI['REAL_SDH'])-($dataSMI['REAL_EKSPOR_TAHUNLALU']+$dataSMI['REAL_TAHUNLALU']))/($dataSMI['REAL_EKSPOR_TAHUNLALU']+$dataSMI['REAL_TAHUNLALU']))*100,1);
        }
        ######################################################
        $dom['real_sdk'] = $dataSMI['REAL_SDK'];
        $dom['rkap_sdk'] = $dataSMI['RKAP_SDK'];
        $dom['selisih'] = $dataSMI['DEVIASI'];

        $eks['real_sm'] = $dataSMI['REAL_SM_EKSPOR'];
        $eks['real_tr'] = $dataSMI['REAL_TR_EKSPOR'];
        $eks['rkap_eks'] = $dataSMI['RKAP_EKSPOR'];

        $gro['dom_real'] = $dataSMI['GROWTH_DOM_REAL'];
        $gro['dom_prog'] = $dataSMI['GROWTH_DOM_PROG'];
        $gro['ekspor_real'] = $dataSMI['GROWTH_EKSPOR'];
        $gro['total'] = $dataSMI['GROWTH_TOTAL'];

        $json['s4000']['dom'] = $dom;
        $json['ekspor'] = $eks;
        $json['growth'] = $gro;
        echo json_encode($json);
        // echo json_encode($result);
    }

}

/* End of file volproduksi4000.php */
/* Location: ./application/controllers/volproduksi4000.php */