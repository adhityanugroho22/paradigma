<?php
header("Access-Control-Allow-Origin:*");

if (ISSET($_GET['s']) && $_GET['s'] == 'kiln3'){
 $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Hood_Draft%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler3_Speed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Bearing_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Depth_Cooler%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Kiln_Burner%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Heat_Cons%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_ILC_Rate%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Ops_Speed_IdF1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Ops_Power_IdF1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Ops_Vib1_IdF1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Ops_Vib2_IdF1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Ops_Damp_IdF1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Ops_ExTemp1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_CoalBurner_ILC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_SLC_Rate%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Ops_Speed_IdF2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Ops_Power_IdF2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Ops_Vib1_IdF2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Ops_Vib2_IdF2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Ops_Damp_IdF2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_Ops_ExTemp2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL3_CoalBurner_SLC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
}else if (ISSET($_GET['s']) && $_GET['s'] == 'kiln4'){
 $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Hood_Draft%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Speed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Bearing_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Depth_Cooler%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Coal_Mill4_Product%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Heat_Cons%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_Speed_IdF1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_Amp_IdF1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_Vib1_IdF1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_Vib2_IdF1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_Damp_IdF1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_Speed_IdF2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_Amp_IdF2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_Vib1_IdF2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_Vib2_IdF2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_Damp_IdF2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_ExTemp11%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_ExTemp12%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_ExTemp21%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_ExTemp22%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_CoalBurner_ILC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
}
print file_get_contents($myUrl);
?>