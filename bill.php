<?php
/*
# code by nguyentri729
# phone_number: 0971-010-421
*/


if(isset($_GET['ma_don_hang'])){
}else{
	exit('?ma_don_hang={ma_don_hang}');
}

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://www.ups.com/track/api/Track/GetStatus?loc=vi_VN');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"Locale\":\"vi_VN\",\"TrackingNumber\":[\"".$_GET['ma_don_hang']."\"]}");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = 'Host: www.ups.com';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:69.0) Gecko/20100101 Firefox/69.0';
$headers[] = 'Accept: application/json, text/plain, */*';
$headers[] = 'Accept-Language: en-US,en;q=0.5';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Referer: https://www.ups.com/track?loc=vi_VN&tracknum='.$_GET['ma_don_hang'].'&requester=WT/trackdetails';
$headers[] = 'Cookie: _ENV["AMCV_036784BD57A8BB277F000101%40AdobeOrg=-715282455%7CMCIDTS%7C18086%7CMCMID%7C25534255203367927852643208175995128007%7CMCAAMLH-1563182092%7C3%7CMCAAMB-1563182092%7C6G1ynYcLPuiQxYZrsz_pkqfLG9yMXBpb2zX5dvJdYQJzPXImdj0y%7CMCOPTOUT-1562584492s%7CNONE%7CMCSYNCSOP%7C411-18093%7CMCCIDH%7C1934833521%7CvVersion%7C4.2.0; mbox=PC#f8ae76856dfb4cc5ba30c31a3f3ee9a9.22_16#1625822134|session#fb2569461aae421cb32c7fddfe685b8b#1562579151; utag_main=v_id:016bcfd05d780010fa118c52e9360004e008d00d0086e_sn:2_se:5_ss:0_st:1562579132694vapi_domain:ups.comses_id:1562577290995%3Bexp-session_pn:3%3Bexp-session; s_nr=1562577333288-Repeat; s_vnum=1564592400959%26vn%3D2; dayssincevisit=1562577333294; _gcl_au=1.1.1705347552.1562559669; _fbp=fb.1.1562559668894.851845146; aam_uuid=25784563652303434452596779595536015619; RT=\"sl=2&ss=1562577288633&tt=9936&obo=0&sh=1562577312765%3D2%3A0%3A9936%2C1562577294361%3D1%3A0%3A5636&dm=ups.com&si=aa8c860a-56b8-4d97-9e4d-a7665e3f244c&bcn=%2F%2F60062f05.akstat.io%2F\"; aam_cms=segments%3D15025641; ups_language_preference=vi_VN; check=true; mboxEdgeCluster=22; st_cur_page=st_trackdetails; AMCVS_036784BD57A8BB277F000101%40AdobeOrg=1; s_ppv=ups%253Avn%253Avi%253Atrack%2C63%2C63%2C613; s_tp=971; s_invisit=true; dayssincevisit_s=Less%20than%201%20day; s_cc=true"]';
$headers[] = 'Cache-Control: max-age=0';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
//echo $result;
curl_close($ch);
$arr  = json_decode($result, true);
if(!isset($arr['trackDetails'])){
	exit('Không thể lấy thông tin đơn hàng !');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>UPS Tracking</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div style="padding-top: 5%;"></div>
		<div class="row">
			<div class="col-md-8">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Mã đơn hàng: <b><?=$_GET['ma_don_hang']?></b> </h3>
					</div>
					<div class="panel-body">



						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Ngày</th>
										<th>Địa điểm</th>
										<th>Hoạt động</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($arr['trackDetails'][0]['shipmentProgressActivities'] as $value) {
									    //echo(.' | '.$value['location'].' | '.$value['activityScan'].'<br>');
									?>
										<tr>
											<td><?=$value['date'].' '.$value['time']?></td>
											<td><?=$value['location']?></td>
											<td><?=$value['activityScan']?></td>
										</tr>
									<?php
									}
									?>
									
										
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
	<h4>Được giao vào: <b><?=$arr['trackDetails'][0]['deliveredDate'].' '.$arr['trackDetails'][0]['deliveredTime']?></b></h4>
						<h4>Đã giao đến: <b><?=$arr['trackDetails'][0]['shipToAddress']['city'].', '.$arr['trackDetails'][0]['shipToAddress']['country']?></b></h4>
						<h4>Để hàng tại: <b><?=$arr['trackDetails'][0]['leftAt']?></b></h4>
						<h4>Nhận hàng bởi: <b><?=$arr['trackDetails'][0]['receivedBy']?></b></h4>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>