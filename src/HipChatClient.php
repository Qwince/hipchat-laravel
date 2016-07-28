<?php

namespace Qwince\HipchatLaravel;

class HipChatClient
{
    /**
     * HTTP response codes from API
     *
     * @see http://api.hipchat.com/docs/api/response_codes
     */
    const STATUS_BAD_RESPONSE = -1; // Not an HTTP response code
    const STATUS_OK = 200;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;
    const STATUS_NOT_ACCEPTABLE = 406;
    const STATUS_INTERNAL_SERVER_ERROR = 500;
    const STATUS_SERVICE_UNAVAILABLE = 503;

    /**
     * Formats for rooms/message
     */
    const FORMAT_HTML = 'html';
    const FORMAT_TEXT = 'text';
    /**
     * API versions
     */
    const VERSION = 'v2';
    private $api_server;
    private $auth_token;
    private $verify_ssl = true;
    private $proxy;
    private $request_timeout = 15;

    /**
     * HipChatClient constructor.
     * @param $api_token
     * @param $api_server
     */
    function __construct($api_token,$api_server) {
        $this->auth_token = $api_token;
        $this->api_server = $api_server;
        $this->api_version = self::VERSION;
    }


    /**
     *
     * Send a message to a room
     *
     * @param $room_id
     * @param $from
     * @param $message
     * @param bool $notify
     * @param string $color
     * @param string $message_format
     * @return mixed|string
     */
    public function message_room($room_id, $from, $message, $notify, $color,$message_format)
    {
        $args = array(
            'room_id' => $room_id,
            'from' => $from,
            'message' => $message,
            'notify' => $notify,
            'color' => $color,
            'message_format' => $message_format
        );
        return $this->make_request('room/'.$room_id.'/notification?auth_token='.$this->auth_token, $args, 'POST');
    }

    protected function make_request($api_method, $args = array(), $http_method = 'GET')
    {
        $args['format'] = 'json';
        $args['auth_token'] = $this->auth_token;
        $url = "$this->api_server/$this->api_version/$api_method";
        $post_data = null;
        // add args to url for GET
        if ($http_method == 'GET') {
            $url .= '?' . http_build_query($args);
        } else {
            $post_data = $args;
        }
        $response = $this->curl_request($url, $post_data);
        // make sure response is valid json
        $response = json_decode($response);
        if (!$response) {
            throw new HipChat_Exception(self::STATUS_BAD_RESPONSE,
                "Invalid JSON received: $response", $url);
        }
        return $response;
    }


    /**
     * Performs a curl request
     *
     * @param $url        URL to hit.
     * @param $post_data  Data to send via POST. Leave null for GET request.
     *
     * @throws HipChat_Exception
     * @return string
     */
    protected function curl_request($url, $post_data = null)
    {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->request_timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        if (isset($this->proxy)) {
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        }
        if (is_array($post_data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        }
        $response = curl_exec($ch);


        // make sure we got a real response
        if (strlen($response) == 0) {
            return true;
        }
        // make sure we got a 200
        $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code != self::STATUS_OK) {
            throw new HipChat_Exception($code,
                "HTTP status code: $code, response=$response", $url);
        }
        curl_close($ch);
        return $response;
    }
}

class HipChat_Exception extends \Exception {
    public $code;
    public function __construct($code, $info, $url) {
        $message = "HipChat API error: code=$code, info=$info, url=$url";
        parent::__construct($message, (int)$code);
    }
}