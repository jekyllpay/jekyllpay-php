<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-05-19
 * Time: 18:33
 */

namespace controller;

abstract class Base_controller
{
    protected $view = NULL;

    protected $model = NULL;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
    }

    public function config($name, $value=NULL, $category='')
    {
        global $jekyllpay_config;

        if (empty($name)) {
            return$jekyllpay_config;
        }
        elseif ($value === NULL) {
            $arr = explode('.', $name);
            $count = count($arr);
            if ($count == 1) {
                return $jekyllpay_config[ $arr[0] ] ?? NULL;
            }
            elseif ($count == 2) {
                return $jekyllpay_config[ $arr[0] ][ $arr[1] ] ?? NULL;
            }
            elseif ($count == 3) {
                return $jekyllpay_config[ $arr[0] ][ $arr[1] ][ $arr[2] ] ?? NULL;
            }
            return $jekyllpay_config[ $arr[0] ][ $arr[1] ][ $arr[2] ][ $arr[3] ] ?? NULL;
        }

        $jekyllpay_config[$name] = $value;
        return true;
    }

    public function display($html='', $params=[])
    {
        global $jekyllpay;

        extract($params);

        $view = $html ?: $jekyllpay->router[1] ?? 'index';
        $file = APP_PATH . DIRECTORY_SEPARATOR .'view'. DIRECTORY_SEPARATOR . $view . '.php';
        return require $file;

        //$this->view->render();
    }

    public function output($data=[])
    {
        $data = $data ?: $this->data;

        $accept_type = $_SERVER['HTTP_ACCEPT'] ?? $this->_config['default_accept_type'] ?? 'html';
        if ($accept_type == 'json') {
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode($data, JSON_UNESCAPED_UNICODE));
        }
        elseif ($accept_type == 'xml') {
            header('Content-Type:text/xml; charset=utf-8');
            exit(xml_encode($data));
        }

        header('Content-Type:text/html; charset=utf-8');
        exit($data);
    }

    public function __call($fun, $method)
    {
        if (!empty($config['debug'])) {
            die('url broken');
        }

        die(__METHOD__ .'::'. __LINE__);
    }

}