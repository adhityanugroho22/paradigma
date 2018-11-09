<?php
header('Access-Control-Allow-Origin:*');
defined('BASEPATH') OR exit('No direct script access allowed');

class Material_balance_st extends CI_Controller{
  Protected $path_upload = "";
  public function __construct()
    {
      parent::__construct();
      $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
      $this->db=$this->load->database('tonasa1',true);
    } 

    public function index(){
        $bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $plant = (empty($_GET['plant']) ? 1 : $_GET['plant']);
        $product = (empty($_GET['plant']) ? 1 : $_GET['plant']);
        $bulan_sekarang=$tahun.'-'.$bulan;
        if($plant==1){
            $plant="'KILN23','KILN4','KILN5', 'CLOSEDYARD'";
            $gr_= "'Pemakaian Finish Mill 2' ,'Pemakaian Finish Mill 3','Pemakaian Finish Mill 4.1','Pemakaian Finish Mill 4.2','Transfer dari Plant lain'";
            $gi_= "'Transfer ke Plant lain','Transfer ke Open Yard'";
            $plant_detail=array('KILN23','KILN4','KILN5', 'CLOSEDYARD');
        }else {
           $plant="'FINISHMIL23','FINISHMIL4','FINISHMIL5', '4403'";
           $gi_= "'- Jual FOT & Franco','- Kirim ke Pelum Maccini Baji & Paotere','- Kirim ke GP Biringkassi & Plant Transhipment','- Kirim ke GP Makassar','Kirim ke UP Biringkassi','Kirim ke UP Makassar','Transfer ke Plant lain pabrik'";
           $gr_= "'Transfer dari Plant lain pabrik'";
           $plant_detail=array('FINISHMIL23','FINISHMIL4','FINISHMIL5', '4402', '4403', '4404', '4405', '4406', '4407', '4408', '4409', '4411', '4413');
           $plant_fm=array('4402', '4403', '4404', '4405', '4406', '4407', '4408', '4409', '4411', '4413');
        }
        
        if($bulan==date('m')){
            $cek=$this->db->query("SELECT MAX(DATE) AS DATE FROM MATERIAL_BALANCE1 WHERE PLANT IN ('KILN23','KILN4','KILN5', 'CLOSEDYARD')")->row();
        }else{
            $cek=$this->db->query("SELECT MAX(DATE) AS DATE FROM MATERIAL_BALANCE1 WHERE date_format(DATE,'%Y-%m')='$bulan_sekarang' AND PLANT IN ('KILN23','KILN4','KILN5', 'CLOSEDYARD')")->row();
        }
        $cek1=$this->db->query("SELECT MAX(DATE) AS DATE FROM MATERIAL_BALANCE1 WHERE PLANT IN ('KILN23','KILN4','KILN5', 'CLOSEDYARD')")->row();
        $tanggal=$cek->DATE;
        $stok_akhir = $this->db->query("SELECT SUM(NILAI) AS NILAI FROM MATERIAL_BALANCE1 WHERE DATE = '$tanggal'  AND PLANT IN($plant) AND KET ='Stock Akhir'")->row();
        $stok_oy = $this->db->query("SELECT SUM(NILAI) AS NILAI FROM MATERIAL_BALANCE1 WHERE DATE = '$tanggal'  AND PLANT IN('CLOSEDYARD') AND KET ='Stock Akhir'")->row();
        $saldo_awal = $this->db->query("SELECT SUM(NILAI)AS NILAI FROM MATERIAL_BALANCE1 WHERE DATE = '$tanggal'  AND KET ='Stock Awal' AND PLANT IN ($plant)")->row();
        $gi=$this->db->query("SELECT SUM(NILAI) AS NILAI FROM MATERIAL_BALANCE1 WHERE DATE = '$tanggal'  AND KET IN ($gi_) AND PLANT IN ($plant)")->row();
        $gr= $this->db->query("SELECT SUM(NILAI)AS NILAI FROM MATERIAL_BALANCE1 WHERE DATE = '$tanggal'  AND KET IN ($gr_) AND PLANT IN ($plant)")->row();
        $stok_chart=$this->db->query("SELECT SUM(MATERIAL_BALANCE1.NILAI) AS NILAI, SUM(MB_KAPASITAS.NILAI) AS KAPASITAS FROM MATERIAL_BALANCE1 INNER JOIN MB_KAPASITAS ON MB_KAPASITAS.PLANT=MATERIAL_BALANCE1.PLANT WHERE DATE_FORMAT(MATERIAL_BALANCE1.DATE,'%Y-%m')='".date('Y-m', strtotime($tanggal))."' AND MATERIAL_BALANCE1.PLANT IN ($plant) AND MATERIAL_BALANCE1.KET='Stock Akhir' GROUP BY MATERIAL_BALANCE1.DATE ORDER BY MATERIAL_BALANCE1.DATE ASC");
        $stok_kiln = $this->db->query("SELECT  PLANT,KET,NILAI FROM MATERIAL_BALANCE1 WHERE DATE = '$tanggal'  AND PLANT IN ($plant)");

        $data[]=array('STOK'=>number_format($stok_akhir->NILAI,2,",","."),'SALDO_AKHIR'=> number_format($saldo_awal->NILAI,2,",","."),'STOK_OPENYARD'=> number_format($stok_oy->NILAI,2,",","."),'GI'=> number_format($gi->NILAI,2,",","."),'GR'=>number_format($gr->NILAI,2,",","."),'LAST_UPDATE'=>date('d/m/Y', strtotime($cek1->DATE)));
        foreach ($stok_chart->result_array() as $row) { 
            $data['CHART'][]=array('NILAI'=>$row['NILAI'], 'KAPASITAS'=>$row['KAPASITAS']);
        }
        foreach ($plant_detail as $value) {
            $stok_chart_plant=$this->db->query("SELECT SUM(MATERIAL_BALANCE1.NILAI) AS NILAI, SUM(MB_KAPASITAS.NILAI) AS KAPASITAS, MATERIAL_BALANCE1.PLANT AS PLANT FROM MATERIAL_BALANCE1 INNER JOIN MB_KAPASITAS ON MB_KAPASITAS.PLANT=MATERIAL_BALANCE1.PLANT WHERE DATE_FORMAT(MATERIAL_BALANCE1.DATE,'%Y-%m')='".date('Y-m', strtotime($tanggal))."' AND MATERIAL_BALANCE1.PLANT = '$value' AND MATERIAL_BALANCE1.KET='Stock Akhir' GROUP BY MATERIAL_BALANCE1.DATE ORDER BY MATERIAL_BALANCE1.DATE ASC");
            foreach ($stok_chart_plant->result_array() as $row) {
                $data['PLANT_DETAIL'][$row['PLANT']][]=array('NILAI'=>$row['NILAI'], 'KAPASITAS'=>$row['KAPASITAS']);
            }
        }
        foreach ($stok_kiln->result_array() as $row1) {
            $data['PLANT'][$row1['PLANT']][]=array('KET'=>$row1['KET'],'NILAI'=> $row1['NILAI']);
        }
        if($product==2){
              $stok_brks = $this->db->query("SELECT PLANT,KET,SUM(NILAI) AS NILAI FROM MATERIAL_BALANCE1 WHERE DATE_FORMAT(DATE,'%Y-%m')='".date('Y-m', strtotime($tanggal))."'  AND PLANT IN (4402) AND KET LIKE ('%Stock Awal%')")->row();
              $gi_brks = $this->db->query("SELECT PLANT,KET,SUM(NILAI) AS NILAI FROM MATERIAL_BALANCE1 WHERE DATE_FORMAT(DATE,'%Y-%m')='".date('Y-m', strtotime($tanggal))."'  AND PLANT IN (4402) AND KET LIKE ('%Pengiriman ke Packing Plant:%')")->row();
              $prod_brks = $this->db->query("SELECT PLANT,KET,SUM(NILAI) AS NILAI FROM MATERIAL_BALANCE1 WHERE DATE_FORMAT(DATE,'%Y-%m')='".date('Y-m', strtotime($tanggal))."'  AND PLANT IN (4402) AND KET LIKE ('%Produksi Packer%')")->row();
              $jual_brks = $this->db->query("SELECT PLANT,KET,SUM(NILAI) AS NILAI FROM MATERIAL_BALANCE1 WHERE DATE_FORMAT(DATE,'%Y-%m')='".date('Y-m', strtotime($tanggal))."'  AND PLANT IN (4402) AND KET LIKE ('%Penjumboan%')")->row();
              $selisih_brks = $this->db->query("SELECT PLANT,KET,SUM(NILAI) AS NILAI FROM MATERIAL_BALANCE1 WHERE DATE_FORMAT(DATE,'%Y-%m')='".date('Y-m', strtotime($tanggal))."'  AND PLANT IN (4402) AND KET LIKE ('%Selisih Stock%')")->row();
              $akhir_brks = $this->db->query("SELECT PLANT,KET,SUM(NILAI) AS NILAI FROM MATERIAL_BALANCE1 WHERE DATE_FORMAT(DATE,'%Y-%m')='".date('Y-m', strtotime($tanggal))."'  AND PLANT IN (4402) AND KET LIKE ('%Stock Akhir%')")->row();
                $data1=array('KET'=>$stok_brks->KET,'NILAI'=> $stok_brks->NILAI);
                $data2=array('KET'=>$gi_brks->KET,'NILAI'=> $gi_brks->NILAI);
                $data3=array('KET'=>$jual_brks->KET,'NILAI'=> $jual_brks->NILAI);
                $data4=array('KET'=>$selisih_brks->KET,'NILAI'=> $selisih_brks->NILAI);
                $data5=array('KET'=>$akhir_brks->KET,'NILAI'=> $akhir_brks->NILAI);
                $data6=array('KET'=>$prod_brks->KET,'NILAI'=> $prod_brks->NILAI);

                $data['PLANT']['4402']=array($data1, $data2, $data6, $data3, $data4, $data5);

              $stok_luar = $this->db->query("SELECT KET,SUM(NILAI) AS NILAI FROM MATERIAL_BALANCE1 WHERE  DATE_FORMAT(DATE,'%Y-%m')='".date('Y-m', strtotime($tanggal))."' AND PLANT IN ('4404', '4405', '4406', '4407', '4408', '4409', '4411', '4413') GROUP BY KET"); 
                foreach ($stok_luar->result_array() as $row2) {
                  $data['PLANT']['UPLUAR'][]=array('KET'=>$row2['KET'], 'NILAI'=>$row2['NILAI']);
                }
        }

        echo json_encode($data);    
    }
  
    public function _get_path_upload(){
        $tes = dirname(__FILE__);
        $pet_pat = str_replace('application/controllers/', '', $tes); 
        return $pet_pat;   
    }
  
    public function upload_material_balance() {
        $insert=0;
        $update=0;
        $this->path_upload = $this->_get_path_upload()."/model/".basename($_FILES['file']['name']);
        $file = $_FILES['file']['tmp_name'];
         if (move_uploaded_file($file, $this->path_upload))
        {

        	$inputFileName = $this->path_upload;
         
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            } 
            
            
//          kiln
            $sheet = $objPHPExcel->getSheet(3);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <=$highestColumn; $row++){                
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                if ($rowData[0][0]==""){
                    continue;
                }          
                $this->db->where(array("OPCO"=>$rowData[0][0],'PLANT'=>$rowData[0][1],'DATE'=>$rowData[0][4],'PERIODE'=>$rowData[0][5],'YEAR'=>$rowData[0][6]));
                $query=$this->db->get('MATERIAL_BALANCE');
                if($query->num_rows()>0){
                $this->db->where(array("OPCO"=>$rowData[0][0],'PLANT'=>$rowData[0][1],'DATE'=>$rowData[0][4],'PERIODE'=>$rowData[0][5],'YEAR'=>$rowData[0][6]));
                $sql=$this->db->update('MATERIAL_BALANCE',array(
                                                                  'PACKER'=>$rowData[0][2],
                                                                  'SILO_CAPACITY'=>$rowData[0][3],
                                                                  'BEGINNING_BALANCE'=>$rowData[0][7],
                                                                  'PRODUKSI'=>$rowData[0][8],
                                                                  'GI_FINISH_MILL'=>$rowData[0][9],
                                                                  'GI_STO_CURAH'=>$rowData[0][10],
                                                                  'GI_STO_ZAK'=>$rowData[0][11],
                                                                  'SALES'=>$rowData[0][12],
                                                                  'GR_BELI'=>$rowData[0][13],
                                                                  'GR_STO_CURAH'=>$rowData[0][14],
                                                                  'GR_STO_ZAK'=>$rowData[0][15],
                                                                  'SELISIH_STOK'=>$rowData[0][16],
                                                                  'SALDO_AKHIR'=>$rowData[0][17]
                                                    ));
                 $update++;
                }else{
                $sql=$this->db->update('MATERIAL_BALANCE',array(  'OPCO'=>$rowData[0][0],
                                                                  'PLANT'=>$rowData[0][1],
                                                                  'DATE'=>$rowData[0][4],
                                                                  'PERIODE'=>$rowData[0][5],
                                                                  'YEAR'=>$rowData[0][6],
                                                                  'PACKER'=>$rowData[0][2],
                                                                  'SILO_CAPACITY'=>$rowData[0][3],
                                                                  'BEGINNING_BALANCE'=>$rowData[0][7],
                                                                  'PRODUKSI'=>$rowData[0][8],
                                                                  'GI_FINISH_MILL'=>$rowData[0][9],
                                                                  'GI_STO_CURAH'=>$rowData[0][10],
                                                                  'GI_STO_ZAK'=>$rowData[0][11],
                                                                  'SALES'=>$rowData[0][12],
                                                                  'GR_BELI'=>$rowData[0][13],
                                                                  'GR_STO_CURAH'=>$rowData[0][14],
                                                                  'GR_STO_ZAK'=>$rowData[0][15],
                                                                  'SELISIH_STOK'=>$rowData[0][16],
                                                                  'SALDO_AKHIR'=>$rowData[0][17]));
                $insert++;
                                                    
            	}
        	}

            unlink($inputFileName);
            echo json_encode(array('status'=>true,'msg'=>'Casflow Daily<br>Insert :'.$insert.'<br> Update : '.$update));
        }
        else{
        echo json_encode(array('status'=>false,'msg'=>'Gagal Import Data'));
   		 }
   	}
        
        
        public function upload_material_balance1() {
            $insert=0;
            $update=0;
            $insert_fm=0;
            $update_fm=0;
            $bulan1= $this->input->post('bulan');
            $tahun= $this->input->post('tahun');
            $bulan=$this->bulan($bulan1);
            $this->path_upload = $this->_get_path_upload()."/model/".basename($_FILES['file']['name']);
            $file = $_FILES['file']['tmp_name'];
               
               if (move_uploaded_file($file, $this->path_upload))
            {

        	$inputFileName = $this->path_upload;
         
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
//          
//          kiln
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $aa=cal_days_in_month(CAL_GREGORIAN,$bulan1, $tahun);
            $aa1=$aa+1;
            for ($i=2; $i <=$aa1 ; $i++) { 
            for ($row = 2; $row <= $highestRow; $row++){                
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                if ($rowData[0][1]==""){
                    continue;
                }
                
                if ($rowData[0][0]!=""){
                    $plant = $rowData[0][0];
                }
                $d=$i-1;
                $date=$this->tanggal($d,$bulan,$tahun);
                $this->db->where(array("OPCO"=>4000,"DATE"=>$date,
                			"KET"=>$rowData[0][1],
                                        "PLANT"=>$plant));
                $query=$this->db->get('MATERIAL_BALANCE1');
                if($query->num_rows()>0){
                $this->db->where(array("OPCO"=>4000,"DATE"=>$date,
                			"KET"=>$rowData[0][1],
                                         "PLANT"=>$plant));
                 $sql=$this->db->update('MATERIAL_BALANCE1',array(
					"NILAI"=>$rowData[0][$i]
                                                    ));
                 $update++;
                }else{
                $sql=$this->db->insert('MATERIAL_BALANCE1',array('OPCO'=>4000,'DATE'=>$date,"PLANT"=>$plant,'KET'=>$rowData[0][1],'NILAI'=>$rowData[0][$i]));
                $insert++;
            	}
        	}
            }
//          finishmill
            $sheet = $objPHPExcel->getSheet(1);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $aa=cal_days_in_month(CAL_GREGORIAN,$bulan1, $tahun);
            $aa1=$aa+1;
            for ($i=2; $i <=$aa1 ; $i++) { 
            for ($row = 2; $row <= $highestRow; $row++){                
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                if ($rowData[0][1]==""){
                    continue;
                }
                
                if ($rowData[0][0]!=""){
                    $plant = $rowData[0][0];
                }
                $d=$i-1;
                $date=$this->tanggal($d,$bulan,$tahun);
                $this->db->where(array("OPCO"=>4000,"DATE"=>$date,
                			"KET"=>$rowData[0][1],
                                        "PLANT"=>$plant));
                $query=$this->db->get('MATERIAL_BALANCE1');
                if($query->num_rows()>0){
                $this->db->where(array("OPCO"=>4000,"DATE"=>$date,
                			"KET"=>$rowData[0][1],
                                         "PLANT"=>$plant));
                 $sql=$this->db->update('MATERIAL_BALANCE1',array(
					"NILAI"=>$rowData[0][$i]
                                                    ));
                 $update_fm++;
                }else{
                $sql=$this->db->insert('MATERIAL_BALANCE1',array('OPCO'=>4000,'DATE'=>$date,"PLANT"=>$plant,'KET'=>$rowData[0][1],'NILAI'=>$rowData[0][$i]));
                $insert_fm++;
            	}
        	}
            }

            unlink($inputFileName);
                echo  json_encode(array('status'=>true,'msg'=>'Kiln<br>Insert :'.$insert.'<br> Update : '.$update.'<br>Finish Mill : '.$insert_fm.'<br>'.$update_fm));
            
                }
        else{
    		echo json_encode(array('status'=>false,'msg'=>'Gagal Import Data'));
            }
    }
  
        public function upload(){
        $this->load->view('upload/v_upload_material_balance');
    }
    
    
    public function tanggal($id,$bulan,$tahun)
	{
		switch ($id) {
			case 1:
				$d='01';
				break;
			case 2:
				$d='02';
				break;
			case 3:
				$d='03';
				break;
			case 4:
				$d='04';
				break;
			case 5:
				$d='05';
				break;
			case 6:
				$d='06';
				break;
			case 7:
				$d='07';
				break;
			case 8:
				$d='08';
				break;
			case 9:
				$d='09';
				break;
			default:
				$d=$id;
				break;
		}

		return $tahun.'-'.$bulan.'-'.$d;
	}

		public function bulan($id)
	{
		switch ($id) {
			case 1:
				$d='01';
				break;
			case 2:
				$d='02';
				break;
			case 3:
				$d='03';
				break;
			case 4:
				$d='04';
				break;
			case 5:
				$d='05';
				break;
			case 6:
				$d='06';
				break;
			case 7:
				$d='07';
				break;
			case 8:
				$d='08';
				break;
			case 9:
				$d='09';
				break;
			default:
				$d=$id;
				break;
		}
		
		return $id;
	}


	public function month($bulan)
	{
		switch ($bulan) {
			case 'JANUARI':
				$bln =1;
				break;
			case 'FEBRUARI':
				$bln =2;
				break;
			case 'MARET':
				$bln =3;
				break;
			case 'APRIL':
				$bln =4;
				break;
			case 'MEI':
				$bln =5;
				break;
			case 'JUNI':
				$bln =6;
				break;
			case 'JULI':
				$bln =7;
				break;
			case 'AGUSTUS':
				$bln =8;
				break;
			case 'SEPTEMBER':
				$bln =9;
				break;
			case 'OKTOBER':
				$bln =10;
				break;
			case 'NOVEMBER':
				$bln =11;
				break;
			case 'DESEMBER':
				$bln =12;
				break;
			default:
				$bln =0;
				break;
		}

		return $bln;
	}
        
        
        

}
