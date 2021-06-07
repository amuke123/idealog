<?php
class App{
	static function sendTell($phoneNumber){
		$code = Cellcode::getCode($phoneNumber);
		$params = array($code);
		$nationCode = "86";
		$templId = Control::get('message_templId');
		$sign = Control::get('message_sign');
        $appid = Control::get('message_appid');  //自己的短信appid
        $appkey = Control::get('message_appkey'); //自己的短信appkey
		$extend = "";
		$ext = "";

        $random = rand(100000, 999999);//生成随机数
        $curTime = time();
        $wholeUrl = Control::get('message_url'). "?sdkappid=" . $appid . "&random=" . $random;

        // 按照协议组织 post 包体
        $data = new \stdClass();//创建一个没有成员方法和属性的空对象
        $tel = new \stdClass();
        $tel->nationcode = "".$nationCode;
        $tel->mobile = "".$phoneNumber;
        $data->tel = $tel;
        $data->sig=hash("sha256", "appkey=".$appkey."&random=".$random."&time=".$curTime."&mobile=".$phoneNumber);// 生成签名
        $data->tpl_id = $templId;
        $data->params = $params;
        $data->sign = $sign;
        $data->time = $curTime;
        $data->extend = $extend;
        $data->ext = $ext;

        return self::sendCurlPost($wholeUrl, $data);
	}
	static function sendCurlPost($url, $dataObj){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dataObj));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec($curl);
        if (false == $ret) {
            // curl_exec failed
            $result = "{ \"result\":" . -2 . ",\"errmsg\":\"" . curl_error($curl) . "\"}";
        } else {
            $rsp = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (200 != $rsp) {
                $result = "{ \"result\":" . -1 . ",\"errmsg\":\"". $rsp
                        . " " . curl_error($curl) ."\"}";
            } else {
                $result = $ret;
            }
        }
        curl_close($curl);

        return $result;
	}

}
?>