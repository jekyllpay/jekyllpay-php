<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-05-19
 * Time: 19:51
 */

namespace library;

use GuzzleHttp\Client;

class Unionpay
{
    public $config = [];

    public function __construct(array $extends = [])
    {
        $this->config = array_merge($this->config, $extends);
    }

    public function exec($url, $data)
    {
        $client = new Client(['timeout'=>3,]);
        $res = $client->post($url . $this->config['utoken'], ['json' => $this->build_query($data)]);
        return $res->getBody()->getContents();
    }

    function build_query(array $data)
    {
        ksort($data);
        $json = json_encode($data);
        $priv_key = openssl_get_privatekey(file_get_contents($this->config['cert_pem']), $this->config['pri_passwd']);
        openssl_sign($json, $signature, $priv_key, OPENSSL_ALGO_SHA256);
        openssl_free_key($priv_key);
        return [
            "data" => base64_encode(mb_convert_encoding($json, "GBK", "UTF-8")), //$json_gbk = iconv("UTF-8","GBK//IGNORE", $json);
            "signature" => base64_encode($signature),
        ];
    }

}
