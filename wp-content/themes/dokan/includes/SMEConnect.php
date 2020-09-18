<?php
/*
 * 串接 工研院 中小型店家數位轉型補助方案用Class
 */
class SMEConnect
{
    private $_url; //Domain name
    private $_apiurl; //各API串接主網址 正式
    private $_apiurl_test; //各API串接主網址 測試

    public function __construct()
    {
        //domain && 要求token 網址
        $this->_url = 'https://sme.bizlion.com.tw/api/';

        //各對應API組成
        $this->_apiurl = 'v1/Upload/';
        $this->_apiurl_test = 'v1/Test/Upload/';
    }

    /*
     * 工研院線上點餐服務 DATA1010
     * input
     * @tax_num , string 為店家統編
     * @key , string 為工研院發放之店家金鑰
     */

    public function service_DATA1010($tax_num ='', $key='', $datas )
    {
        $datas = [
            "金鑰" => "$key",
            "上傳資料" => $datas
        ];

        //轉成JSON格式
        $datas = json_encode($datas,JSON_UNESCAPED_UNICODE);

        //先取得token
        //TODO: 後續應檢查token是否過期
        $token_data = $this->_get_token($tax_num,$key);

        //送入工研院的線上點餐系統
//        $url = $this->_apiurl_test . 'DATA1010';
        $url = $this->_apiurl . 'DATA1010';
        $result = $this->_curl($url,$datas,$token_data['access_token']);

        return $result;

    }

    /*
     * 取得工研院token
     * input
     * @tax_num string , 為店家統編
     * @key string , 為工研院發放之店家金鑰
     *
     * output
     * @access_token string , 為工研院發放之token
     * @issued timestamp , 申請token 時間
     * @expires timestamp , token過期時間
     * 一般token有效時間為3600秒
     */
    private function _get_token($tax_num,$key)
    {
        $get_token_data  = [
            'grant_type=password',
            "username=$tax_num",
            "password=$key"
        ];

        //轉成網址格式
        $get_token_data = implode("&",$get_token_data);

        $temp_data = $this->_curl('Token',$get_token_data);
        // 整理token內容
        $token_data = [
            'access_token' => $temp_data['access_token'],
            'issued' => $temp_data['.issued'],
            'expires' => $temp_data['.expires']
        ];

        return $token_data;
    }

    /*
     * Class 發送請求函數
     * input
     * @url string , API字串
     * @datas array , 欲傳送之資料
     * @token string , 為工研院發放之token，若為取得token則此項可空白
     */
    private function _curl($url,$datas,$token = '')
    {
        $url = $this->_url.$url;

        if($token){
            $bearer = "Authorization: Bearer ";
            $header = $bearer . $token;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $datas);
        if($token){
            //請求TOKEN時使用的Header
            curl_setopt($curl, CURLOPT_HTTPHEADER,['Content-Type: application/json', $header]);
        }else{
            //各項線上服務API使用Header
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        }

        $response = curl_exec($curl);
        $data     = json_decode($response, TRUE);
//        if(!isset($token)){
//            var_dump($data);
//        }
        return $data;
    }
}
