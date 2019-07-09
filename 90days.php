<?php
//header('Content-Type: application/json');
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://www.ups.com/assets/resources/fuel-surcharge/vn.json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:69.0) Gecko/20100101 Firefox/69.0';
$headers[] = 'Accept: */*';
$headers[] = 'Accept-Language: en-US,en;q=0.5';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Referer: https://www.ups.com/vn/vi/shipping/surcharges/fuel-surcharges.page';
$headers[] = 'Cookie: AMCV_036784BD57A8BB277F000101%\"40AdobeOrg=-715282455\"%\"7CMCIDTS\"%\"7C18086\"%\"7CMCMID\"%\"7C25534255203367927852643208175995128007\"%\"7CMCAAMLH-1563202168\"%\"7C3\"%\"7CMCAAMB-1563202168\"%\"7C6G1ynYcLPuiQxYZrsz_pkqfLG9yMXBpb2zX5dvJdYQJzPXImdj0y\"%\"7CMCOPTOUT-1562604568s\"%\"7CNONE\"%\"7CMCSYNCSOP\"%\"7C411-18093\"%\"7CMCCIDH\"%\"7C1934833521\"%\"7CvVersion\"%\"7C4.2.0;';
$headers[] = 'Cache-Control: max-age=0';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$arr = json_decode($result, true);
echo '* Ngày: '.$arr['FuelSurchargeResponse']['SurchargeHistory_vi']['RevenueSurchargeHistory'][0]['Field1'];
echo ': <b>';
echo $arr['FuelSurchargeResponse']['SurchargeHistory_vi']['RevenueSurchargeHistory'][0]['Field2'];
echo '</b>';