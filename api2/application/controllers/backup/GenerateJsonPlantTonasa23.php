<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GenerateJsonPlantTonasa23 extends CI_Controller {

	public function index()
	{
		$seta ='http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tonasa%202/3.FM1_TNS2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202/3.FM1_TNS3_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202/3.FM1_TNS3_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202/3.KL1_TNS2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202/3.KL1_TNS3_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202/3.KL1_TNS3_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202/3.RM1_TNS2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202/3.RM1_TNS2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202/3.RM1_TNS3_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202/3.RM1_TNS3_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202/3.CM1_TNS2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202/3.CM1_TNS3_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202/3.KL1_TNS2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202/3.FM1_TNS2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589521355';
print file_get_contents($seta);
	}

}

/* End of file GenerateJsonPlantTonasa23.php */
/* Location: ./application/controllers/GenerateJsonPlantTonasa23.php */