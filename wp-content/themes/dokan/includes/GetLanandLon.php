<?php


class GetLanandLon
{
    public function __construct()
    {
        //google map api key
        $this->_api_key = 'AIzaSyAz2aAiFA5WUDqeAwWH21u2alvcraGpiUk';
    }

    public function getlanlon($datas)
    {
        $return_data = [];
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$this->_api_key.'&address=';
        //取得店家lanlon
        $pickup_url = $url.$datas['store_address'];
        $pickup = $this->_curl($pickup_url);
        $return_data['pickup'] = [
            'lat' => $pickup['results'][0]['geometry']['location']['lat'],
            'lng' => $pickup['results'][0]['geometry']['location']['lng'],
        ];

        //取得顧客latlng
        $user_url = $url.$datas['user_address'];
        $user = $this->_curl($user_url);
        $return_data['user'] = [
            'lat' => $user['results'][0]['geometry']['location']['lat'],
            'lng' => $user['results'][0]['geometry']['location']['lng'],
        ];

        return $return_data;

    }

    private function _curl($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");

        $response = curl_exec($curl);
        $data     = json_decode($response,TRUE);

        return $data;
    }
}