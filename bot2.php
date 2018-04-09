<?php
session_start(); //เปิด seesion เพื่อทำงาน
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

//connectdb
$host = "sql12.freemysqlhosting.net";
$username = "sql12231545";
$password = "9r6TkPaBMc";
$objConnect = mysqli_connect($host,$username,$password);

if($objConnect)
{
	echo "MySQL Connected";
}
else
{
	echo "MySQL Connect Failed : Error : ".mysqli_error();
}


//Line Token
$strAccessToken = '1OFasil/2dmg4zfIvklnFzY23slCclWjIgKyIwHnQcbg7ztGPVMZny6479Vnyeh8gCNpL9KJl5I6YfMpmNveUjbwcoi4f943KMjpHwmxb+pXKetgldM4DK2CUVZhRCvCoQYEAS5+yPkDLjwLQvm3RgdB04t89/1O/w1cDnyilFU=';
$content = file_get_contents('php://input');
$arrJson = json_decode($content, true);
$strUrl = "https://api.line.me/v2/bot/message/reply";
$arrHeader = array();
$arrHeader[] = "Content-Type: application/json";
$arrHeader[] = "Authorization: Bearer {$strAccessToken}";
$msg = $arrJson['events'][0]['message']['text'];

	$objDB = mysqli_select_db($objConnect,"sql12231545");
	$s = "SELECT * FROM msgdata Where c_data = '$msg'";
	$sql = mysqli_query($objConnect,$s);

if(mysqli_num_rows($sql)<=1){
	
			$row = mysqli_fetch_array($sql);
			
			$_SESSION["id"] = $row["i_id"];
			$_SESSION["data"] = $row["c_data"];
			$_SESSION["value"] = $row["c_value"];

			  $arrPostData = array();
			  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
			  $arrPostData['messages'][0]['type'] = "text";
			  $arrPostData['messages'][0]['text'] = $_SESSION["value"];


}else{
			$arrPostData = array();
			  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
			  $arrPostData['messages'][0]['type'] = "text";
			  $arrPostData['messages'][0]['text'] = "ไม่พบข้อความ ".$msg. "S = ".$s ;
			//echo "<BR>ขออภัยค่ะ Line ID ยังไม่ได้ลงทะบียนค่ะ";
		}


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$strUrl);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrPostData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close ($ch);
?>
