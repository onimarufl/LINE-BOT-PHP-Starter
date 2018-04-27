<?php
session_start(); //เปิด seesion เพื่อทำงาน
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

/
//Line Token
$strAccessToken = '1OFasil/2dmg4zfIvklnFzY23slCclWjIgKyIwHnQcbg7ztGPVMZny6479Vnyeh8gCNpL9KJl5I6YfMpmNveUjbwcoi4f943KMjpHwmxb+pXKetgldM4DK2CUVZhRCvCoQYEAS5+yPkDLjwLQvm3RgdB04t89/1O/w1cDnyilFU=';
$content = file_get_contents('php://input');
$arrJson = json_decode($content, true);
$strUrl = "https://api.line.me/v2/bot/message/reply";
$arrHeader = array();
$arrHeader[] = "Content-Type: application/json";
$arrHeader[] = "Authorization: Bearer {$strAccessToken}";
$msg = $arrJson['events'][0]['message']['text'];
$token = $arrJson['events'][0]['source']['userId'];

		
			if($arrJson['events'][0]['message']['text'] == "ID"){
		

			  $arrPostData = array();
			  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
			  $arrPostData['messages'][0]['type'] = "uri";
			  $arrPostData['messages'][0]['label'] = "https://pbs.twimg.com/profile_images/972154872261853184/RnOg6UyU_400x400.jpg";
			$arrPostData['messages'][0]['linkUri'] = "https://www.google.com/";
			$arrPostData['messages'][0]['area'] = {  
      								"x":0,
								"y":0,
								"width":520,
								"height":1040
								   }
		
}else{			
			
	  		$arrPostData = array();
			  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
			  $arrPostData['messages'][0]['type'] = "text";
			  $arrPostData['messages'][0]['text'] = "ขออภัยครับ ผมไม่สามารถเข้าใจข้อความ (" .$msg. ") ได้ ขณะนี้ระบบกำลังอยู่ในช่วงพัฒนา ขออภัยในความไม่สะดวกครับ";
			
	
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
