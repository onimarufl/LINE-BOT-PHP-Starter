<?php
session_start(); //เปิด seesion เพื่อทำงาน
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

//connectdb
$host = "sql12.freemysqlhosting.net";
$username = "sql12233361";
$password = "MvIKw9EABA";
$objConnect = mysqli_connect($host,$username,$password);
mysqli_set_charset($objConnect,"utf8");

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

			$objDB = mysqli_select_db($objConnect,"sql12233361");

			$s1 = "SELECT inputsentence.sentence,outputsentence.output_sentence 
		FROM inputsentence INNER JOIN outputsentence ON inputsentence.catinput_id = outputsentence.catinput_id 
		WHERE inputsentence.sentence = '$msg' ORDER BY RAND() LIMIT 1";
			$sql1 = mysqli_query($objConnect,$s1);
	
		if(mysqli_num_rows($sql1)==1){
				
			$row = mysqli_fetch_array($sql1);
	
			$_SESSION["data"] = $row["sentence"];
			$_SESSION["value"] = $row["output_sentence"];

			  $arrPostData = array();
			  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
			  $arrPostData['messages'][0]['type'] = "text";
			  $arrPostData['messages'][0]['text'] = $_SESSION["value"];
		

}else{			
			
	  		$arrPostData = array();
			  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
			  $arrPostData['messages'][0]['type'] = "text";
			  $arrPostData['messages'][0]['text'] = "ขออภัยครับ ผมไม่สามารถเข้าใจข้อความ " .$msg. " ได้ ขณะนี้ระบบกำลังอยู่ในช่วงพัฒนา ขออภัยในความไม่สะดวกครับ";
			
		$s2 = "SELECT * FROM `log` WHERE msg = '$msg' ";
			$sql2 = mysqli_query($objConnect,$s2);
	
		if(mysqli_num_rows($sql2)==0){
			$objDB = mysqli_select_db($objConnect,"sql12233361");
			$s2 = "INSERT INTO log (msg) VALUES ('$msg')";
			$sql2 = mysqli_query($objConnect,$s2);
		}
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
