<?php
namespace App\RestApiClient;

use App\Interfaces\ClientInterface;
use Exception;

class Client implements ClientInterface {

    const API_URL = 'http://localhost:8000/';

    /**
    * The whole url including host, api uri and jql query.
    * @var string
    */
    protected $url;

    function __construct($url = self::API_URL)
    {
      $this->url = $url;
    }
    /**
    * {@inheritdoc}
    */
    public function getUrl() {
        return $this->url;
    }

    /**
    * {@inheritdoc}
    */
//    public function createUrl($path, array $query = array()) {
//    $result = $this->url . '/';
//        if (!empty($path)) {
//          $result .= $path;
//        }
//        if (!empty($query)) {
//          $result .= '?' . http_build_query($query);
//        }
//
//        return $result;
//    }

    /**
    * {@inheritdoc}
    */
//    public function exec($url) {
//        $this->url = urldecode($url);
//        //    $username = Config::getUser();
//        //    $password = Config::getPassword();
//
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
//        //    curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
//
//        $response = curl_exec($curl);
//        if (empty($response)) {
//            $seconds = 5;
//            $i = 1;
//            $count = 5;
//            while (empty($response) && $count >= 0) {
//                sleep($i * $seconds);
//                $response = curl_exec($curl);
//                $i++;
//                $count--;
//            }
//        }
////        $result = $this->getResult($response, $curl, $url);
//        if (!$response) {
//            trigger_error(curl_error($curl));
//        }
//
//        return $response;
//    }

    /**
    * {@inheritdoc}
    */
//    static function getResult($response, $curl, $url) {
//        // If request failed.
//        if (!$response) {
//            $http_response = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//            $body = curl_error($curl);
//            curl_close($curl);
//
//            //The server successfully processed the request, but is not returning any content.
//            if ($http_response == 204) {
//                return '';
//            }
//            $error = "CURL Error (" . self::class . ") \n
//            url: $url\n
//            body: $body";
//            throw new Exception($error);
//        }
//        else {
//          // If request was ok, parsing http response code.
//            $http_response = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//            // don't check 301, 302 because setting CURLOPT_FOLLOWLOCATION
//            if ($http_response != 200 && $http_response != 201) {
//                $error = "CURL HTTP Request Failed: Status Code :
//                    $http_response, URL: $url
//                    \nError Message : $response";
//                throw new Exception($error);
//            }
//        }
//
//        return json_decode($response, TRUE);
//    }

    function post($url, array $data = [])
    {
        $json = json_encode($data);
    //        $username = Config::getUser();
    //        $password = Config::getPassword();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    //        curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($curl, CURLOPT_URL, $this->url . $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($json)]);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        $response = curl_exec($curl);
//        $result = self::getResult($response, $curl, $url);
        if (!$response) {
            trigger_error(curl_error($curl));
        }
        curl_close($curl);

        return json_decode($response, TRUE);

    }

    function get($route, array $query = [])
    {
        $url = $this->getUrl() . $route;
        $curl = curl_init();
        curl_setopt(
            $curl, 
            CURLOPT_RETURNTRANSFER, 
            TRUE
        );
        curl_setopt(
            $curl, 
            CURLOPT_URL, 
            $url
        );
        curl_setopt(
            $curl, 
            CURLOPT_HTTPHEADER, 
            array('Content-Type: application/json')
        );
        $response = curl_exec($curl);
//        $result = self::getResult($response, $curl, $url);
        if (!$response) {
            trigger_error(curl_error($curl));
        }
        curl_close($curl);

        return json_decode($response, TRUE);
    }

    function delete($url, $id)
    {
        $json = json_encode(['id' => $id]);
        //    $username = Config::getUser();
        //    $password = Config::getPassword();

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        //    curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($curl, CURLOPT_URL, $this->url . $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        $response = curl_exec($curl);
        if (!$response) {
            $error = curl_error($curl);
            if ($error) {
                trigger_error($error);
            }
        }
        curl_close($curl);

        return json_decode($response, TRUE);;
    }

    function put($url, array $data = [])
    {
        // TODO: Implement put() method.
    }

    function update($url, array $data = [])
    {
        // TODO: Implement update() method.
    }

//    public function callAPI($method, $url, $data = false) {
//
//        $ch = curl_init ();
//
//        switch ($method) {
//            case "POST" :
//                curl_setopt ( $ch, CURLOPT_POST, 1 );
//
//                if ($data) {
//                    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
//                    curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
//                        'Content-Type: application/json',
//                        'Content-Length: ' . strlen ( $data )
//                    ));
//                }
//                break;
//            case "PUT" :
//                curl_setopt ( $ch, CURLOPT_PUT, 1 );
//                break;
//            case "GET" :
//                //No settings required
//                break;
//        }
//
//        curl_setopt ( $ch, CURLOPT_URL, $url );
//        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
//
//        $response = curl_exec ( $ch );
//
//        curl_close ( $ch );
//
//        return $response;
//    }
}
