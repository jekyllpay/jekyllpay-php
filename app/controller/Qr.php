<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-05-19
 * Time: 20:06
 */

namespace controller;

use library\Unionpay;

class Qr extends Base_controller
{
    public function pay()
    {
        $this->config = $this->config('unionpay');

        $pay = new Unionpay($this->config['cert'] ?? []);

        $data = [];
        $result = $pay->exec($this->config['urls']['qr'], $data);

        var_dump($result);die;
    }
}