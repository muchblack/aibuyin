<?php

class DeliveryGOGOVAN
{
    private $_api_url;
    private $_client_id;
    private $_client_secret;
    private $_api_key;
    private $_db;


    public function __construct()
    {
        //GOGOVAN串接網址
        $this->_api_url = 'https://stag-tw-api.gogox.com/';

        //GOGOVAN串接帳號
        $this->_client_id = "bba4fcc5acbdc283394bc7339306a65daa570322dc6bd7775ef273e2edf36537";

        //GOGOVAN串接密碼
        $this->_client_secret = "03269ade986d032ff6fb0b10e0c2649f1ad74f664430e20bcbbe8d070553b0e5";

        require_once 'GetLanandLon.php';
        global $wpdb;
        $this->_db = $wpdb;
    }

    //取得運費試算
    public function get_quotation($datas = '')
    {
        //測試用data
        $datas = [
            'store_address' => '台北市內湖區洲子街12號',
            'user_address' => '台北市內湖區洲子街100號',
            'order_time' => '2020-09-16 20:00:00',
            'pay_by_receiver'=> false
        ];
        //檢查token是否過期與取得
        $token_data = $this->_check_token();

        //取得店家和顧客地址經緯度
        $lanlogs = $this->_get_lat_long($datas);

        //組出運費試算array
        $try = [
            'vehicle_type' => 'motorcycle',
            'pickup' => [
                'schedule_at' => strtotime($datas['order_time']),
                'location' => [
                    'lat' => $lanlogs['pickup']['lat'],
                    'lng' => $lanlogs['pickup']['lng']
                ],
            ],
            'destinations' => [
                [
                    'location' =>[
                        'lat' => $lanlogs['user']['lat'],
                        'lng' => $lanlogs['user']['lng']
                    ]
                ]
            ],
            'extra_requirements' => [
                'delivery_box' => false,
                'need_help_moving' => false,
                'pay_by_receiver' => $datas['pay_by_receiver'],
            ]
        ];

        $send_data = json_encode($try);

        $return_datas = $this->_curl('quotations',$send_data,'POST',$token_data['access_token']);

        //回傳運費試算
        return $return_datas['estimated_price'];
    }

    public function new_order($datas = '')
    {
        //測試用data
        $datas = [
            'store_name' => '某間商行',
            'store_address' => '台北市內湖區洲子街12號',
            'store_phone' => '0222345678',
            'user_name'=> '某個顧客',
            'user_address' => '台北市內湖區洲子街100號',
            'user_phone' => '0910234567',
            'order_time' => '2020-09-16 20:00:00',
            'pay_by_receiver'=> false
        ];

        //檢查token是否過期與取得
        $token_data = $this->_check_token();

        //取得店家和顧客地址經緯度
        $lanlogs = $this->_get_lat_long($datas);

        //組出訂單array
        $try = [
            'pickup' => [
                'name' => $datas['store_name'],
                'street_address' => $datas['store_address'],
                'schedule_at' => strtotime($datas['order_time']),
                'location' => [
                    'lat' => $lanlogs['pickup']['lat'],
                    'lng' => $lanlogs['pickup']['lng']
                ],
                'contact' =>
                [
                    'name' => $datas['store_name'],
                    'phone_number' => $datas['store_phone'],
                ],
            ],
            'destinations' => [
                [
                    'name' => $datas['user_name'],
                    'street_address' => $datas['user_address'],
                    'location' => [
                        'lat' => $lanlogs['user']['lat'],
                        'lng' => $lanlogs['user']['lng']
                    ],
                    'contact' => [
                        'name' => $datas['user_name'],
                        'phone_number' => $datas['user_phone'],
                    ],
                ]
            ],
            'extra_requirements' => [
                'delivery_box' => false,
                'need_help_moving' => false,
                'pay_by_receiver' => $datas['pay_by_receiver'],
            ],
            'vehicle_type' => 'motorcycle',
            "payment_method" => "prepaid_wallet"
        ];

        $send_data = json_encode($try);

        $return_datas = $this->_curl('new',$send_data,'POST',$token_data['access_token']);

        return $return_datas;
    }

    public function get_orderstatus($uuid = '')
    {
        $uuid = "b0045850-9476-4b56-9a9e-3a596724dde1";

        //檢查token是否過期與取得
        $token_data = $this->_check_token();

        $return_datas = $this->_curl('status',$uuid,'GET', $token_data['access_token']);

        return $return_datas;
    }

    public function cancel_order($uuid = '' )
    {
        $uuid = "310ad263-d2b7-403e-8e83-946bd5058121";

        //檢查token是否過期與取得
        $token_data = $this->_check_token();

        $return_datas = $this->_curl('cancel',$uuid,'POST', $token_data['access_token']);

        return $return_datas;
    }

    //測試用function
    public function testfunc()
    {
        $this->_check_token();
    }

    //確認token是否過期
    private function _check_token()
    {
        //判斷DB儲存token是否過期
        $db_token = $this->_db->get_row("SELECT * FROM `wp_system_keys` WHERE keys_name='gogovan'");
        if($db_token)
        {
            //現在時間轉成timestamp
            $now = time();
            //計算是否過期
            $expired = $db_token->created_at + $db_token->expires;
            if($now > $expired)
            {
                //已過期，重新取得token
                $tmp_data = $this->_get_token();

                $token_data['access_token'] = $tmp_data['access_token'];

            }
            else
            {
                $token_data = [
                    'access_token' => $db_token->keys_value
                ] ;
            }
        }
        else{
            return false;
        }

        return $token_data;
    }

    //取得經緯度
    private function _get_lat_long($datas)
    {
        $geos = new GetLanandLon();
        $address = $geos->getlanlon($datas);

        return $address;
    }

    //取得token
    private function _get_token()
    {
        global $wpdb;
        $tmp_data = [
            "grant_type" => 'client_credentials',
            "client_id" => $this->_client_id,
            "client_secret" => $this->_client_secret
        ];

        $send_data = json_encode($tmp_data);

        $result = $this->_curl('token',$send_data,'POST');

        if($result)
        {
            $token_data = [
                'access_token' => $result['access_token']
            ];

            //塞進資料庫or更新資料庫
            $SQL = "SELECT * FROM `wp_system_keys` WHERE keys_name='gogovan'";
            $sql_result  = $wpdb->get_results($SQL);
            if($sql_result)
            {
                $upd_array = [
                    'keys_value' => $result['access_token'],
                    'expires' => $result['expires_in'],
                    'created_at' => $result['created_at']
                ];
                $wpdb->update('wp_system_keys',$upd_array,['keys_name'=>'gogovan']);

            }
            else
            {
                //塞入資料庫
                $ins_array = [
                    'keys_name' => 'gogovan',
                    'keys_value' => $result['access_token'],
                    'expires' => $result['expires_in'],
                    'created_at' => $result['created_at']
                ];
                $wpdb->insert('wp_system_keys',$ins_array);
            }

            return $token_data;
        }
    }

    //串接 CURL部分
    private function _curl($action, $datas = '', $method_action, $token='')
    {
        if($token){
            $bearer = "Authorization: Bearer ";
            $header = $bearer . $token;
        }

        switch($action)
        {
            case "token":
                $url = $this->_api_url.'oauth/token';
                $arr_header = [
                    'accept: application/json',
                    'Content-Type: application/json'
                ];
                break;
            case "quotations":
                $url = $this->_api_url.'transport/quotations';
                $arr_header = [
                    'accept: application/json',
                    'Content-Type: application/json',
                    $header,
                ];
                break;
            case "new":
                $url = $this->_api_url.'transport/orders';
                $arr_header = [
                    'accept: application/json',
                    'Content-Type: application/json',
                    $header,
                ];
                break;
            case "status":
                $url = $this->_api_url.'transport/orders/'.$datas;
                $arr_header = [
                    'accept: application/json',
                    $header,
                ];
                break;
            case "cancel":
                $url = $this->_api_url.'transport/orders/'.$datas.'/cancel';
                $arr_header = [
                    $header,
                ];
                break;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method_action);
        if($action == 'token' || $action == 'new' || $action == 'quotations')
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $datas);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER,$arr_header);

        $response = curl_exec($curl);

        $data     = json_decode($response, TRUE);


        return $data;
    }
}