<?php

namespace App\Http\Controllers;

//use Google_Client;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class GeolocationController extends Controller
{
    public function index(Request $request)
    {
//        $client = new Google_Client();
//        $client->setApplicationName("cspemerge");
//        $client->setDeveloperKey("AIzaSyCjO5l2A_gM8cXPD5nWrbKYfo_UlEr4Oyo");
//        $client->authorize();

//        $httpClient = $client->getHttpClient();
        $httpClient = new Client();

//        $service = new \Google_Service_Spectrum_GeoLocation();
        $optParams = array(
            "homeMobileCountryCode" => 440, // ソフトバンク（MCC）
            "homeMobileNetworkCode" => 20, // ソフトバンク（MNC）
            "radioType" => "lte", // モバイル端末の無線通信タイプ（lte, gsm, cdma, wcdma）
            "considerIp" => "false",  // true にすると、IPアドレスから位置を取得
            "carrier" => "Softbank", // 携帯キャリア
            "wifiAccessPoints" => [
                ["macAddress" => "BC:5C:4C:DE:AF:75"],
                ["macAddress" => "D8:0F:99:E4:F0:8A"],
                ["macAddress" => "BC:5C:4C:1E:A0:96"]
            ]
        );

        try {
            $result = $httpClient->post('https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyCjO5l2A_gM8cXPD5nWrbKYfo_UlEr4Oyo',
                $optParams);

            dd($result->getBody()->getContents());
        }catch (ClientException $e)
        {
            $response = $e->getResponse();
            dd($response->getBody()->getContents());
        }
        return "ok";
    }
}

