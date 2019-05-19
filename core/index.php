<?php
/**
 * Date: 2019-05-19
 * Time: 14:57
 */


defined('APP_PATH') || define('APP_PATH', BASE_PATH . 'app'. DIRECTORY_SEPARATOR);

defined('CONFIG_PATH') || define('CONFIG_PATH', BASE_PATH . 'app'. DIRECTORY_SEPARATOR .'config'. DIRECTORY_SEPARATOR);

$jekyllpay_config = require_once(CONFIG_PATH .'config.php');

require_once($jekyllpay_config['COMPOSER']);

require_once(BASE_PATH .'core'. DIRECTORY_SEPARATOR .'jekyllpay.php');


$jekyllpay = (new Jekyllpay\Jekyllpay)->initialize($jekyllpay_config);
try {

    $jekyllpay->runner()->output();

} catch (Exception $e) {
    if ($jekyllpay_config['debug']) {
        throw $e;
    } else {
        $jekyllpay->logger()->error($e);
    }
}

