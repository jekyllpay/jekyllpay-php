<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-05-19
 * Time: 14:41
 */

namespace jekyllpay\config;

return [

    'debug'                 => true,


    'default_ajax_accept'   => 'json',


    'CACHE_PATH'            => BASE_PATH .'runtime'. DIRECTORY_SEPARATOR .'cache'. DIRECTORY_SEPARATOR,


    'COMPOSER'              => BASE_PATH .'vendor'. DIRECTORY_SEPARATOR .'autoload.php',


    'log' => [
        'LOG_PATH'          => BASE_PATH .'runtime'. DIRECTORY_SEPARATOR .'log',
        'filename'          => date('Ymd'),
        'extension'         => 'log',
        'level'             => 'debug',
    ],
];

